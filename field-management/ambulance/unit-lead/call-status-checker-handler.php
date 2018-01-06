<?php
session_start();
include_once('dbconnect.php');
//error_reporting();

$userid = $_SESSION['userid'];
//Get user ID
$select1 = "SELECT user_id FROM users WHERE username = '$userid' ";

	$query1 = mysqli_query($con,$select1);

	$user_id = mysqli_fetch_assoc($query1); 

//Determines the call being initiated
	$employee_tele = $_SESSION['employee_tele']; //From telephone-dispatch call-handler

//Determines origins of employee with the number stored in employee_tele
	$select_ = "(SELECT employees.employee_id, 'employees' AS type FROM employees WHERE employees.employee_tele = '$employee_tele')
			UNION 
			(SELECT hospital_employees.hospital_employees_id, 'hospital_employees' AS type FROM hospital_employees WHERE hospital_employees.tele = '$employee_tele')";

	$query_ = mysqli_query($con,$select_);

	$employee_type = mysqli_fetch_assoc($query_);

if ($employee_type['type'] == 'employees') {

			

	//Get's the lastest Call record by the User
$select2 = "SELECT * FROM call_ext WHERE call_ext.user_id = '$user_id[user_id]' ORDER BY call_ext.callext_id DESC LIMIT 1";

	$query2 = mysqli_query($con,$select2);

	$caller_record = mysqli_fetch_assoc($query2);

//Checks the status of the Call
if ($caller_record['status'] == 1 && $caller_record['call_accepted'] == 1 && empty($caller_record['call_ended']) ) {
		
		echo "Call still in progress...";

		echo "<br>"."To END CURRENT CALL PLEASE CLICK >>>>"."<button id = 'button' style = 'color:red' onclick = 'endCall();return false'>END CALL!</button>"."<<<<" ;
		//Use timers from php script into the database as a method to check if calls were ended pre-maturely

	} elseif ($caller_record['status'] == 0 && $caller_record['call_accepted'] == 0 && $caller_record['call_ended'] == 0) {
		
		echo "Receiver declined your call...";

		//$update_call = "UPDATE `call_ext_hospital` SET `status` = '0' WHERE `call_ext_hospital`.`call_ext_hospital_id` = '$caller_record[call_ext_hospital_id]' ";

		//mysqli_query($con,$update_call);

	} elseif ($caller_record['status'] == 0 && $caller_record['call_accepted'] == 1 && $caller_record['call_ended'] == 1) {
		
		echo "You TERMINATED the CALL!";

	} elseif ($caller_record['status'] == 0 && $caller_record['call_accepted'] == 1 && $caller_record['call_ended'] == 0) {
		
		echo "Receiver TERMINATED the CALL!";

	} elseif ($caller_record['status'] == 1 && empty($caller_record['call_accepted']) && empty($caller_record['call_ended']) && empty($caller_record['time_out'])) {
		
		echo "Waiting for Receiver to Accepting Call..."; echo "<br>";
		echo "Do you want to terminate this call?"."<button type='button' onclick = 'endCall();return false' style = 'color:red' >End Call !</button><br>";

	} elseif ($caller_record['status'] == 0 && $caller_record['call_accepted'] == 0 && $caller_record['call_ended'] == 1) {
		
		echo "You ENDED the CALL prematurely...";

		$update = "UPDATE `call_ext` SET `call_ended` = '1', `status` = '0' WHERE `call_ext`.`callext_id` = '$caller_record[callext_id]' ";

      	mysqli_query($con,$update);

	} elseif ( empty($caller_record['status'])  && empty($caller_record['call_accepted'])  && empty($caller_record['call_ended']) ) {
		
		echo "Waiting for CALL SESSION to connect...";

	} elseif ($caller_record['status'] == 1 && empty($caller_record['call_accepted']) && empty($caller_record['call_ended']) && $caller_record['time_out'] == 1) {
		
		echo "Sorry no connection was established";


	} else {

		echo "Something have seem to gone wrong...";

	}	

} else {

	//Hospital

	echo "Hospital";

	//Get's the lastest Call record by the User
$select2 = "SELECT * FROM call_ext_hospital WHERE call_ext_hospital.user_id = '$user_id[user_id]' ORDER BY call_ext_hospital.call_ext_hospital_id DESC LIMIT 1";

	$query2 = mysqli_query($con,$select2);

	$caller_record = mysqli_fetch_assoc($query2);

//Checks the status of the Call
if ($caller_record['status'] == 1 && $caller_record['call_accepted'] == 1 && empty($caller_record['call_ended']) ) {
		
		echo "Call still in progress...";

		echo "<br>"."To END CURRENT CALL PLEASE CLICK >>>>"."<button id = 'button' style = 'color:red' onclick = 'endCall()'>END CALL!</button>"."<<<<" ;
		//Use timers from php script into the database as a method to check if calls were ended pre-maturely

	} elseif ($caller_record['status'] == 0 && $caller_record['call_accepted'] == 0 && $caller_record['call_ended'] == 0) {
		
		echo "Receiver declined your call...";

		//$update_call = "UPDATE `call_ext_hospital` SET `status` = '0' WHERE `call_ext_hospital`.`call_ext_hospital_id` = '$caller_record[call_ext_hospital_id]' ";

		//mysqli_query($con,$update_call);

	} elseif ($caller_record['status'] == 0 && $caller_record['call_accepted'] == 1 && $caller_record['call_ended'] == 1) {
		
		echo "You TERMINATED the CALL!";

	} elseif ($caller_record['status'] == 0 && $caller_record['call_accepted'] == 1 && $caller_record['call_ended'] == 0) {
		
		echo "Receiver TERMINATED the CALL!";

	} elseif ($caller_record['status'] == 1 && empty($caller_record['call_accepted']) && empty($caller_record['call_ended']) && empty($caller_record['time_out'])) {
		
		echo "Waiting for Receiver to Accepting Call..."; echo "<br>";
		echo "Do you want to terminate this call?"."<button type='button' onclick = 'endCall()' style = 'color:red' >End Call !</button><br>";

	} elseif ($caller_record['status'] == 0 && $caller_record['call_accepted'] == 0 && $caller_record['call_ended'] == 1) {
		
		echo "You ENDED the CALL prematurely...";

		$update = "UPDATE `call_ext_hospital` SET `call_ended` = '1', `status` = '0' WHERE `call_ext_hospital`.`call_ext_hospital_id` = '$caller_record[call_ext_hospital_id]' ";

      	mysqli_query($con,$update);

	} elseif ( empty($caller_record['status'])  && empty($caller_record['call_accepted'])  && empty($caller_record['call_ended']) ) {
		
		echo "Waiting for CALL SESSION to connect...";

	} elseif ($caller_record['status'] == 1 && empty($caller_record['call_accepted']) && empty($caller_record['call_ended']) && $caller_record['time_out'] == 1) {
		
		echo "Sorry no connection was established";


	} else {

		echo "Something have seem to gone wrong...";

	}
}

	


?>