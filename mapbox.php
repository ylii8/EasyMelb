<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.2.0/mapbox-gl.css' rel='stylesheet' />
    <style>

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
        .marker {
            background-image: url('img/mapbox-icon.png');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

    </style>
</head>

<body>
<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v3.1.3/mapbox-gl-directions.js'></script>
<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v3.1.3/mapbox-gl-directions.css' type='text/css' />

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.html"><img src="img/logo.PNG" style="margin-right:.3rem;margin-bottom:3px;width:2.2rem;height:2.2rem;">Your Guider</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="#">Map</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<section class="yellow bg-primary" id="contact">
    <div class="container">
        <h2>Check out seats, toilets and drinking fountains!</h2>
    </div>
    <div class="container_map row no-gutters">
        <!-- Filter Checkboxes -->
        <div class="marker-filter col-lg-2" style="margin-left: 30px">
            <p style="margin-top: 8rem; font-size: 25px; font-weight: bold;">To find out:</p>
            <span class="filter-box">
            <label for="seats" style="font-size: 18px;">
                <input type="checkbox" name="seats" id="seats" onclick="getSeats()">
                Seats
            </label>
        </span>
            <hr>
            <span class="filter-box">
            <label for="toilets" style="font-size: 18px;">
                <input type="checkbox" name="toilets"  id="toilets" onclick="getToilets()">
                Toilets
            </label>
        </span>
            <hr>
            <span class="filter-box">
            <label for="drinking_fountains" style="font-size: 18px;">
                <input type="checkbox" name="drinking_fountains" id="drinking_fountains" onclick="getDrink()">
                Drinking Fountains
            </label>
        </span>
            <hr>
            <p id="seatText" style="display:none">More functions are upcoming!</p>

        </div>
             <div class="col-lg-9" id='map' ></div>
    </div>
</section>



<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>



<?php include_once 'locations_model.php'; ?>

<script>

    mapboxgl.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw';

    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/light-v10', //style URL of map style
        center: [144.96565, -37.81384], //default location when load the map
        zoom: 15, //default zoom level
        // Zero is perpendicular to the surface
        pitch: 45,
        // the compass direction that is "up"
        bearing: -17.6,
    });
    var seatMarkers = [];
    var toiletMarkers = [];
    var drinkMarkers = [];
    var locations;


    function getToilets(){

        var checkBox = document.getElementById("toilets");
        if (checkBox.checked == true)
        {
            locations = <?php get_toilet_locations() ?>;
            var markers = [];
            var i ;
            for (i = 0; i < locations.length; i++)
            {
                var marker = new mapboxgl.Marker({color:'#ff1744'})
                    .setLngLat([locations[i][2], locations[i][1]])
                    .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                        .setHTML('<h3>'+ 'Detailed location:' +'</h3><p>' + locations[i][0] + '</p>'))
                    .addTo(map);

                markers.push(marker);

            }
            toiletMarkers = markers;
        }
        else
        {
            for (var i = 0; i < toiletMarkers.length; i++) {
                toiletMarkers[i].remove();
            }
        }
    }

    function getDrink(){

        var checkBox = document.getElementById("drinking_fountains");
        if (checkBox.checked == true)
        {
            locations = <?php get_drink_locations() ?>;
            var markers = [];
            var i ;
            for (i = 0; i < locations.length; i++)
            {
                var marker = new mapboxgl.Marker()
                    .setLngLat([locations[i][2], locations[i][1]])

                    .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                    .setHTML('<h3>'+ 'Detailed location:' +'</h3><p style=\"text-align: Left;\">' + locations[i][0] + '</p>'))
                    .addTo(map);

                markers.push(marker);

            }
            drinkMarkers = markers;
        }
        else
        {
            for (var i = 0; i < drinkMarkers.length; i++) {
                drinkMarkers[i].remove();
            }
        }
    }

    function getSeats(){

        var checkBox = document.getElementById("seats");
        if (checkBox.checked == true)
        {
            locations = <?php get_seats_locations() ?>;
            var markers = [];
            var i ;
            for (i = 0; i < locations.length; i++)
            {
                var marker = new mapboxgl.Marker({color: '#79c142'})
                    .setLngLat([locations[i][2], locations[i][1]])
                    .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
                        .setHTML('<h3>'+ 'Detailed location:' +'</h3><p>' + locations[i][0] + '</p>'))
                    .addTo(map);

                markers.push(marker);

            }
            seatMarkers = markers;
        }
        else
        {
            for (var i = 0; i < seatMarkers.length; i++) {
                seatMarkers[i].remove();
            }
        }
    }




</script>







</html>