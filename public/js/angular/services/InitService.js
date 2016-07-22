app.factory('InitService', ['$document', function ($document) {
    'use strict';

    var service = this,
        eventListeners = {
            'ready' : []
        };

    service.ready = false;

    service.addEventListener = function (eventName, listener) {

        eventListeners[eventName].push(listener);

        if(service.ready) {
            service.bindOnTheFlyReadyEvents();
        }
    };

    service.triggerReady = function() {

        var i;
        for (i = 0; i < eventListeners.ready.length; i = i + 1) {
            eventListeners.ready[i]();
            eventListeners.ready.splice(i, 1);
        }
    }

    service.fixDateInputs = function() {

        $('input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="time"], input[type="week"]').each(function() {

            var el = this;
            var $e = $(el);
            var type = $e.attr('type');

            if ($e.val() == '') $e.attr('type', 'text');
            $e.focus(function() {
                $e.attr('type', type);
                el.click();
            });
            $e.blur(function() {
                if ($e.val() == '') $e.attr('type', 'text');
            });
        });
    }

    function onReady() {

        $(document).on('ajaxStart', function (e) {
            /*
             if (e.detail.xhr.requestUrl.indexOf('autocomplete-languages.json') >= 0) {
             // Don't show preloader for autocomplete demo requests
             return;
             }
             */

            // hey
        });

        $(document).on('ajaxComplete', function (e) {

            // hey
        });

        service.fixDateInputs();
        service.triggerReady();

        service.ready = true;
    }


    service.init = function() {

        // Init
        (function () {
            $document.ready(function () {

                if (document.URL.indexOf("http://") === -1 && document.URL.indexOf("https://") === -1) {

                    // Cordova
                    console.log("Using Cordova/PhoneGap setting");
                    document.addEventListener("deviceready", onReady, false);

                }
                else {

                    // Web browser
                    console.log("Using web browser setting");
                    onReady();
                }

            });
        }());
    }

    service.bindOnTheFlyReadyEvents = function() {

        $document.ready(function () {

            service.triggerReady();
        });
    }

    service.init();

    return service;

}]);