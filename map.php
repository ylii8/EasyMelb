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
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger" href="aboutUs.php">About us</a>
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
                <input type="checkbox" name="toilets"  id="toilets" onclick="getToilet()">
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
            <!--        <p id="drinkText" style="display:none">Drinking Fountains is SELECTED!</p>-->
            <!--        <p id="toiletText" style="display:none">Toilets is SELECTED!</p>-->
        </div>
        <div class="col-lg-9" id="map" ></div>
    </div>
</section>


<!--map-->




<!--click event -->
<div style="display: none" id="form">
    <table class="map1">
        <tr>
            <input name="id" type='hidden' id='id'/>
            <td><a>Detailed Location:</a></td>
            <td><textarea disabled id='description' placeholder='Description'></textarea></td>
        </tr>
<!--        <tr><td></td><td><input type='button' value='View Histroy Record' onclick='HistroyData()'/></td></tr>-->
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
    var infoBubble;
    var toilet_icon = "img/toilet.png";
    var drink_icon = "img/drink.png";
    var seat_icon = "img/seat.png";
    var locations;

    function getSeats(){

        var checkBox = document.getElementById("seats");
        var text = document.getElementById("seatText");
        if (checkBox.checked == true)
        {
             text.style.display = "block";
            //locations = <?php //get_seats_locations() ?>//;
            //var markers =[];
            //var i ;
            //for (i = 0; i < locations.length; i++)
            //{
            //
            //    marker = new google.maps.Marker({
            //        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            //        map: map,
            //        icon: seat_icon,
            //        html: document.getElementById('form')
            //
            //    });
            //
            //    google.maps.event.addListener(marker, 'click', (function (marker, i) {
            //        return function () {
            //            // $("#id").val(locations[i][0]);
            //            $("#description").val(locations[i][0]);
            //            $("#form").show();
            //             infowindow.setContent(marker.html);
            //             infowindow.open(map, marker);
            //            // infoBubble.setContent(marker.html);
            //            // infoBubble.open(map, marker);
            //        }
            //    })(marker, i));
            //    markers.push(marker);
            //}
            //    seatMarkers = markers;
        }
        else
        {
            text.style.display = "none";
            // for (var i = 0; i < seatMarkers.length; i++) {
            //     seatMarkers[i].setMap(null);
            // }
        }
    }

    function getDrink(){

        var checkBox = document.getElementById("drinking_fountains");
        // var text = document.getElementById("drinkText");
        if (checkBox.checked == true)
        {
            // text.style.display = "block";
            locations = <?php get_drink_locations() ?>;
            var markers =[];
            var i ;
            for (i = 0; i < locations.length; i++)
            {

                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: drink_icon,
                    html: document.getElementById('form')

                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        // $("#id").val(locations[i][0]);
                        $("#description").val(locations[i][0]);
                        $("#form").show();
                        infowindow.setContent(marker.html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
                markers.push(marker);
            }
            drinkMarkers = markers;
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
            var markers =[];
            var i ;
            for (i = 0; i < locations.length; i++)
            {

                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    icon: toilet_icon,
                    html: document.getElementById('form')

                });

                google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        // $("#id").val(locations[i][0]);
                        $("#description").val(locations[i][0]);
                        $("#form").show();
                        infowindow.setContent(marker.html);
                        infowindow.open(map, marker);
                    }
                })(marker, i));
                markers.push(marker);
            }
            toiletMarkers = markers;
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



    // function addMarkers()
    // {
    //     var markers =[];
    //     var i ;
    //     for (i = 0; i < locations.length; i++)
    //     {
    //
    //         marker = new google.maps.Marker({
    //             position: new google.maps.LatLng(locations[i][1], locations[i][2]),
    //             map: map,
    //             // icon: locations[i][5] === 'A' ? red_icon : purple_icon,
    //             html: document.getElementById('form')
    //
    //         });
    //
    //         google.maps.event.addListener(marker, 'click', (function (marker, i) {
    //             return function () {
    //                 // $("#id").val(locations[i][0]);
    //                 $("#description").val(locations[i][4]);
    //                 $("#form").show();
    //                 infowindow.setContent(marker.html);
    //                 infowindow.open(map, marker);
    //             }
    //         })(marker, i));
    //         markers.push(marker);
    //     }
    //     return markers;
    // }

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