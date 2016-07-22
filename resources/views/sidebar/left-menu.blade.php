<section id="wrapper" class="toggled-2 hidden-xs" ng-show="token">

    <div id="sidebar-wrapper">
        <ul class="sidebar-nav nav-pills nav-stacked" id="menu">

            <li class="active">
                <a href="#"  ng-click="events.showSplashScreen()"><span class="fa-stack fa-lg pull-left"><i class="fa fa-question-circle fa-stack-1x "></i></span> How to use?</a>
            </li>

            <li class="active">
                <a href="#" class="my-locations-link" ng-click="events.myMarkersClick()"><span class="fa-stack fa-lg pull-left"><i class="fa fa-map-pin fa-stack-1x "></i></span> Show my Markers</a>
            </li>

            <li class="active">
                <a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-map-marker fa-stack-1x "></i></span> My Locations</a>
                <ul class="nav-pills nav-stacked default-open" style="list-style-type:none;">
                    <li ng-show="!locations.length" class="no-locations">
                        <a href="#">
                            No locations found.
                        </a>
                    </li>
                    <li ng-repeat="location in locations">
                        <div class="remove-location">
                            <i class="fa fa-remove remove-icon" ng-click="events.removeLocation(location)"></i>
                        </div>
                        <a href="#" ng-click="events.goToLocation(location.lat, location.lng)">
                            @{{ location.name  }}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</section>