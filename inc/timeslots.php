<?php 
    date_default_timezone_set('America/New_York');
    require_once 'database.php';
    $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $current_weekday = date('l');
    $current_time = date('Hi');
    $current_hour = $current_time[0] . $current_time[1];

    // seeds the database with all of the timeslots
    function seed_timeslots(){
        $db = db_connect();

        foreach ($GLOBALS['weekdays'] as $weekday){
            for ($i = 0; $i < 24; $i += 3) { 
                $insert_sql = "INSERT INTO heroku_e691b3f32de1113.Timeslots (start_hour, weekday)
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
    function get_available_timeslots($weekday){
        $db = db_connect();
        $sql = "SELECT * FROM heroku_e691b3f32de1113.Timeslots WHERE apt_number IS NULL AND weekday = '$weekday'";
        $result = $db->query($sql);
        $timeslots = [];

        while($row = $result->fetch_assoc()){
            array_push($timeslots, $row);
        }

        // sort the timeslots by start_hour by converting them to date objects
        // and then sorting them by their start_hour
        usort($timeslots, function($a, $b){
            $a_date = new DateTime($a['start_hour']);
            $b_date = new DateTime($b['start_hour']);
            return $a_date <=> $b_date;
        });
        

        $db->close();
        return $timeslots;
    }

    // returns template html for a timeslot
    function print_available_timeslots($weekday){
        $available_timeslots = get_available_timeslots($weekday);
        
        foreach ($available_timeslots as $timeslot_arr) {
            $start_hour = date('g:i A', strtotime($timeslot_arr['start_hour']));
            $item = "<span data-hour='$timeslot_arr[start_hour]' class='timeslot'>
                        $start_hour 
                    </span>";

            $weekday_num = array_search($weekday, $GLOBALS['weekdays']);
            $current_weekday_num = array_search($GLOBALS['current_weekday'], $GLOBALS['weekdays']);

            if($current_weekday_num === $weekday_num){
                if(strtotime($GLOBALS['current_time']) <= strtotime($timeslot_arr['start_hour'])){
                    echo $item;
                }

            } else if ($current_weekday_num < $weekday_num){
                echo $item;
            }
        }
    }

    // reserve a timeslot using the start_hour and weekday of the timeslot
    function reserve_timeslot($start_hour, $weekday, $apt_number){
        $db = db_connect();
        $sql = "UPDATE heroku_e691b3f32de1113.Timeslots 
                SET apt_number = '$apt_number' 
                WHERE start_hour = '$start_hour' 
                AND weekday = '$weekday'";

        if(is_timeslot_reserved($start_hour, $weekday)){
            return false;
        } else {
            $db->query($sql);
            $db->close();
            return true;
        }
    }

    // get reservation info for a given apt_number
    function get_reservation_info($apt_number){
        $db = db_connect();
        $sql = "SELECT * FROM heroku_e691b3f32de1113.Timeslots WHERE apt_number = '$apt_number'";
        $result = $db->query($sql)->fetch_assoc();
        $db->close();

        return $result;
    }

    //checks if a timeslot already has a apt_number in it's row
    function is_timeslot_reserved($start_hour, $weekday){
        $db = db_connect();
        $sql = "SELECT * FROM heroku_e691b3f32de1113.Timeslots WHERE start_hour = '$start_hour' AND weekday = '$weekday'";
        $result = $db->query($sql)->fetch_assoc();
        $db->close();

        return !empty($result['apt_number']);
    }


    //returns total number of timeslots (should be 56)
    function get_num_timeslots(){
        $db = db_connect();
        $sql = "SELECT COUNT(*) FROM heroku_e691b3f32de1113.Timeslots";
        $count = $db->query($sql)->fetch_assoc()['COUNT(*)'];
        $db->close();
    
        return $count;
    }

    // call seed_timeslots() if there are no timeslots in the database
    if (get_num_timeslots() == 0) {
        seed_timeslots();
    }

    // resetting apt_numbers to null if at Sunday at 00:00
    if ($current_weekday == 'Sunday' && $current_time == '0000') {
        $db = db_connect();
        $sql = "UPDATE heroku_e691b3f32de1113.Timeslots SET apt_number = NULL";
        $db->query($sql);
        $db->close();
    }


    
?>

