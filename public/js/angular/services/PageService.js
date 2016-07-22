app.factory('PageService', ['$rootScope', '$timeout', function ($rootScope, $timeout) {
    'use strict';

    var service = this;

    service.hideSidebar = function() {

        $('.sidebar').addClass('off');
    }

    service.hideAll = function() {

        service.hideMyLocationsScreen();
        service.hideSplashScreen();
        service.hideSidebar();
    }

    service.hideAllRight = function() {

        service.hideFilters();
        service.hideMyMarkersBox();
    }

    service.hideSplashScreen = function() {

        $('.splash-screen').addClass('off');
        $('.chitikaAdContainer').remove();
    }

    service.showSplashScreen = function() {

        service.hideAll();
        $('.splash-screen').removeClass('off');
    }

    service.hideMyLocationsScreen = function() {

        $('.save-my-location-screen').addClass('off');
    }

    service.showMyLocationScreen = function() {

        service.hideAll();
        $('.save-my-location-screen').removeClass('off');
        $('[name="mylocation"]').focus();
    }


    service.showMainSidebar = function() {

        service.hideSidebar();
        $('.main-sidebar').removeClass('off');
    }

    service.showAddSidebar = function() {

        service.hideAll();
        $('.add-pokemon-sidebar').removeClass('off');
    }

    service.showViewSidebar = function() {

        service.hideAll();
        $('.view-pokemon-sidebar').removeClass('off');
    }

    service.showFilters = function() {

        service.hideAllRight();
        $('.filters').removeClass('off-right');


        $timeout(function() {
            $('.filters').show();
        }, 400);
    }

    service.hideFilters = function() {

        $('.filters').addClass('off-right');

        $timeout(function() {
            $('.filters').hide();
        }, 400);
    }

    service.showMyMarkersBox = function() {

        service.hideAllRight();
        $('.my-markers-box').removeClass('off-right');

        $timeout(function() {
            $('.my-markers-box').show();
        }, 400);
    }

    service.hideMyMarkersBox = function() {

        $('.my-markers-box').addClass('off-right');
        $timeout(function() {
            $('.my-markers-box').hide();
        }, 400);
    }


    return service;

}]);