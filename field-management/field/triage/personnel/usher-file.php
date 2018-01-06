<?php	
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
$userid = $_SESSION['userid'];
$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 


//Get's User Id to obtian the vehicleteam of the user
$select_userid = "SELECT `user_id` FROM `users` WHERE `users`.`username` = '$userid' ";

	$query_userid = mysqli_query($con,$select_userid);

	$user_id = mysqli_fetch_assoc($query_userid);

$select = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.user_id = '$user_id[user_id]'";

	$query = mysqli_query($con,$select);

	$employee = mysqli_fetch_assoc($query);

	$disaster_id = $_SESSION['disaster_id']; //From even field-management/ambulance/unit-lead/event-record-handler.php

$select1 = "SELECT * FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' AND `ics_structure`.`branch_id_FK` = '10' ORDER BY `ics_structure_id` ASC LIMIT 1";

	$query1 = mysqli_query($con,$select1);

	$ics_structure1 = mysqli_fetch_assoc($query1);

$select2 = "SELECT * FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' AND `ics_structure`.`branch_id_FK` = '10' ORDER BY `ics_structure_id` ASC LIMIT 1,1";

	$query2 = mysqli_query($con,$select2);

	$ics_structure2 = mysqli_fetch_assoc($query2);

$select3 = "SELECT * FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' AND `ics_structure`.`branch_id_FK` = '10' ORDER BY `ics_structure_id` ASC LIMIT 1,2";

	$query3 = mysqli_query($con,$select3);

	$ics_structure3 = mysqli_fetch_assoc($query3);

	//This sends the user to the appropriate triage-personnel directory

	if ($employee['employee_id'] == $ics_structure1['employee_id_FK']) {
		
		header("Location: http://$host/ems/field-management/field/triage/personnel/on-site/home-page.php");
		exit();

	} elseif ($employee['employee_id'] == $ics_structure2['employee_id_FK']) {
		
		header("Location: http://$host/ems/field-management/field/triage/personnel/medical/home-page.php");
		exit();

	} else {

		header("Location: http://$host/ems/field-management/field/triage/personnel/evacuation/home-page.php");
		exit();

	}

?>