<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        require_once './inc/session.php';
        require_once './inc/timeslots.php';
        check_session();
        date_default_timezone_set('America/New_York');
        echo 'Monday' < 'Friday';
        
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Time Slots</title>
</head>
<body>
    <form action="./inc/session.php" method="post">
        <input type="hidden" name="url" value="logout">
        <button type="submit" name="submit">Log out</button>
    </form>

    <h2> Hello, <?php echo $_SESSION['session_user']; ?> </h2>
    <h3> Your current time is: <?php echo date('h:i A'); ?> </h3>
    <h3> Your current date is: <?php echo date('l, m/d/Y'); ?> </h3>


    <form action="confirmation.php" method="get" >
        
        <div id="timeslots-table">
            
            <ul id="monday-col" class="table-col">
                <h2>monday</h2>
                <?php print_available_timeslots('Monday'); ;?>
            </ul>

            <ul id="tuesday-col" class="table-col">
                <h2>tuesday</h2>
                <?php print_available_timeslots('Tuesday'); ?>
            </ul>
        

            <ul id="wednesday-col" class="table-col">
                <h2>wednesday</h2>
                <?php print_available_timeslots('Wednesday'); ?>
            </ul>
            
            
            <ul id="thursday-col" class="table-col">
                <h2>thursday</h2>
                <?php print_available_timeslots('Thursday'); ?>
            </ul>
            
            
            <ul id="friday-col" class="table-col">
                <h2>friday</h2>
                <?php print_available_timeslots('Friday'); ?>
            </ul>


            <ul id="saturday-col" class="table-col">
                <h2>saturday</h2>
                <?php print_available_timeslots('Saturday'); ?>
            </ul>
            
            <ul id="sunday-col" class="table-col">
                <h2>sunday</h2>
                <?php print_available_timeslots('Sunday'); ?>
            </ul>
            
        </div>
            
    <button type="submit" name="submit">Continue</button>
</form>

</body>
</html>