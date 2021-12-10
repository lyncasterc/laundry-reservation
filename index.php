<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require_once './inc/session.php';
        check_session();
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Slots</title>
</head>
<body>
    <form action="./inc/session.php" method="post">
        <input type="hidden" name="url" value="logout">
        <button type="submit" name="submit">Log out</button>
    </form>
</body>
</html>