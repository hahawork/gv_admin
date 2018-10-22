(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function () {

        var center = [12.106283, -86.248980];

        var map = L.map(
                'google_map',
                {
                    center: center,
                    zoom: 16
                });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //L.tileLayer('https://api.tiles.mapbox.com/v4/MapID/997/256/{z}/{x}/{y}.png', {
            //L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=' + mapboxAccessToken, {
            id: 'mapbox.satellite',
            attribution: '&copy; <a href="https://www.grupovalor.com.ni/mo">Marketing One </a> HHerrera',
            minZoom: 16, maxZoom: 16,
            updateWhenIdle: true,
            reuseTiles: true
        }).addTo(map);

        var myIcon = L.icon({
            iconUrl: 'images/icons/map-marker.png',
            iconSize: [23, 35],
            iconAnchor: [22, 34],
            popupAnchor: [-3, -30]
        });
        L.marker([12.112407, -86.252761], {icon: myIcon})
                .addTo(map)
                .bindPopup("Marketing One")
                .openPopup()
    });

})(jQuery);