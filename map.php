<?php include_once 'locations_model.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Filtering marker cluster groups</title>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <script src='https://api.mapbox.com/mapbox.js/v3.2.0/mapbox.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/v3.2.0/mapbox.css' rel='stylesheet' />
    <style>
        body { margin:0; padding:0; }
        #map { position:absolute; top:0; bottom:0; width:100%; }
    </style>
</head>
<body>

<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/leaflet.markercluster.js'></script>
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.css' rel='stylesheet' />
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v1.0.0/MarkerCluster.Default.css' rel='stylesheet' />


<style>
    #colors {
        position: absolute;
        top: 0;
        right: 0;
        background: #fff;
        width: 150px;
        padding:5px;
    }
</style>
<div id='map'></div>
<!--<form id='colors'>-->
<!--    <div><input type='checkbox' name='filters' onclick='showStations();' value='red' checked> red</div>-->
<!--    <div><input type='checkbox' name='filters' onclick='showStations();' value='green' checked> green</div>-->
<!--    <div><input type='checkbox' name='filters' onclick='showStations();' value='orange' checked> orange</div>-->
<!--    <div><input type='checkbox' name='filters' onclick='showStations();' value='yellow' checked> yellow</div>-->
<!--    <div><input type='checkbox' name='filters' onclick='showStations();' value='blue' checked> blue</div>-->
<!--</form>-->


<script>
    var locations;
    // var mymap = L.map('map').setView([-37.8136,144.9631], 15);
    //
    // L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    //     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    //     maxZoom: 18,
    //     id: 'mapbox.streets',
    //     accessToken: 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw'
    // }).addTo(mymap);
    L.mapbox.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw';
    var map = L.mapbox.map('map')
        .setView([-37.8136,144.9631], 15)
        .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));

    // var overlays = L.layerGroup().addTo(map);
    // var layers;








        // pass data to Geojson array
        locations = <?php get_toilet_locations() ?>;
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
                    "description": locations[k][0]
                }
            }
            geojson['features'].push(newFeature);
        }

        console.log(geojson);

    var myLayer = L.mapbox.featureLayer().addTo(map);

    myLayer.setGeoJSON(geojson);



</script>
</body>
</html>