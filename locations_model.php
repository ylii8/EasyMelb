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
    function get_seats_locations()
    {
        $con= connect_db();
        // update location with location_status if admin location_status.

        $seatData = mysqli_query($con,"select LOCATION_DESC,lat,lon from seats");

        $rows = array();
        while($r = mysqli_fetch_assoc($seatData)) {
            $rows[] = $r;
        }

      $indexed = array_map('array_values', $rows);
      //  $array = array_filter($indexed);

        echo json_encode($indexed);
        if (!$rows) {return null;}
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
        //  $array = array_filter($indexed);

        echo json_encode($indexed);
        if (!$rows) {return null;}
    }

    function get_toilet_locations()
    {
        $con= connect_db();
        // update location with location_status if admin location_status.

        $toiletData = mysqli_query($con,"select name,lat,lon from toilets");

        $rows = array();
        while($r = mysqli_fetch_assoc($toiletData)) {
            $rows[] = $r;
        }
        $indexed = array_map('array_values', $rows);
        //  $array = array_filter($indexed);

        echo json_encode($indexed);
        if (!$rows) {return null;}
    }

//    function get_sqlData()
//    {
//        $con= connect_db();
//        if
//        $seatData = mysqli_query($con,"select LOCATION_DESC,lat,lon from seats");
//        $sqlData = mysqli_query($con,"select Description,lat,lon from drinking_fountains");
//        $sqlData = mysqli_query($con,"select name,lat,lon from toilets");
//        return $sqlData;
//    }

?>