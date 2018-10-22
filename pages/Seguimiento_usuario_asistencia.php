<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <title>Simple Polylines</title>
        <style>
            /* Always set the map height explicitly to define the size of the div
             * element that contains the map. */
            #map {
                height: 100%;
            }
            /* Optional: Makes the sample page fill the window. */
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body>
        <script src="https://maps.googleapis.com/maps/api/js"></script>
        <div id="map"></div>
        <script type="text/javascript">
            var geocoder;
            var map;
            var directionsDisplay;
            var directionsService = new google.maps.DirectionsService();
            var locations = [
                ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
                ['Bondi Beach', -33.890542, 151.274856, 4],
                ['Coogee Beach', -33.923036, 151.259052, 5],
                ['Maroubra Beach', -33.950198, 151.259302, 1],
                ['Cronulla Beach', -34.028249, 151.157507, 3]
            ];

            function initialize() {
                directionsDisplay = new google.maps.DirectionsRenderer();


                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 10,
                    center: new google.maps.LatLng(-33.92, 151.25),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                directionsDisplay.setMap(map);
                var infowindow = new google.maps.InfoWindow();

                var marker, i;
                var request = {
                    travelMode: google.maps.TravelMode.DRIVING
                };
                for (i = 0; i < locations.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map
                    });

                    google.maps.event.addListener(marker, 'click', (function (marker, i) {
                        return function () {
                            infowindow.setContent(locations[i][0]);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                    if (i == 0)
                        request.origin = marker.getPosition();
                    else if (i == locations.length - 1)
                        request.destination = marker.getPosition();
                    else {
                        if (!request.waypoints)
                            request.waypoints = [];
                        request.waypoints.push({
                            location: marker.getPosition(),
                            stopover: true
                        });
                    }

                }
                directionsService.route(request, function (result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {
                        directionsDisplay.setDirections(result);
                    }
                });
            }
            google.maps.event.addDomListener(window, "load", initialize);

            /*
             var geocoder;
             var map;
             var directionsDisplay;
             var directionsService = new google.maps.DirectionsService();
             
             function initMap() {
             
             directionsDisplay = new google.maps.DirectionsRenderer();
             var map = new google.maps.Map(document.getElementById('map'), {
             center: {lat: 12.147755, lng: -86.304353},
             mapTypeId: 'terrain',
             zoom: 14
             //center: new google.maps.LatLng(-86.304353, 12.147755)
             //mapTypeId: google.maps.MapTypeId.ROADMAP
             });
             var locations = [
             ['Manly Beach', -86.304353, 12.147755, 2],
             ['Bondi Beach', -86.247925, 12.103431, 4],
             ['Coogee Beach', -86.214004, 12.066714, 5],
             ['Maroubra Beach', -86.2975359, 12.1060528, 1],
             ['Cronulla Beach', -86.2975359, 12.1060528, 3]
             ];
             
             var flightPlanCoordinates = [
             {lat: 12.147755, lng: -86.304353},
             {lat: 12.103431, lng: -86.247925},
             {lat: 12.066714, lng: -86.214004},
             {lat: 12.1060528, lng: -86.2975359},
             {lat: 12.1060528, lng: -86.2975359}
             ];
             
             var image = {
             url: '../dist/pin.png',
             // This marker is 20 pixels wide by 32 pixels high.
             size: new google.maps.Size(23, 35),
             // The origin for this image is (0, 0).
             origin: new google.maps.Point(0, 0),
             // The anchor for this image is the base of the flagpole at (0, 32).
             anchor: new google.maps.Point(0, 35)
             };
             // Shapes define the clickable region of the icon. The type defines an HTML
             // <area> element 'poly' which traces out a polygon as a series of X,Y points.
             // The final coordinate closes the poly by connecting to the first coordinate.
             var shape = {
             coords: [1, 1, 1, 23, 18, 35, 18, 10],
             type: 'poly'
             };
             
             directionsDisplay.setMap(map);
             var infowindow = new google.maps.InfoWindow();
             var marker, i, n;
             var request = {
             travelMode: google.maps.TravelMode.DRIVING
             };
             var marker1 = [];
             for (n = 0; n < flightPlanCoordinates.length; n++) {
             marker1[n] = new google.maps.Marker({
             position: new google.maps.LatLng(flightPlanCoordinates[n][1], flightPlanCoordinates[n][2]),
             title: 'titulo',
             map: map,
             label: 'p',
             draggable: false,
             icon: image,
             shape: shape,
             id: n
             });
             //
             marker = new google.maps.Marker({
             position: new google.maps.LatLng(locations[n][1], locations[n][2]),
             });
             
             google.maps.event.addListener(marker, 'click', (function (marker, n) {
             return function () {
             infowindow.setContent(locations[n][0]);
             infowindow.open(map, marker);
             }
             })(marker, n));
             if (n == 0)
             request.origin = marker.getPosition();
             
             else if (n == locations.length - 1)
             request.destination = marker.getPosition();
             
             else {
             if (!request.waypoints)
             request.waypoints = [];
             
             request.waypoints.push({
             location: marker.getPosition(),
             stopover: true
             });
             }
             }
             
             directionsService.route(request, function (result, status) {
             if (status == google.maps.DirectionsStatus.OK) {
             directionsDisplay.setDirections(result);
             }
             });
             // 
             var flightPath = new google.maps.Polyline({
             path: flightPlanCoordinates,
             geodesic: true,
             strokeColor: '#FF0000',
             strokeOpacity: 1.0,
             strokeWeight: 2
             });
             flightPath.setMap(map);
             }
             google.maps.event.addDomListener(window, "load", initMap);
             */</script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9OxMLn656_GQYD15qs94-A6ieBcFmFTs&callback=initialize">
        </script>
    </body>
</html>