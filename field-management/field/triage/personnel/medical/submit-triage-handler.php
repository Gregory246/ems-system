<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
//$userid = $_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = 'jess'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);

$victim_unique_key_id = $_GET['victim_unique_key_id'];

$select5 = "SELECT * FROM victim WHERE victim.victim_unique_key_id = '$victim_unique_key_id'";

	$query5 = mysqli_query($con,$select5);

	$victim = mysqli_fetch_assoc($query5);


if ($_GET['set'] == "injury") {

$type = $_GET['type'];
$severity = $_GET['severity'];
$noi = $_GET['noi'];
$aob = $_GET['aob'];

	
	$insert = "INSERT INTO `injuries` (`injuries_id`, `type`, `severity`, `natureofinjury`, `areaofbody`, `victimid`, `employee_id`, `date_created`, `last_updated`) 
		   VALUES (NULL, '$type', '$severity', '$noi', '$aob', '$victim[victimid]', '$employee[employee_id]', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

	   mysqli_query($con,$insert);

} elseif ($_GET['set'] == "triage") {
	
$classification = $_GET['classification']; 
$walk = $_GET['walk'];
$breathe = $_GET['breathe'];
$airway = $_GET['airway'];
$resp = $_GET['resp'];
$pref = $_GET['pref'];
$mental = $_GET['mental'];


	$insert1 = "INSERT INTO `start_triage` (`start_triage_id`, `walk`, `breathing`, `position_airway`, `respiratory_rate`, `perfusion`, `mental_status`, `date_time`, `employee_id`) 
			VALUES (NULL, '$walk', '$breathe', '$airway', '$resp', '$pref', '$mental', CURRENT_TIMESTAMP, '$employee[employee_id]')";

		mysqli_query($con,$insert1);

	$select6 = "SELECT * FROM `start_triage` WHERE `start_triage`.`employee_id` = '$employee[employee_id]' ORDER BY `start_triage`.`start_triage_id` DESC LIMIT 1";

		$query6 = mysqli_query($con,$select6);

		$start_triage = mysqli_fetch_assoc($query6);

	$update = "UPDATE `victim` SET `medical_triage_tag` = '$classification', `start_triage_id` = '$start_triage[start_triage_id]' WHERE `victim`.`victimid` = '$victim[victimid]'"; 

		mysqli_query($con,$update);

		echo "hello";
}

?>