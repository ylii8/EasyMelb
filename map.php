<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>

    <script type="text/javascript" src="js/googleMap.js"></script>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            margin-top: 3rem;
            height: 600px;
            width: 100%;
            background-color:grey;
        }
        #lightData{
            display:none;
        }
    </style>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.php"><img src="img/logo.PNG" style="margin-right:.3rem;margin-bottom:3px;width:2.2rem;height:2.2rem;">Your Guider</a>
    </div>
</nav>


<!--map-->

<div class="container">
    <div id="map"></div>
</div>


<!--click event -->
<div style="display: none" id="form">
    <table class="map1">
        <tr>
            <input name="id" type='hidden' id='id'/>
            <td><a>Description:</a></td>
            <td><textarea disabled id='description' placeholder='Description'></textarea></td>
        </tr>
        <tr><td></td><td><input type='button' value='View Histroy Record' onclick='HistroyData()'/></td></tr>
    </table>
</div>

<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>




<!-- GoogleMap js (show markers and click events)-->
<?php include_once 'locations_model.php'; ?>
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
        icon: locations[i][5] === 'A' ? red_icon : purple_icon,
        html: document.getElementById('form')

    });

    google.maps.event.addListener(marker, 'click', (function (marker, i) {
        return function () {
            $("#id").val(locations[i][0]);
            $("#description").val(locations[i][4]);
            $("#form").show();
            infowindow.setContent(marker.html);
            infowindow.open(map, marker);
        }
    })(marker, i));

    }
}
</script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBE_QUgncNwk1lNw3QdVic6K5qIFj9_13o&callback=initMap"
        async defer></script>

</html>