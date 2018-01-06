<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 

$victim_unique_key_id = $_POST['victim_unique_key'];
$employee_id = $_POST['employee_id'];

$update = "UPDATE `victim` SET `treatment_personnel` = '$employee_id' WHERE `victim`.`victim_unique_key_id` = '$victim_unique_key_id'";

	mysqli_query($con,$update);

	if (mysqli_affected_rows($con) > 0 ) {
		
		header("Location: http://$host/ems/field-management/field/treatment/minor/assign-teams.php");
		exit(); 

	} else {

		echo "Sorry record not updated!";
	}



?>