<?php

    // Connect to database.
    function connect_db()
    {
        $con=mysqli_connect ("127.0.0.1", 'root', 'root','light');
        if (!$con) {
            die('Not connected : ' . mysqli_connect_error());
        }
        return $con;
    }

    // Get seats data from CSV file.
    function get_seats_locations()
    {

        $f_pointer = fopen("data/seats.csv", "r"); // file pointer
        $array=[];
        while (!feof($f_pointer)) {
            $ar = fgetcsv($f_pointer);
            array_push($array,$ar);
        }
        $indexed = array_map('array_values', $array);
        echo json_encode($indexed);
        if (!$array) {return null;}

    }

    // Get drinking fountains data from database
    function get_drink_locations()
    {
        $con= connect_db();
        $drinkData = mysqli_query($con,"select Description,lat,lon from drinking_fountains");
        $rows = array();
        while($r = mysqli_fetch_assoc($drinkData)) {
            $rows[] = $r;
        }
        $indexed = array_map('array_values', $rows);
        echo json_encode($indexed);
        if (!$rows) {return null;}
    }

    // Get toilets data from database
    function get_toilet_locations()
    {
        $con= connect_db();
        $toiletData = mysqli_query($con,"select name,lat,lon, female, male, wheelchair, baby_facil from toilets");
        $rows = array();
        while($r = mysqli_fetch_assoc($toiletData)) {
            $rows[] = $r;
        }
        $indexed = array_map('array_values', $rows);
        echo json_encode($indexed);
        if (!$rows) {return null;}
    }

    // Gets data from URL parameters.
    function get_pedestrian()
    {
        $f_pointer = fopen("data/SensorPerHour.csv", "r"); // file pointer
        $array=[];
        while (!feof($f_pointer)) {
            $ar = fgetcsv($f_pointer);
            array_push($array,$ar);
        }
        $indexed = array_map('array_values', $array);
        echo json_encode($indexed);
        if (!$array) {return null;}

    }


?>