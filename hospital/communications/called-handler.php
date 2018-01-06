<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
error_reporting(0);

//Get's the called's acception status of incoming call

$accepted_call = $_GET['accepted_call'];
$call_ext_hospital = $_SESSION['cuurent_call'];



//Get status of current call
$select = "SELECT status FROM call_ext_hospital WHERE call_ext_hospital_id = '$call_ext_hospital' ";
$query = mysqli_query($con,$select);
$status = mysqli_fetch_assoc($query);


//Shows that the incoming call was accepted or not by the user
if ($accepted_call == "1" ) {

	
		$update = "UPDATE call_ext_hospital SET call_accepted = 1 WHERE call_ext_hospital.call_ext_hospital_id = '$call_ext_hospital'";
		mysqli_query($con,$update);

		
		
	} elseif ($accepted_call == "0" ) {

		$update = "UPDATE `call_ext_hospital` SET `call_ended` = '0', `status` = '0' WHERE `call_ext_hospital`.`call_ext_hospital_id` = '$call_ext_hospital'";
		mysqli_query($con,$update);

		echo "<strong>CALL DECLINED</strong>";

	} 

if ($_GET['endcall_confirm'] == "true") {


	if ($status['status'] == "1"){
		
		$update = "UPDATE call_ext_hospital SET call_ended = 0,status = 0 WHERE call_ext_hospital.call_ext_hospital_id = '$call_ext_hospital'";
		mysqli_query($con,$update);

		echo "You ENDED the CALL!!";

	} elseif($status['status'] != "1") {

		echo "Caller ENDED the CALL!";
	} else { echo "NO ACTIVE CALLS TO END!";}
	
}

?>