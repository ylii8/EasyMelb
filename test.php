<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header.php'; ?>
    <meta charset='utf-8' />
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <!-- logo -->
    <link rel="icon" href="img/logo.PNG" mce_href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="img/logo.PNG" mce_href="favicon.ico" type="image/x-icon">
    <!-- Mapbox -->
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.0/mapbox-gl.css' rel='stylesheet' />
    <!-- Direction API-->
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v3.1.3/mapbox-gl-directions.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v3.1.3/mapbox-gl-directions.css' type='text/css' />
    <!-- Geocoder plugin -->
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.css' type='text/css' />
    <!-- Import jQuery -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <!-- Import Mapbox GL Draw -->
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.css' type='text/css' />
    <!-- jquery -->
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>
    <!--turf-->
    <script src='https://api.mapbox.com/mapbox.js/plugins/turf/v2.0.2/turf.min.js'></script>

<style>
    body { margin:0; padding:0; }
    #map { position:absolute; top:0; bottom:0; width:100%; }

    /* The sidepanel */
    .sidepanel {
        height: 410px; /* Specify a height */
        width: 0; /* 0 width - change this with JavaScript */
        position: fixed; /* Stay in place */
        z-index: 1; /* Stay on top */
        top: 0;
        right: 0;
        background-color: #707382;
        overflow-x: hidden; /* Disable horizontal scroll */
        padding-top: 60px; /* Place content 60px from the top */
        transition: 0.5s; /* 0.5 second transition effect to slide in the sidepanel */
    }
    /* The sidepanel links */
    .sidepanel a {
        padding: 8px 8px 8px 60px;
        text-decoration: none;
        font-size: 20px;
        color: black;
        display: block;
        transition: 0.3s;
    }
    /* When you mouse over the navigation links, change their color */
    .sidepanel a:hover {
        color: #fdcc52;
    }
    .sidepanel a:active {
        color: #fdcc52;
    }
    /* Position and style the close button (top left corner) */
    .sidepanel .closebtn {
        position: absolute;
        top: 0;
        left: 10px;
        font-size: 36px;
        margin-right: 50px;
        padding-left: 10px;
    }
    #sidepanel {
        display: block;
        position: absolute;
        top:15px;
        right: 40px;
        width: 80px;
        height: 40px;
        padding: 5px;
        border: none;
        text-align: center;
        font-size: 18px;
        font-family: 'Catamaran', 'Helvetica', 'Arial', 'sans-serif';
        font-weight: 800;
        letter-spacing: 1.7px;
        color: #545765;
        background: transparent;
        cursor: pointer;
    }
    #sidepanel:active:hover{
        color: #fdcc52;
    }

    /* logo */
    #logo {
        display: block;
        position: absolute;
        top:15px;
        left: 15px;
        background-color: transparent;
        border: none;
        font-size: 20px;
        font-family: 'Catamaran', 'Helvetica', 'Arial', 'sans-serif';
        font-weight: 800;
        letter-spacing: 2px;
        color: #545765;
    }
    #logo img{
        margin-right:.3rem;
        margin-bottom:3px;
        width:2.2rem;
        height:2.2rem;
    }

    /* current location */
    #fly {
        display: block;
        position: absolute;
        bottom:0;
        margin-left: 8px;
        margin-bottom: 140px;
        width: 37px;
        height: 37px;
        padding: 10px;
        border-radius: 50%;
        border-bottom: solid 2px rgba(92, 92, 92, 0.38);
        font-size: 13px;
        text-align: center;
        left:0;
        color: rgba(41, 41, 41, 0.99);
        background: rgba(253, 255, 251, 0.98);
        cursor: pointer;
    }
    #fly:hover{
        background: rgba(235, 236, 233, 0.84);
    }
    #fly:active{
        background: #fdcc52;
    }

    /* undo button */
    #undo {
        display: block;
        position: absolute;
        top:64px;
        left: 312px;
        width: 45px;
        height: 70px;
        padding: 5px;
        border-radius: 10%;
        border-bottom: solid 2px rgba(92, 92, 92, 0.38);
        font-size: 13px;
        text-align: center;
        color: rgba(41, 41, 41, 0.99);
        background: rgba(253, 255, 251, 0.98);
        cursor: pointer;
    }
    #undo:hover{
        background: rgba(235, 236, 233, 0.84);
    }
    #undo:active{
        background: #fdcc52;
    }

    .marker-filter hr {
        width: 0;
    }


    @media (max-width: 640px) {
        #fly {
            margin-bottom: 150px;
        }
    }
    @media (max-width: 415px) {
        #console{
            font-family: sans-serif;
            margin-left: 10px;
            width: 40%;
            margin-top: 17%;
        }
        #gradient_color{
            font-family: sans-serif;
            margin-left: 10px;
            width: 40%;
            margin-top: 19%;
        }

    }
    @media (max-width: 370px) {
        #logo{font-size: 16px;}
        #sidepanel{font-size: 16px;}
        .sidepanel a{font-size: 15px;}
    }

    h2 {
        font-size: 15px;
        font-weight: bold;
    }
    h3 {
        font-size: 10px;
        font-weight: bold;
    }

    #console {
        position: absolute;
        display:block;
        right:5px;
        bottom:0;
        width: 250px;
        height: fit-content;
        padding: 5px 20px;
        background-color: rgba(255, 255, 255, 0.9);
        margin-bottom: 30px;
    }

    .session {
        margin-bottom: 10px;
    }

    .row {
        height: 10px;
        width: 100%;
        margin-left: 0px;
        margin-right: 0px;
        display: block;

    }

    .colors {
        background: linear-gradient(to right, #95c78b, #72c55a, #15cb0b, #51c4c8, #2a6ed7, #132eda, #953f3f, #730709);
        margin-bottom: 5px;
    }

    .label {
        font-family: sans-serif;
        font-size: 12px;
        width: 29%;
        display: inline-block;
        text-align: center;
        cursor: default;
        font-weight: bold;
    }

    #gradient_color{
        position: absolute;
        height: fit-content;
        margin-bottom: 173px;
        right: 5px;
        bottom: 0;
        width: 250px;
        padding: 5px 20px;
        background-color: rgba(255, 255, 255, 0.9);
        display: none;
        margin-top: 0;
    }

    .row2 {
        height: 10px;
        width: 100%;
        margin-left: 0px;
        margin-right: 0px;
        display: block;
        line-height: 1px;
    }

    .colors2 {
        background: linear-gradient(to right, #ADFF2F, #FF3300, #6e0000);
        margin-bottom: 5px;
    }

    .label2 {
        font-family: sans-serif;
        font-size: 12px;
        width: 29%;
        display: inline-block;
        text-align: center;
        cursor: default;
        font-weight: bold;
    }
    .direction{
        margin-left: 10px;
        margin-top: 60px;
    }
    /* The snackbar - position it at the bottom and in the middle of the screen */
    #snackbar {
        visibility: hidden; /* Hidden by default. Visible on click */
        min-width: 250px; /* Set a default minimum width */
        margin-left: -125px; /* Divide value of min-width by 2 */
        background-color: #333; /* Black background color */
        color: #fff; /* White text color */
        text-align: center; /* Centered text */
        border-radius: 2px; /* Rounded borders */
        padding: 16px; /* Padding */
        position: fixed; /* Sit on top of the screen */
        z-index: 1; /* Add a z-index if needed */
        left: 50%; /* Center the snackbar */
        bottom: 30px; /* 30px from the bottom */
    }
    /* Show the snackbar when clicking on a button (class added with JavaScript) */
    #snackbar.show {
        visibility: visible; /* Show the snackbar */
        /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
        However, delay the fade out process for 2.5 seconds */
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    /* Animations to fade the snackbar in and out */
    @-webkit-keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
    }
    @keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
    }
    @-webkit-keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
    }
    @keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
    }
</style>
</head>

<?php include_once 'locations_model.php'; ?>
<body>

<div id="mySidepanel" class="sidepanel">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a id="seatButton"><i class="fas fa-chair"></i> Seats</a>
    <a id="toiletButton"><i class="fas fa-restroom"></i> Toilets</a>
    <a id="drinkButton"><i class="fas fa-tint"></i> Drinking fountains</a>
    <a id="gradientButton"><i class="fas fa-mountain"></i> Street steepness</a>
    <a id="densityButton"><i class="fas fa-users"></i> Pedestrian density</a>
    <a id="3dButton"><i class="fas fa-cubes"></i> 3D model</a>
    <a id="nearby"><i class="fas fa-search-location"></i> Nearby features</a>
</div>
<div id='map'></div>
<div id='direction' class='direction'></div>
<a id='logo' href="index.html" title="Go to Home Page" ><img src="img/logo.PNG">EasyMelb</a>
<button id='sidepanel' onclick="openNav()" title="More functions">Functions</button>
<button id='fly' title="Show current location"><i class="fa fa-location-arrow"></i></button>
<button id='undo' title="Undo drag changes"><i class="fas fa-undo-alt"></i>Undo</button>
<div id='console' style="display: none; height: fit-content">
    <div class='session'>
        <h2>Pedestrian</h2>
        <div class='row2 colors'></div>
        <div class='row2 labels'>
            <div class='label'>Low</div>
            <div class='label'>        </div>
            <div class='label'>High</div>
        </div>
    </div>
    <div class='session' id='sliderbar'>
        <h3>Hour: <label2 id='active-hour'>12PM</label2></h3>
        <input id='slider' class='row' type='range' min='0' max='23' step='1' value='12' />
    </div>
    <div class='session' >
        <h3>Day</h3>
        <div class='row2' id='filters'>
            <script type="text/javascript">
                var chartsdayid = new Array("Monday","Tuesday","Wednesday",
                    "Thursday","Friday","Saturday","Sunday");
                // choose different day
                function selectchangeday(e) {
                    // alert(e)
                    for(j = 0; j < chartsdayid.length; j++) {
                        try{
                            // document.getElementById(e).style.display="none";
                            if (chartsdayid[j]==e)
                            //document.getElementById(chartsyearid[j]).style.display="block";
                                document.getElementById(chartsdayid[j]).style.height="auto";
                            else
                            //document.getElementById(chartsyearid[j]).style.display="none";
                                document.getElementById(chartsdayid[j]).style.height="0";
                        }catch(err){
                            // alert(err);
                        }
                    }
                }
            </script>
            <select id="day" onchange="selectchangeday(this.value)" style="font-size: 10px; display: inline-block;" >
                <option value="Monday" selected="selected">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
            <button onclick="snackBar()" style="margin-left:35px;font-size: 13px;display: inline-block;">More details</button>
        </div>

    </div>
</div>
<div id='gradient_color' style="">
    <div class='session'>
        <h2>Gradient</h2>
        <div class='row2 colors2'></div>
        <div class='row2 labels2'>
            <div class='label2'>Low</div>
            <div class='label2'>        </div>
            <div class='label2'>High</div>
        </div>
    </div>
</div>
<div id="snackbar">The points show the sensor locations</div>

</body>


<script>

    mapboxgl.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw';
    var map;
    var directions;
    var start;

    initmap();

    function initmap() {

        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v10', //style URL of map style
            center: [144.96565, -37.81384], //default location when load the map
            zoom: 16, //default zoom level
            pitch: 45,
            bearing: -17.6,
            antialias: true,
        });

        getUserLocation();
        drawSeat();
        drawPedestrian();
        drawDrink();
        drawToilet();
        getGradient();
        load3D();
        getCurrentDay();
        var nav = new mapboxgl.NavigationControl();
        map.addControl(nav, 'bottom-left');
        addDirectionAPI();

    }

    document.getElementById('fly').addEventListener('click', function () {
        map.flyTo({center: start,zoom: 17});
    });
    document.getElementById("seatButton").addEventListener("click", function() {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
            map.setLayoutProperty('seat', 'visibility', 'none');
            map.setLayoutProperty('seat-cluster-count', 'visibility', 'none');
            map.setLayoutProperty('seat-unclustered-point', 'visibility', 'none');
            document.getElementById("seatButton").style.background= "#707382";
        } else{
            this.classList.add("active");
            map.setLayoutProperty('seat', 'visibility', 'visible');
            map.setLayoutProperty('seat-cluster-count', 'visibility', 'visible');
            map.setLayoutProperty('seat-unclustered-point', 'visibility', 'visible');
            document.getElementById("seatButton").style.background= "#fdcc52";
        }
    });
    document.getElementById("toiletButton").addEventListener("click", function() {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
            map.setLayoutProperty("places", 'visibility', 'none');
            map.setLayoutProperty('cluster-count', 'visibility', 'none');
            map.setLayoutProperty('unclustered-point', 'visibility', 'none');
            document.getElementById("toiletButton").style.background= "#707382";
        } else{
            this.classList.add("active");
            map.setLayoutProperty('places', 'visibility', 'visible');
            map.setLayoutProperty('cluster-count', 'visibility', 'visible');
            map.setLayoutProperty('unclustered-point', 'visibility', 'visible');
            document.getElementById("toiletButton").style.background= "#fdcc52";
        }
    });
    document.getElementById("drinkButton").addEventListener("click", function() {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
            map.setLayoutProperty('drink', 'visibility', 'none');
            map.setLayoutProperty('drink-cluster-count', 'visibility', 'none');
            map.setLayoutProperty('drink-unclustered-point', 'visibility', 'none');
            document.getElementById("drinkButton").style.background= "#707382";
        } else{
            this.classList.add("active");
            map.setLayoutProperty('drink', 'visibility', 'visible');
            map.setLayoutProperty('drink-cluster-count', 'visibility', 'visible');
            map.setLayoutProperty('drink-unclustered-point', 'visibility', 'visible');
            document.getElementById("drinkButton").style.background= "#fdcc52";
        }
    });
    document.getElementById("gradientButton").addEventListener("click", function() {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
            document.getElementById("gradient_color").style.display = "none";
            map.setLayoutProperty('line', 'visibility', 'none');
            document.getElementById("gradientButton").style.background= "#707382";
        } else{
            this.classList.add("active");
            document.getElementById("gradient_color").style.display = "block";
            map.setLayoutProperty('line', 'visibility', 'visible');
            document.getElementById("gradientButton").style.background= "#fdcc52";
        }
    });
    document.getElementById("densityButton").addEventListener("click", function() {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
            document.getElementById("console").style.display = "none";
            map.setLayoutProperty("pedestrian", 'visibility', 'none');
            document.getElementById("densityButton").style.background= "#707382";
        } else{
            this.classList.add("active");
            document.getElementById("console").style.display = "block";
            map.setLayoutProperty('pedestrian', 'visibility', 'visible');
            document.getElementById("densityButton").style.background= "#fdcc52";
        }
    });
    document.getElementById("3dButton").addEventListener("click", function() {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
            map.setLayoutProperty("3d-buildings", 'visibility', 'none');
            document.getElementById("3dButton").style.background= "#707382";
        } else{
            this.classList.add("active");
            map.setLayoutProperty("3d-buildings", 'visibility', 'visible');
            document.getElementById("3dButton").style.background= "#fdcc52";
        }
    });
    document.getElementById("nearby").addEventListener("click", function() {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
            map.setLayoutProperty("nearSeat", 'visibility', 'none');
            map.setLayoutProperty("nearDrink", 'visibility', 'none');
            map.setLayoutProperty("nearFeature", 'visibility', 'none');
            document.getElementById("nearby").style.background= "#707382";
        } else{
            this.classList.add("active");
            map.flyTo({center: [144.9639, -37.8136],zoom: 17});
            map.setLayoutProperty("nearSeat", 'visibility', 'visible');
            map.setLayoutProperty("nearDrink", 'visibility', 'visible');
            map.setLayoutProperty("nearFeature", 'visibility', 'visible');
            document.getElementById("nearby").style.background= "#fdcc52";
        }
    });

    function openNav() {
        document.getElementById("mySidepanel").style.width = "280px";
    }

    function closeNav() {
        document.getElementById("mySidepanel").style.width = "0";
    }

    function getUserLocation() {
        if (navigator.geolocation)
            navigator.geolocation.getCurrentPosition(function(position) {
                start = [position.coords.longitude,position.coords.latitude];
                passData();
                // var marker = new mapboxgl.Marker({ color: '#fcd703'})
                //     .setLngLat([position.coords.longitude, position.coords.latitude])
                //     .setPopup(new mapboxgl.Popup({offset: 25}) // add popups
                //         .setHTML('<h3>Your current location</h3>'))
                //     .addTo(map);
                var size = 100;
                var pulsingDot = {
                    width: size,
                    height: size,
                    data: new Uint8Array(size * size * 4),

                    onAdd: function() {
                        var canvas = document.createElement('canvas');
                        canvas.width = this.width;
                        canvas.height = this.height;
                        this.context = canvas.getContext('2d');
                    },

                    render: function() {
                        var duration = 1500;
                        var t = (performance.now() % duration) / duration;

                        var radius = size / 2 * 0.3;
                        var outerRadius = size / 2 * 0.7 * t + radius;
                        var context = this.context;

                        context.clearRect(0, 0, this.width, this.height);
                        context.beginPath();
                        context.arc(this.width / 2, this.height / 2, outerRadius, 0, Math.PI * 2);
                        context.fillStyle = 'rgba(255, 200, 200,' + (1 - t) + ')';
                        context.fill();

                        context.beginPath();
                        context.arc(this.width / 2, this.height / 2, radius, 0, Math.PI * 2);
                        context.fillStyle = '#f6d753';
                        context.strokeStyle = 'white';
                        context.lineWidth = 2 + 4 * (1 - t);
                        context.fill();
                        context.stroke();

                        this.data = context.getImageData(0, 0, this.width, this.height).data;
                        map.triggerRepaint();
                        return true;
                    }
                };
                map.on('load', function () {

                    map.addImage('pulsing-dot', pulsingDot, { pixelRatio: 2 });

                    map.addLayer({
                        "id": "points",
                        "type": "symbol",
                        "source": {
                            "type": "geojson",
                            "data": {
                                "type": "FeatureCollection",
                                "features": [{
                                    "type": "Feature",
                                    "geometry": {
                                        "type": "Point",
                                        "coordinates": start
                                    }
                                }]
                            }
                        },
                        "layout": {
                            "icon-image": "pulsing-dot"
                        }
                    });
                });

                map.on('click', 'points', function (e) {
                    map.getCanvas().style.cursor = 'pointer';
                    var coordinates = e.features[0].geometry.coordinates.slice();
                    console.log(coordinates);
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }
                    new mapboxgl.Popup()
                        .setLngLat(coordinates)
                        .setHTML('Your current location')
                        .addTo(map);
                });
            });

        else
            console.log("geolocation is not supported");
    }

    function getCurrentDay(){
        var currentDateTime = new Date();
        var day;
        switch (currentDateTime.getDay()) {
            case 0:
                day = "Sunday";
                break;
            case 1:
                day = "Monday";
                break;
            case 2:
                day = "Tuesday";
                break;
            case 3:
                day = "Wednesday";
                break;
            case 4:
                day = "Thursday";
                break;
            case 5:
                day = "Friday";
                break;
            case 6:
                day = "Saturday";
        }
        document.getElementById("day").value = day;
    }

    function snackBar() {
        // Get the snackbar DIV
        var x = document.getElementById("snackbar");
        // Add the "show" class to DIV
        x.className = "show";
        // After 3 seconds, remove the show class from DIV
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }

    function addDirectionAPI(){
        var query = "https://api.mapbox.com/geocoding/v5/mapbox.places/144.965,-37.813.json?access_token=" + mapboxgl.accessToken;
        directions = new MapboxDirections({
            accessToken: mapboxgl.accessToken,
            profile: 'mapbox/walking',
            proximity:[144.96565, -37.81384],
            unit: 'metric',
            geocoder: query,
            placeholderOrigin:'Click or search an origin',
            placeholderDestination:'Click or search a destination',
            controls: {
                profileSwitcher: false,
            }
        });

        addUndo();

        document.getElementById('direction').appendChild(directions.onAdd(map));

    }

    function addUndo() {

        map.on('load', () => {
            document.getElementById("undo").addEventListener('click', function() {
                if (directions.getWaypoints().length === 0){
                    alert("Undo when you has some changes of the route :)");
                }
                else{
                    directions.removeWaypoint(0);
                    console.log(directions.getWaypoints());
                }
            });
        });
    }

    function discoverNearest(){
        // fake current location
        var marker = new mapboxgl.Marker({
            color: '#fcd703'
        }).setLngLat([144.9639, -37.8136])
            .setPopup(new mapboxgl.Popup({offset: 25})
                .setHTML('<h3>Fake current location</h3>')).addTo(map);

        var nearSeat = {};
        nearSeat['type'] = 'FeatureCollection';
        nearSeat['features'] = [];
        seatGeojson.features.forEach(function(e) {
            Object.defineProperty(e.properties, 'distance', {
                value: turf.distance(turf.point([144.9639, -37.8136]), turf.point(e.geometry.coordinates)),
                writable: true,
                enumerable: true,
                configurable: true
            });
            if (e.properties.distance < 0.1){
                nearSeat['features'].push(e);
            }
        });
        map.on('load', function () {
            map.addSource("nearSeat", {
                type: "geojson",
                data: nearSeat
            });
            map.addLayer({
                id: "nearSeat",
                type: "symbol",
                "source": "nearSeat",
                "layout": {
                    "icon-image": "bench",
                    "icon-allow-overlap": true,
                    'visibility': 'none'
                }
            });
            map.on('click', 'nearSeat', function (e) {
                var coordinates = e.features[0].geometry.coordinates.slice();
                var description = e.features[0].properties.description;
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }
                var distance = Math.round(e.features[0].properties.distance * 1000);
                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description + '<p style="font-size: 13px;"><strong>' + distance + ' meters away</strong></p>')
                    .addTo(map);
            });
        });

        var nearDrink = {};
        nearDrink['type'] = 'FeatureCollection';
        nearDrink['features'] = [];
        drinkGeojson.features.forEach(function(e) {
            Object.defineProperty(e.properties, 'distance', {
                value: turf.distance(turf.point([144.9639, -37.8136]), turf.point(e.geometry.coordinates)),
                writable: true,
                enumerable: true,
                configurable: true
            });
            if (e.properties.distance < 0.1){
                nearDrink['features'].push(e);
            }
        });
        searchNearest(nearDrink.features,drinkGeojson);
        map.on('load', function () {
            map.addSource("nearDrink", {
                type: "geojson",
                data: nearDrink
            });
            map.addLayer({
                id: "nearDrink",
                type: "symbol",
                "source": "nearDrink",
                "layout": {
                    "icon-image": "drop",
                    "icon-allow-overlap": true,
                    'visibility': 'none'
                }
            });
            map.on('click', 'nearDrink', function (e) {
                var coordinates = e.features[0].geometry.coordinates.slice();
                var description = e.features[0].properties.description;
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }
                var distance = Math.round(e.features[0].properties.distance * 1000);
                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description + '<p style="font-size: 13px;"><strong>' + distance + ' meters away</strong></p>')
                    .addTo(map);
            });
        });

        var near = {};
        near['type'] = 'FeatureCollection';
        near['features'] = [];
        geojson.features.forEach(function(e) {
            Object.defineProperty(e.properties, 'distance', {
                value: turf.distance(turf.point([144.9639, -37.8136]), turf.point(e.geometry.coordinates)),
                writable: true,
                enumerable: true,
                configurable: true
            });
            if (e.properties.distance < 0.1){
                near['features'].push(e);
            }
        });
        searchNearest(near.features,geojson);
        map.on('load', function () {
            map.addSource("near", {
                type: "geojson",
                data: near
            });
            map.addLayer({
                id: "nearFeature",
                type: "symbol",
                "source": "near",
                "layout": {
                    "icon-image": "toilet",
                    "icon-allow-overlap": true,
                    'visibility': 'none'
                }
            });
            map.on('click', 'nearFeature', function (e) {
                var coordinates = e.features[0].geometry.coordinates.slice();
                var description = e.features[0].properties.description;
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }
                var distance = Math.round(e.features[0].properties.distance * 1000);
                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description + '<p style="font-size: 13px;"><strong>' + distance + ' meters away</strong></p>')
                    .addTo(map);
            });
        });
    }

    function searchNearest(nearFeature,geojsonData){
        // if no toilet available within 100m, search the nearest 5 toilets and show on the map
        if (nearFeature.length === 0){
            geojsonData.features.sort(function(a, b) {
                if (a.properties.distance > b.properties.distance) {
                    return 1;
                }
                if (a.properties.distance < b.properties.distance) {
                    return -1;
                }
                // a must be equal to b
                return 0;
            });
            for (var i = 0; i < 5; i++){
                nearFeature.push(geojsonData.features[i]);
            }
        }
    }

    var geojson = {};
    var drinkGeojson = {};
    var seatGeojson = {};
    var pedestrianGeojson = {};

    function passData(){
        // pass toilet data to Geojson array
        var locations = <?php get_toilet_locations() ?>;
        geojson['type'] = 'FeatureCollection';
        geojson['features'] = [];
        for (var k in locations) {
            var newFeature = {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [parseFloat(locations[k][2]), parseFloat(locations[k][1])]
                },
                "properties": {
                    "description": locations[k][0] + '<br>' + "Female: " + locations[k][3] + '<br>' + "Male: " + locations[k][4] + '<br>' + "Wheelchair: " + locations[k][5] + '<br>' + "Baby Facility: " + locations[k][6],
                    "icon": "toilet"
                }
            }
            geojson['features'].push(newFeature);
        }

        // pass drink data to Geojson array
        var drinkLocations = <?php get_drink_locations() ?>;
        drinkGeojson['type'] = 'FeatureCollection';
        drinkGeojson['features'] = [];
        for (var k in drinkLocations) {
            var newFeature = {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [parseFloat(drinkLocations[k][2]), parseFloat(drinkLocations[k][1])]
                },
                "properties": {
                    "description": drinkLocations[k][0],
                    "icon": "beer"
                }
            }
            drinkGeojson['features'].push(newFeature);
        }

        // pass seat data to Geojson array
        var seatLocations = <?php get_seats_locations() ?>;
        seatGeojson['type'] = 'FeatureCollection';
        seatGeojson['features'] = [];
        for (var k in seatLocations) {
            var newFeature = {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [parseFloat(seatLocations[k][3]), parseFloat(seatLocations[k][2])]
                },
                "properties": {
                    "description": seatLocations[k][1],
                    "icon": "picnic-site"
                }
            }
            seatGeojson['features'].push(newFeature);
        }

        // pass pedestrian data to Geojson array
        var pedestrian = <?php get_pedestrian() ?>;
        pedestrianGeojson['type'] = 'FeatureCollection';
        pedestrianGeojson['features'] = [];
        for (var k in pedestrian) {
            var newFeature = {
                "type": "Feature",
                "properties": {
                    "Day": pedestrian[k][0],
                    "Hour": parseInt(pedestrian[k][1], 10),
                    "Number": parseInt(pedestrian[k][3], 10),
                },
                "geometry": {
                    "type": "Point",
                    "coordinates": [parseFloat(pedestrian[k][5]), parseFloat(pedestrian[k][4])]
                }
            }
            pedestrianGeojson['features'].push(newFeature);
        }

        discoverNearest();
    }

    function drawSeat(){
        map.on('load', function () {
            map.addSource("seatGeojson", {
                type: "geojson",
                // Point to GeoJSON data. This example visualizes all M1.0+ earthquakes
                data: seatGeojson,
                cluster: true,
                clusterMaxZoom: 17, // Max zoom to cluster points on
                clusterRadius: 50 // Radius of each cluster when clustering points (defaults to 50)
            });

            // Add a layer showing the places.
            map.addLayer({
                "id": "seat",
                "type": "circle",
                "source": 'seatGeojson',
                "filter": ["has", "point_count"],
                "layout": {
                    'visibility': 'none'
                },
                paint: {
                    "circle-color": [
                        "step",
                        ["get", "point_count"],
                        "#ffc020",
                        15,
                        "#ff8020",
                        30,
                        "#ff4020",
                        300,
                        "#ff0020"
                    ],
                    "circle-radius": [
                        "step",
                        ["get", "point_count"],
                        20,
                        100,
                        30,
                        750,
                        40
                    ]
                }
            });

            map.addLayer({
                id: "seat-cluster-count",
                type: "symbol",
                "source": 'seatGeojson',
                filter: ["has", "point_count"],
                layout: {
                    "text-field": "{point_count_abbreviated}",
                    "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                    "text-size": 12,
                    'visibility': 'none'
                }
            });

            map.loadImage('img/bench.png', function(error, image) {
                if (error) throw error;
                map.addImage('bench', image);
                map.addLayer({
                    id: "seat-unclustered-point",
                    type: "symbol",
                    "source": 'seatGeojson',
                    filter: ["!", ["has", "point_count"]],
                    layout: {
                        "icon-image": "bench",
                        "icon-allow-overlap": true,
                        "visibility":"none"
                    }
                });
            });

            // inspect a cluster on click
            map.on('click', 'seat', function (e) {
                var features = map.queryRenderedFeatures(e.point, { layers: ['seat'] });
                var clusterId = features[0].properties.cluster_id;
                map.getSource('seatGeojson').getClusterExpansionZoom(clusterId, function (err, zoom) {
                    if (err)
                        return;

                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                });
            });

            // When a click event occurs on a feature in the places layer, open a popup at the
            // location of the feature, with description HTML from its properties.
            map.on('click', 'seat-unclustered-point', function (e) {
                var coordinates = e.features[0].geometry.coordinates.slice();
                console.log(coordinates);
                var description = e.features[0].properties.description;

                // Ensure that if the map is zoomed out such that multiple
                // copies of the feature are visible, the popup appears
                // over the copy being pointed to.
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }
                var distance = Math.round(e.features[0].properties.distance * 1000);
                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description + '<p style="font-size: 13px;"><strong>' + distance + ' meters away</strong></p>')
                    .addTo(map);
            });

            // Change the cursor to a pointer when the mouse is over the places layer.
            map.on('mouseenter', 'seat', function () {
                map.getCanvas().style.cursor = 'pointer';
            });

            // Change it back to a pointer when it leaves.
            map.on('mouseleave', 'seat', function () {
                map.getCanvas().style.cursor = '';
            });
        });
    }

    function drawToilet(){
        map.on('load', function () {

            map.addSource("geojson", {
                type: "geojson",
                data: geojson,
                cluster: true,
                clusterMaxZoom: 15, // Max zoom to cluster points on
                clusterRadius: 50 // Radius of each cluster when clustering points (defaults to 50)
            });

            // Add a layer showing the places.
            map.addLayer({
                "id": "places",
                "type": "circle",
                "source": "geojson",
                "filter": ["has", "point_count"],
                "layout": {
                    'visibility': 'none'
                },
                "paint": {
                    "circle-color": [
                        "step",
                        ["get", "point_count"],
                        "#ffa0c0",
                        10,
                        "#ff60c0",
                        30,
                        "#ff20c0"
                    ],
                    "circle-radius": [
                        "step",
                        ["get", "point_count"],
                        20,
                        100,
                        30,
                        750,
                        40
                    ]
                }
            });

            map.addLayer({
                id: "cluster-count",
                type: "symbol",
                "source": "geojson",
                filter: ["has", "point_count"],
                layout: {
                    "text-field": "{point_count_abbreviated}",
                    "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                    "text-size": 12,
                    'visibility': 'none'
                }
            });

            map.loadImage('img/toilet_paper.png', function(error, image) {
                if (error) throw error;
                map.addImage('toilet', image);
                map.addLayer({
                    id: "unclustered-point",
                    type: "symbol",
                    "source": "geojson",
                    filter: ["!", ["has", "point_count"]],
                    "layout": {
                        "icon-image": "toilet",
                        "icon-allow-overlap": true,
                        'visibility': 'none'
                    }
                    // "paint":{
                    //     color:'#730709'
                    // }
                });
            });

            // inspect a cluster on click
            map.on('click', 'places', function (e) {
                var features = map.queryRenderedFeatures(e.point, { layers: ['places'] });
                var clusterId = features[0].properties.cluster_id;
                map.getSource("geojson").getClusterExpansionZoom(clusterId, function (err, zoom) {
                    if (err)
                        return;

                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                });
            });

            map.on('mouseenter', 'places', function () {
                map.getCanvas().style.cursor = 'pointer';
            });
            map.on('mouseleave', 'places', function () {
                map.getCanvas().style.cursor = '';
            });

            // inspect a cluster on click
            map.on('click', 'places', function (e) {
                var features = map.queryRenderedFeatures(e.point, { layers: ['places'] });
                var clusterId = features[0].properties.cluster_id;
                map.getSource("geojson").getClusterExpansionZoom(clusterId, function (err, zoom) {
                    if (err)
                        return;

                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                });
            });

            // When a click event occurs on a feature in the places layer, open a popup at the
            // location of the feature, with description HTML from its properties.
            map.on('click', 'unclustered-point', function (e) {
                var coordinates = e.features[0].geometry.coordinates.slice();
                console.log(coordinates);
                var description = e.features[0].properties.description;

                // Ensure that if the map is zoomed out such that multiple
                // copies of the feature are visible, the popup appears
                // over the copy being pointed to.
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }
                var distance = Math.round(e.features[0].properties.distance * 1000);
                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description + '<p style="font-size: 13px;"><strong>' + distance + ' meters away</strong></p>')
                    .addTo(map);
            });

        });
    }

    function drawDrink(){
        map.on('load', function () {
            map.addSource("drinkGeojson", {
                type: "geojson",
                data: drinkGeojson,
                cluster: true,
                clusterMaxZoom: 15, // Max zoom to cluster points on
                clusterRadius: 50 // Radius of each cluster when clustering points (defaults to 50)
            });

            // Add a layer showing the places.
            map.addLayer({
                "id": "drink",
                "type": "circle",
                "source": 'drinkGeojson',
                "filter": ["has", "point_count"],
                "layout": {
                    'visibility': 'none'
                },
                "paint": {
                    "circle-color": [
                        "step",
                        ["get", "point_count"],
                        "#00c0ff",
                        15,
                        "#0060ff",
                        30,
                        "#0000ff"
                    ],
                    "circle-radius": [
                        "step",
                        ["get", "point_count"],
                        20,
                        100,
                        30,
                        750,
                        40
                    ]
                }
            });
            map.addLayer({
                id: "drink-cluster-count",
                type: "symbol",
                "source": 'drinkGeojson',
                filter: ["has", "point_count"],
                layout: {
                    "text-field": "{point_count_abbreviated}",
                    "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                    "text-size": 12,
                    "visibility":"none"
                }
            });

            map.loadImage('img/drop.png', function(error, image) {
                if (error) throw error;
                map.addImage('drop', image);
                map.addLayer({
                    id: "drink-unclustered-point",
                    type: "symbol",
                    "source": 'drinkGeojson',
                    filter: ["!", ["has", "point_count"]],
                    layout: {
                        "icon-image": "drop",
                        "icon-allow-overlap": true,
                        "visibility":"none"
                    }
                });
            });

            // inspect a cluster on click
            map.on('click', 'drink', function (e) {
                var features = map.queryRenderedFeatures(e.point, { layers: ['drink'] });
                var clusterId = features[0].properties.cluster_id;
                map.getSource('drinkGeojson').getClusterExpansionZoom(clusterId, function (err, zoom) {
                    if (err)
                        return;

                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                });
            });


            // When a click event occurs on a feature in the places layer, open a popup at the
            // location of the feature, with description HTML from its properties.
            map.on('click', 'drink-unclustered-point', function (e) {
                var coordinates = e.features[0].geometry.coordinates.slice();
                console.log(coordinates);
                var description = e.features[0].properties.description;

                // Ensure that if the map is zoomed out such that multiple
                // copies of the feature are visible, the popup appears
                // over the copy being pointed to.
                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }
                var distance = Math.round(e.features[0].properties.distance * 1000);
                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description + '<p style="font-size: 13px;"><strong>' + distance + ' meters away</strong></p>')
                    .addTo(map);
            });

            // inspect a cluster on click
            map.on('click', 'drink', function (e) {
                var features = map.queryRenderedFeatures(e.point, { layers: ['drink'] });
                var clusterId = features[0].properties.cluster_id;
                map.getSource('drinkGeojson').getClusterExpansionZoom(clusterId, function (err, zoom) {
                    if (err)
                        return;

                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                });
            });

            // Change the cursor to a pointer when the mouse is over the places layer.
            map.on('mouseenter', 'drink', function () {
                map.getCanvas().style.cursor = 'pointer';
            });

            // Change it back to a pointer when it leaves.
            map.on('mouseleave', 'drink', function () {
                map.getCanvas().style.cursor = '';
            });
        });
    }

    function drawPedestrian(){

        map.on('load', function() {
            var filterHour = ['==', ['number', ['get', 'Hour']], 12];
            var filterDay = ['==', ['string', ['get', 'Day']], 'Monday'];

            map.addLayer({
                id: 'pedestrian',
                type: 'circle',
                source: {
                    type: 'geojson',
                    data: pedestrianGeojson
                },
                layout: {
                    'visibility': 'none'
                },
                paint: {
                    'circle-radius': 10,
                    'circle-color': [
                        'interpolate',
                        ['linear'],
                        ['number', ['get', 'Number']],
                        10, '#95c78b',
                        50, '#72c55a',
                        100, '#15cb0b',
                        300, '#51c4c8',
                        600, '#2a6ed7',
                        2000, '#132eda',
                        3000, '#953f3f',
                        5000, '#730709'
                    ],
                    "circle-opacity": 0.6,
                },
            });

            var currentHours = new Date().getHours();
            document.getElementById('slider').value = currentHours;
            filterHour = ['==', ['number', ['get', 'Hour']], currentHours];
            map.setFilter('pedestrian', ['all', filterHour, filterDay]);
            var ampm = currentHours >= 12 ? 'PM' : 'AM';
            var hour12 = currentHours % 12 ? currentHours % 12 : 12;
            document.getElementById('active-hour').innerText = hour12 + ampm;


            document.getElementById('slider').addEventListener('input', function(e) {
                var hour = parseInt(e.target.value);
                // update the map
                filterHour = ['==', ['number', ['get', 'Hour']], hour];
                map.setFilter('pedestrian', ['all', filterHour, filterDay]);
                // converting 0-23 hour to AMPM format
                var ampm = hour >= 12 ? 'PM' : 'AM';
                var hour12 = hour % 12 ? hour % 12 : 12;
                // update text in the UI

                document.getElementById('active-hour').innerText = hour12 + ampm;
            });
            document.getElementById('filters').addEventListener('change', function(e) {
                var day = e.target.value;
                filterDay = ['==', ['string', ['get', 'Day']], day];
                /* the rest of the if statement */
                map.setFilter('pedestrian', ['all', filterHour, filterDay]);
            });
        });
    }

    function load3D() {
        // The 'building' layer in the mapbox-streets vector source contains building-height
        // data from OpenStreetMap.

        map.on('load', function() {
            // Insert the layer beneath any symbol layer.
            var layers = map.getStyle().layers;

            var labelLayerId;
            for (var i = 0; i < layers.length; i++) {
                if (layers[i].type === 'symbol' && layers[i].layout['text-field']) {
                    labelLayerId = layers[i].id;
                    break;
                }
            }

            map.addLayer({
                'id': '3d-buildings',
                'source': 'composite',
                'source-layer': 'building',
                'filter': ['==', 'extrude', 'true'],
                'type': 'fill-extrusion',
                'layout': {
                    'visibility': 'none'
                },
                'minzoom': 15,
                'paint': {
                    'fill-extrusion-color': '#aaa',

                    // use an 'interpolate' expression to add a smooth transition effect to the
                    // buildings as the user zooms in
                    'fill-extrusion-height': [
                        "interpolate", ["linear"],
                        ["zoom"],
                        15, 0,
                        15.05, ["get", "height"]
                    ],
                    'fill-extrusion-base': [
                        "interpolate", ["linear"],
                        ["zoom"],
                        15, 0,
                        15.05, ["get", "min_height"]
                    ],
                    'fill-extrusion-opacity': .6
                }
            }, labelLayerId);
        });

    }

    function getGradient() {

        var geojson = 'Footpath steepness.geojson';

        map.on('load', function() {
            // Insert the layer beneath any symbol layer.
            var layers = map.getStyle().layers;

            var labelLayerId;
            for (var i = 0; i < layers.length; i++) {
                if (layers[i].type === 'symbol' && layers[i].layout['text-field']) {
                    labelLayerId = layers[i].id;
                    break;
                }
            }

            // 'line-gradient' can only be used with GeoJSON sources
            // and the source must have the 'lineMetrics' option set to true
            map.addSource('line', {
                type: 'geojson',
                lineMetrics: true,
                data: geojson
            });

            // the layer must be of type 'line'
            map.addLayer({
                type: 'line',
                source: 'line',
                id: 'line',
                paint: {
                    'line-color': 'red',
                    'line-width': 2.8,
                    // 'line-gradient' must be specified using an expression
                    // with the special 'line-progress' property
                    'line-gradient': [
                        'interpolate', ['linear'],
                        ['line-progress'],
                        0, "#ADFF2F",
                        0.5, "#FF3300",
                        1, "#6e0000",
                    ]
                },
                layout: {
                    'visibility': 'none',
                    'line-cap': 'round',
                    'line-join': 'round',
                }

            }, labelLayerId);
        });

    }


</script>

</html>
