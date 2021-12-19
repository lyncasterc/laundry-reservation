<?php 

    // connects and returns a MySQL connection object
    function db_connect(){
        $servername = 'localhost:3306';
        $username = 'root';
        $password = 'root';
        $db = new mysqli($servername, $username, $password);
        if($db->connect_error){
            die('Connection failed: ') . $db->connect_error;
        }

        return $db;
    }
?>