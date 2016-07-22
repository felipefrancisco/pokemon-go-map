app.controller('MapController', ['$rootScope', '$scope', '$http', '$timeout', 'InitService', 'MapService', 'ApiService', 'PageService', function ($rootScope, $scope, $http, $timeout, InitService, MapService, ApiService, PageService) {
    'use strict';

    var controller = this;
    var s =  'gyuHBJKAYO7UIHJNKS89UYHJASNM2#';

    $scope.events = {};
    $scope.loading = true;
    $scope.sidebar = false;
    $scope.pokemons = [];
    $scope.latest = [];
    $scope.center_loader = true;
    $scope.loading_icon = MapService.bucket + '/loading.gif';
    $rootScope.reported = false;
    $rootScope.owner = false;
    $rootScope.seen = false;
    $rootScope.reported_label = 'Report this marker';
    $rootScope.seen_label = 'I saw this pokemon around here!';
    $scope.locations = [];
    $scope.myMarkersActive = false;
    $scope.myMarkers = [];

    controller.filteredPokemon = [];
    $scope.filteredMarkers = [];
    $scope.mylocation_name = null;

    controller.markersByNumber = {};
    controller.markers = [];
    controller.remainingMarkers = [];

    $rootScope.$watch('currentMarker', function() {

        MapService.inspect();
    })

    $scope.events.showSplashScreen = function() {

        PageService.showSplashScreen();
    }

    $scope.events.myMarkersClick = function($event) {

        MapService.clearAllMarkers();

        if($scope.myMarkersActive) {

            PageService.showFilters();

            $scope.myMarkersActive = false;
            $('.my-locations-link').removeClass('selected');
            controller.remainingMarkers = controller.getMarkers();

            controller.loadMarkers();
        }
        else {

            PageService.showMyMarkersBox();

            $scope.myMarkersActive = true;
            $('.my-locations-link').addClass('selected');

            controller.loadMyMarkers();
        }
    }


    $scope.events.pokemonFilterClick = function($event) {

        var target = $($event.currentTarget);
        var number = target.data('number');
        var key = controller.filteredPokemon.indexOf(number);

        if(key !== -1) {

            controller.filteredPokemon.splice(key, 1)
            target.removeClass('selected');
        }
        else {

            controller.filteredPokemon.push(number);
            target.addClass('selected');
        }

        MapService.clearAllMarkers();
        controller.loadFilteredMarkers();
    }


    $scope.$watch('pokemon_filter', function(newValue) {

        if(!newValue)
            return $('.pokemon-filters .pokemon').show();

        $('.pokemon-filters .pokemon').hide();
        $('.pokemon-filters .pokemon[data-query*="'+ newValue.toLowerCase() +'"]').show();
    });

    $scope.events.googleLoginClick = function() {

        $('.abcRioButton').click();
    }

    $scope.events.viewMarkerClickHere = function() {

        PageService.showAddSidebar();
    }

    $scope.events.googleLogin = function (googleUser) {

        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        var id_token = googleUser.getAuthResponse().id_token;

        if(!$rootScope.token) {

            var data = {
                name: profile.getName(),
                id: profile.getId(),
                email: profile.getEmail(),
                network:'google',
                accessToken: id_token
            };

            ApiService.auth(data, function(data) {

                if($rootScope.currentMarker.hasOwnProperty('uuid')) {
                    PageService.hideAll();
                    PageService.showViewSidebar();
                }

                $rootScope.token = data.token;
                $rootScope.$apply();
            });
        }
    }

    $scope.events.login = function () {

        FB.login(function(response) {

            if (response.authResponse) {

                var accessToken = response.authResponse.accessToken;

                FB.api('/me', { locale: 'en_US', fields: 'name, email' }, function(response) {

                    if(!response.email)
                        return;

                    response.accessToken = accessToken;
                    response.network = 'facebook';

                    ApiService.auth(response, function(data) {

                        if($rootScope.currentMarker.hasOwnProperty('uuid')) {
                            PageService.hideAll();
                            PageService.showViewSidebar();
                        }

                        $rootScope.token = data.token;
                        $rootScope.$apply();
                    });
                });

            }
            else {

                console.log('User cancelled login or did not fully authorize.');
            }
        }, {scope:'email'});
    }

    $scope.events.finishAddingPokemon = function($event) {

        PageService.showViewSidebar();
        MapService.inspect();
    }

    $scope.events.goToLocation = function(lat, lng) {

        MapService.panTo(lat, lng);
        MapService.map.setZoom(16);
    }


    $scope.events.goToLocationHash = function(marker) {

        if( marker.uuid in controller.cached ) {

            var location = controller.cached[marker.uuid];
        }
        else {

            var location = controller.decode(marker.location, marker.uuid);
            controller.cached[marker.uuid] = location;
        }

        MapService.panTo(location.lat, location.lng);
        MapService.map.setZoom(16);
    }

    $scope.events.closeAddSidebar = function($event) {

        PageService.showMainSidebar();
    }

    $scope.events.closeMainSidebar = function($event) {

        PageService.hideSidebar();
    }


    $scope.events.openMyLocationScreen = function($event) {

        PageService.showMyLocationScreen();
    }


    $scope.events.closeMyLocationsScreen = function($event) {

        PageService.hideMyLocationsScreen();
    }

    $scope.events.closeSplashScreen = function($event) {

        PageService.hideSplashScreen();
    }

    $scope.events.latest = function(marker) {

        var location = controller.decode(marker.location, marker.uuid);

        MapService.panTo(location.lat, location.lng)
        MapService.map.setZoom(16);
        controller.loadMarkers();
    }

    $scope.events.report = function() {

        if(!$rootScope.currentMarker.uuid)
            return;

        $.post('api/report', {
            uuid: $rootScope.currentMarker.uuid,
            token: $rootScope.token
        }, function(data) {

            if(data.hasOwnProperty('error')) {
                console.error(data.error);
                return;
            }

            if($rootScope.userData[$rootScope.currentMarker.uuid]) {

                $rootScope.userData[$rootScope.currentMarker.uuid].report = true;
            }
            else {

                $rootScope.userData[$rootScope.currentMarker.uuid] = {
                    report:true,
                    owner:false,
                    seen:false
                };
            }

            $rootScope.currentMarker.model.reports += 1;
            $rootScope.$apply();

            MapService.inspect();
        });
    }


    $scope.events.location = function() {

        var location = MapService.map.getCenter();

        $.post('api/location', {
            lat: location.lat(),
            lng: location.lng(),
            name: $scope.mylocation_name,
            token: $rootScope.token
        }, function(data) {

            if(data.hasOwnProperty('error')) {
                console.error(data.error);
                return;
            }

            $scope.locations.push(data);
            $scope.$apply();
            PageService.hideMyLocationsScreen();
        });
    }

    $scope.events.removeLocation = function(location) {

        $.post('api/remove-location', {
            uuid: location.uuid,
            token: $scope.token
        }, function(data) {

            if(data.hasOwnProperty('error')) {
                console.error(data.error);
                return;
            }

            var k = $scope.locations.indexOf(location);
            $scope.locations.splice(k, 1);
            $scope.$apply();
        });
    }

    $scope.events.sight = function() {

        if(!$rootScope.currentMarker.uuid)
            return;

        $.post('api/sight', {
            uuid: $rootScope.currentMarker.uuid,
            token: $rootScope.token
        }, function(data) {

            if(data.hasOwnProperty('error')) {
                console.error(data.error);
                return;
            }

            if($rootScope.userData[$rootScope.currentMarker.uuid]) {

                $rootScope.userData[$rootScope.currentMarker.uuid].seen = true;
            }
            else {

                $rootScope.userData[$rootScope.currentMarker.uuid] = {
                    report:false,
                    owner:false,
                    seen: true
                };
            }

            $rootScope.currentMarker.model.sights += 1;
            $rootScope.$apply();

            MapService.inspect();
        });
    }
    $scope.events.remove = function() {

        if($rootScope.currentMarker.uuid) {

            $.post('api/remove', {
                uuid: $rootScope.currentMarker.uuid,
                token: $rootScope.token
            }, function(data) {

                if(data.hasOwnProperty('error')) {
                    console.error(data.error);
                    return;
                }

                var internalMarkerObject = angular.element($('[ng-controller]')).scope().currentMarker.model;

                MapService.removeMarker($rootScope.currentMarker);

                var key = $scope.myMarkers.indexOf(internalMarkerObject)
                if(key !== -1)
                    $scope.myMarkers.splice(key, 1);

                var key = controller.remainingMarkers.indexOf(internalMarkerObject)
                if(key !== -1)
                    controller.remainingMarkers.splice(key, 1);

                var key = controller.markers.indexOf(internalMarkerObject)
                if(key !== -1)
                    controller.markers.splice(key, 1);

                $scope.$apply();
            });

        }
        else {
            MapService.removeMarker($rootScope.currentMarker);
        }
    }


    $scope.events.select = function($event) {

        var el = $($event.currentTarget);
        var number = el.data('number');

        var src  = $('[data-number="'+ number +'"]').attr('src');

        var markerImage = MapService.markerImage(src);

        $rootScope.currentMarker.setIcon(markerImage);

        var color = (new ColorThief()).getColor($('[data-number="'+ number +'"]')[0]);
        color = rgbToHex(color[0],color[1],color[2]);

        $rootScope.currentMarker.circle.set('fillColor', color);
        $rootScope.currentMarker.circle.set('strokeColor', color);

        var uuid = null;
        if($rootScope.currentMarker.hasOwnProperty('uuid'))
            uuid = $rootScope.currentMarker.uuid;

        ApiService.marker({
            lat: $rootScope.currentMarker.position.lat(),
            lng: $rootScope.currentMarker.position.lng(),
            number: el.data('number'),
            uuid: uuid,
            token: $rootScope.token
        }, function(data) {

            if(data.hasOwnProperty('error')) {
                console.error(data.error);
                return;
            }

            $rootScope.currentMarker.uuid = data.uuid;
            $rootScope.currentMarker.model = data;
            $rootScope.$apply();

            $rootScope.userData[data.uuid] = {
                report:false,
                owner:true,
                seen:true
            };

            for(var i in $scope.myMarkers) {

                var value = $scope.myMarkers[i];

                if(value.uuid == data.uuid) {
                    $scope.myMarkers.splice(i, 1);
                    break;
                }
            }

            $scope.myMarkers.push(data);
            $scope.$apply();

            controller.markers.push(data);

            MapService.untouched = [];
        });

    }



    controller.init = function() {

        controller.loadPokemon(function() {
            
            MapService.init({
                map: document.getElementById('map'),
                content: $('.pokemon-list-template').html(),
                callback: controller.callback
            });

        });
    }

    controller.cached = [];

    controller.filtered = false;


    controller.loadMyMarkers = function() {

        $scope.center_loader = true;
        if(!$scope.$$phase) {
            $scope.$apply();
        }

        $timeout(function() {


            for(var i in  $scope.myMarkers) {

                var marker = $scope.myMarkers[i];

                if( marker.uuid in controller.cached ) {

                    var location = controller.cached[marker.uuid];
                }
                else {

                    var location = controller.decode(marker.location, marker.uuid);
                    controller.cached[marker.uuid] = location;
                }

                //if(MapService.map.getBounds().contains(position)) {

                MapService.placeMarker(location, marker);
                //}
            }

            MapService.loadClusterer();

            $scope.center_loader = false;
            if(!$scope.$$phase) {
                $scope.$apply();
            }

        }, 200);
    }

    controller.loadFilteredMarkers = function() {

        if(controller.filteredPokemon.length > 0) {

            controller.filtered = true;

        $scope.center_loader = true;
        if(!$scope.$$phase) {
            $scope.$apply();
        }

            $timeout(function() {

                   $scope.filteredMarkers = [];
                   for(var i in controller.filteredPokemon) {

                       var number = controller.filteredPokemon[i];

                       $scope.filteredMarkers = $scope.filteredMarkers.concat(controller.markersByNumber[number]);
                   }

                    for(var i in  $scope.filteredMarkers) {

                        var marker = $scope.filteredMarkers[i];

                        if( marker.uuid in controller.cached ) {

                            var location = controller.cached[marker.uuid];
                        }
                        else {

                            var location = controller.decode(marker.location, marker.uuid);
                            controller.cached[marker.uuid] = location;
                        }

                        //if(MapService.map.getBounds().contains(position)) {

                            MapService.placeMarker(location, marker);
                        //}
                    }

                    MapService.loadClusterer();

                    $scope.center_loader = false;
                    if(!$scope.$$phase) {
                        $scope.$apply();
                    }

            }, 200);

        }
        else {

            controller.filtered = false;
            $scope.filteredMarkers = [];

            // always get a copy from markers
            controller.remainingMarkers = controller.getMarkers();
            controller.loadMarkers();
        }
    }

    controller.getMarkers = function() {

        return controller.markers.slice();
    }

    controller.decode = function(hash, salt) {

        return JSON.parse(Hasher.dec(hash, salt + s));
    }

    controller.loadMarkers = function() {

        if(controller.filtered)
            return;

        if($scope.myMarkersActive)
            return;

        $scope.center_loader = true;
        if(!$scope.$$phase) {
            $scope.$apply();
        }

        $timeout(function() {

            var reload = false;

            var to_delete = [];
            for(var i in controller.remainingMarkers) {

                var marker = controller.remainingMarkers[i];

                if(marker.map)
                    continue;

                if( marker.uuid in controller.cached ) {

                    var location = controller.cached[marker.uuid];
                }
                else {

                    var location = controller.decode(marker.location, marker.uuid);
                    controller.cached[marker.uuid] = location;
                }

                var position = new google.maps.LatLng(location.lat, location.lng);

                if(MapService.map.getBounds().contains(position)) {

                    reload = true;
                    MapService.placeMarker(location, marker);
                    to_delete.push(i);
                }
            }

            for (var i = to_delete.length -1; i >= 0; i--)
                controller.remainingMarkers.splice(to_delete[i],1);

            if(reload)
                MapService.loadClusterer();

            $scope.center_loader = false;
            if(!$scope.$$phase) {
                $scope.$apply();
            }

        }, 200);
    }

    controller.callback = function() {

        $http({
            method:'GET',
            url: 'api/markers',
            params: {
                token: $scope.token
            }
        })
        .success(function(data) {

            $scope.totalMarkers = data.markers.length;
            $rootScope.userData = data.data;

            controller.remainingMarkers = data.markers

            // array copy to avoid conflict with remainingMarkers reference.
            controller.markers = data.markers.slice();

            for(var i in controller.markers) {

                var marker = controller.markers[i];

                if(!controller.markersByNumber.hasOwnProperty(marker.number))
                    controller.markersByNumber[marker.number] = new Array();

                controller.markersByNumber[marker.number].push(marker);

                if($rootScope.userData.hasOwnProperty(marker.uuid)) {

                    if($rootScope.userData[marker.uuid].owner == true)
                        $scope.myMarkers.push(marker);
                }
            }

            $timeout(function() {

                controller.loadMarkers();

                $scope.loading = false;

            }, 2000)


            google.maps.event.addListener(MapService.map, 'zoom_changed', function() {

                controller.loadMarkers();
            });

            google.maps.event.addListener(MapService.map, 'dragend', function() { controller.loadMarkers(); } );

            var input = document.getElementById('pac-input');
            var searchBox = new google.maps.places.SearchBox(input);
            MapService.map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);

            MapService.map.addListener('bounds_changed', function() {
                searchBox.setBounds(MapService.map.getBounds());
            });

            searchBox.addListener('places_changed', function() {
                try {
                    var places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    var place = places[0];

                    if(!place.geometry)
                        throw new Error('api call limit');

                    MapService.map.panTo(place.geometry.location);
                    MapService.map.setZoom(16);
                    controller.loadMarkers();
                }
                catch(err) {

                    alert('It seems that we\'ve reached the limit of Google Places API calls. We\'ve already asked Google to increase our API limit, please, try again later. Thanks for your patience.');
                }
            });

            PageService.showMainSidebar();

        });
    }

    controller.loadPokemon = function(callback) {

        $http.get('api/start')
            .success(function(data) {

                $rootScope.focus = data.focus;

                $scope.pokemons  = data.pokemons;
                $scope.latest    = data.latest;
                $scope.locations = data.locations;

                $rootScope.token = data.token;

                if(typeof callback == 'function')
                    callback();
            });
    }

    InitService.addEventListener('ready' , function() {

        google.maps.event.addDomListener(window, 'load', controller.init);

        $('.nav-search-box').off('keyup');
        $('.nav-search-box').on('keyup', function() {

            if($(this).val() == '')
                return $('.pokemon-nav-list .pokemon').show();

            $('.pokemon-nav-list .pokemon').hide();
            $('.pokemon-nav-list .pokemon[data-query*="'+ $(this).val().toLowerCase() +'"]').show();
        });

    });
}]);

function googleLogin(user) {

    angular.element('[ng-controller]').scope().events.googleLogin(user);
}

window.onbeforeunload = function(e){
    gapi.auth2.getAuthInstance().signOut()
};