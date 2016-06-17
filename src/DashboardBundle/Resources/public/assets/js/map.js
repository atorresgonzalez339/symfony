
var marker = null;
var map = null;
var map_autocomplete = null;

function initialize(params) {

    var mapOptions = {
        center: new google.maps.LatLng(params.center_lat, params.center_lng),
        scrollwheel: false,
        zoom: params.zoom
    };

    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    var input = document.getElementById(params.map_input_id);

    var types = document.getElementById('type-selector');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

    map_autocomplete = new google.maps.places.Autocomplete(input);
    map_autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();

    if(params.show_marker){
        setMarker(params);
    }

    google.maps.event.addListener(map_autocomplete, 'place_changed', function () {
        infowindow.close();

        if(marker){
            marker.setVisible(false);
        }

        var place = map_autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
        }

        setMarker({
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng()
        });

        $('#' + params.map_input_lat_id).val(place.geometry.location.lat());
        $('#' + params.map_input_lng_id).val(place.geometry.location.lng());
        $('#' + params.map_input_zoom_id).val(map.getZoom());
        $('#' + params.map_input_center_lat_id).val(place.geometry.location.lat());
        $('#' + params.map_input_center_lng_id).val(place.geometry.location.lng());

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }

        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
    });

    google.maps.event.addListener(map, 'zoom_changed', function() {
        $('#' + params.map_input_zoom_id).val(map.getZoom());
    });

    google.maps.event.addListener(map, 'center_changed', function() {
        $('#' + params.map_input_center_lat_id).val(map.center.lat());
        $('#' + params.map_input_center_lng_id).val(map.center.lng());
    });
}

function setMarker(params){

    if(!marker){
        marker = new google.maps.Marker({
            draggable: true,
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        google.maps.event.addListener(marker, "mouseup", function (event) {
            $('#' + params.map_input_lat_id).val(this.position.lat());
            $('#' + params.map_input_lng_id).val(this.position.lng());
            $('#' + params.map_input_zoom_id).val(map.getZoom());
        });
    }

    marker.setPosition(new google.maps.LatLng(params.lat,params.lng));

    marker.setVisible(true);
}
