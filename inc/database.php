<?php 

    // connects and returns a MySQL connection object
    function db_connect(){
        // $servername = 'localhost:3306';
        // $username = 'root';
        // $password = 'root';
        $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $cleardb_server = $cleardb_url["host"];
        $cleardb_username = $cleardb_url["user"];
        $cleardb_password = $cleardb_url["pass"];
        $cleardb_db = substr($cleardb_url["path"], 1);
        $db = new mysqli($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
        
        if($db->connect_error){
            die('Connection failed: ') . $db->connect_error;
        }

        return $db;
    }
?>