<?php 
    require_once 'database.php';

    // insert a new user into the database if the username or apt number is not already taken and return that info as array, otherwise return false.
    function create_user(){
        $db = db_connect();
        $input_username = $_POST['username'];
        $input_password = $_POST['password'];
        $apt_number = $_POST['apt_number'];

        if(apt_number_exists($apt_number)){
            $_SESSION["error"] = "Account with apartment number $apt_number already exists.";
            return false;
        } else if(username_exists($input_username)){
            $_SESSION["error"] = "Username already exists! Try another username.";
            return false;
        }

        $insert_sql = "INSERT INTO heroku_e691b3f32de1113.Users (apt_number, username, password) 
                        VALUES ('$apt_number', '$input_username', '$input_password')";

        $db->query($insert_sql);
        $db->close();
        
        return array($input_username, $apt_number);
    }
    

    // retrieves user's apt_number using the user's username and password
    // or returns false if user does not exist.
    function get_apt_number($username, $password){
        $db = db_connect();
        $get_apt_number_sql = "SELECT *
                            FROM heroku_e691b3f32de1113.Users 
                            WHERE heroku_e691b3f32de1113.Users.username = '$username' 
                            AND heroku_e691b3f32de1113.Users.password = '$password' ";

        $result = $db->query($get_apt_number_sql)->fetch_assoc()['apt_number'];
        $db->close();
    
        return (empty($result)) ? false : $result;
    }

    // returns true if apt_number exists, false otherwise
    function apt_number_exists($apt_number){
        $db = db_connect();
        $apt_number_exists_sql = "SELECT *
                            FROM heroku_e691b3f32de1113.Users 
                            WHERE heroku_e691b3f32de1113.Users.apt_number = '$apt_number' ";

        $result = $db->query($apt_number_exists_sql)->fetch_assoc()['apt_number'];
        $db->close();
    
        return !empty($result);
    }

    // returns true if username exists, false otherwise
    function username_exists($username){
        $db = db_connect();
        $username_exists_sql = "SELECT *
                            FROM heroku_e691b3f32de1113.Users 
                            WHERE heroku_e691b3f32de1113.Users.username = '$username' ";

        // retrieves the user id 
        $result = $db->query($username_exists_sql)->fetch_assoc()['username'];
        $db->close();
    
        return (empty($result)) ? false : true;
    }

?>