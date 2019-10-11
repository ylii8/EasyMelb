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
    <script src="js/jquery-1.9.1.min.js"></script>
    <!--turf-->
    <script src='https://api.mapbox.com/mapbox.js/plugins/turf/v2.0.2/turf.min.js'></script>
    <!-- Custom styles -->
    <link href="css/mapstyle.css" rel="stylesheet">
    <link href="css/bar.css" type="text/css" rel="stylesheet" />
    <!-- Add IntroJs -->
    <link href="lib/introjs.css" rel="stylesheet">
    <script type="text/javascript" src="lib/intro.js"></script>
    <!-- Map JS-->
    <script src='js/map.js'></script>
</head>

<?php include_once 'locations_model.php'; ?>
<body onload="checkCookie()">

<div id="mySidepanel" class="sidepanel">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a id="seatButton" class="abtn"><i class="fas fa-chair"></i> Seats</a>
    <a id="toiletButton"><i class="fas fa-restroom"></i> Toilets</a>
    <a id="drinkButton"><i class="fas fa-tint"></i> Drinking fountains</a>
    <a id="gradientButton"><i class="fas fa-mountain"></i> Street steepness</a>
    <a id="densityButton"><i class="fas fa-users"></i> Pedestrian density</a>
    <a id="3dButton"><i class="fas fa-cubes"></i> 3D model</a>
    <a id="nearby"><i class="fas fa-search-location"></i> Nearby facilities</a>
</div>
<div id='map'></div>

<div id='direction' class='direction'></div>
<button id='close' title="Hide or show direction form"><i class="fas fa-times"></i></button>

<a id='logo' href="index.html" title="Go to the Home Page" ><img src="img/logo.PNG">EasyMelb</a>
<button id='sidepanel' onclick="openNav()" title="More functions" style="">Features</button>
<button id='fly' title="Show current location"><i class="fa fa-location-arrow"></i></button>
<button id='undo' title="Undo drag changes"><i class="fas fa-undo-alt"></i></button>
<div id="snackbar">The points show the sensor locations</div>
<!--Pedestrian-->
<div id="rightArrow" style="display: none"><a href="javascript:;" title="Pedestrian"><i class="fas fa-users"></i></a></div>
<div id="floatDivBoxs" style="display: none">
    <div class="floatDtt" >Pedestrian</div>
    <div class="floatShadow">
        <div class='session'>
            <div class='row2 colors'></div>
            <div class='row2 labels'>
                <div class='label'>Low</div>
                <div class='label'>        </div>
                <div class='label'>High</div>
            </div>
        </div>
        <div class='session' id='sliderbar' style="margin-left: 3px;">
            <h3 >Hour: <label2 id='active-hour'>12PM</label2></h3>
            <input id='slider' class='row' type='range' min='0' max='23' step='1' value='12' />
        </div>
        <div class='session' style="margin-left: 3px;">
            <h3 >Day</h3>
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
                <button onclick="snackBar()" style="margin-left:65px;font-size: 13px;border:none;display: inline-block;"><i class="fas fa-info-circle"></i></button>
            </div>

        </div>
    </div>
</div>
<!--Gradient-->
<div id="rightArrow2" style="display: none"><a href="javascript:;" title="Gradient"><i class="fas fa-mountain"></i></a></div>
<div id="floatDivBoxs2" style="display: none">
    <div class="floatDtt">Gradient</div>
    <div class="floatShadowgr">
        <div class='session'>
            <div class='row2 colors2'></div>
            <div class='row2 labels2'>
                <div class='label2'>Low</div>
                <div class='label2'>        </div>
                <div class='label2'>High</div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        var flag=1;
        $('#rightArrow').on("click",function(){
            // hide
            if(flag==1){
                $("#floatDivBoxs").animate({right: '-175px'},300);
                $(this).animate({right: '-5px'},300);
                $(this).css('background-position','-50px 0');
                flag=0;
            }else
                // show
                {
                $("#floatDivBoxs").animate({right: '0'},300);
                $(this).animate({right: '170px'},300);
                $(this).css('background-position','0px 0');
                flag=1;
            }
        });
    });

    $(function(){
        var flag=1;
        $('#rightArrow2').on("click",function(){
            if(flag==1){
                $("#floatDivBoxs2").animate({right: '-175px'},300);
                $(this).animate({right: '-5px'},300);
                $(this).css('background-position','-50px 0');
                flag=0;
            }else{
                $("#floatDivBoxs2").animate({right: '0'},300);
                $(this).animate({right: '170px'},300);
                $(this).css('background-position','0px 0');
                flag=1;
            }
        });
    });
</script>

</body>

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiamVzc2llOTk5IiwiYSI6ImNqenh4a2w0ZTBsMWwzZ3BwN21nYnhyNXcifQ.Nzlxkc0JFpXOeHP4_nDqAw';
    var map;
    var directions;
    var start;
    var geojson = {};
    var drinkGeojson = {};
    var seatGeojson = {};
    var pedestrianGeojson = {};
    var first = true;
    var intro = introJs();

    initmap();

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

    document.getElementById('fly').addEventListener('click', function () {
        map.flyTo({center: start,zoom: 17});
    });
    document.getElementById("seatButton").addEventListener("click", function() {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
            map.setLayoutProperty('seat', 'visibility', 'none');
            map.setLayoutProperty('seat-cluster-count', 'visibility', 'none');
            map.setLayoutProperty('seat-unclustered-point', 'visibility', 'none');
            document.getElementById("seatButton").style.background= "#babed1";
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
            document.getElementById("toiletButton").style.background= "#babed1";
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
            document.getElementById("drinkButton").style.background= "#babed1";
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
            document.getElementById("rightArrow2").style.display = "none";
            document.getElementById("floatDivBoxs2").style.display = "none";
            map.setLayoutProperty('line', 'visibility', 'none');
            document.getElementById("gradientButton").style.background= "#babed1";
        } else{
            this.classList.add("active");
            document.getElementById("rightArrow2").style.display = "block";
            document.getElementById("floatDivBoxs2").style.display = "block";
            document.getElementById("floatDivBoxs2").style.right='0';
            document.getElementById("rightArrow2").style.right='170px';
            map.setLayoutProperty('line', 'visibility', 'visible');
            document.getElementById("gradientButton").style.background= "#fdcc52";
        }
    });
    document.getElementById("densityButton").addEventListener("click", function() {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
            document.getElementById("rightArrow").style.display = "none";
            document.getElementById("floatDivBoxs").style.display = "none";
            map.setLayoutProperty("pedestrian", 'visibility', 'none');
            document.getElementById("densityButton").style.background= "#babed1";
        } else{
            this.classList.add("active");
            document.getElementById("rightArrow").style.display = "block";
            document.getElementById("floatDivBoxs").style.display = "block";
            document.getElementById("floatDivBoxs").style.right='0';
            document.getElementById("rightArrow").style.right='170px';
            map.setLayoutProperty('pedestrian', 'visibility', 'visible');
            document.getElementById("densityButton").style.background= "#fdcc52";
        }
    });
    document.getElementById("3dButton").addEventListener("click", function() {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
            map.setLayoutProperty("3d-buildings", 'visibility', 'none');
            document.getElementById("3dButton").style.background= "#babed1";
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
            map.setLayoutProperty("near-cluster-count", 'visibility', 'none');
            map.setLayoutProperty("nearcluster", 'visibility', 'none');

            map.setLayoutProperty("nearDrink", 'visibility', 'none');
            map.setLayoutProperty("neardrinkcluster", 'visibility', 'none');
            map.setLayoutProperty("neardrink-cluster-count", 'visibility', 'none');

            map.setLayoutProperty("nearFeature", 'visibility', 'none');
            map.setLayoutProperty("neartoiletcluster", 'visibility', 'none');
            map.setLayoutProperty("neartoilet-cluster-count", 'visibility', 'none');
            document.getElementById("nearby").style.background= "#babed1";
        } else{
            this.classList.add("active");
            map.flyTo({center: start,zoom: 17});
            map.setLayoutProperty("nearSeat", 'visibility', 'visible');
            map.setLayoutProperty("near-cluster-count", 'visibility', 'visible');
            map.setLayoutProperty("nearcluster", 'visibility', 'visible');

            map.setLayoutProperty("nearDrink", 'visibility', 'visible');
            map.setLayoutProperty("neardrinkcluster", 'visibility', 'visible');
            map.setLayoutProperty("neardrink-cluster-count", 'visibility', 'visible');

            map.setLayoutProperty("nearFeature", 'visibility', 'visible');
            map.setLayoutProperty("neartoiletcluster", 'visibility', 'visible');
            map.setLayoutProperty("neartoilet-cluster-count", 'visibility', 'visible');

            document.getElementById("nearby").style.background= "#fdcc52";
        }
    });
    document.getElementById("close").addEventListener("click", function() {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
            document.getElementById('direction').style.display='block';
            this.style.marginLeft = "285px";
            $(this).find('i').removeClass('fa-chevron-right').addClass('fa-times');

        }
        else{

            this.classList.add("active");
            document.getElementById('direction').style.display='none';
            this.style.marginLeft = "0px";
            $(this).find('i').removeClass('fa-times').addClass('fa-chevron-right');
        }
    });


    intro.setOptions({
        steps: [
            {
                intro: "Welcome to EasyMelb, here are some tips to get you familiar with EasyMelb!"
            },
            {
                element: document.getElementById('logo'),
                intro: "You can go to the home page by clicking this.",
                position: 'right'
            },
            {
                element: document.getElementById('fly'),
                intro: "Showing your current location by clicking this button, the current location will show as a yellow blinking point.",
                position: 'top'
            },
            {
                element: document.getElementById("undo"),
                intro: "This is used to undo your drag changes when you already made some changes to the displayed route. <br> To make a route, start with entering your origin and destination.",
                position: 'right'
            },
            {
                element: document.getElementById('direction'),
                intro: 'Here you can set your origin and destination for your journey, just click on the map or search in the box.',
                position: 'top'
            },
            {
                element: document.getElementById('sidepanel'),
                intro: "Here we provide features to help you find out street conditions and detailed public " +
                    "facilities information such as street seats and toilets.<br> You can customized your route based on these features.",
                position: 'left'
            },
            {
                intro: "Ready? Let's GO!"
            }
        ]
    });


    // set a cookie which the valid time will be three minutes.
    function setCookie() {
        var d = new Date();
        d.setTime(d.getTime() + (1*60*1000));
        var expires = d.toGMTString();
        document.cookie = expires;
    }

    // when the cookie expired, the introduction will show again and set a new cookie.
    function checkCookie() {
        var now = new Date();
        var expires = document.cookie;
        console.log(now.toGMTString());
        console.log(expires);
        console.log(now.getTime() > Date.parse(expires));
        if ( now.getTime() > Date.parse(expires) )
        {
            intro.start();
            setCookie();
        }
    }


</script>



</html>
