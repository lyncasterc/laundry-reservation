<?php 
    require_once 'database.php';

    function create_user(){
        $db = db_connect();
        $input_username = $_POST['username'];
        $input_password = $_POST['password'];

        $insert_sql = "INSERT INTO LaundryDatabase.Users (username, password) 
                        VALUES ('$input_username', '$input_password')";

        $db->query($insert_sql);
        $db->close();
        $user_id = get_user_id($input_username ,$input_password);

        return $user_id;        
    }
    

    // retrieves user_id from the user's username and password
    // or returns false if user does not exist.
    function get_user_id($username, $password){
        $db = db_connect();
        $get_user_id_sql = "SELECT *
                            FROM LaundryDatabase.Users 
                            WHERE LaundryDatabase.Users.username = '$username' 
                            AND LaundryDatabase.Users.password = '$password' ";

        // retrieves the user id 
        $user_id_result = $db->query($get_user_id_sql)->fetch_assoc()['user_id'];
        $db->close();
    
        return (empty($user_id_result)) ? false : $user_id_result;
    }
?>