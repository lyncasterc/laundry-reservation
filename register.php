<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
        require_once './inc/session.php';
        if(logged_in()){
            header("Location: ./index.php");
        } 
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <h1>REGISTRATION FORM</h1>
    <div class="login">
        <?php 
            if(isset($_SESSION['error'])){
                echo "<p class='error'>".$_SESSION['error']."</p>";
                unset($_SESSION['error']);
            }
        ?>

        <form action="./inc/session.php" method="post">

            <h2><label for="username">USERNAME</label> <br>
                <input type="text" class="input-box" placeholder="username" id="username" name="username" required>
            </h2>

            <h2><label for="aptnumber">APARTMENT NUMBER</label><br>
                <input type="text" class="input-box" placeholder="apt #" id="apt_number" name="apt_number" required>
            </h2>

            <h2><label for="password">PASSWORD</label><br>
                <input type="password" class="input-box" placeholder="password" id="password" name="password" required>
            </h2><br>

            <input type="hidden" name="url" value="register">

            <button type="submit" name="submit">SIGN UP</button> <br>

            <br><a href="signin.php"> Already have an account? Sign in </a>
        </form>
    </div>
</body>

</html>