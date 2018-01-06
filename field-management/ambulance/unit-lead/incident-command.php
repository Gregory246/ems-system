<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
error_reporting(0);
$userid = $_SESSION['userid'];

//Get's User Id to obtian the vehicleteam of the user
$select_userid = "SELECT `user_id` FROM `users` WHERE `users`.`username` = '$userid' ";

	$query_userid = mysqli_query($con,$select_userid);

	$user_id = mysqli_fetch_assoc($query_userid);


$select1 = "SELECT `employees`.*,`users`.*,`vehicleteam`.* FROM `employees`
			JOIN `users` ON `employees`.`user_id` = `users`.`user_id`
			JOIN `vehicleteam` ON `employees`.`employee_id` = `vehicleteam`.`advance_tech_FK` WHERE `employees`.`user_id` = '$user_id[user_id]' ";

	$query1 = mysqli_query($con,$select1);

	$vehicleteam = mysqli_fetch_assoc($query1);

	$select8 = "SELECT vehicleteam.operator_FK, CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name 
                            FROM vehicleteam JOIN employees ON vehicleteam.operator_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query8 = mysqli_query($con,$select8);

                $operator = mysqli_fetch_assoc($query8);


                $select9 = "SELECT vehicleteam.assistance_FK,CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name 
                            FROM vehicleteam JOIN employees ON vehicleteam.assistance_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query9 = mysqli_query($con,$select9);

                $assistant = mysqli_fetch_assoc($query9);


                $select10 = "SELECT vehicleteam.tech_FK,CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name 
                            FROM vehicleteam JOIN employees ON vehicleteam.tech_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query10 = mysqli_query($con,$select10);

                $emt = mysqli_fetch_assoc($query10);


                $select11 = "SELECT vehicleteam.advance_tech_FK,CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name 
                            FROM vehicleteam JOIN employees ON vehicleteam.advance_tech_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query11 = mysqli_query($con,$select11);

                $ademt = mysqli_fetch_assoc($query11);


                $select12 = "SELECT vehicleteam.paramedic_FK,CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name 
                            FROM vehicleteam JOIN employees ON vehicleteam.paramedic_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query12 = mysqli_query($con,$select12);

                $para = mysqli_fetch_assoc($query12);


                $select13 = "SELECT vehicleteam.advance_paramedic_FK,CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name 
                            FROM vehicleteam JOIN employees ON vehicleteam.advance_paramedic_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query13 = mysqli_query($con,$select13);

                $adpara = mysqli_fetch_assoc($query13);


                $select14 = "SELECT vehicleteam.wilderness_tech_FK,CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name 
                            FROM vehicleteam JOIN employees ON vehicleteam.wilderness_tech_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query14 = mysqli_query($con,$select14);

                $wtech = mysqli_fetch_assoc($query14);

//Gets the most recent Disaster Event ID
$disaster_id = $_SESSION['disaster_id'];

$select = "SELECT * FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' ";

	$query = mysqli_query($con,$select);

	$ics_structure = mysqli_fetch_assoc($query);

	//INITIAL RESPONSE

	if (mysqli_num_rows($query) == 0 ) {
		
		echo "<strong>"."<div style = 'color:red' >"."Please Establish a Incident Command System!"."</div>"."</strong>"; echo "<hr>";

		echo "<form method = 'POST' action = 'ems-incident-command.php' target = '_blank'>

				<label><strong>At Disaster Location?:</strong></label> &nbsp;&nbsp;
				<input type = 'radio' id = 'arrival' = name = 'arrival' value = '1' required/>Yes &nbsp;
				<input type = 'radio' id = 'arrival' = name = 'arrival' value = '0' required/>No
				<br><br>

		 		<label><strong>Incident Commander:</strong></label>
		 			<select id = 'incident_command' name = 'incident_command'>
		 			<option value = '' selected disabled>Select...</option>
		 			<option value = ".$operator['operator_FK']." >".$operator['employee_name']."</option>
		 			<option value = ".$assistant['assistance_FK']." >".$assistant['employee_name']."</option>
		 			<option value = ".$emt['tech_FK']." >".$emt['employee_name']."</option>
		 			<option value = ".$ademt['advance_tech_FK']." >".$ademt['employee_name']."</option>
		 			<option value = ".$para['paramedic_FK']." >".$para['employee_name']."</option>
		 			<option value = ".$adpara['advance_paramedic_FK']." >".$adpara['employee_name']."</option>
		 			<option value = ".$wtech['wilderness_tech_FK']." >".$wtech['employee_name']."</option>
		 			</select><br><br>


		 		<label><strong>Triage Personnel:</strong></label>
		 			<select id = 'triage_personnel' name = 'triage_personnel'>
		 			<option value = '' selected disabled>Select...</option>
		 			<option value = ".$operator['operator_FK']." >".$operator['employee_name']."</option>
		 			<option value = ".$assistant['assistance_FK']." >".$assistant['employee_name']."</option>
		 			<option value = ".$emt['tech_FK']." >".$emt['employee_name']."</option>
		 			<option value = ".$ademt['advance_tech_FK']." >".$ademt['employee_name']."</option>
		 			<option value = ".$para['paramedic_FK']." >".$para['employee_name']."</option>
		 			<option value = ".$adpara['advance_paramedic_FK']." >".$adpara['employee_name']."</option>
		 			<option value = ".$wtech['wilderness_tech_FK']." >".$wtech['employee_name']."</option>
		 			</select><br><br>

		 			
		 		<label><strong>Medical Communications Coordinator:</strong></label>
		 			<select id = 'medical_communications_coordinator' name = 'medical_communications_coordinator'>
		 			<option value = '' selected  disabled>Select...</option>
		 			<option value = ".$operator['operator_FK']." >".$operator['employee_name']."</option>
		 			<option value = ".$assistant['assistance_FK']." >".$assistant['employee_name']."</option>
		 			<option value = ".$emt['tech_FK']." >".$emt['employee_name']."</option>
		 			<option value = ".$ademt['advance_tech_FK']." >".$ademt['employee_name']."</option>
		 			<option value = ".$para['paramedic_FK']." >".$para['employee_name']."</option>
		 			<option value = ".$adpara['advance_paramedic_FK']." >".$adpara['employee_name']."</option>
		 			<option value = ".$wtech['wilderness_tech_FK']." >".$wtech['employee_name']."</option>
		 			</select><br><br>	

		 			<input type = 'submit' value = 'Submit!' /><br>
		 		</form> ";

	//REINFORCED RESPONSE	 		
	} elseif (mysqli_num_rows($query) == 3) {

		echo "Incident Command established! Please Report to..."; echo "<hr>";

		$select = "SELECT * FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' AND `ics_structure`.`branch_id_FK` = '1' ORDER BY `ics_structure`.`date_created` DESC LIMIT 1";

			$query = mysqli_query($con,$select);

			$ics_structure = mysqli_fetch_assoc($query);

		$select1 = "SELECT `ics_structure`.*, CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name FROM `ics_structure` 
					JOIN `employees` ON  `ics_structure`.`employee_id_FK` = `employees`.`employee_id`
					WHERE `ics_structure`.`employee_id_FK` = '$ics_structure[employee_id_FK]' ";

			$query1 = mysqli_query($con,$select1);

			$incident_command = mysqli_fetch_assoc($query1);

			echo "<button id = 'mybutton' onclick = 'call(this.value)'>".$incident_command['employee_name']."</button>" ; //Call Function can be created to can this employee directly

	} elseif (mysqli_num_rows($query) > 3) {
		
		echo "Incident Command Established! Please Report to...";
	}

?>