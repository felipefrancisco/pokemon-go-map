app.factory('MapService', ['$rootScope', 'PageService', function ($rootScope, PageService) {
    'use strict';

    var service = this;

    service.bucket = 'https://s3-us-west-2.amazonaws.com/pgo-static';

    service.untouched = [];

    /**
     * Map Canvas
     * @type HTMLElement
     */
    service.canvas = null;

    /**
     *
     * @type {Array}
     */
    service.markers = [];

    /**
     * Google Maps Instance
     * @type google.maps.Map
     */
    service.map = null;

    /**
     * Content
     * @type Object
     */
    service.content = null;

    /**
     * Google maps options object
     * @type Object
     */
    service.options = {};

    /**
     * Location data
     * @type Object
     */
    service.location = {
        default: {
            lat: 53.3540406,
            lng: -6.2589086
        },
        object: null
    }

    /**
     * Default Marker data
     * @type Object
     */
    service.defaultMarker = {
        options: {
            src: service.bucket + '/pokeball.png',
            size: new google.maps.Size(35,35),
            scale: new google.maps.Size(35,35)
        },
        object: null
    };

    /**
     * Default InfoWindow data
     * @type Object
     */
    service.infoWindow = {
        options: {
            content: null,
            maxWidth: 400
        },
        object: null
    };

    service.area = {
        options: {
            color: '#9acdd7',
            radius: 40
        }
    }

    /**
     * Markers clusterer
     * @type {null}
     */
    service.markerClusterer = null;

    service.defaultLocation = null;

    service.styles = [
        {
            "featureType": "road",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#525252"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#ccbc08"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#11d47c"
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#53db6e"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#1157ad"
                }
            ]
        },
        {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#2aa363"
                }
            ]
        },
        {
            "featureType": "transit.line",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "labels",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "transit.station",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        }
    ];

    service.geocoder = new google.maps.Geocoder();

    service.events = {};

    service.events.infoWindowOpened = function() {

        //$('.search-box').focus();
    }

    /**
     * Start the map application.
     *
     * @param map
     * @param infoWindowContent
     */
    service.create = function(map) {


        if($rootScope.focus) {

            service.defaultLocation = new google.maps.LatLng($rootScope.focus.lat, $rootScope.focus.lng);
        }
        else {

            service.defaultLocation = new google.maps.LatLng(service.location.default.lat, service.location.default.lng);
        }

        service.canvas = document.getElementById('map');
        service.options = {
            center: service.defaultLocation,
            zoom: 16,
            panControl: true,
            minZoom: 7,
            scrollwheel: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControlOptions: {
                mapTypeIds: []
            },
        }

        service.map = new google.maps.Map(service.canvas, service.options);

        service.defaultMarker.object = new google.maps.MarkerImage(
            service.defaultMarker.options.src,
            service.defaultMarker.options.size,
            null, //origin
            null, //anchor
            service.defaultMarker.options.scale
        );

        // Create the search box and link it to the UI element.
    }

    service.panTo = function(lat, lng) {

        var location = new google.maps.LatLng(lat, lng);

        service.map.panTo(location);
    }

    service.setInfoWindowContent = function(content) {

        if(!isMobile)
            return;

        //service.infoWindow.options.content = content;
        //service.infoWindow.object = new google.maps.InfoWindow(service.infoWindow.options);
    }

    service.addListeners = function() {

        if(!isMobile) {
            // 1000 miliseconds delay to trigger marker placement
            new LongPress(service.map, 1000);

            google.maps.event.addListener(service.map, 'longpress', function (event) {

                service.removeUntouchedMarkers();

                var marker = service.placeMarker(event.latLng);

                service.untouched.push(marker);

                if (!isMobile) {

                    PageService.showAddSidebar();
                }

                service.handleClick(marker);
                service.loadClusterer();
            });
        }

    }

    service.removeUntouchedMarkers = function() {

        for(var i in service.untouched) {
            service.markerClusterer.removeMarker(service.untouched[i]);

            var ax = service.markers.indexOf(service.untouched[i]);
            if(ax !== -1)
                service.markers.splice(ax, 1);
        }

        service.map.clearMarkers(service.untouched);

    }

    service.marker = function(location) {

        return new google.maps.Marker({
            position: location,
            icon: service.defaultMarker.object
        });
    }

    service.pokemonMarker = function(location, src) {

        var marker = service.marker(location);

        marker.setIcon(service.markerImage(src));

        return marker;
    }

    service.markerImage = function(src) {

        return new google.maps.MarkerImage(
            src,
            new google.maps.Size(50,50), //size
            null, //origin
            null, //anchor
            new google.maps.Size(50,50) //scale
        );
    }

    service.circle = function(color, radius) {

        if(typeof color === 'undefined')
            color = service.area.options.color;

        if(typeof radius === 'undefined')
            radius = service.area.options.radius;

        return new google.maps.Circle({
            map: service.map,
            radius: radius,    // 10 miles in metres
            fillColor: color,
            strokeColor: color
        });
    }

    service.bindCircleToMarker = function(circle, marker) {

        // bind the circle to the marker position
        circle.bindTo('center', marker, 'position');

        // let the marker know that an area has been bound to it
        marker.circle = circle
    }

    service.addInfoWindowToMarker = function(marker) {

        // add click listener to marker
        marker.addListener('click', function () {

            service.handleClick(marker);
        });
    }

    service.handleClick = function(marker) {

        $rootScope.currentMarker = marker;
        $rootScope.$apply();

        if(isMobile) {

           // service.infoWindow.object.open(service.map, marker);
           // service.events.infoWindowOpened(marker);

        }
        else {

            marker.hasOwnProperty('uuid') ?  PageService.showViewSidebar() : PageService.showAddSidebar();
        }

        service.inspect();

        service.applyPokemonFunction(marker);
    }

    service.loadClusterer = function() {

        if (service.markerClusterer) {
            service.markerClusterer.clearMarkers();
        }

        service.markerClusterer = new MarkerClusterer(service.map, service.markers, {
            'zoom': 13,
            'center': service.defaultLocation,
            imagePath: service.bucket + '/maps/m',
            zoomOnClick:true,
            minimumClusterSize: 50
        });

        $rootScope.clusterer = service.markerClusterer;

        return service.markerClusterer;
    }

    service.placeMarker = function(location, obj) {

        var image;
        var color = service.area.options.color;

        // if object is received
        if(typeof obj !== 'undefined') {

            // find the pokemon
            image = $('[data-number="'+obj.number+'"]');

            // if the pokemon was found
            if(image) {

                //
                var marker = service.pokemonMarker(location, image.attr('src'));
                marker.uuid = obj.uuid;
                marker.model = obj;

                color = (new ColorThief()).getColor(image[0]);
                color = rgbToHex(color[0],color[1],color[2]);
            }
        }
        else {

            var marker = service.marker(location);
        }

        if(!marker.hasOwnProperty('circle')) {
            // create circle overlay
            var circle = service.circle(color);

            // bind the overlay to the marker
            service.bindCircleToMarker(circle, marker);

            if(!isMobile) {
                new LongPress(circle, 1000);
                google.maps.event.addListener(circle, 'longpress', function(event) {

                    service.removeUntouchedMarkers();

                    var marker = service.placeMarker(event.latLng);

                    service.untouched.push(marker);

                    if(!isMobile) {

                        PageService.showAddSidebar();
                    }

                    service.handleClick(marker);
                    service.loadClusterer();
                });
            }
        }

        service.addInfoWindowToMarker(marker);

        service.markers.push(marker);

        return marker;
    }

    service.removeFromClusterer = function(marker) {

        var ax;

        if(ax = service.markerClusterer.markers_.indexOf(marker) !== -1)
            service.markerClusterer.markers_.splice(ax, 1);

        return service.markerClusterer.markers_;
    }

    service.removeMarker = function(marker) {

        marker.setMap(null);

        if(marker.hasOwnProperty('circle'))
            marker.circle.setMap(null);

        $rootScope.currentMarker = null;
        $rootScope.$apply();

        service.markerClusterer.removeMarker(marker);

        var ax = service.markers.indexOf(marker);
        if(ax !== -1)
            service.markers.splice(ax, 1);

        if(!isMobile)
            PageService.showMainSidebar();
    }

    service.applyPokemonFunction = function() {

        $('.search-box').off('keyup');
        $('.search-box').on('keyup', function() {

            if($(this).val() == '')
                return $('.pokemon-list img.pokemon').show();

            $('.pokemon-list img.pokemon').hide();
            $('.pokemon-list img.pokemon[data-query*="'+ $(this).val().toLowerCase() +'"]').show();
        });

        $('.remove-marker').off('click');
        $('.remove-marker').on('click', function() {

            service.removeMarker($rootScope.currentMarker);
        });

    }

    service.clearAllMarkers = function() {

        service.map.clearMarkers(service.markers);
        service.markers = [];
    }

    service.init = function(options) {

        service.create(options.map);
        service.setInfoWindowContent(options.content);
        service.addListeners();

        google.maps.event.addListenerOnce(service.map, 'idle', function(){

            $('#pac-input').show();
            $('.loading').hide();
        });

        if(options.callback) {

            if(typeof options.callback === 'function') {

                options.callback();
            }
        }
    }


    service.inspect = function () {

        $rootScope.reported = false;
        $rootScope.owner = false;
        $rootScope.seen = false;

        $rootScope.reported_label = 'Report this marker';
        $rootScope.seen_label = 'I saw this pokemon around here!';

        if(!$rootScope.currentMarker)
            return;

        var uuid = $rootScope.currentMarker.uuid;


        if(!uuid) return false;

        if(!(uuid in $rootScope.userData))
            return false;

        var data = $rootScope.userData[uuid];

        $rootScope.reported = data.report;
        $rootScope.seen = data.seen;
        $rootScope.owner = data.owner;

        if(data.report) {
            $rootScope.reported_label = 'Thanks for reporting!';
        }

        if(data.seen) {
            $rootScope.seen_label = 'Thanks for marking this as seen!';
        }

        if(!$rootScope.$$phase) {
            $rootScope.$apply();
        }
    }



    return service;

}]);