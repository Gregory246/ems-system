<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
//error_reporting();

//Get the current user session 

$userid = $_SESSION['userid'];
echo $userid;


$employee_tele = $_GET['calls'];
//$employee_tele = $_GET['employee_tel'];

//Get user ID
$select1 = "SELECT user_id FROM users WHERE username = '$userid' "; 

	$query1 = mysqli_query($con,$select1);

	$user_id = mysqli_fetch_assoc($query1);
	

//Selects the CALLER's employee id for tracking
$select2 = "SELECT hospital_employees_id FROM hospital_employees WHERE hospital_employees.user_id = '$user_id[user_id]'";  

	$query2 = mysqli_query($con,$select2);

	$caller = mysqli_fetch_assoc($query2);

//Checks if the CALLER is in a current call session, if yes then prompt caller to END current call
$select3 = "SELECT * FROM call_ext_hospital WHERE call_ext_hospital.user_id = '$user_id[user_id]' ORDER BY call_ext_hospital.call_ext_hospital_id DESC LIMIT 1";

	$query3 = mysqli_query($con,$select3);

	$status_caller = mysqli_fetch_assoc($query3); 

//This statement looks through tables with employees of hospitals and other agencies and return the employee's unique record ID
$select4 = "(SELECT employees.employee_id, 'employees' AS type FROM employees WHERE employees.employee_tele = '$employee_tele')
			UNION 
			(SELECT hospital_employees.hospital_employees_id, 'hospital_employees' AS type FROM hospital_employees WHERE hospital_employees.tele = '$employee_tele')";

	$query4 = mysqli_query($con,$select4);

	$employee_type = mysqli_fetch_assoc($query4);


//**********************************************************CALL-HANDLER STARTS HERE****************************************************************//



if ($employee_type['type'] == "employees") {
	
	//First retreives the last status of the lastest call made to the CALLED and then checks if the CALLED is currently in a call or not and then redirects the call
	$select4 = "SELECT * FROM employees WHERE employees.employee_id = '$employee_type[type]' ";

	$query4 = mysqli_query($con,$select4);

	$receiver = mysqli_fetch_assoc($query4);

	//****HERE WOULD USE AN IF STATEMENT THAT CHECKS BOTH CALL_EXT AND CALL_EXT_HOSPITAL TABLES FOR THIS PARTICULAR RECEIVER IS CURRENTLY ON A CALL//

$select5 = "SELECT call_ext_hospital FROM hospital_ext_calls_junc WHERE hospital_ext_calls_junc.receiver_employee = '$receiver[employee_id]' ORDER BY hospital_ext_calls_junc.hospital_ext_calls_junc_id DESC LIMIT 1 ";

	$query5 = mysqli_query($con,$select5);

	$call_ext_hospital_FK = mysqli_fetch_assoc($query5);

$select6 = "SELECT * FROM call_ext_hospital WHERE call_ext_hospital.call_ext_hospital_id = '$call_ext_hospital_FK[call_ext_hospital]' ";

	$query6 = mysqli_query($con,$select6);//

	$status_called_check1 = mysqli_fetch_assoc($query6);

$select7 = "SELECT call_ext FROM employees_call_ext_junc WHERE employees_call_ext_junc.receiver = '$receiver[employee_id]' ORDER BY employees_call_ext_junc.employees_call_ext_junc_id DESC LIMIT 1";

	$query7 = mysqli_query($con,$select7);

	$call_ext_FK = mysqli_fetch_assoc($query7);

$select8 = "SELECT * FROM call_ext WHERE call_ext.callext_id = '$call_ext_FK[call_ext]' ";

	$query8 = mysqli_query($con,$select8);//

	$status_called_check2 = mysqli_fetch_assoc($query8);

//This statement checks the tables and returns the status from the statement that is true

	if ($status_called_check1['status'] == 1) {
		
		$status_called = mysqli_fetch_assoc($query8);

	} else {

		$status_called = mysqli_fetch_assoc($query6);

	}

//*******************************************************************************************************************************************************//	

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

		 echo "<form method = 'POST' action = 'busy-call-handler.php' target = '_blank'>
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

			//This selects the receivers field in order to insert the employee's ID into the appropriate field
			if ($receiver['employee_field'] == 'Dispatch' || $receiver['employee_field'] == 'Emergency Response') {
					
					echo "check insert query";
				$insert = "INSERT INTO `hospital_ext_calls_junc` (`hospital_ext_calls_junc_id`, `caller_hospital`, `caller_employee`, `caller_ics`, `caller_HCF`, `receiver_hospital`, `receiver_employee`, `receiver_ics`, `receiver_HCF`, `call_ext_hospital`) 
							VALUES (NULL, '$caller[hospital_employees_id]', NULL, NULL, NULL, NULL, '$receiver[employee_id]', NULL, NULL, '$call_ext_hospital_id[call_ext_hospital_id]')";

				mysqli_query($con,$insert);

			} else {//Else if ICS

				$insert = "INSERT INTO `hospital_ext_calls_junc` (`hospital_ext_calls_junc_id`, `caller_hospital`, `caller_employee`, `caller_ics`, `caller_HCF`, `receiver_hospital`, `receiver_employee`, `receiver_ics`, `receiver_HCF`, `call_ext_hospital`) 
							VALUES (NULL, '$caller[hospital_employees_id]', NULL, NULL, NULL, NULL, NULL, '$receiver[employee_id]', NULL, '$call_ext_hospital_id[call_ext_hospital_id]')";

				mysqli_query($con,$insert);

			}


	} else { echo "Whoops!"."<br>"."Something went wrong. Please Click END CALL and try again...";}


	

}

} else {
			//echo "This is Call to Hospital";
	//First retreives the last status of the lastest call made to the CALLED and then checks if the CALLED is currently in a call or not and then redirects the call
	$select4 = "SELECT * FROM hospital_employees WHERE hospital_employees.hospital_employees_id = '$employee_type[employee_id]' ";

	$query4 = mysqli_query($con,$select4);

	$receiver = mysqli_fetch_assoc($query4);

	echo $receiver['hospital_employees_id'];
	
//****HERE WOULD USE AN IF STATEMENT THAT CHECKS BOTH CALL_EXT AND CALL_EXT_HOSPITAL TABLES FOR THIS PARTICULAR RECEIVER IS CURRENTLY ON A CALL//

$select5 = "SELECT call_ext_hospital FROM hospital_ext_calls_junc WHERE hospital_ext_calls_junc.receiver_hospital = '$receiver[hospital_employees_id]' ORDER BY hospital_ext_calls_junc.hospital_ext_calls_junc_id DESC LIMIT 1 ";

	$query5 = mysqli_query($con,$select5);

	$call_ext_hospital_FK = mysqli_fetch_array($query5);

	

$select6 = "SELECT * FROM call_ext_hospital WHERE call_ext_hospital.call_ext_hospital_id = '$call_ext_hospital_FK[call_ext_hospital]' ";

	$query6 = mysqli_query($con,$select6);//

	$status_called = mysqli_fetch_assoc($query6);
	

	//**Uncomment to add HCF etc**//

//$select7 = "SELECT call_ext FROM employees_call_ext_junc WHERE employees_call_ext_junc.receiver = '$receiver[employee_id]' ORDER BY employees_call_ext_junc.employees_call_ext_junc_id DESC LIMIT 1";

	//$query7 = mysqli_query($con,$select7);

	//$call_ext_FK = mysqli_fetch_assoc($query7);

//$select8 = "SELECT * FROM call_ext WHERE call_ext.callext_id = '$call_ext_FK[call_ext]' ";

	//$query8 = mysqli_query($con,$select8);//

	//$status_called_check2 = mysqli_fetch_assoc($query8);

//This statement checks the tables and returns the status from the statement that is true

	//if ($status_called_check1['status'] == 1) {
		
	//	$status_called = mysqli_fetch_assoc($query8);

	//} else {

	//	$status_called = mysqli_fetch_assoc($query6);
	//}

//**********************************************************************************************************************************	


	$_SESSION['status_called'] = $status_called['call_ext_hospital_id'];


if ($status_caller['status'] ==  1 && $status_caller['call_accepted'] == 1) {
	
	echo "Your CURRENT CALL is still ACTIVE!"."<br>"."Please END CALL and then proceed..." ;

} else {

	if ($status_called['status'] == 1 && $status_called['user_id'] != $user_id['user_id']) {
		
		echo "This Person is CURRENTLY ENGAGED in an EMERGENCY CALL."."<br>"."Please CONTACT NEXT AVAILABLE HOSPITAL! Until FURTHER NOTICE!...";
		//Missed call session would be logged here in the DATABASE.
		//Use html function to prompt CALLER if they would like to notify the CALLED missed call session.
		//Clears interval

		 echo "<form method = 'POST' action = 'busy-call-handler.php' target = '_blank'>
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

			//This selects the receivers field in order to insert the employee's ID into the appropriate field
			if ($receiver['title'] == 'Emergency Communications Coordinator' ) {//|| $receiver['###'] == '####') {

					echo "Inner IFFFFFFFFFFFFF".$receiver['hospital_employees_id'];

					echo "<br>";

					echo $caller['hospital_employees_id'].$call_ext_hospital_id['call_ext_hospital_id'];
				
				$insert = "INSERT INTO `hospital_ext_calls_junc` (`hospital_ext_calls_junc_id`, `caller_hospital`, `caller_employee`, `caller_ics`, `caller_HCF`, `receiver_hospital`, `receiver_employee`, `receiver_ics`, `receiver_HCF`, `call_ext_hospital`) 
							VALUES (NULL, '$caller[hospital_employees_id]', NULL, NULL, NULL, '$receiver[hospital_employees_id]', NULL, NULL, NULL, '$call_ext_hospital_id[call_ext_hospital_id]');";

				mysqli_query($con,$insert);

			} else { //For other Health Care Services

				$insert = "INSERT INTO `hospital_ext_calls_junc` (`hospital_ext_calls_junc_id`, `caller_hospital`, `caller_employee`, `caller_ics`, `caller_HCF`, `receiver_hospital`, `receiver_employee`, `receiver_ics`, `receiver_HCF`, `call_ext_hospital`) 
							VALUES (NULL, '$caller[hospital_employees_id]', NULL, NULL, NULL, NULL, NULL, NULL,'$receiver[hospital_employees_id]', '$call_ext_hospital_id[call_ext_hospital_id]') ";

				mysqli_query($con,$insert);

				}

	} else { echo "Whoops!"."<br>"."Something went wrong. Please Click END CALL and try again...";}


	

}





}
	

?>