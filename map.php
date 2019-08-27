<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>

    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
            width: 100%;
            border: 1px solid lightyellow;
            background-color:grey;
            shape-outside: ellipse();
        }
        .container_map{
            height:600px;
        }
        .filter-box {
            padding: 5px 10px;
            border: 1px solid #e8e8e8;
        }
        .marker-filter hr{
            width:0;
        }

    </style>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.html"><img src="img/logo.PNG" style="margin-right:.3rem;margin-bottom:3px;width:2.2rem;height:2.2rem;">Your Guider</a>
    </div>
</nav>



<!--map-->

<div class="container_map row no-gutters">
    <!-- Filter Checkboxes -->
    <div class="marker-filter col-lg-1">
        <hr>
        <span class="filter-box">
            <label for="seats">
                <input type="checkbox" name="seats" id="seats" onclick="getSeats()">
                Seats
            </label>
        </span>
        <hr>
        <span class="filter-box">
            <label for="toilets">
                <input type="checkbox" name="toilets"  id="toilets" onclick="getToilet()">
                Toilets
            </label>
        </span>
        <hr>
        <span class="filter-box">
            <label for="drinking_fountains">
                <input type="checkbox" name="drinking_fountains" id="drinking_fountains" onclick="getDrink()">
                Drinking Fountains
            </label>
        </span>
<!--        <p id="seatText" style="display:none">Seats is SELECTED!</p>-->
<!--        <p id="drinkText" style="display:none">Drinking Fountains is SELECTED!</p>-->
<!--        <p id="toiletText" style="display:none">Toilets is SELECTED!</p>-->
    </div>
    <div class="col-lg-11" id="map"></div>
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
    // var markers =[];
    var seatMarkers = [];
    var toiletMarkers = [];
    var drinkMarkers = [];
    var infowindow;
    var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
    var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
    var locations;

    function getSeats(){

        var checkBox = document.getElementById("seats");
        // var text = document.getElementById("seatText");
        if (checkBox.checked == true)
        {
            // text.style.display = "block";
            locations = <?php get_seats_locations() ?>;
            seatMarkers=addMarkers();
        }
        else
        {
            // text.style.display = "none";
            for (var i = 0; i < seatMarkers.length; i++) {
                seatMarkers[i].setMap(null);
            }
        }
    }

    function getDrink(){

        var checkBox = document.getElementById("drinking_fountains");
        // var text = document.getElementById("drinkText");
        if (checkBox.checked == true)
        {
            // text.style.display = "block";
            locations = <?php get_drink_locations() ?>;
            drinkMarkers = addMarkers();
        }
        else
        {
            // text.style.display = "none";
            for (var i = 0; i < drinkMarkers.length; i++) {
                drinkMarkers[i].setMap(null);
            }
        }
    }

    function getToilet(){

        var checkBox = document.getElementById("toilets");
        // var text = document.getElementById("toiletText");
        if (checkBox.checked == true)
        {
            // text.style.display = "block";
            locations = <?php get_toilet_locations() ?>;
            toiletMarkers=addMarkers();
        }
        else
        {
            // text.style.display = "none";
            for (var i = 0; i < toiletMarkers.length; i++) {
                toiletMarkers[i].setMap(null);
            }
        }
    }


    function initMap()
    {

        var Melbourne = {lat: -37.8136, lng: 144.9631};
        infowindow = new google.maps.InfoWindow();
        map = new google.maps.Map(document.getElementById('map'), {
        center: Melbourne,
        zoom: 15
        });
        // addMarkers();

    }

    // check checkbox first, get data, add marker


    function addMarkers()
    {
        var markers =[];
        var i ;
        for (i = 0; i < locations.length; i++)
        {

            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                // icon: locations[i][5] === 'A' ? red_icon : purple_icon,
                html: document.getElementById('form')

            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    // $("#id").val(locations[i][0]);
                    $("#description").val(locations[i][4]);
                    $("#form").show();
                    infowindow.setContent(marker.html);
                    infowindow.open(map, marker);
                }
            })(marker, i));
            markers.push(marker);
        }
        return markers;
    }

    // function removeSeatsMarker()
    // {
    //
    //     for (var i = 0; i < markers.length; i++) {
    //         markers[i].setMap(null);
    //     }
    // }
    //


</script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBE_QUgncNwk1lNw3QdVic6K5qIFj9_13o&callback=initMap"
        async defer></script>

</html>