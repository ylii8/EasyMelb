<?php

class DbConnect
{
    private $host = '127.0.0.1';
    private $dbName = 'light';
    private $user = 'root';
    private $pass = 'root';

    public function connect()
    {
        try {
            $conn = new PDO('mysql:host=' . $this->host . '; dbname' . $this->dbName,
                $this->user, $this->pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            echo "Connected";
            return $conn;
        } catch (PDOException $e) {
            echo 'Database Error: ' . $e->getMessage();
        }


    }
}

?>