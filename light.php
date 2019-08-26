<?php

class Light
{
    private $asset_number;
    private $asset_description;
    private $lamp_type_lupvalue;
    private $lamp_rating_w;
    private $mounting_type_lupvalue;
    private $lat;
    private $lon;
    private $conn;
    private $tableName = "lights";
    private $dbName = "light";

    function setAsset_number($asset_number) { $this->asset_number = $asset_number; }
    function getAsset_number() { return $this->asset_number; }
    function setAsset_description($asset_description) { $this->asset_description = $asset_description; }
    function getAsset_description() { return $this->asset_description; }
    function setLamp_type_lupvalue($lamp_type_lupvalue) { $this->lamp_type_lupvalue = $lamp_type_lupvalue; }
    function getLamp_type_lupvalue() { return $this->lamp_type_lupvalue; }
    function setLamp_rating_w($lamp_rating_w) { $this->lamp_rating_w = $lamp_rating_w; }
    function getLamp_rating_w() { return $this->lamp_rating_w; }
    function setMounting_type_lupvalue($mounting_type_lupvalue) { $this->mounting_type_lupvalue = $mounting_type_lupvalue; }
    function getMounting_type_lupvalue() { return $this->mounting_type_lupvalue; }
    function setLat($lat) { $this->lat = $lat; }
    function getLat() { return $this->lat; }
    function setLon($lon) { $this->lon = $lon; }
    function getLon() { return $this->lon; }

    public function __construct()
    {
        require_once('dbConnect.php');
        $conn = new DbConnect;
        $this->conn = $conn->connect();
    }

    public function getLightsLatLon()
    {
        $sql = "Select * from $this->dbName.$this->tableName";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}