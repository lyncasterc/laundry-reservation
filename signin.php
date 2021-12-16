<!DOCTYPE html>
<html lang="en">

<head>
    <?php session_start() ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <h1> WELCOME TO ABC <br> LAUNDRY ROOM <br> RESERVATION SYSTEM </h1>
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="login">
        <?php 
            if(isset($_SESSION['error'])){
                echo "<p class='error'>".$_SESSION['error']."</p>";
                unset($_SESSION['error']);
            }
        ?>

        <form action="./inc/session.php" method="post">

            <h2><label for="username">USERNAME</label><br>
                <input type="text" class="input-box" placeholder="username" id="username" name="username" required>
            </h2>

            <h2><label for="password">PASSWORD</label><br>
                <input type="password" class="input-box" placeholder="password" id="password" name="password" required>
            </h2>

            <input type="hidden" name="url" value="signin">

            <h2><button type="submit" name="submit">SIGN IN</button> </h2>

            <h2 class="or"> DON'T HAVE AN ACCOUNT? </h2>
            <h2><a href="register.php"> <button type="button" class="sign-up-botton"> SIGN UP </h2></a>
        </form>
    </div>

</body>

</html>