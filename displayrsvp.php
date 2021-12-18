<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once './inc/session.php';

    if (!logged_in()) {
        $_SESSION['unauth'] = "You must be logged in to view that page";
        header("Location: ./signin.php");
    } else if (!$reservation = get_reservation_info($_SESSION['session_apt'])) {
        $_SESSION['error'] = "You must reserve a time slot before viewing that page.";
        header("Location: ./index.php");
    }
    date_default_timezone_set('America/New_York');

    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Reservation</title>
    
    <link href="style.css" rel="stylesheet">
</head>

<body>
    
    <h1> Hello,
    
        <strong>
            <?php echo $_SESSION['session_user']; ?>
        </strong>
    
    </h1>

    <div class="login">
        <?php 
            if (isset($_SESSION['success'])){
                echo "<p class='success'>".$_SESSION['success']."</p>";
                unset($_SESSION['success']);
            }
        ?>

        <h2>

            YOU ALREADY HAVE AN <br> EXISTING RESERVATION <br> FOR THIS WEEK <br>
            <br>

            <?php
                echo $reservation['weekday'] . " at  " . date('g:i A', strtotime($reservation['start_hour'])) . " to " . date('g:i A', strtotime($reservation['start_hour'] . ' + 3 hours'));
            ?>

        </h2>

        <br>
        <h2>
            <form action="./inc/session.php" method="post">
                <input type="hidden" name="url" value="logout">
                <button type="submit" name="submit">Log out</button>
            </form>
        </h2>
    </div>

</body>

</html>