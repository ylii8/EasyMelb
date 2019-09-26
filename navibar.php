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
        .icon-bar {
            border-bottom: solid 2px rgba(92, 92, 92, 0.38);
            border-radius: 15%;
            font-size: 15px;
            text-align: center;
            color: rgba(41, 41, 41, 0.99);
            background: rgba(253, 255, 251, 0.98);
            cursor: pointer;
            width: 35px;
            height:35px;
        }
        .icon-bar:hover{
            background: rgba(235, 236, 233, 0.84);
        }
        .icon-bar:active{
            background: #fdcc52;
        }
        #icon-container{
            display: block;
            position: absolute;
            bottom:0;
            padding:0px;
            margin-right: 5px;
            top:90px;
            width: 40px;
            height: 180px;
            right:0;
        }
        #fly {
            display: block;
            position: absolute;
            bottom:0;
            margin-right: 8px;
            margin-bottom: 130px;
            width: 37px;
            height: 37px;
            padding: 10px;
            border-radius: 50%;
            border-bottom: solid 2px rgba(92, 92, 92, 0.38);
            font-size: 13px;
            text-align: center;
            right:0;
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
        .filter-box {
            padding: 5px 10px;
            border: 1px solid #e8e8e8;
        }

        .marker-filter hr {
            width: 0;
        }

        .mapboxgl-popup {
            max-width: 400px;
            font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
        }

        #instructions {
            position: absolute;
            margin-top: 28rem;
            margin-left: 3rem;
            width: 25%;
            height: 30%;
            top: 0;
            bottom: 20%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            overflow-y: scroll;
            font-family: sans-serif;
            font-size: 0.8em;
            line-height: 2em;
        }

        .duration {
            font-size: 2em;
        }

        @media (max-width: 640px) {
            #fly {
                margin-bottom: 150px;
            }

        }

        @media (max-width: 769px) {
            #instructions{
                font-family: sans-serif;
                font-size: 14px;
                height: 30%;
            }

        }
        @media (max-width: 415px) {
            #instructions{
                font-family: sans-serif;
                font-size: 12px;
                padding: 7px;
                margin-left: 40px;
                width: 80%;
                height: 17%;
                margin-top: 39rem;
            }

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
            top: 70px;
            bottom: 20%;
            width: 250px;
            height: 200px;
            padding: 5px 20px;
            margin: 80px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        @media (max-width: 415px) {
            #console{
                font-family: sans-serif;
                margin-left: 10px;
                width: 40%;
                margin-top: 17%;
            }
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
            height: 11%;
            top: 0;
            bottom: 20%;
            width: 250px;
            padding: 5px 20px;
            margin: 80px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        @media (max-width: 415px) {
            #gradient_color{
                font-family: sans-serif;
                margin-left: 10px;
                width: 40%;
                margin-top: 19%;
            }
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
    </style>
</head>

<?php include_once 'locations_model.php'; ?>

<body>

<nav class="topnav navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" title="Go to Home page" href="index.html" style="color: #545765;"><img src="img/logo.PNG" style="margin-right:.3rem;margin-bottom:3px;width:2.2rem;height:2.2rem;">EasyMelb</a>
    </div>
</nav>
<div  id='map' ></div>
<div id="icon-container">
    <button class="icon-bar" id="seatButton" title="Display seats"><i class="fas fa-chair"></i></button>
    <button class="icon-bar" id="toiletButton" title="Display toilets"><i class="fas fa-restroom"></i></button>
    <button class="icon-bar" id="drinkButton" title="Display drinking fountains"><i class="fas fa-tint"></i></button>
    <button class="icon-bar" id="gradientButton" title="Display gradient"><i class="fas fa-mountain"></i></button>
    <button class="icon-bar" id="densityButton" title="Display pedestrian density"><i class="fas fa-users"></i></button>
    <button class="icon-bar" id="3dButton" title="Display 3D buildings"><i class="fas fa-cubes"></i></button>
</div>
<button id='fly' title="Show current location"><i class="fa fa-location-arrow"></i></button>
<div id="instructions" style="display: none;"></div>
<div id="info-box" class="info-box" style="display: none;">
    <div id="info">
        <p style="font-size: 16px;">Draw your route using the draw tools on the right. To get the most accurate route match, draw points at regular intervals.</p>
    </div>
    <div id="directions"></div>
</div>
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
<div id='gradient_color' style="display: none; height: fit-content">
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
        // // Set bounds to Mel city
        // var bounds = [
        //     [144.884368, -37.875602], // Southwest coordinates
        //     [145.043748, -37.757360]// Northeast coordinates
        // ];

        map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v10', //style URL of map style
            center: [144.96565, -37.81384], //default location when load the map
            zoom: 16, //default zoom level
            // Zero is perpendicular to the surface
            pitch: 45,
            // the compass direction that is "up"
            bearing: -17.6,
            antialias: true,
            // maxBounds: bounds // Sets bounds as max
        });
        getUserLocation();

        // document.getElementById('geocoder').appendChild(geocoder.onAdd(map));

        var nav = new mapboxgl.NavigationControl();
        map.addControl(nav, 'bottom-right');

        drawPedestrian();
        drawDrink();
        drawSeat();
        drawToilet();
        getGradient();
        load3D();
        addDirectionAPI();
        getCurrentDay();
        // map.moveLayer('cluster-count', 'line');

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

    document.getElementById('fly').addEventListener('click', function () {
        map.flyTo({center: start,zoom: 17});
    });
    document.getElementById("seatButton").addEventListener("click", function() {
            if (this.classList.contains("active")) {
                this.classList.remove("active");
                map.setLayoutProperty('seat', 'visibility', 'none');
                map.setLayoutProperty('seat-cluster-count', 'visibility', 'none');
                map.setLayoutProperty('seat-unclustered-point', 'visibility', 'none');
                document.getElementById("seatButton").style.background= "rgba(253, 255, 251, 0.98)";
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
            document.getElementById("toiletButton").style.background= "rgba(253, 255, 251, 0.98)";
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
            document.getElementById("drinkButton").style.background= "rgba(253, 255, 251, 0.98)";
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
            document.getElementById("gradientButton").style.background= "rgba(253, 255, 251, 0.98)";
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
            document.getElementById("densityButton").style.background= "rgba(253, 255, 251, 0.98)";
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
            document.getElementById("3dButton").style.background= "rgba(253, 255, 251, 0.98)";
        } else{
            this.classList.add("active");
            map.setLayoutProperty("3d-buildings", 'visibility', 'visible');
            document.getElementById("3dButton").style.background= "#fdcc52";
        }
    });

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

        // remove all waypoints
        var removeWaypointsButton = document.body.appendChild(document.createElement('button'));
        removeWaypointsButton.style = 'z-index:10;position:absolute;top:100px;right:50px;';
        removeWaypointsButton.textContent = 'Undo';

        map.on('load', () => {
            removeWaypointsButton.addEventListener('click', function() {
                directions.removeWaypoint(0);
            });
        });

        map.addControl(directions, 'bottom-left');
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
                    "icon-allow-overlap": true
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
                    "icon-allow-overlap": true
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
                    "icon-allow-overlap": true
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


</script>

</html>