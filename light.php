<?php

class light
{
    private $id;
    private $desc;
    private $type;
    private $rating;
    private $lat;
    private $lon;
    private $conn;
    private $tableName = "lights";

    function setId($id) { $this->id = $id; }
    function getId() { return $this->id; }
    function setDesc($desc) { $this->desc = $desc; }
    function getDesc() { return $this->desc; }
    function setType($type) { $this->type = $type; }
    function getType() { return $this->type; }
    function setRating($rating) { $this->rating = $rating; }
    function getRating() { return $this->rating; }
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
        $sql = "Select lat from $this->tableName";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}