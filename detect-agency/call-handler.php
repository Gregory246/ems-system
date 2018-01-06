<?php 
session_start();
include_once('dbconnect.php');
error_reporting(0);

//Get the current user
$userid = $_SESSION['userid'];


if ($_GET['bool'] == "true") {

	$select = "SELECT user_id FROM users WHERE username = '$userid' ";
	$query = mysqli_query($con,$select);
	$user_id = mysqli_fetch_assoc($query);

	//This logs the time and date and the caller of the call. a status of 1 is selected for active calls and zero for not active
	$insert_call = "INSERT INTO call_ext (callext_id,status,device,user_id) VALUES (NULL,1,'PHONE','$user_id[user_id]')";
	mysqli_query($con,$insert_call);

	//Gets request type for the caller to enter into the system
	$select2 = "SELECT request_type.type FROM request_type WHERE request_type.request_type_id = 22 OR request_type.request_type_id = 24";
	$query1 = mysqli_query($con,$select2);
	$request = mysqli_fetch_assoc($query1);

	//This determines the agency of user who is initiating the call
	$select3 = "SELECT agency.agency_name,department.department_name, IFNULL(department.department_fax,'~')department_fax,
				employees.employee_fname,employees.employee_lname, employees.user_id
				FROM employees_department_junc JOIN department ON employees_department_junc.department_FK_id = department.department_id 
				JOIN employees ON employees_department_junc.employee_FK_id = employees.employee_id 
				JOIN agency ON department.agency_id = agency.agency_id WHERE employees.user_id = '$user_id[user_id]'";

	$query2 = mysqli_query($con,$select3);
	$user_agency = mysqli_fetch_assoc($query2);

	$select6 = "SELECT employee_id FROM employees WHERE employees.user_id = '$user_id[user_id]'";

	$employee_tele = $_GET['calls'];

	$select7 = "SELECT employee_id FROM employees WHERE employees.employee_tele = '$employee_tele' ";

	$select8 = "SELECT callext_id FROM call_ext WHERE call_ext.user_id = '$user_id[user_id]' ORDER BY call_ext.callext_id DESC LIMIT 1";

	$query6 = mysqli_query($con,$select6);

	$query7 = mysqli_query($con,$select7);

	$query8 = mysqli_query($con,$select8);

	$caller = mysqli_fetch_assoc($query6);

	$receiver = mysqli_fetch_assoc($query7);

	$callext_id = mysqli_fetch_assoc($query8);

	//echo $caller['employee_id'].$receiver['employee_id'].$callext_id['callext_id'];
	
	$insert = "INSERT INTO employees_call_ext_junc (employees_call_ext_junc_id,caller,receiver,call_ext,call_ext_ics)
				VALUES (NULL,'$caller[employee_id]','$receiver[employee_id]','$callext_id[callext_id]',NULL) ";

	mysqli_query($con,$insert);

	
} elseif ($_GET['bool'] == "false") {

	$select = "SELECT user_id FROM users WHERE username = '$userid' ";
	$query = mysqli_query($con,$select);
	$user_id = mysqli_fetch_assoc($query);

	$select = "SELECT * FROM call_ext WHERE call_ext.user_id = '$user_id[user_id]' ORDER BY call_ext.callext_id DESC LIMIT 1";
	$query = mysqli_query($con,$select);
	$status = mysqli_fetch_assoc($query);

	if( empty($status['call_ended']) && $status['status'] == "1"){


	$select = "SELECT user_id FROM users WHERE username = '$userid' ";
	$query = mysqli_query($con,$select);
	$user_id = mysqli_fetch_assoc($query);
	
	$select1 = "UPDATE call_ext SET call_ended = 1, status = 0 WHERE call_ext.user_id = '$user_id[user_id]' ORDER BY call_ext.callext_id DESC LIMIT 1";
	mysqli_query($con,$select1);

	echo "CALL ENDED!";

} else{ echo "Receiver has already ENDED the CALL!";}

}
//---------------------------------------------------
if ($_GET['checkstatus'] == "1") {

	//echo "This CheckStatus works!!";
	$select = "SELECT user_id FROM users WHERE username = '$userid' ";
	$query = mysqli_query($con,$select);
	$user_id = mysqli_fetch_assoc($query);

	$select = "SELECT * FROM call_ext WHERE call_ext.user_id = '$user_id[user_id]' ORDER BY call_ext.callext_id DESC LIMIT 1";
	$query = mysqli_query($con,$select);
	$status = mysqli_fetch_assoc($query);


	if ($status['status'] != "1" && $status['call_ended'] == "0"){

		echo "The Receiver ENDED the CALL!";

	} elseif($status['status'] == "1") { 

		echo "CALL STILL ACTIVE!";

	} 
}

?>