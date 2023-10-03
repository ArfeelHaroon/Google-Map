<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>How to Add Google Map in Laravel? - ItSolutionStuff.com</title>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style type="text/css">
        #map {
            height: 400px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Google Map</h2>
        <input id="location-search" type="text" placeholder="Search for a location...">
        <div id="map">
        </div>
    </div>

    <script type="text/javascript">
        let map;
        let marker;

        function initMap() {
            // Check if geolocation is available in the browser
            if ("geolocation" in navigator) {
                // Get the user's current position
                navigator.geolocation.getCurrentPosition(function(position) {
                    const userLatLng = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 10, // You can adjust the zoom level as needed
                        center: userLatLng,
                    });

                    marker = new google.maps.Marker({
                        position: userLatLng,
                        map: map,
                        title: "Your Current Location",
                    });

                    // Initialize the Places Autocomplete service
                    const input = document.getElementById('location-search');
                    const autocomplete = new google.maps.places.Autocomplete(input);

                    // When a place is selected, set the map's center and update the marker
                    autocomplete.addListener('place_changed', function() {
                        const place = autocomplete.getPlace();
                        if (!place.geometry) {
                            return; // No place data available
                        }

                        // Set the map's center to the selected place
                        map.setCenter(place.geometry.location);

                        // Update the marker's position
                        marker.setPosition(place.geometry.location);
                    });

                    // Initialize the Drawing Manager
                    const drawingManager = new google.maps.drawing.DrawingManager({
                        drawingControl: true,
                        drawingControlOptions: {
                            position: google.maps.ControlPosition.TOP_CENTER,
                            drawingModes: ['marker', 'circle', 'polygon', 'polyline', 'rectangle'],
                        },
                    });

                    drawingManager.setMap(map);
                });
            } else {
                // Geolocation is not available in this browser
                alert("Geolocation is not supported in your browser.");
            }
        }

        window.initMap = initMap;
    </script>

    <!-- Include the Google Maps API with the Places Library and the callback function -->
    {{-- <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap">
    </script> --}}

    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places,drawing&callback=initMap">
    </script>
</body>

</html>
