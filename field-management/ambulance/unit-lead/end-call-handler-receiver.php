<?php
session_start();
include_once('dbconnect.php');
//error_reporting();

//This is for the Receiever of a call to end the call
$endcall_confirm = $_GET['endcall_confirm'];

$callext_id = $_SESSION['cuurent_call'];


$select = "SELECT * FROM `call_ext` WHERE `call_ext`.`callext_id` = '$callext_id' ";

	$query = mysqli_query($con,$select);

	$active_call = mysqli_fetch_assoc($query);

if ($active_call['status'] == 0 && $active_call['call_ended'] == 1 ) {
		
		echo "Caller already TERMINATED the CALL!";

	} else {

		$update = "UPDATE `call_ext` SET `call_ended` = '0', `status` = '0' WHERE `call_ext`.`callext_id` = '$callext_id'";

			mysqli_query($con,$update);

			echo "You TERMINATED the CALL!";
	}	

	
?>