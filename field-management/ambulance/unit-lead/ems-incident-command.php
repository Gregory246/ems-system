<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
error_reporting(0);
$userid = $_SESSION['userid'];
$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 

//Get's User Id to obtian the vehicleteam of the user
$select_userid = "SELECT `user_id` FROM `users` WHERE `users`.`username` = '$userid' ";

	$query_userid = mysqli_query($con,$select_userid);

	$user_id = mysqli_fetch_assoc($query_userid);


//Get the POST from the submitted Command system 

	$incident_command = $_POST['incident_command']; 
	$triage_personnel = $_POST['triage_personnel'];
	$medical_communications_coordinator = $_POST['medical_communications_coordinator'];
	$arrival = $_POST['arrival'];
	$disaster_id = $_SESSION['disaster_id']; //From even field-management/ambulance/unit-lead/event-record-handler.php

	echo $incident_command.",".$triage_personnel.",".$medical_communications_coordinator.",".$disaster_id;
	//These sessions are saved to use when employees log event data
	$_SESSION['ems_IC'] = $incident_command;
	$_SESSION['ems_triage'] = $triage_personnel;
	$_SESSION['ems_mcc'] = $medical_communications_coordinator;

$update = "UPDATE `ems_response` SET `arrived` = '$arrival' WHERE `ems_response`.`disaster_id` = '$disaster_id'";

	mysqli_query($con,$update);


$insert = "INSERT INTO `ics_structure` (`ics_structure_id`, `branch_id_FK`, `employee_id_FK`, `reports_to_id`, `date_created`, `updated`, `disaster_id`) 
			VALUES (NULL, '1', '$incident_command', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$disaster_id')";

	mysqli_query($con,$insert);

$insert1 = "INSERT INTO `ics_structure` (`ics_structure_id`, `branch_id_FK`, `employee_id_FK`, `reports_to_id`, `date_created`, `updated`, `disaster_id`) 
			VALUES (NULL, '10', '$triage_personnel', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$disaster_id')";

	mysqli_query($con,$insert1);

$insert2 = "INSERT INTO `ics_structure` (`ics_structure_id`, `branch_id_FK`, `employee_id_FK`, `reports_to_id`, `date_created`, `updated`, `disaster_id`) 
			VALUES (NULL, '16', '$medical_communications_coordinator', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$disaster_id')";

	$query = mysqli_query($con,$insert2);


if (mysqli_affected_rows($con) >= 1) {
	
	header("Location: http://$host/ems/field-management/field/usher-file.php");
	exit();

} else {

	echo "Sorry an ERROR occurred. Please Try again.";
	
}
	


?>