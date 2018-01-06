<?php 
session_start();
include_once('dbconnect.php');
error_reporting(0);

//Get's the called's acception status of incoming call

$accepted_call = $_GET['accepted_call'];
$call_ext = $_SESSION['cuurent_call']; 

echo $callext_id."session works";

//Get status of current call
$select = "SELECT status FROM call_ext WHERE callext_id = '$callext_id' ";
$query = mysqli_query($con,$select);
$status = mysqli_fetch_assoc($query); 



//Shows that the incoming call was accepted or not by the user
if ($accepted_call == "1" ) {

	
		$update = "UPDATE `call_ext` SET `call_accepted` = '1' WHERE `call_ext`.`callext_id` = '$call_ext'";
		mysqli_query($con,$update);

		
		
	} elseif ($accepted_call == "0" ) {

		$update = "UPDATE `call_ext` SET `call_ended` = '0', `status` = '0', `call_accepted` = '0'  WHERE `call_ext`.`callext_id` = '$call_ext'";
		mysqli_query($con,$update);

		echo "<strong>CALL DECLINED</strong>";

	} 

if ($_GET['endcall_confirm'] == "true") {


	if ($status['status'] == "1"){
		
		$update = "UPDATE `call_ext` SET `call_ended` = '0' , `status` = '0' WHERE `call_ext`.`callext_id` = '$call_ext'";
		mysqli_query($con,$update);

		echo "You ENDED the CALL!!";

	} elseif($status['status'] != "1") {

		echo "Caller ENDED the CALL!";
	}
	
}

?>