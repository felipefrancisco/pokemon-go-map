/**
 * request interceptor to auto add the content-type
 * @see http://stackoverflow.com/a/19633847/1891542
 */
app.config(['$httpProvider', function ($httpProvider) {


    $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    $httpProvider.defaults.transformRequest.unshift(function (data, headersGetter) {
        var key, result = [];

        if (typeof data === "string")
            return data;

        for (key in data) {
            if (data.hasOwnProperty(key))
                result.push(encodeURIComponent(key) + "=" + encodeURIComponent(data[key]));
        }
        return result.join("&");
    });
}]);


app.filter('reverse', function() {
    return function(items) {
        return items.slice().reverse();
    };
});