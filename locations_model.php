<?php

    function connect_db()
    {
        $con=mysqli_connect ("127.0.0.1", 'root', 'root','light');
        if (!$con) {
            die('Not connected : ' . mysqli_connect_error());
        }
        return $con;
    }

    // Gets data from URL parameters.
    get_seats_locations();
    function get_seats_locations()
    {

        $f_pointer = fopen("seats.csv", "r"); // file pointer
        $array=[];
        while (!feof($f_pointer)) {
            $ar = fgetcsv($f_pointer);
            array_push($array,$ar);
        }

        $indexed = array_map('array_values', $array);

        echo json_encode($indexed);
        if (!$array) {return null;}

    }

    function get_drink_locations()
    {
        $con= connect_db();
        // update location with location_status if admin location_status.

        $drinkData = mysqli_query($con,"select Description,lat,lon from drinking_fountains");

        $rows = array();
        while($r = mysqli_fetch_assoc($drinkData)) {
            $rows[] = $r;
        }

        $indexed = array_map('array_values', $rows);

        echo json_encode($indexed);
        if (!$rows) {return null;}
    }

    function get_toilet_locations()
    {
        $con= connect_db();
        $toiletData = mysqli_query($con,"select name,lat,lon from toilets");

        $rows = array();
        while($r = mysqli_fetch_assoc($toiletData)) {
            $rows[] = $r;
        }
        $indexed = array_map('array_values', $rows);

        echo json_encode($indexed);
        if (!$rows) {return null;}
    }


?>