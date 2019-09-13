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
    <!-- Geocoder plugin -->
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.min.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.2.0/mapbox-gl-geocoder.css' type='text/css' />
    <!-- Import jQuery -->
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <!-- Import Mapbox GL Draw -->
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.css' type='text/css' />
    <!-- jquery -->
    <script src="https://cdn.staticfile.org/jquery/1.10.2/jquery.min.js"></script>
    <style>

        body { margin:0; padding:0; }
        #map { position:absolute; top:0; bottom:0; width:100%; }

        .container_map {
            height: 600px;
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

        @media (max-width: 769px) {
            #instructions{
                font-family: sans-serif;
                font-size: 0.4em;
                height: 30%;
            }

        }
        @media (max-width: 415px) {
            #instructions{
                font-family: sans-serif;
                font-size: 0.2em;
                padding: 7px;
                margin-left: 40px;
                width: 80%;
                height: 18%;
                margin-top: 39rem;
            }

        }

        h1 {
            display: block;
            font-size: 20px;
            line-height: 30px;
            margin-block-start: 0.67em;
            margin-block-end: 0.67em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
        }

        h2 {
            font-size: 1px;
            font-size: 15px;
            font-weight: bold;
        }

        #console {
            position: absolute;
            height: 23%;
            top: 0;
            bottom: 20%;
            width: 250px;
            padding: 5px 20px;
            margin: 80px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        @media (max-width: 415px) {
            #console{
                font-family: sans-serif;
                margin-left: 10px;
                width: 40%;
                height: 155px;
                margin-top: 20%;
            }

        }

        .session {
            margin-bottom: 10px;
        }

        .row {
            height: 14px;
            width: 100%;
            margin-left: 0px;
            margin-right: 0px;
            display: block;
        }

        .colors {
            background: linear-gradient(to right, #99FF00, #CCFF00, #FFFF00, #FFCC00, #FF9900, #FF6600, #FF3300, #FF0000);
            margin-bottom: 5px;
        }

        .label {
            font-family: sans-serif;
            font-size: 2px;
            width: 30%;
            display: inline-block;
            text-align: center;
            cursor: default;
            font-weight: bold;
        }

    </style>
</head>

<?php include_once 'locations_model.php'; ?>

<body>
<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v3.1.3/mapbox-gl-directions.js'></script>
<link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v3.1.3/mapbox-gl-directions.css' type='text/css' />
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.html" style="color: #545765;"><img src="img/logo.PNG" style="margin-right:.3rem;margin-bottom:3px;width:2.2rem;height:2.2rem;">Your Guider</a>
    </div>
</nav>

<div class="container_map row no-gutters">
    <!-- Filter Checkboxes -->
    <style>
        #menu {
            background: #fff;
            position: absolute;
            z-index: 1;
            top: 6px;
            right: 0px;
            border-radius: 3px;
            width: 120px;
            font-family: 'Open Sans', sans-serif;
        }

        #menu label {

            font-size: 13px;
            color: #404040;
            display: block;
            margin: 0;
            padding: 10px;
            text-decoration: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.25);
            text-align: center;
        }

        #menu label:last-child {
            border: none;
        }

        #menu label:hover {
            background-color: #fdcb50;
            color: #404040;
        }

        #menu label:active {
            background-color: #ff9609;
            color: #ffffff;
        }

        #menu label:active:hover {
            background: #ff9609;
        }

        #blockLabel {
            background: #fff;
            position: absolute;
            z-index: 1;
            top: 65px;
            right: 10px;
            border-radius: 3px;
            width: 120px;
            border: 1px solid rgba(0, 0, 0, 0.4);
            font-family: 'Open Sans', sans-serif;
        }

        #blockLabel label {
            right: 100px;
            font-size: 13px;
            color: #404040;
            display: block;
            margin: 0;
            padding: 10px;
            text-decoration: none;
            text-align: center;
        }

        #blockLabel label:last-child {
            border: none;
        }

        #blockLabel label:hover {
            background-color: #fdcb50;
            color: #404040;
        }

        #blockLabel label:active {
            background-color: #ff9609;
            color: #ffffff;
        }

        #blockLabel label:active:hover {
            background: #ff9609;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#blockLabel").hover(function() {
                $("#menu").css("display", "block");
            }, function() {
                $("#menu").css("display", "none");
            });

            $("#hideLabel").hover(function() {
                $("#menu").css("display", "block");
            }, function() {
                $("#menu").css("display", "none");
            });
        });
    </script>
    <div id='blockLabel' style="text-align: left;font-size: 18px; margin-left: 4rem">
        <label style="right: -1000px;">Show Feature</label>
    </div>
    <div id='menu' style="text-align: left;font-size: 18px; margin-left: 4rem;display:none;">
        <div id='hideLabel'>
            <nav id="filter-group" class="filter-group">
                <input type="checkbox" id="seats" onclick="getSeats()">
                <label for="seats" id="seats" >Seats</label>
                <input type="checkbox" id="toilets" onclick="getToilets()">
                <label for="toilets" id="toilets" >Toilets</label>
                <input type="checkbox" id="drinking_fountains" onclick="getDrink()">
                <label for="drinking_fountains" id="drinking_fountains" >Drinking Fountains</label>
                <input type="checkbox" id="pedestrian" onclick="showPedestrian()">
                <label for="pedestrian" id="pedestrian" >Pedestrian Density</label>
                <input type="checkbox" id="line" onclick="showGradientLayer()">
                <label for="line" id="line" >Gradient</label>
                <input type="checkbox" id="3d-buildings" onclick="show3dLayer()">
                <label for="3d-buildings" id="3d-buildings" >3D</label>
<!--                <input type="checkbox" id="route" onclick="showRoute()">-->
<!--                <label for="route" id="route" >Show Route</label>-->
                <input type="checkbox" id="customizeRoute" onclick="showCustomizeRoute()">
                <label for="customizeRoute" id="customizeRoute" >Draw Customize Route</label>
            </nav>
        </div>
    </div>
    <style>
        .info-box {
            position: absolute;
            margin-top: 60px;
            margin-left: 20px;
            width: 25%;
            top: 0;
            bottom: 40%;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            overflow-y: scroll;
            font-family: sans-serif;
            font-size: 0.8rem;
            line-height: 2em;
        }

        #info {
            font-size: 16px;
            font-weight: bold;
        }
        .filter-group {
            font-size: 13px;
            font-family: 'Open Sans', sans-serif;
            position: absolute;
            top: 100px;
            right: 10px;
            z-index: 1;
            /*border: 1px solid rgba(0, 0, 0, 0.4);*/
            width: 120px;
            color: #404040;
        }

        .filter-group input[type=checkbox]:first-child + label {
            border-radius: 3px 3px 0 0;
        }

        .filter-group label:last-child {
            border-radius: 0 0 3px 3px;
            border: none;
        }

        .filter-group input[type=checkbox] {
            display: none;
        }

        .filter-group input[type=checkbox] + label {
            background-color: #3386c0;
            display: block;
            cursor: pointer;
            padding: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.25);
            margin-bottom: 0;
        }

        .filter-group input[type=checkbox] + label {
            background-color: #fff;
            text-transform: capitalize;
        }

        .filter-group input[type=checkbox] + label:hover,
        .filter-group input[type=checkbox]:checked + label {
            background-color: #fdcb50;
        }

        .filter-group input[type=checkbox]:checked + label:before {
            content: '✔';
        }

    </style>
</div>

<div  id='map' ></div>
<div id="instructions" style="display: none;"></div>
<div id="info-box" class="info-box" style="display: none;">
    <div id="info">
        <p style="font-size: 16px;">Draw your route using the draw tools on the right. To get the most accurate route match, draw points at regular intervals.</p>
    </div>
    <div id="directions"></div>
</div>
<div id='console' style="display: none;">
    <div class='session'>
        <div class='row colors'></div>
        <div class='row labels'>
            <div class='label'>Low</div>
            <div class='label'>        </div>
            <div class='label'>High</div>
        </div>
    </div>
    <div class='session' id='sliderbar'>
        <h2>Hour: <label2 id='active-hour'>12PM</label2></h2>
        <input id='slider' class='row' type='range' min='0' max='23' step='1' value='12' />
    </div>
    <div class='session'>
        <h2>Day</h2>
        <div class='row' id='filters'>
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
            <select onchange="selectchangeday(this.value)">
                <option value="Monday" selected="selected">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>
        </div>
    </div>
</div>

</body>

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw';
    var map;

    initmap();

    function initmap() {
        // Set bounds to Mel city
        var bounds = [
            [144.884368, -37.875602], // Southwest coordinates
            [145.043748, -37.757360]// Northeast coordinates
        ];

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
            maxBounds: bounds // Sets bounds as max
        });

        var nav = new mapboxgl.NavigationControl();
        map.addControl(nav, 'bottom-right');

        map.addControl(new MapboxDirections({
            accessToken: mapboxgl.accessToken,
            profile: 'mapbox/walking',
            controls: {
                instructions: false,
                profileSwitcher: false}
        }), 'bottom-left');

        drawPedestrian();
        getUserLocation();
        drawDrink();
        drawSeat();
        unSelectAll();
        drawToilet();
        getGradient();
        load3D();
        // map.moveLayer('cluster-count', 'line');
    }

    function unSelectAll() {
        var items = document.getElementsByName('checkbox');
        for (var i = 0; i < items.length; i++) {
            if (items[i].type == 'checkbox')
                items[i].checked = false;
        }
    }

    function  show3dLayer() {

        var checkBox = document.getElementById("3d-buildings");
        if (checkBox.checked == true) {
            map.setLayoutProperty("3d-buildings", 'visibility', 'visible');
        } else {
            map.setLayoutProperty("3d-buildings", 'visibility', 'none');
        }
    }

    function  showGradientLayer() {

        var checkBox = document.getElementById("line");
        if (checkBox.checked == true)
        {
            map.setLayoutProperty('line', 'visibility', 'visible');
        } else {
            map.setLayoutProperty('line', 'visibility', 'none');
        }
    }

    function  showRoute() {

        var checkBox = document.getElementById("route");
        if (checkBox.checked == true)
        {
            map.setLayoutProperty('route', 'visibility', 'visible');
            map.setLayoutProperty('end', 'visibility', 'visible');
            document.getElementById("instructions").style.display = "block";

        } else {
            map.setLayoutProperty('route', 'visibility', 'none');
            map.setLayoutProperty('end', 'visibility', 'none');
            document.getElementById("instructions").style.display = "none";
        }
    }

    function  showPedestrian() {

        var checkBox = document.getElementById("pedestrian");
        if (checkBox.checked == true)
        {
            document.getElementById("console").style.display = "block";
            map.setLayoutProperty('pedestrian', 'visibility', 'visible');
        } else {
            document.getElementById("console").style.display = "none";
            map.setLayoutProperty("pedestrian", 'visibility', 'none');
        }
    }

    function showCustomizeRoute(){
        var checkBox = document.getElementById("customizeRoute");
        if (checkBox.checked == true)
        {
            document.getElementById("info-box").style.display = "block";
            map.setLayoutProperty('customizeRoute', 'visibility', 'visible');
            // Add the draw tool to the map
            map.addControl(draw,'bottom-right');


        } else {
            document.getElementById("info-box").style.display = "none";
            map.setLayoutProperty("customizeRoute", 'visibility', 'none');
            map.removeControl(draw);
        }
    }

    function getUserLocation() {
        if (navigator.geolocation)
            navigator.geolocation.getCurrentPosition(function(position) {
                start = [position.coords.longitude,position.coords.latitude];

                var marker = new mapboxgl.Marker({ color: '#fcd703'})
                    .setLngLat([position.coords.longitude, position.coords.latitude])
                    .setPopup(new mapboxgl.Popup({offset: 25}) // add popups
                        .setHTML('<h3>Your current location</h3>'))
                    .addTo(map);
            });
        else
            console.log("geolocation is not supported");
    }

    function getToilets(){

        var checkBox = document.getElementById("toilets");
        if (checkBox.checked == true)
        {
            map.setLayoutProperty('places', 'visibility', 'visible');
            map.setLayoutProperty('cluster-count', 'visibility', 'visible');
            map.setLayoutProperty('unclustered-point', 'visibility', 'visible');
        }
        else
        {
            map.setLayoutProperty("places", 'visibility', 'none');
            map.setLayoutProperty('cluster-count', 'visibility', 'none');
            map.setLayoutProperty('unclustered-point', 'visibility', 'none');
        }
    }

    function getDrink(){

        var checkBox = document.getElementById("drinking_fountains");
        if (checkBox.checked == true)
        {
            map.setLayoutProperty('drink', 'visibility', 'visible');
            map.setLayoutProperty('drink-cluster-count', 'visibility', 'visible');
            map.setLayoutProperty('drink-unclustered-point', 'visibility', 'visible');
        }
        else
        {
            map.setLayoutProperty('drink', 'visibility', 'none');
            map.setLayoutProperty('drink-cluster-count', 'visibility', 'none');
            map.setLayoutProperty('drink-unclustered-point', 'visibility', 'none');
        }
    }

    function getSeats(){

        var checkBox = document.getElementById("seats");
        if (checkBox.checked == true)
        {
            map.setLayoutProperty('seat', 'visibility', 'visible');
            map.setLayoutProperty('seat-cluster-count', 'visibility', 'visible');
            map.setLayoutProperty('seat-unclustered-point', 'visibility', 'visible');
        }
        else
        {
            map.setLayoutProperty('seat', 'visibility', 'none');
            map.setLayoutProperty('seat-cluster-count', 'visibility', 'none');
            map.setLayoutProperty('seat-unclustered-point', 'visibility', 'none');
        }
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
                        0, "#FFFCEC",
                        0.5, "#FFDC35",
                        1, "#5B4B00",
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

    // pass toilet data to Geojson array
    var locations = <?php get_toilet_locations() ?>;
    var geojson = {};
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
    console.log(geojson);

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
                "source": 'geojson',
                "filter": ["has", "point_count"],
                "layout": {
                    'visibility': 'none'
                },
                "paint": {
                    // Use step expressions (https://docs.mapbox.com/mapbox-gl-js/style-spec/#expressions-step)
                    // with three steps to implement three types of circles:
                    //   * Blue, 20px circles when point count is less than 10
                    //   * Yellow, 30px circles when point count is between 10 and 30
                    //   * Pink, 40px circles when point count is greater than or equal to 750
                    "circle-color": [
                        "step",
                        ["get", "point_count"],
                        "#CCFF99",
                        10,
                        "#3CB371",
                        30,
                        "#2E8B57"
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
                "source": 'geojson',
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
                    "source": 'geojson',
                    filter: ["!", ["has", "point_count"]],
                    "layout": {
                        "icon-image": "toilet",
                        "icon-allow-overlap": true,
                        'visibility': 'none'
                    }
                });
            });

            // inspect a cluster on click
            map.on('click', 'places', function (e) {
                var features = map.queryRenderedFeatures(e.point, { layers: ['places'] });
                var clusterId = features[0].properties.cluster_id;
                map.getSource('geojson').getClusterExpansionZoom(clusterId, function (err, zoom) {
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
                map.getSource('geojson').getClusterExpansionZoom(clusterId, function (err, zoom) {
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

                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(map);
            });

        });
    }

    // pass drink data to Geojson array
    var drinkLocations = <?php get_drink_locations() ?>;
    var drinkGeojson = {};
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

                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description)
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

    // pass seat data to Geojson array
    var seatLocations = <?php get_seats_locations() ?>;
    var seatGeojson = {};
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
    console.log(seatGeojson);

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

                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description)
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

    // pass pedestrian data to Geojson array
    var pedestrian = <?php get_pedestrian() ?>;
    var pedestrianGeojson = {};
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
    console.log(pedestrianGeojson);

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
                        10, '#99FF00',
                        50, '#CCFF00',
                        100, '#FFFF00',
                        300, '#FFCC00',
                        600, '#FF9900',
                        2000, '#FF6600',
                        3000, '#FF3300',
                        5000, '#FF0000'
                    ],
                    "circle-opacity": 0.6,
                },
                filter: ['all', ['==', ['number', ['get', 'Hour']], 12], ['==', ['string', ['get', 'Day']], 'Monday']]
            });
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

    var start;
    var canvas = map.getCanvasContainer();
    getUserLocation();
    // create a function to make a directions request
    function getRoute(end) {

        // make a directions request using cycling profile
        // an arbitrary start will always be the same
        // only the end or destination will change
        // initialize the map canvas to interact with later
        console.log(start);
        console.log(end);
        // an arbitrary start will always be the same
        // only the end or destination will change
        var url = 'https://api.mapbox.com/directions/v5/mapbox/walking/' + start[0] + ',' + start[1] + ';' + end[0] + ',' + end[1] + '?steps=true&geometries=geojson&access_token=' + mapboxgl.accessToken;

        // make an XHR request https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest
        var req = new XMLHttpRequest();
        req.responseType = 'json';
        req.open('GET', url, true);
        req.onload = function() {
            var data = req.response.routes[0];
            var route = data.geometry.coordinates;
            var geojson = {
                type: 'Feature',
                properties: {},
                geometry: {
                    type: 'LineString',
                    coordinates: route
                }
            };
            // if the route already exists on the map, reset it using setData
            if (map.getSource('route')) {
                map.getSource('route').setData(geojson);
            } else { // otherwise, make a new request
                map.addLayer({
                    id: 'route',
                    type: 'line',
                    source: {
                        type: 'geojson',
                        data: {
                            type: 'Feature',
                            properties: {},
                            geometry: {
                                type: 'LineString',
                                coordinates: geojson
                            }
                        }
                    },
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round',
                        'visibility': 'none'
                    },
                    paint: {
                        'line-color': '#e04050',
                        'line-width': 5,
                        'line-opacity': 0.75

                    }
                });
            }
            // add turn instructions here at the end
            // get the sidebar and add the instructions
            var instructions = document.getElementById('instructions');
            var steps = data.legs[0].steps;

            var tripInstructions = [];
            for (var i = 0; i < steps.length; i++) {
                tripInstructions.push('<br><li>' + steps[i].maneuver.instruction) + '</li>';
                instructions.innerHTML = '<span class="duration">Trip duration: ' + Math.floor(data.duration / 60) + ' min </span>' + tripInstructions;
            }
        };
        req.send();
    }

    map.on('click', function(e) {
        var coordsObj = e.lngLat;
        canvas.style.cursor = '';
        var coords = Object.keys(coordsObj).map(function(key) {
            return coordsObj[key];
        });
        var end = {
            type: 'FeatureCollection',
            features: [{
                type: 'Feature',
                properties: {},
                geometry: {
                    type: 'Point',
                    coordinates: coords
                }
            }
            ]
        };
        if (map.getLayer('end')) {
            map.getSource('end').setData(end);
        } else {
            map.addLayer({
                id: 'end',
                type: 'circle',
                source: {
                    type: 'geojson',
                    data: {
                        type: 'FeatureCollection',
                        features: [{
                            type: 'Feature',
                            properties: {},
                            geometry: {
                                type: 'Point',
                                coordinates: coords
                            }
                        }]
                    }
                },
                paint: {
                    'circle-radius': 5,
                    'circle-color': '#3887be'
                },
                layout: {
                    'visibility': 'none'
                },
            });
        }
        getRoute(coords);
    });

    var draw = new MapboxDraw({
        // Instead of showing all the draw tools, show only the line string and delete tools
        displayControlsDefault: false,
        controls: {
            line_string: true,
            trash: true
        },
        styles: [
            // Set the line style for the user-input coordinates
            {
                "id": "gl-draw-line",
                "type": "line",
                "filter": ["all", ["==", "$type", "LineString"],
                    ["!=", "mode", "static"]
                ],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#438EE4",
                    "line-dasharray": [0.2, 2],
                    "line-width": 4,
                    "line-opacity": 0.7
                }
            },
            // Style the vertex point halos
            {
                "id": "gl-draw-polygon-and-line-vertex-halo-active",
                "type": "circle",
                "filter": ["all", ["==", "meta", "vertex"],
                    ["==", "$type", "Point"],
                    ["!=", "mode", "static"]
                ],
                "paint": {
                    "circle-radius": 12,
                    "circle-color": "#FFF"
                }
            },
            // Style the vertex points
            {
                "id": "gl-draw-polygon-and-line-vertex-active",
                "type": "circle",
                "filter": ["all", ["==", "meta", "vertex"],
                    ["==", "$type", "Point"],
                    ["!=", "mode", "static"]
                ],
                "paint": {
                    "circle-radius": 8,
                    "circle-color": "#438EE4",
                }
            },
        ]
    });

    function updateRoute() {
        // Set the profile
        var profile = "walking";
        // Get the coordinates that were drawn on the map
        var data = draw.getAll();
        var lastFeature = data.features.length - 1;
        var coords = data.features[lastFeature].geometry.coordinates;
        // Format the coordinates
        var newCoords = coords.join(';')
        // Set the radius for each coordinate pair to 25 meters
        var radius = [];
        coords.forEach(element => {
            radius.push(25);
        });
        getMatch(newCoords, radius, profile);
    }

    // Make a Map Matching request
    function getMatch(coordinates, radius, profile) {
        // Separate the radiuses with semicolons
        var radiuses = radius.join(';')
        // Create the query
        var query = 'https://api.mapbox.com/matching/v5/mapbox/' + profile + '/' + coordinates + '?geometries=geojson&radiuses=' + radiuses + '&steps=true&access_token=' + mapboxgl.accessToken;

        $.ajax({
            method: 'GET',
            url: query
        }).done(function(data) {
            // Get the coordinates from the response
            var coords = data.matchings[0].geometry;
            // Draw the route on the map
            addRoute(coords);
            getInstructions(data.matchings[0]);
        });
    }

    // Draw the Map Matching route as a new layer on the map
    function addRoute(coords) {
        // If a route is already loaded, remove it
        if (map.getSource('customizeRoute')) {
            map.removeLayer('customizeRoute')
            map.removeSource('customizeRoute')
        } else {
            map.addLayer({
                "id": "customizeRoute",
                "type": "line",
                "source": {
                    "type": "geojson",
                    "data": {
                        "type": "Feature",
                        "properties": {},
                        "geometry": coords
                    }
                },
                "layout": {
                    "line-join": "round",
                    "line-cap": "round"
                },
                "paint": {
                    "line-color": "#03AA46",
                    "line-width": 8,
                    "line-opacity": 0.8
                }
            });
        };
    }
    function getInstructions(data) {
        // Target the sidebar to add the instructions
        var directions = document.getElementById('directions');

        var legs = data.legs;
        var tripDirections = [];
        // Output the instructions for each step of each leg in the response object
        for (var i = 0; i < legs.length; i++) {
            var steps = legs[i].steps;
            for (var j = 0; j < steps.length; j++) {
                tripDirections.push('<br><li>' + steps[j].maneuver.instruction) + '</li>';
            }
        }
        directions.innerHTML = '<h2>Trip duration: ' + Math.floor(data.duration / 60) + ' min.</h2>' + tripDirections;
    }

    // If the user clicks the delete draw button, remove the layer if it exists
    function removeRoute() {
        if (map.getSource('customizeRoute')) {
            map.removeLayer('customizeRoute');
            map.removeSource('customizeRoute');
        } else {
            return;
        }
    }

    map.on('draw.create', updateRoute);
    map.on('draw.update', updateRoute);
    map.on('draw.delete', removeRoute);

</script>

</html>