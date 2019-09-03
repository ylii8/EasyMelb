<?php include_once 'locations_model.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Filtering marker cluster groups</title>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.0/mapbox-gl.css' rel='stylesheet' />
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
    //var locations;
    //// var mymap = L.map('map').setView([-37.8136,144.9631], 15);
    ////
    //// L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    ////     attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    ////     maxZoom: 18,
    ////     id: 'mapbox.streets',
    ////     accessToken: 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw'
    //// }).addTo(mymap);
    //L.mapbox.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw';
    //var map = L.mapbox.map('map')
    //    .setView([-37.8136,144.9631], 15)
    //    .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));
    //
    //// var overlays = L.layerGroup().addTo(map);
    //// var layers;
    //
    //
    //
    //
    //
    //
    //
    //
    //    // pass data to Geojson array
    //    locations = //;
    //    var geojson = {};
    //    geojson['type'] = 'FeatureCollection';
    //    geojson['features'] = [];
    //
    //    for (var k in locations) {
    //        var newFeature = {
    //            "type": "Feature",
    //            "geometry": {
    //                "type": "Point",
    //                "coordinates": [parseFloat(locations[k][2]), parseFloat(locations[k][1])]
    //            },
    //            "properties": {
    //                "description": locations[k][0]
    //            }
    //        }
    //        geojson['features'].push(newFeature);
    //    }
    //
    //    console.log(geojson);
    //
    //var myLayer = L.mapbox.featureLayer().addTo(map);
    //
    //myLayer.setGeoJSON(geojson);

    mapboxgl.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw';
    var map = new mapboxgl.Map({
        style: 'mapbox://styles/mapbox/dark-v10',
        center: [-74.0066, 40.7135],
        zoom: 15.5,
        pitch: 45,
        bearing: -17.6,
        container: 'map',
        antialias: true
    });

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
            'minzoom': 15,
            'paint': {
                'fill-extrusion-color': '#aaa',

// use an 'interpolate' expression to add a smooth transition effect to the
// buildings as the user zooms in
                'fill-extrusion-height': [
                    "interpolate", ["linear"], ["zoom"],
                    15, 0,
                    15.05, ["get", "height"]
                ],
                'fill-extrusion-base': [
                    "interpolate", ["linear"], ["zoom"],
                    15, 0,
                    15.05, ["get", "min_height"]
                ],
                'fill-extrusion-opacity': .6
            }
        }, labelLayerId);
    });

</script>
</body>
</html>