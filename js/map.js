// create a map and load methods to draw data on
function initmap() {

    map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/light-v10', //style URL of map style
        center: [144.95936, -37.81654], //default location when load the map
        zoom: 15.5, //default zoom level
        pitch: 45,
        bearing: -17.6,
        antialias: true,
    });
    discoverNearest(userLocation);
    getCurrentDay();
    getGradient();
    drawSeat();
    drawPedestrian();
    drawDrink();
    drawToilet();
    load3D();
    var nav = new mapboxgl.NavigationControl();
    map.addControl(nav, 'bottom-left');
    addDirectionAPI();
}

// open side panel and change the style
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
}

// close side panel
function closeNav() {
    document.getElementById("mySidepanel").style.width = "0";
}

// get current day and set the value to pedestrian legend
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

// show snack bar when click information button on pedestrian legend
function snackBar() {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");
    // Add the "show" class to DIV
    x.className = "show";
    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000);
}

// add direction API to the map
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

// add undo button to undo the drag change
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

function forExpo(){
    nearSeat = {
        "type": "FeatureCollection",
        "features": [{
            "type": "Feature",
            "geometry": {
                "type": "Point",
                "coordinates": [144.958733332854, -37.8165340323693]
            },
            "properties": {
                description: "William Street between Little Collins Street and Bourke Street approximately 18m NW of The Australian Club Inc, 110 William Street, Melbourne, 3000",
                icon: "picnic-site",
                distance: 0.05506869752466761}
            },
            {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [144.960383415257, -37.8166099388127]
                },
                "properties": {
                    description: "Bank Place between Collins Street and Little Collins Street approximately 5m SW of Melbourne Savage Club, The Melbourne Savage Club, 12-16 Bank Place, Melbourne, 3000",
                    icon: "picnic-site",
                    distance: 0.09026241626167168}
            },
            {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [144.960441312164, -37.8167599059526]
                },
                "properties": {
                    description: "Bank Place between Collins Street and Little Collins Street approximately 2m North of Mitre Tavern, 5-9 Bank Place, Melbourne, 3000",
                    icon: "picnic-site",
                    distance: 0.09811178017420624}
            },
            {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [144.958390404621, -37.816368218343]
                },
                "properties": {
                    description: "William Street between Little Collins Street and Bourke Street approximately 25m North of Priceline Pharmacy William Street, 111 William Street, Melbourne, 3000",
                    icon: "picnic-site",
                    distance: 0.08731390226875771}
            },
            {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [144.959972080052, -37.81729473501]
                },
                "properties": {
                    description: "Collins Street between William Street and Market Street approximately 28m NW of 431 Collins Street, Melbourne, 3000",
                    icon: "picnic-site",
                    distance: 0.09969963832426827}
            },
    ]};
    nearDrink = {
        "type": "FeatureCollection",
        "features": [{
            "type": "Feature",
            "geometry": {
                "type": "Point",
                "coordinates": [144.9584794, -37.8165598]
            },
            "properties": {
                description: "Drinking Fountain - Stainless Steel Drinking Fountain - Leaf Type - Bottle Refill Tap",
                icon: "beer",
                distance: 0.0774088781027173}
        }
        ]};
    near = {
        "type": "FeatureCollection",
        "features": [{
            "type": "Feature",
            "geometry": {
                "type": "Point",
                "coordinates": [144.9602543, -37.8174699]
            },
            "properties": {
                description: "Public Toilet - Toilet 4 - Market Street (Opposite 74 Market Street)<br>Female: yes<br>Male: yes<br>Wheelchair: yes<br>Baby Facility: no",
                icon: "toilet",
                distance: 0.12989711156805617}
        },
            {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [144.9610621, -37.8158382]
                },
                "properties": {
                    description: "Public Toilet - Toilet 43 - Queen Street (opposite 113 Queen Street)<br>Female: yes<br>Male: yes<br>Wheelchair: yes<br>Baby Facility: n",
                    icon: "toilet",
                    distance: 0.1687084803607659}
            },
            {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [144.9612768, -37.8194061]
                },
                "properties": {
                    description: "Public Toilet - Toilet 3 - Flinders Street (399 Flinders Street)<br>Female: yes<br>Male: yes<br>Wheelchair: yes<br>Baby Facility: no",
                    icon: "toilet",
                    distance: 0.36055167922656894}
            },
            {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [144.9600121, -37.8129331]
                },
                "properties": {
                    description: "Public Toilet - Toilet 36 - Lonsdale Street (Opposite 424 Lonsdale Street)<br>Female: yes<br>Male: yes<br>Wheelchair: yes<br>Baby Facility: yes",
                    icon: "toilet",
                    distance: 0.4052662388571639}
            },
            {
                "type": "Feature",
                "geometry": {
                    "type": "Point",
                    "coordinates": [144.9630972, -37.8138378]
                },
                "properties": {
                    description: "Public Toilet - Toilet 6 - Elizabeth Street (Toilet Adjacent 200 Elizabeth Street)<br>Female: yes<br>Male: no<br>Wheelchair: no<br>Baby Facility: n",
                    icon: "toilet",
                    distance: 0.44517389782166394}
            },
        ]};

}

// explore nearest features around the user and save the data
function discoverNearest(userLocation){
    // console.log(userLocation);
    // nearSeat['type'] = 'FeatureCollection';
    // nearSeat['features'] = [];
    seatGeojson.features.forEach(function(e) {
        Object.defineProperty(e.properties, 'distance', {
            value: turf.distance(turf.point(userLocation), turf.point(e.geometry.coordinates)),
            writable: true,
            enumerable: true,
            configurable: true
        });
        // if (e.properties.distance < 0.1){
        //     nearSeat['features'].push(e);
        // }
    });
    // console.log(seatGeojson);
    // console.log(nearSeat);

    // nearDrink['type'] = 'FeatureCollection';
    // nearDrink['features'] = [];
    drinkGeojson.features.forEach(function(e) {
        Object.defineProperty(e.properties, 'distance', {
            value: turf.distance(turf.point(userLocation), turf.point(e.geometry.coordinates)),
            writable: true,
            enumerable: true,
            configurable: true
        });
        // if (e.properties.distance < 0.1){
        //     nearDrink['features'].push(e);
        // }
    });
    // searchNearest(nearDrink.features,drinkGeojson);
    // console.log(nearDrink);

    // near['type'] = 'FeatureCollection';
    // near['features'] = [];
    geojson.features.forEach(function(e) {
        Object.defineProperty(e.properties, 'distance', {
            value: turf.distance(turf.point(userLocation), turf.point(e.geometry.coordinates)),
            writable: true,
            enumerable: true,
            configurable: true
        });
        // if (e.properties.distance < 0.1){
        //     near['features'].push(e);
        // }
    });
    // searchNearest(near.features,geojson);
    // console.log(near);
}

// draw nearest features on the map
function drawNearest(){
    if (userLocation != null || typeof userLocation !== 'undefined'){
        map.on('load', function () {
            map.addSource("nearSeat", {
                type: "geojson",
                data: nearSeat,
                cluster: true,
                clusterMaxZoom: 40, // Max zoom to cluster points on
                clusterRadius: 50
            });

            // Add a layer showing the places.
            map.addLayer({
                "id": "nearcluster",
                "type": "circle",
                "source": 'nearSeat',
                "filter": ["has", "point_count"],
                "layout": {
                    'visibility': 'none'
                },
                paint: {
                    "circle-color": [
                        "step",
                        ["get", "point_count"],
                        "#ffc020",
                        3,
                        "#ff8020",
                        6,
                        "#ff4020",
                        9,
                        "#ff0020"
                    ],
                    "circle-radius": [
                        "step",
                        ["get", "point_count"],
                        20,
                        10,
                        30,
                        20,
                        40
                    ]
                }
            });
            map.addLayer({
                id: "near-cluster-count",
                type: "symbol",
                "source": 'nearSeat',
                filter: ["has", "point_count"],
                layout: {
                    "text-field": "{point_count_abbreviated}",
                    "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                    "text-size": 12,
                    'visibility': 'none'
                }
            });

            map.addLayer({
                id: "nearSeat",
                type: "symbol",
                "source": "nearSeat",
                filter: ["!", ["has", "point_count"]],
                "layout": {
                    "icon-image": "bench",
                    "icon-allow-overlap": true,
                    'visibility': 'none'
                }
            });

            // inspect a cluster on click
            map.on('click', 'nearcluster', function (e) {
                var features = map.queryRenderedFeatures(e.point, { layers: ['nearcluster'] });
                var clusterId = features[0].properties.cluster_id;
                map.getSource('nearSeat').getClusterExpansionZoom(clusterId, function (err, zoom) {
                    if (err)
                        return;

                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                });
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

            // Change the cursor to a pointer when the mouse is over the places layer.
            map.on('mouseenter', 'nearcluster', function () {
                map.getCanvas().style.cursor = 'pointer';
            });

            // Change it back to a pointer when it leaves.
            map.on('mouseleave', 'nearcluster', function () {
                map.getCanvas().style.cursor = '';
            });
        });
        map.on('load', function () {
            map.addSource("nearDrink", {
                type: "geojson",
                data: nearDrink,
                cluster: true,
                clusterMaxZoom: 20, // Max zoom to cluster points on
                clusterRadius: 50
            });
            // Add a layer showing the places.
            map.addLayer({
                "id": "neardrinkcluster",
                "type": "circle",
                "source": 'nearDrink',
                "filter": ["has", "point_count"],
                "layout": {
                    'visibility': 'none'
                },
                paint: {
                    "circle-color": [
                        "step",
                        ["get", "point_count"],
                        "#00c0ff",
                        2,
                        "#0060ff",
                        4,
                        "#0000ff"
                    ],
                    "circle-radius": [
                        "step",
                        ["get", "point_count"],
                        20,
                        6,
                        30,
                        9,
                        40
                    ]
                }
            });
            map.addLayer({
                id: "neardrink-cluster-count",
                type: "symbol",
                "source": 'nearDrink',
                filter: ["has", "point_count"],
                layout: {
                    "text-field": "{point_count_abbreviated}",
                    "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                    "text-size": 12,
                    'visibility': 'none'
                }
            });

            map.addLayer({
                id: "nearDrink",
                type: "symbol",
                "source": "nearDrink",
                filter: ["!", ["has", "point_count"]],
                "layout": {
                    "icon-image": "drop",
                    "icon-allow-overlap": true,
                    'visibility': 'none'
                }
            });

            // inspect a cluster on click
            map.on('click', 'neardrinkcluster', function (e) {
                var features = map.queryRenderedFeatures(e.point, { layers: ['neardrinkcluster'] });
                var clusterId = features[0].properties.cluster_id;
                map.getSource('nearDrink').getClusterExpansionZoom(clusterId, function (err, zoom) {
                    if (err)
                        return;

                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                });
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
        map.on('load', function () {
            map.addSource("near", {
                type: "geojson",
                data: near,
                cluster: true,
                clusterMaxZoom: 20, // Max zoom to cluster points on
                clusterRadius: 50
            });
            // Add a layer showing the places.
            map.addLayer({
                "id": "neartoiletcluster",
                "type": "circle",
                "source": 'near',
                "filter": ["has", "point_count"],
                "layout": {
                    'visibility': 'none'
                },
                paint: {
                    "circle-color": [
                        "step",
                        ["get", "point_count"],
                        "#ffa0c0",
                        2,
                        "#ff60c0",
                        3,
                        "#ff20c0"
                    ],
                    "circle-radius": [
                        "step",
                        ["get", "point_count"],
                        20,
                        6,
                        30,
                        9,
                        40
                    ]
                }
            });
            map.addLayer({
                id: "neartoilet-cluster-count",
                type: "symbol",
                "source": 'near',
                filter: ["has", "point_count"],
                layout: {
                    "text-field": "{point_count_abbreviated}",
                    "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
                    "text-size": 12,
                    'visibility': 'none'
                }
            });
            map.addLayer({
                id: "nearFeature",
                type: "symbol",
                "source": "near",
                filter: ["!", ["has", "point_count"]],
                "layout": {
                    "icon-image": "toilet",
                    "icon-allow-overlap": true,
                    'visibility': 'none'
                }
            });
            // inspect a cluster on click
            map.on('click', 'neartoiletcluster', function (e) {
                var features = map.queryRenderedFeatures(e.point, { layers: ['neartoiletcluster'] });
                var clusterId = features[0].properties.cluster_id;
                map.getSource('near').getClusterExpansionZoom(clusterId, function (err, zoom) {
                    if (err)
                        return;

                    map.easeTo({
                        center: features[0].geometry.coordinates,
                        zoom: zoom
                    });
                });
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
}

// draw user current location on the map
function drawCurrentLocation(){
    if (userLocation != null || typeof userLocation !== 'undefined'){
        console.log(userLocation);
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
                                "coordinates": userLocation
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
    }
}

// search nearest features within 100m, if no, search the nearest 5 features
function searchNearest(nearFeature,geojsonData){
    // if no toilet available within 100m, search the nearest 5 toilets
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

// draw seats on the map
function drawSeat(){
    map.on('load', function () {
        map.addSource("seatGeojson", {
            type: "geojson",
            data: seatGeojson,
            cluster: true,
            clusterMaxZoom: 40, // Max zoom to cluster points on
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
                    300,
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

// draw toilets on the map
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

// draw drinking fountains on the map
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

// draw pedestrian density on the map
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

// draw 3D building on the map
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

// draw street steepness on the map
function getGradient() {

    var geojson = 'data/Footpath steepness.geojson';

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

