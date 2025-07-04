<!DOCTYPE html>
<html>
<head>
    <title>Google Map with Route</title>
    <style>
        #map { height: 600px; width: 100%; }
    </style>
</head>
<body>
    <h3>Map Example</h3>
    <div id="map"></div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB3EAcy39SPZKs1aM7DbL1l7CFTUU1qepE&libraries=places"></script>

    <script>
    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 28.5708, lng: 77.3260 }, // Noida coordinates
            zoom: 13
        });

        const directionsService = new google.maps.DirectionsService();
        const directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map);

        calculateAndDisplayRoute(directionsService, directionsRenderer);
    }

    function calculateAndDisplayRoute(directionsService, directionsRenderer) {
        directionsService.route(
            {
                origin: "Noida Sector 18 Metro Station",
                destination: "Noida City Centre",
                travelMode: google.maps.TravelMode.DRIVING, // ✅ missing comma added
            },
            (response, status) => {
                if (status === "OK") {
                    directionsRenderer.setDirections(response);
                } else {
                    alert("Directions request failed due to " + status);
                }
            }
        );
    }

    window.onload = initMap;
    </script>
</body>
</html>
