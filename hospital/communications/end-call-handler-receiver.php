<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
//error_reporting();

//This is for the Receiever of a call to end the call
$endcall_confirm = $_GET['endcall_confirm'];

$call_ext_hospital_id = $_SESSION['cuurent_call'];

echo $call_ext_hospital_id;

$select = "SELECT * FROM call_ext_hospital WHERE call_ext_hospital_id = '$call_ext_hospital_id' ";

	$query = mysqli_query($con,$select);

	$active_call = mysqli_fetch_assoc($query);

if ($active_call['status'] == 0 && $active_call['call_ended'] == 1 ) {
		
		echo "Caller already TERMINATED the CALL!";

	} else {

			

		$update = "UPDATE `call_ext_hospital` SET `call_ended` = '0', `status` = '0' WHERE `call_ext_hospital`.`call_ext_hospital_id` = '$call_ext_hospital_id'";

			mysqli_query($con,$update);
	}	

	
?>