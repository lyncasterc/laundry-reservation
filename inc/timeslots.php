<?php 
    date_default_timezone_set('America/New_York');
    require_once 'database.php';
    $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $current_weekday = date('l');
    $current_hour = date('Hi');

    // seeds the database with all of the timeslots
    function seed_timeslots(){
        $db = db_connect();

        foreach ($GLOBALS['weekdays'] as $weekday){
            for ($i = 0; $i < 24; $i += 3) { 
                $insert_sql = "INSERT INTO LaundryDatabase.Timeslots (start_hour, weekday)
                                VALUES ('$i:00', '$weekday')";

                if($db->query($insert_sql)){
                    echo "Successfully inserted $i:00 $weekday into Timeslots table.\n\n";
                } else {
                    echo "Error inserting $i:00 $weekday into Timeslots table.\n\n";
                }
                
            }
        }
        
        $db->close();
    }

    //get all of the timeslots from the database where apt_number is null and return them as an array
    function get_available_timeslots(){
        $db = db_connect();
        $sql = "SELECT * FROM LaundryDatabase.Timeslots WHERE apt_number IS NULL";
        $result = $db->query($sql);
        $timeslots = [];

        while($row = $result->fetch_assoc()){
            array_push($timeslots, $row);
        }

        $db->close();
        return $timeslots;
    }

    // reserve a timeslot using the start_hour and weekday of the timeslot
    function reserve_timeslot($start_hour, $weekday, $apt_number){
        $db = db_connect();
        $sql = "UPDATE LaundryDatabase.Timeslots 
                SET apt_number = '$apt_number' 
                WHERE start_hour = '$start_hour' 
                AND weekday = '$weekday'";

        $result = $db->query($sql);

        if($result){
            echo "Successfully reserved $start_hour $weekday for apt_number $apt_number.\n\n";
        } else {
            echo "Error reserving $start_hour $weekday for apt_number $apt_number.\n\n";
        }

        $db->close();
    }

    // returns true if apt_number has a timeslot reserved, false otherwise
    function check_for_reservation($apt_number){
        $db = db_connect();
        $sql = "SELECT * FROM LaundryDatabase.Timeslots WHERE apt_number = '$apt_number'";
        $result = $db->query($sql);

        if($result->num_rows > 0){
            $db->close();
            return true;
        } else {
            $db->close();
            return false;
        }
    }


    //returns total number of timeslots (should be 56)
    function get_num_timeslots(){
        $db = db_connect();
        $sql = "SELECT COUNT(*) FROM LaundryDatabase.Timeslots";
        $count = $db->query($sql)->fetch_assoc()['COUNT(*)'];
        $db->close();
    
        return $count;
    }

    // call seed_timeslots() if there are no timeslots in the database
    if (get_num_timeslots() == 0) {
        seed_timeslots();
    }

    // resetting apt_numbers to null if at Sunday at 00:00
    if ($current_weekday == 'Sunday' && $current_hour == '0000') {
        $db = db_connect();
        $sql = "UPDATE LaundryDatabase.Timeslots SET apt_number = NULL";
        $db->query($sql);
        $db->close();
    }
    
    
?>