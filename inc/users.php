<?php 

    function create_user(){
    
        $servername = 'localhost:3306';
        $username = 'root';
        $password = 'Treehugger106';
        $conn = new mysqli($servername, $username, $password);
        if($conn->connect_error){
            die('Connection failed: ') . $conn->connect_error;
        }

        $input_username = $_POST['username'];
        $input_password = $_POST['password'];

        $insert_sql = "INSERT INTO LaundryDatabase.Users (username, password) 
                        VALUES ('$input_username', '$input_password')";


        if ($conn->query($insert_sql)) {
            echo 'Record inserted';
            $get_user_id_sql = "SELECT *
                                FROM LaundryDatabase.Users 
                                WHERE LaundryDatabase.Users.username = '$input_username' 
                                AND LaundryDatabase.Users.password = '$input_password' ";

            // retrieves the user id 
            $user_id_result = $conn->query($get_user_id_sql)->fetch_assoc()['user_id'];
    
            return $user_id_result;
        
        } 
        
    }
?>