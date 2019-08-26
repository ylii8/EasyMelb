<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <script type="text/javascript" src="js/googleMap.js"></script>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            margin-top: 3rem;
            height: 600px;
            width: 100%;
            background-color:grey;
        }
        #lightData{
            display:none;
        }
    </style>
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.php"><img src="img/icon.JPG" style="margin-right:.3rem;margin-bottom:3px;width:1.2rem;height:1.2rem;">Your Guider</a>
    </div>
</nav>

<div class="container">

    <?php
        require 'light.php';
        $light = new Light;
        $lightData = $light->getLightsLatLon();
        $lightData = json_encode($lightData,true);
        echo '<div id="lightData">' . $lightData . '</div>';
    ?>
    <div id="map"></div>

</div>


<footer>
    <?php include 'footer.php'; ?>
</footer>
</body>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBE_QUgncNwk1lNw3QdVic6K5qIFj9_13o&callback=loadMap"
        async defer></script>

</html>