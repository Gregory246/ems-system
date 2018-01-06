<?php 
session_start();
include_once('dbconnect.php');
//error_reporting();

//Get the current user session 

$userid = $_SESSION['userid'];
$employee_tele = $_GET['calls'];

$_SESSION['employee_tele'] = $employee_tele; //Used in call-status-checker

//Get user ID
$select1 = "SELECT user_id FROM users WHERE username = '$userid' ";

	$query1 = mysqli_query($con,$select1);

	$user_id = mysqli_fetch_assoc($query1);

//Selects the CALLER's employee id for tracking
$select2 = "SELECT employee_id FROM employees WHERE employees.user_id = '$user_id[user_id]'"; 

	$query2 = mysqli_query($con,$select2);

	$caller = mysqli_fetch_assoc($query2);

//Deteremines whether the caller is from employee's table or hospital's employees table

	$select_ = "(SELECT employees.employee_id, 'employees' AS type FROM employees WHERE employees.employee_tele = '$employee_tele')
			UNION 
			(SELECT hospital_employees.hospital_employees_id, 'hospital_employees' AS type FROM hospital_employees WHERE hospital_employees.tele = '$employee_tele')";

	$query_ = mysqli_query($con,$select_);

	$employee_type = mysqli_fetch_assoc($query_);


	//**********************************************************************************//

//Based on the returned result from employee_type and uses an if statement to logged and retrieve data in appropriate tables

	if ($employee_type['type'] == 'employees') {
		

		//Checks if the CALLER is in a current call session, if yes then prompt caller to END current call
$select3 = "SELECT * FROM call_ext WHERE call_ext.user_id = '$user_id[user_id]' ORDER BY call_ext.callext_id DESC LIMIT 1";

	$query3 = mysqli_query($con,$select3);

	$status_caller = mysqli_fetch_assoc($query3);

//First retreives the last status of the lastest call made to the CALLED and then checks if the CALLED is currently in a call or not and then redirects the call
$select4 = "SELECT employee_id FROM employees WHERE employees.employee_tele = '$employee_tele' ";

	$query4 = mysqli_query($con,$select4);
	
	$receiver = mysqli_fetch_assoc($query4);

$select5 = "SELECT call_ext FROM employees_call_ext_junc WHERE employees_call_ext_junc.receiver = '$receiver[employee_id]' ORDER BY employees_call_ext_junc.employees_call_ext_junc_id DESC LIMIT 1 ";

	$query5 = mysqli_query($con,$select5);

	$call_ext_FK = mysqli_fetch_assoc($query5);

$select6 = "SELECT * FROM call_ext WHERE call_ext.callext_id = '$call_ext_FK[call_ext]' ";

	$query6 = mysqli_query($con,$select6);

	$status_called = mysqli_fetch_assoc($query6);

	echo $status_called['callext_id']."This line..";

	$_SESSION['status_called'] = $status_called['callext_id'];

if ($status_caller['status'] ==  1 && $status_caller['call_accepted'] == 1) {
	
	echo "Your CURRENT CALL is still ACTIVE!"."<br>"."Please END CALL and then proceed..." ;

} else {

	if ($status_called['status'] == 1 && $status_called['user_id'] != $user_id['user_id']) {
		
		echo "This Person is CURRENTLY ENGAGED in an EMERGENCY CALL."."<br>"."Please CONTACT NEXT AVAILABLE HOSPITAL! Until FURTHER NOTICE!...";
		//Missed call session would be logged here in the DATABASE.
		//Use html function to prompt CALLER if they would like to notify the CALLED missed call session.
		//Clears interval

		 echo "<form onsubmit = 'return false' method = 'POST' action = 'busy-call-handler.php' target = '_blank'>
		 		<label>Note:</label>
		 		<input type = 'text' id = 'note' name = 'note' width = '150px' height = '100px' placeholder = 'Leave message here (50words max)' />
		 		<input type = 'submit' value = 'Submit!' />
		 		</form>";

	} elseif ($status_called['status'] == 0){

		$insert_call = "INSERT INTO call_ext (callext_id,status,device,user_id) VALUES (NULL,1,'PHONE','$user_id[user_id]')";
			
			mysqli_query($con,$insert_call);

		$select = "SELECT callext_id FROM call_ext WHERE call_ext.user_id = '$user_id[user_id]' ORDER BY call_ext.callext_id DESC LIMIT 1";

			$query = mysqli_query($con,$select);

			$callext_id = mysqli_fetch_assoc($query);	

			$_SESSION['call_ext_hospital_id'] = $callext_id['callext_id'];

			
		$insert = "INSERT INTO `employees_call_ext_junc` (`employees_call_ext_junc_id`, `caller`, `receiver`, `call_ext`, `call_ext_ics`) 
					VALUES (NULL, '$caller[employee_id]', '$receiver[employee_id]', '$callext_id[callext_id]', NULL) ";

			mysqli_query($con,$insert);

	} else { echo "Whoops!"."<br>"."Something went wrong. Please Click END CALL and try again...";}

}

	} else {

		//*************IF THE CALLED IS FROM HOSPITAL**********************************//
		//Checks if the CALLER is in a current call session, if yes then prompt caller to END current call
$select3 = "SELECT * FROM call_ext_hospital WHERE call_ext_hospital.user_id = '$user_id[user_id]' ORDER BY call_ext_hospital.call_ext_hospital_id DESC LIMIT 1";

	$query3 = mysqli_query($con,$select3);

	$status_caller = mysqli_fetch_assoc($query3);

//First retreives the last status of the lastest call made to the CALLED and then checks if the CALLED is currently in a call or not and then redirects the call
$select4 = "SELECT hospital_employees_id FROM hospital_employees WHERE hospital_employees.tele = '$employee_tele' ";

	$query4 = mysqli_query($con,$select4);
	
	$receiver = mysqli_fetch_assoc($query4);

$select5 = "SELECT call_ext_hospital FROM hospital_ext_calls_junc WHERE hospital_ext_calls_junc.receiver_hospital = '$receiver[hospital_employees_id]' ORDER BY hospital_ext_calls_junc.hospital_ext_calls_junc_id DESC LIMIT 1 ";

	$query5 = mysqli_query($con,$select5);

	$call_ext_hospital_FK = mysqli_fetch_assoc($query5);

$select6 = "SELECT * FROM call_ext_hospital WHERE call_ext_hospital.call_ext_hospital_id = '$call_ext_hospital_FK[call_ext_hospital]' ";

	$query6 = mysqli_query($con,$select6);

	$status_called = mysqli_fetch_assoc($query6);

	echo $status_called['call_ext_hospital_id']."This line..";

	$_SESSION['status_called'] = $status_called['call_ext_hospital_id'];

if ($status_caller['status'] ==  1 && $status_caller['call_accepted'] == 1) {
	
	echo "Your CURRENT CALL is still ACTIVE!"."<br>"."Please END CALL and then proceed..." ;

} else {

	if ($status_called['status'] == 1 && $status_called['user_id'] != $user_id['user_id']) {
		
		echo "This Person is CURRENTLY ENGAGED in an EMERGENCY CALL."."<br>"."Please CONTACT NEXT AVAILABLE HOSPITAL! Until FURTHER NOTICE!...";
		//Missed call session would be logged here in the DATABASE.
		//Use html function to prompt CALLER if they would like to notify the CALLED missed call session.
		//Clears interval

		 echo "<form onsubmit = 'return false' method = 'POST' action = 'busy-call-handler.php' target = '_blank'>
		 		<label>Note:</label>
		 		<input type = 'text' id = 'note' name = 'note' width = '150px' height = '100px' placeholder = 'Leave message here (50words max)' />
		 		<input type = 'submit' value = 'Submit!' />
		 		</form>";

	} elseif ($status_called['status'] == 0){

		$insert_call = "INSERT INTO call_ext_hospital (call_ext_hospital_id,status,device,user_id) VALUES (NULL,1,'PHONE','$user_id[user_id]')";
			
			mysqli_query($con,$insert_call);

		$select = "SELECT call_ext_hospital_id FROM call_ext_hospital WHERE call_ext_hospital.user_id = '$user_id[user_id]' ORDER BY call_ext_hospital.call_ext_hospital_id DESC LIMIT 1";

			$query = mysqli_query($con,$select);

			$call_ext_hospital_id = mysqli_fetch_assoc($query);	

			$_SESSION['call_ext_hospital_id'] = $call_ext_hospital_id['call_ext_hospital_id'];

		$insert = "INSERT INTO hospital_ext_calls_junc (hospital_ext_calls_junc_id,caller_hospital,caller_employee,caller_HCF,receiver_hospital,receiver_employee,receiver_ics,receiver_HCF,call_ext_hospital)
					VALUES (NULL,NULL,'$caller[employee_id]',NULL,'$receiver[hospital_employees_id]',NULL,NULL,NULL,'$call_ext_hospital_id[call_ext_hospital_id]') ";

			mysqli_query($con,$insert);

	} else { echo "Whoops!"."<br>"."Something went wrong. Please Click END CALL and try again...";}

}
	}




?>