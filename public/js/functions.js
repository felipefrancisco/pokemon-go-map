function url( path ) {

    if(typeof path === 'undefined')
        path = '';

    if(path.indexOf('http') !== -1)
        return path;

    return host + path;
}

function redirect( path ) {

    window.location = url(path);
}

function componentToHex(c) {
    var hex = c.toString(16);
    return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {

    return "#" + componentToHex(r) + componentToHex(g) + componentToHex(b);
}

function LongPress(map, length) {
    this.length_ = length;
    var me = this;
    me.map_ = map;
    me.timeoutId_ = null;
    google.maps.event.addListener(map, 'mousedown', function(e) {
        me.onMouseDown_(e);
    });
    google.maps.event.addListener(map, 'mouseup', function(e) {
        me.onMouseUp_(e);
    });
    google.maps.event.addListener(map, 'drag', function(e) {
        me.onMapDrag_(e);
    });
};

LongPress.prototype.onMouseUp_ = function(e) {
    clearTimeout(this.timeoutId_);
};

LongPress.prototype.onMouseDown_ = function(e) {
    clearTimeout(this.timeoutId_);
    var map = this.map_;
    var event = e;
    this.timeoutId_ = setTimeout(function() {
        google.maps.event.trigger(map, 'longpress', event);
    }, this.length_);
};

LongPress.prototype.onMapDrag_ = function(e) {
    clearTimeout(this.timeoutId_);
};

google.maps.Map.prototype.clearMarkers = function(markers) {
    for(var i=0; i < markers.length; i++){

        if(markers[i].circle)
            markers[i].circle.setMap(null);

        markers[i].setMap(null);
    }
};
