<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
error_reporting(0);

//error_reporting(0);
  $userid ="wayl"  ;   //$_SESSION['userid'];


//Get's User Id to obtian the vehicleteam of the user
$select_userid = "SELECT `user_id` FROM `users` WHERE `users`.`username` = '$userid' ";

$query_userid = mysqli_query($con,$select_userid);

	$user_id = mysqli_fetch_assoc($query_userid);


//Gets Agency details of the current USER
    $select_agency = "SELECT agency.*,department.*,employees.*,employees_department_junc.* 
                  FROM `employees_department_junc`
                  JOIN department ON employees_department_junc.department_FK_id = department.department_id
                  JOIN employees ON employees_department_junc.employee_FK_id = employees.employee_id
                  JOIN agency ON department.agency_id = agency.agency_id
                  WHERE employees.user_id = '$user_id[user_id]' ";

      $query0 = mysqli_query($con,$select_agency);

      $agency = mysqli_fetch_assoc($query0);


$select_emsvehicle = "SELECT * FROM `emsvehicle` WHERE `emsvehicle`.`agency_id`= '$agency[agency_id]'";

		$query1 = mysqli_query($con,$select_emsvehicle);

		$emsvehicle = mysqli_fetch_assoc($query1);


	$employee_id = $_GET['f1'];

	$select = "SELECT `employees`.*, CONCAT(employee_fname,' ',employee_lname)employee_name FROM `employees` WHERE `employees`.`employee_id` = '$employee_id' ";

	$query = mysqli_query($con,$select);

	$employee_name = mysqli_fetch_assoc($query);


$select2 = "SELECT `vehicleteam_id`,`operator_FK`, `assistance_FK`, `tech_FK`, `advance_tech_FK`, `paramedic_FK`, `advance_paramedic_FK`, `wilderness_tech_FK` 
			FROM `vehicleteam` WHERE `user_id`= '$user_id[user_id]' ORDER BY `vehicleteam_id` DESC LIMIT 1";

	$query2 = mysqli_query($con,$select2);

	$vehicleteam = mysqli_fetch_assoc($query2);

/*INSERT INTO `vehicleteam` (`vehicleteam_id`, `emsvehicle_id`, `team_type`, `life_support`, `operator_FK`, `assistance_FK`, `tech_FK`, `advance_tech_FK`, `paramedic_FK`, `advance_paramedic_FK`, `wilderness_tech_FK`, `user_id`) 
VALUES (NULL, '2', 'team_type', 'life_support', '2', NULL, NULL, NULL, NULL, NULL, NULL, '2');*/

	
if ($_GET["bin"] == "true") {

		$team_class = $_GET['team_class'];
		$life_support = $_GET['life_support'];
		$vehicle_id = $_GET['vehicle_id'];


	if (!empty($vehicleteam['operator_FK']) && !empty($vehicleteam['assistance_FK']) && !empty($vehicleteam['tech_FK']) && !empty($vehicleteam['advance_tech_FK']) && !empty($vehicleteam['paramedic_FK']) && !empty($vehicleteam['advance_paramedic_FK']) && !empty($vehicleteam['wilderness_tech_FK']) ) {
		
			echo $vehicle_id;

		if ($employee_name['employee_title'] == 'Ambulance Operator') {
			
			$insert = "INSERT INTO `vehicleteam` (`vehicleteam_id`, `emsvehicle_id`, `team_type`, `life_support`,`operator_FK`,`user_id`) 
						VALUES (NULL, '$vehicle_id', '$team_class', '$life_support','$employee_id','$user_id[user_id]')";

			$query = mysqli_query($con,$insert);

		} elseif ($employee_name['employee_title'] == 'Ambulance Care Assistance') {
			
			$insert = "INSERT INTO `vehicleteam` (`vehicleteam_id`, `emsvehicle_id`, `team_type`, `life_support`,`assistance_FK`,`user_id`) 
						VALUES (NULL, '$vehicle_id', '$team_class', '$life_support','$employee_id','$user_id[user_id]')";

			$query = mysqli_query($con,$insert);

		} elseif ($employee_name['employee_title'] == 'Emergency Medical Technician') {
		
			$insert = "INSERT INTO `vehicleteam` (`vehicleteam_id`, `emsvehicle_id`, `team_type`, `life_support`,`tech_FK`,`user_id`) 
						VALUES (NULL, '$vehicle_id', '$team_class', '$life_support','$employee_id','$user_id[user_id]')";

			$query = mysqli_query($con,$insert);	

		} elseif ($employee_name['employee_title'] == 'Advance Emergency Medical Technician') {
			
			$insert = "INSERT INTO `vehicleteam` (`vehicleteam_id`, `emsvehicle_id`, `team_type`, `life_support`,`advance_tech_FK`,`user_id`) 
						VALUES (NULL, '$vehicle_id', '$team_class', '$life_support','$employee_id','$user_id[user_id]')";

			$query = mysqli_query($con,$insert);

		} elseif ($employee_name['employee_title'] == 'Paramedic') {
			
			$insert = "INSERT INTO `vehicleteam` (`vehicleteam_id`, `emsvehicle_id`, `team_type`, `life_support`,`paramedic_FK`,`user_id`) 
						VALUES (NULL, '$vehicle_id', '$team_class', '$life_support','$employee_id','$user_id[user_id]')";

			$query = mysqli_query($con,$insert);

		} elseif ($employee_name['employee_title'] == 'Advance Practice Paramedic') {
			
			$insert = "INSERT INTO `vehicleteam` (`vehicleteam_id`, `emsvehicle_id`, `team_type`, `life_support`,`advance_paramedic_FK`,`user_id`) 
						VALUES (NULL, '$vehicle_id', '$team_class', '$life_support','$employee_id','$user_id[user_id]')";

			$query = mysqli_query($con,$insert);

		} elseif ($employee_name['employee_title'] == 'Wilderness Emergency Medical Technician') {
			
			$insert = "INSERT INTO `vehicleteam` (`vehicleteam_id`, `emsvehicle_id`, `team_type`, `life_support`,`wilderness_tech_FK`,`user_id`) 
						VALUES (NULL, '$vehicle_id', '$team_class', '$life_support','$employee_id','$user_id[user_id]')";

			$query = mysqli_query($con,$insert);

		}

	} else { //UPDATE `vehicleteam` SET `assistance_FK` = '112' WHERE `vehicleteam`.`vehicleteam_id` = 8;
		
		if ($employee_name['employee_title'] == 'Ambulance Operator') {
			
			$update = "UPDATE `vehicleteam` SET `operator_FK` = '$employee_id' WHERE `vehicleteam`.`vehicleteam_id` = '$vehicleteam[vehicleteam_id]' ";

			$query = mysqli_query($con,$update);

		} elseif ($employee_name['employee_title'] == 'Ambulance Care Assistance') {
			
			$update = "UPDATE `vehicleteam` SET `assistance_FK` = '$employee_id' WHERE `vehicleteam`.`vehicleteam_id` = '$vehicleteam[vehicleteam_id]' ";

			$query = mysqli_query($con,$update);

		} elseif ($employee_name['employee_title'] == 'Emergency Medical Technician') {
		
			$update = "UPDATE `vehicleteam` SET `tech_FK` = '$employee_id' WHERE `vehicleteam`.`vehicleteam_id` = '$vehicleteam[vehicleteam_id]' ";

			$query = mysqli_query($con,$update);	

		} elseif ($employee_name['employee_title'] == 'Advance Emergency Medical Technician') {
			
			$update = "UPDATE `vehicleteam` SET `advance_tech_FK` = '$employee_id' WHERE `vehicleteam`.`vehicleteam_id` = '$vehicleteam[vehicleteam_id]' ";

			$query = mysqli_query($con,$update);

		} elseif ($employee_name['employee_title'] == 'Paramedic') {
			
			$update = "UPDATE `vehicleteam` SET `paramedic_FK` = '$employee_id' WHERE `vehicleteam`.`vehicleteam_id` = '$vehicleteam[vehicleteam_id]' ";

			$query = mysqli_query($con,$update);

		} elseif ($employee_name['employee_title'] == 'Advance Practice Paramedic') {
			
			$update = "UPDATE `vehicleteam` SET `advance_paramedic_FK` = '$employee_id' WHERE `vehicleteam`.`vehicleteam_id` = '$vehicleteam[vehicleteam_id]' ";

			$query = mysqli_query($con,$update);

		} elseif ($employee_name['employee_title'] == 'Wilderness Emergency Medical Technician') {
			
			$update = "UPDATE `vehicleteam` SET `wilderness_tech_FK` = '$employee_id' WHERE `vehicleteam`.`vehicleteam_id` = '$vehicleteam[vehicleteam_id]' ";

			$query = mysqli_query($con,$update);
	}

	}

	} 

/*--------------------------------------------------------------------------------------------------------------------------------------------*/

if($_GET["bin"] == "false"){

	/*Here confirms the availability of the team when it's finished assigned*/
	if(!empty($vehicleteam['operator_FK']) && !empty($vehicleteam['assistance_FK']) && !empty($vehicleteam['tech_FK']) && !empty($vehicleteam['advance_tech_FK']) && !empty($vehicleteam['paramedic_FK']) && !empty($vehicleteam['advance_paramedic_FK']) && !empty($vehicleteam['wilderness_tech_FK'])){

		$insert_4 = "INSERT INTO `hospital_vehicle_availability` (`hospital_vehicle_availability_id`, `type`, `status`, `date_time`, `updated_by`, `stage`, `user_id`) 
					VALUES (NULL, '0', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '1', '$user_id[user_id]')";

			mysqli_query($con,$insert_4);

		$select_4 = "SELECT `hospital_vehicle_availability_id` FROM `hospital_vehicle_availability` WHERE `user_id` = '$user_id[user_id]' AND `type` = 0 ORDER BY `hospital_vehicle_availability_id` DESC LIMIT 1";
		$query_4 = mysqli_query($con,$select_4);
		$hospital_vehicle_availability_V_id = mysqli_fetch_assoc($query_4);


		$insert_2 = "INSERT INTO vehicleteam_availabilty_junc (vehicleteam_availabilty_junc_id,vehicleteam_id,hospital_vehicle_availability_id)
					VALUES (NULL,'$vehicleteam[vehicleteam_id]','$hospital_vehicle_availability_V_id[hospital_vehicle_availability_id]')"; 

			mysqli_query($con,$insert_2);

		
		if (mysqli_affected_rows($con) > 0) {
			

			echo "Allocator will be notified. Please close window and continue...";

		} else {

			echo "Sorry ERROR occurred with the Update. Please try again!";
		}

	  }

}

?>