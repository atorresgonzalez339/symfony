
var marker = null;
var map = null;
var map_autocomplete = null;

function initialize(lat, lng, map_input_id, map_input_lat_id, map_input_lng_id, show_marker) {
    var mapOptions = {
        center: new google.maps.LatLng(lat, lng),
        scrollwheel: false,
        zoom: 13
    };

    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    var input = /** @type {HTMLInputElement} */(
        document.getElementById(map_input_id));

    var types = document.getElementById('type-selector');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

    map_autocomplete = new google.maps.places.Autocomplete(input);
    map_autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();

    if(show_marker){
        setMarker(new google.maps.LatLng(lat,lng));
    }

    google.maps.event.addListener(map_autocomplete, 'place_changed', function () {
        infowindow.close();
        marker.setVisible(false);
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

        setMarker(place.geometry.location);

        $('#' + map_input_lat_id).val(place.geometry.location.lat());

        $('#' + map_input_lng_id).val(place.geometry.location.lng());

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
}

function setMarker(position){

    if(!marker){
        marker = new google.maps.Marker({
            draggable: true,
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        google.maps.event.addListener(marker, "mouseup", function (event) {
            $('#' + map_input_lat_id).val(this.position.lat());
            $('#' + map_input_lng_id).val(this.position.lng());
        });
    }

    //marker.setIcon(/** @type {google.maps.Icon} */({
    //    size: new google.maps.Size(71, 71),
    //    origin: new google.maps.Point(0, 0),
    //    anchor: new google.maps.Point(17, 34),
    //    scaledSize: new google.maps.Size(35, 35)
    //}));

    marker.setPosition(position);

    marker.setVisible(true);
}
