<!DOCTYPE html>
<html lang="en">
<head>
<?php 
        require_once './inc/session.php';
        require_once './inc/timeslots.php';
        check_session();
        date_default_timezone_set('America/New_York');
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display</title>
    <h1> SCHEDULE FOR THIS WEEK </h1>
    <link href="style.css" rel="stylesheet">
</head>
<body>
  <form action="./inc/session.php" method="post" id="logout-form">
      <input type="hidden" name="url" value="logout">
      <button type="submit" name="submit">Log out</button>
  </form>

  <div class="table">

<table style="width: 100%;" border = "1" cellpadding = "5">
	<tbody>
    <tr height="5px">
      <td><h3>DAY OF THE WEEK</h3><th><h3>AVAILABLE TIME SLOTS</h3>
    </td>
		<tr>
    
			<td class="row"> MONDAY<th>

        <div class="timeslots-container">
          <?php print_available_timeslots('Monday'); ?>
        </div>

      </td>
      
		</tr>
		<tr>
			<td class="row">TUESDAY<th>

        <div class="timeslots-container">
          <?php print_available_timeslots('Tuesday'); ?>
        </div>

      </td>
		</tr>
		<tr>
			<td class="row">WEDNESDAY<th> 

      <div class="timeslots-container">
          <?php print_available_timeslots('Wednesday'); ?>
      </div>

      </td>
		</tr>
		<tr>
			<td class="row">THURDAY<th>

      <div class="timeslots-container">
          <?php print_available_timeslots('Thursday'); ?>
      </div>
        
      </td>
		</tr>
		<tr>
			<td class="row">FRIDAY<th> 

      <div class="timeslots-container">
          <?php print_available_timeslots('Friday'); ?>
      </div>

      </td>
		</tr>
		<tr>
			<td class="row">SATURDAY<th> 

      <div class="timeslots-container">
          <?php print_available_timeslots('Saturday'); ?>
      </div>

      </td>
		</tr>
		<tr>
			<td class="row">SUNDAY<th> 

      <div class="timeslots-container">
          <?php print_available_timeslots('Sunday'); ?>
      </div>

      </td>
		</tr>
	</tbody>
</table><br>

<form action="./inc/session.php" method="post" id="reserve">
  <h3>SELECT DAY OF THE WEEK</h3>
  <select name="weekday-input" id="weekday-input" class="rsvp" style="font-family : Sentil; font-weight: bold; font-size: 16px; color: blue; background-color: rgb(94, 196, 255); text-align:  center; height: 25px; border-radius: 9px; box-shadow: 2px 2px blue" >
    
    <option value="1"> MONDAY </option>
    <option value="2">TUESDAY</option>
    <option value="3">WEDNESDAY</option>
    <option value="4">THURSDAY</option>
    <option value="5">FRIDAY</option>
    <option value="6">SATURDAY</option>
    <option value="7">SUNDAY</option>
  </select>

    <h3>SELECT TIME SLOT</h3>
  <select name="hour-input" id="hour-input" class="rsvp" style="font-family : Sentil; font-weight: bold; font-size: 16px; color: blue; background-color: rgb(94, 196, 255); text-align:  center; height: 25px; border-radius: 9px; box-shadow: 2px 2px blue">
    <option value="1"> 6am</option>
    <option value="2">9am</option>
    <option value="3">12pm</option>
    <option value="4">3pm</option>
    <option value="5">6pm</option>
    <option value="6">9pm</option>
    <option value="7">12am</option>
    <option value="8">3am</option>
  </select>
  <br><h2><button type="submit" name="submit">RESERVE</button> </h2>
</div>

</body>
</html>
