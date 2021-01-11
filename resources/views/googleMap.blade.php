<!DOCTYPE html>
<html>
<head>
    <title>Add Map</title>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzFFGKTLODEd4uZH3vce8U-PL4c5zq-UQ&callback=initMap&libraries=&v=weekly"
        defer
    ></script>
    <!-- jsFiddle will insert css and js -->
</head>
<body>
<h3>My Google Maps Demo</h3>
<!--The div element for the map -->
<div id="map"></div>
<script>
    function initMap() {
        // The location of Uluru
        const uluru = { lat: -25.344, lng: 131.036 };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            center: uluru,
        });
        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
            position: uluru,
            map: map,
        });
    }
</script>
</body>
</html>
