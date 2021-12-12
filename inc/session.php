<?php 
    require_once 'users.php';
    session_start();

    // redirects a user to signin.html if a session is not set.
    function check_session(){
        if(empty($_SESSION["session_user"])){
            header("Location: signin.html");
        } 
    }

    function set_session_user($username, $apt_number){
        $_SESSION["session_user"] = $username;
        $_SESSION["session_apt"] = $apt_number;
    }

    function register(){
        // todo: handle duplicate apt_number error
        $user_info = create_user();
        set_session_user($user_info["username"], $user_info["apt_number"]);
        header("Location: ../index.php");
    }

    function signin(){
        $input_username = $_POST['username'];
        $input_password = $_POST['password'];
        $apt_number = get_apt_number($input_username, $input_password);

        if($apt_number){
            set_session_user($input_username, $apt_number);
            header("Location: ../index.php");
        } else {
            echo "USER DOES NOT EXIST";
            //todo: figure out how to flash an error
        }
    }

    function logout(){
        session_unset();
        session_destroy();
        header("Location: ../index.php");
    }

    //URL Router
    if(isset($_POST['submit'])){
        $url = $_POST['url'];

        if($url === 'register'){
            register();
        } else if ($url === 'signin'){
            signin();
        } else if($url === 'logout'){
            logout();
        }
        
    }


?>
