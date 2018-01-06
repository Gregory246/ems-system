<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
//error_reporting(0);
//$userid = $_SESSION['userid'];

//Get's User Id to obtian the vehicleteam of the user
//$select_userid = "SELECT `user_id` FROM `users` WHERE `users`.`username` = '$userid' ";

//	$query_userid = mysqli_query($con,$select_userid);

//	$user_id = mysqli_fetch_assoc($query_userid);


$select1 = "SELECT `employees`.*, CONCAT(employee_fname,' ',employee_lname)employee_name FROM `employees` WHERE `employees`.`employee_title` = 'Physician' ";

	$query1 = mysqli_query($con,$select1);
	$query2 = mysqli_query($con,$select1);
	$query3 = mysqli_query($con,$select1);

	//$physician = mysqli_fetch_assoc($query1);

	

//Gets the most recent Disaster Event ID
////$disaster_id = $_SESSION['disaster_id'];



		
		echo "<strong>"."<div style = 'color:red' >"."Please Establish Triage-Personnel:"."</div>"."</strong>"; echo "<hr>";

		echo "<form method = 'POST' action = 'ems-incident-command.php' target = '_blank'>";

			
				echo"
		 		<label><strong>On-Site:</strong></label>
		 			<select id = 'on_site' name = 'on_site'>
		 			<option value = '' selected disabled>Select...</option>";
		 			while($physician = mysqli_fetch_assoc($query1)){
		 		echo"	<option value = ".$physician['employee_id']." >".$physician['employee_name']."</option> ";
		 				}
		 			
		 		echo"</select><br><br>";

		 		echo"
		 		<label><strong>Medical-Post:</strong></label>
		 			<select id = 'medical_post' name = 'medical_post'>
		 			<option value = '' selected disabled>Select...</option>";
		 			while($physician2 = mysqli_fetch_assoc($query2)){
		 		echo"	<option value = ".$physician2['employee_id']." >".$physician2['employee_name']."</option> ";
		 				}
		 			
		 		echo"</select><br><br>";

		 		echo"	
		 		<label><strong>Evacuation:</strong></label>
		 			<select id = 'evacuation_triage' name = 'evacuation_triage'>
		 			<option value = '' selected  disabled>Select...</option>";
		 			while($physician3 = mysqli_fetch_assoc($query3)){
		 		echo"	<option value = ".$physician3['employee_id']." >".$physician3['employee_name']."</option> ";
		 				}
		 			
		 		echo"</select><br><br>";


		 			echo "<input type = 'submit' value = 'Submit!' /><br>
		 		</form> ";

?>