function initmap() {

    map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/light-v10', //style URL of map style
        center: [144.96565, -37.81384], //default location when load the map
        zoom: 15.5, //default zoom level
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

function openNav() {
    if (window.matchMedia("(max-width: 415px)").matches) { // If media query matches
        document.getElementById("mySidepanel").style.width = "200px";
        document.getElementById("mySidepanel").style.height = "350px";
        document.getElementById("seatButton").style.paddingLeft = "40px";
        document.getElementById("toiletButton").style.paddingLeft = "40px";
        document.getElementById("drinkButton").style.paddingLeft = "40px";
        document.getElementById("gradientButton").style.paddingLeft = "40px";
        document.getElementById("densityButton").style.paddingLeft = "40px";
        document.getElementById("3dButton").style.paddingLeft = "40px";
        document.getElementById("nearby").style.paddingLeft = "40px";

     }
    else {
        document.getElementById("mySidepanel").style.width = "280px";
    }
    // if (first === true){setTimeout(function(){
    //     var aintro = introJs();
    //     aintro.setOptions({
    //         steps: [
    //             {
    //                 element: document.getElementById('seatButton'),
    //                 intro: "Show all the street seat locations in Melbourne CBD.",
    //                 position: 'left'
    //             },
    //             {
    //                 element: document.getElementById('toiletButton'),
    //                 intro: "You can find public toilets here, we provides detailed information including gender, wheelchair support or baby facility.",
    //                 position: 'left'
    //             },
    //             {
    //                 element: document.getElementById('drinkButton'),
    //                 intro: " Check drinking fountain locations to get free, clean water.",
    //                 position: 'left'
    //             },
    //             {
    //                 element: document.getElementById('gradientButton'),
    //                 intro: 'Here you can see the street steepness, the gradient legend will show below.',
    //                 position: 'left'
    //             },
    //             {
    //                 element: document.getElementById("densityButton"),
    //                 intro: "Show the pedestrian density in each hour in 7 days.",
    //                 position: 'left'
    //             },
    //             {
    //                 element: document.getElementById('3dButton'),
    //                 intro: "You can show a 3D map by using this to check our the facility whether is inside the buildings.",
    //                 position: 'left'
    //             },
    //             {
    //                 element: document.getElementById('nearby'),
    //                 intro: "Explore nearby to find out seats, drinking fountains, and toilets around you",
    //                 position: 'left'
    //             }
    //         ]
    //     });
    //     aintro.start();
    //     first=false;
    // },500)
    // }
}

function closeNav() {
    document.getElementById("mySidepanel").style.width = "0";
}

function getUserLocation() {
    if (navigator.geolocation)
        navigator.geolocation.getCurrentPosition(function(position) {
             start = [position.coords.longitude,position.coords.latitude];
             start = [144.9639, -37.8136];
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
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
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
    //fake current location
    // var marker = new mapboxgl.Marker({
    //     color: '#fcd703'
    // }).setLngLat([144.9639, -37.8136])
    //     .setPopup(new mapboxgl.Popup({offset: 25})
    //         .setHTML('<h3>Fake current location</h3>')).addTo(map);

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

