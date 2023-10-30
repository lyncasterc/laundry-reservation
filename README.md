# laundry-reservation
A mock laundry reservation system for an apartment complex.

This project was completed as part of a college software development course. 
The purpose of this project was to test us on our ability to work with a group, 
design a system using SDLC concepts, and actually create a functional piece of software using the skills we have learned throughout the course including PHP, MySQL, HTML, CSS and JS.

The concept of the project is to design a system and create an application for an apartment complex of 25 tenants who have to share one laundry room, that allows tenants to reserve a 3-hour time slot.
Each tenant can only reserve one timeslot per week, and can not change their timeslot once they have reserved one.

## File Structure
- `/inc` contains all the PHP code.
  - `database.php` contains code to connect and return the `MySQL` connection object.
  - `session.php` contains code for handling sessions (signing in, registering, etc), as well as an "action router".
  - `timeslots.php` contains all the code for checking the database for avialable timeslots, reserving timeslots, etc.
  - `users.php` contains all the code for handling operations relating to users such as creating a new user, checking if a username exists, etc.
- `/js` contains `main.js` which contains code to aid in rendering some UI elements in `index.php`
## Registering/Signing in
- Both `register.php` and use  `signn.php` use a form submitting a `POST` request containing a hidden input named url: `<input type="hidden" name="url" value="signin">`
- `session.php` contains the snippet below, which is routing those form submissions to the appropriate "action" based on the hidden input
    ```php
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
    ```
  - In the case of signing in, we check the database for a user that has the provided password, and if such a user exists, we return the user's apartment number.
    ```php
    function get_apt_number($username, $password){
            $db = db_connect();
            $get_apt_number_sql = "SELECT *
                                FROM heroku_e691b3f32de1113.Users 
                                WHERE heroku_e691b3f32de1113.Users.username = '$username' 
                                AND heroku_e691b3f32de1113.Users.password = '$password' ";
    
            $result = $db->query($get_apt_number_sql)->fetch_assoc()['apt_number'];
            $db->close();
        
            return (empty($result)) ? false : $result;
        }
    ```
    -  One important thing to note -- my knowledge of secure coding practices were not lacking during the development of this project. Therefore:
        - This entire project is susecpible to SQL injections because of the lack of prepared statements, such as the example above.
        - **The example above has a couple serious security issues**.
          - Passwords are stored in plaintext. They should be hashed with a cryptograpic hash function
          - Plaintexts passwords being directly compared with each other instead of the hash of the provided password being compared with a stored hash.
         




## Displaying a reserved timeslot
- Once a user is logged in, they are redirected to the home page, `index.php`, which has the below snippet, checking if they already have a reserved timeslot:
	```php
	if(!logged_in()){
	            ...
	        } else if(get_reservation_info($_SESSION['session_apt'])) {
	            header("Location: ./displayrsvp.php");
	        }
	```
	- `get_reservation_info()` is querying the database for a timeslot with the currently logged in user's apartment number.
	- If they do have a timeslot, they are redirected to `displayrsvp.php` which displays their reserved timeslot.

## Reserving new timeslot
- `index.php` contains a table, listing out all the available timeslots for each day of the week. Here is one example:
	```php
	<tr>
	
		<td class="row"> MONDAY
			<div data-weekday="Monday" class="timeslots-container">
				<?php print_available_timeslots('Monday'); ?>
			</div>
		</td>

	</tr>
	```
	- `print_available_timeslots()` gets all the timeslots for a specific day of the week, then prints each available hour for that weekday:
		- Monday -> 3AM, 6AM, 9AM, ...
- a user can then select the weekday they want in a dropdown:
	```php
	<form action="./inc/session.php" method="post" id="reserve">
		<h3>SELECT DAY OF THE WEEK</h3>
		<select name="weekday-input" id="weekday-input" class="rsvp" >
		</select>

		<h3>SELECT TIME SLOT</h3>
		<select name="hour-input" id="hour-input" class="rsvp" >
		</select>
		<br>

		<input type="hidden" name="url" value="reserve">

		<h2><button id="reserve-btn" name="submit">RESERVE</button> </h2>
	</form>
	```
	- in `main.js`, I have some code that is going through all the `.timeslots-container`, and populates the weekday dropdown. Only weekdays with available timeslots are added as an option in the dropdown.
		```js
		...
		const timeslotRows = document.querySelectorAll('.timeslots-container');
		
		// renders options for weekday select for weekdays that have at least one timeslot
		timeslotRows.forEach(row => {
		    if(row.children.length > 0) {
		        const option = document.createElement('option');
		        option.value = row.dataset.weekday;
		        option.textContent = row.dataset.weekday;
		        weekdaySelect.appendChild(option);
		    }
		});
		```
- once they select the weekday, an event listener in `main.js` fires, which now populates the hours dropdown with all the available hours for that selected weekday:
	```js
	const renderHourOptions = (weekday) => {
	    const WeekdayRow = document.querySelector(`[data-weekday="${weekday}"]`);
	
	    Array.from(WeekdayRow.children).forEach(child => {
	        const option = document.createElement('option');
	        option.value = child.dataset.hour;
	        option.textContent = child.textContent;
	        hourSelect.appendChild(option);
	    });
	}
		```
- when the form is submitted, the `reserve()` function in `session.php` is called, which updates the timeslot's apartment, after first checking that the timeslot is not already reserved.
	```php
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


	// timeslots.php

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
	```
	
