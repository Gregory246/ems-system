<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
$userid = $_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = '$userid'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);

$victim_unique_key_id = $_GET['victim_unique_key_id'];

$select5 = "SELECT * FROM victim WHERE victim.victim_unique_key_id = '$victim_unique_key_id'"; 

	$query5 = mysqli_query($con,$select5);

	$victim = mysqli_fetch_assoc($query5);


if ($_GET['set'] == "injury") {



} elseif ($_GET['set'] == "triage") {
	
$classification = $_GET['classification']; 


	$update = "UPDATE `victim` SET `evacuation_triage_tag` = '$classification', `evacuation_triage_personnel` = '$employee[employee_id]'  WHERE `victim`.`victimid` = '$victim[victimid]'"; 

		mysqli_query($con,$update);

		echo "hello";
}

?>