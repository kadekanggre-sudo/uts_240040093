<?php

class Database {

    protected $conn;

    public function __construct(){
        $this->connect();
    }

    protected function connect(){

        $host = "localhost";
        $user = "root";
        $pass = "";
        $db   = "inventaris_toko";

        $this->conn = new mysqli($host,$user,$pass,$db);

        if($this->conn->connect_error){
            die("Koneksi Error : " . $this->conn->connect_error);
        }
    }
}

?>