<!DOCTYPE html>
<html>
<head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
</head>
<body>
<style>

    /* Optional: Makes the sample page fill the window. */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
    #map {
        height: 100%;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<?php
include_once 'locations_model.php';
?>


<div id="map"></div>

<!------ Include the above in your HEAD tag ---------->
<script>
    var map;
    var marker;
    var infowindow;
    var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
    var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
    var locations = <?php get_all_locations() ?>;

    function initMap() {
        var Melbourne = {lat: -37.8136, lng: 144.9631};
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(document.getElementById('map'), {
            center: Melbourne,
            zoom: 15
        });

        var i ; 
        for (i = 0; i < locations.length; i++) {

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][2], locations[i][3]),
                map: map,
                icon :   locations[i][5] === 'A' ?  red_icon  : purple_icon,
            });
        }
    }

</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBE_QUgncNwk1lNw3QdVic6K5qIFj9_13o&callback=initMap">
</script>