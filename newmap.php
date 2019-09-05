<!DOCTYPE html>
<html>
<head>
    <?php include 'header.php'; ?>
    <meta charset='utf-8' />
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.0/mapbox-gl.css' rel='stylesheet' />

    <!-- Bootstrap core CSS -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts -->
    <link href="lib/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="lib/simple-line-icons/css/simple-line-icons.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        body { margin:0; padding:0; }
        #map { position:absolute; top:0; bottom:0; width:100%; }
    </style>

</head>
<body>

<style>
    #menu {
        background: #fff;
        position: absolute;
        z-index: 1;
        top: 10px;
        right: 10px;
        border-radius: 3px;
        width: 120px;
        border: 1px solid rgba(0,0,0,0.4);
        font-family: 'Open Sans', sans-serif;
    }

    #menu a {
        font-size: 13px;
        color: #404040;
        display: block;
        margin: 0;
        padding: 0;
        padding: 10px;
        text-decoration: none;
        border-bottom: 1px solid rgba(0,0,0,0.25);
        text-align: center;
    }

    #menu a:last-child {
        border: none;
    }

    #menu a:hover {
        background-color: #f8f8f8;
        color: #404040;
    }

    #menu a.active {
        background-color: #3887be;
        color: #ffffff;
    }

    #menu a.active:hover {
        background: #3074a4;
    }
</style>

<nav id="menu"></nav>
<div id="map"></div>

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/light-v10', //style URL of map style
        center: [144.96565, -37.81384], //default location when load the map
        zoom: 14, //default zoom level
        // Zero is perpendicular to the surface
        pitch: 45,
        // the compass direction that is "up"
        bearing: -17.6,
        antialias: true
    });
    load3D();
    getGradient();

    var toggleableLayerIds = [ '3d-buildings', 'line'];

    for (var i = 0; i < toggleableLayerIds.length; i++) {
        var id = toggleableLayerIds[i];

        var link = document.createElement('a');
        link.href = '#';
        link.className = '';
        link.textContent = id;

        link.onclick = function (e) {
            var clickedLayer = this.textContent;
            e.preventDefault();
            e.stopPropagation();

            var visibility = map.getLayoutProperty(clickedLayer, 'visibility');

            if (visibility === 'visible') {
                map.setLayoutProperty(clickedLayer, 'visibility', 'none');
                this.className = '';
            } else {
                this.className = 'active';
                map.setLayoutProperty(clickedLayer, 'visibility', 'visible');
            }
        };

        var layers = document.getElementById('menu');
        layers.appendChild(link);
    }

    function load3D(){
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

    }

    function getGradient(){

        var geojson = 'Footpath steepness.geojson';
        map.on('load', function () {
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
                    'line-width': 3,
                    // 'line-gradient' must be specified using an expression
                    // with the special 'line-progress' property
                    'line-gradient': [
                        'interpolate',
                        ['linear'],
                        ['line-progress'],
                        0, "blue",
                        0.1, "royalblue",
                        0.3, "cyan",
                        0.5, "lime",
                        0.7, "yellow",
                        1, "red"
                    ]
                },
                layout: {
                    'line-cap': 'round',
                    'line-join': 'round'
                }
            });
        });
    }



</script>

</body>
</html>