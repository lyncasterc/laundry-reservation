<?php 
    require_once 'users.php';
    session_start();

    // redirects a user to signin.html if a session is not set.
    function check_session(){
        if(empty($_SESSION["session_user"])){
            header("Location: signin.html");
        } 
    }

    function set_session_user($user_id){
        $_SESSION["session_user"] = $user_id;
    }

    function register(){
        $user_id = create_user();
        set_session_user($user_id);
        header("Location: ../index.php");
    }

    //URL Router
    if(isset($_POST['submit'])){
        $url = $_POST['url'];

        if($url === 'register'){
            register();
        }
        
    }


?>
