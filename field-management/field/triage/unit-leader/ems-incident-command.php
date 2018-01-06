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

	$on_site = $_POST['on_site']; 
	$medical_post = $_POST['medical_post'];
	$evacuation_triage = $_POST['evacuation_triage'];
	$disaster_id = $_SESSION['disaster_id']; //From even field-management/ambulance/unit-lead/event-record-handler.php

	echo $on_site.",".$medical_post.",".$evacuation_triage.",".$disaster_id;
	//These sessions are saved to use when employees log event data
	

$insert = "INSERT INTO `ics_structure` (`ics_structure_id`, `branch_id_FK`, `employee_id_FK`, `reports_to_id`, `date_created`, `updated`, `disaster_id`) 
			VALUES (NULL, '18', '$on_site','8', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$disaster_id')";

	mysqli_query($con,$insert);

$insert1 = "INSERT INTO `ics_structure` (`ics_structure_id`, `branch_id_FK`, `employee_id_FK`, `reports_to_id`, `date_created`, `updated`, `disaster_id`) 
			VALUES (NULL, '19', '$medical_post', '8', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$disaster_id')";

	mysqli_query($con,$insert1);

$insert2 = "INSERT INTO `ics_structure` (`ics_structure_id`, `branch_id_FK`, `employee_id_FK`, `reports_to_id`, `date_created`, `updated`, `disaster_id`) 
			VALUES (NULL, '20', '$evacuation_triage', '8', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$disaster_id')";

	$query = mysqli_query($con,$insert2);


if (mysqli_affected_rows($con) >= 1) {
	
	header("Location: http://$host/ems/field-management/field/triage/unit-leader/home-page");
	exit();

} else {

	echo "Sorry an ERROR occurred. Please Try again.";
	
}
	


?>