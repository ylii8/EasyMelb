<?php

$servername = "localhost;3306";
$database = "light";
$username = "root";
$password = "root";
$charset = "utf8mb4";

try {

    $dsn = "mysql:host=$servername;dbname=$database;charset=$charset";
    $pdo = new PDO($dsn, $username, $password );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection Okay";

    return $pdo;

}
catch (PDOException $e)
{
    echo "Connection failed: ". $e->getMessage();
}

?>