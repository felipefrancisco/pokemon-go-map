app.factory('ApiService', ['$rootScope', function ($rootScope) {
    'use strict';

    var service = this;

    service.token = null;

    service.marker = function(data, callback) {

        $.post('api/marker', data, callback);
    }

    service.removeMarker = function() {

    }

    service.registerNewUser = function() {

    }

    service.token = function() {

    }

    service.request = function() {

    }


    service.auth = function(data, callback) {

        $.post('api/auth', data, function(data) {

            if(typeof callback === 'function')
                callback(data);
        });
    }

    return service;

}]);