<?php 
    session_start();
    require_once 'users.php';
    require_once 'timeslots.php';


    // returns true if user is logged in, false otherwise
    function logged_in(){
        return isset($_SESSION["session_user"]); 
    }

    function set_session_user($username, $apt_number){
        $_SESSION["session_user"] = $username;
        $_SESSION["session_apt"] = $apt_number;
    }

    function register(){
        $user_info = create_user();
        if($user_info){
            set_session_user($user_info["username"], $user_info["apt_number"]);
            header("Location: ../index.php");
        } else {
            header("Location: ../register.php");

        }
    }

    function signin(){
        $input_username = $_POST['username'];
        $input_password = $_POST['password'];
        $apt_number = get_apt_number($input_username, $input_password);

        if($apt_number){
            set_session_user($input_username, $apt_number);
            header("Location: ../index.php");
        } else {
            $_SESSION["error"] = "Invalid username or password.";
            header("Location: ../signin.php");
        }
    }

    function logout(){
        session_unset();
        session_destroy();
        header("Location: ../signin.php");
    }

    function reserve(){
        $start_hour = $_POST['hour-input'];
        $weekday = $_POST['weekday-input'];
        $apt_number = $_SESSION['session_apt'];

        if(reserve_timeslot($start_hour, $weekday, $apt_number)){
            $_SESSION['success'] = "Time slot reserved.";
            header("Location: ../displayrsvp.php");
        } else {
            $_SESSION['error'] = "Time slot already reserved. Please select another time slot.";
            header("Location: ../index.php");
        }

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
        } else if($url === 'reserve'){
            reserve();
        }
    }

?>
