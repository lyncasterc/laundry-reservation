<?php 
    require_once 'database.php';

    function create_user(){
        $db = db_connect();
        $input_username = $_POST['username'];
        $input_password = $_POST['password'];
        $apt_number = $_POST['apt_number'];

        $insert_sql = "INSERT INTO LaundryDatabase.Users (apt_number, username, password) 
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
                            FROM LaundryDatabase.Users 
                            WHERE LaundryDatabase.Users.username = '$username' 
                            AND LaundryDatabase.Users.password = '$password' ";

        // retrieves the user id 
        $result = $db->query($get_apt_number_sql)->fetch_assoc()['apt_number'];
        $db->close();
    
        return (empty($result)) ? false : $result;
    }
?>