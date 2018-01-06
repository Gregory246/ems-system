<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

$disaster_id = $_SESSION['disaster_id'];
$userid = $_SESSION['userid'];


$select = "SELECT employees.*, users.* 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = '$userid'";//Remove Dummy value 

	$query = mysqli_query($con,$select);

	$employee = mysqli_fetch_assoc($query);

//$disaster_id = $_SESSION['disaster_id'];

if ($_GET['complete'] == "true") {
	
	$complete = $_GET['complete'];
	$success = $_GET['state'];
	$treatment_notes = $_GET['treatment_notes'];
	$victim_unique_key_id = $_GET['victim_unique_key_id'];
	$treatment = $_GET['treatment'];
	$start_time = $_GET['start_time'].":00";
	$end_time = $_GET['end_time'].":00";
	$pre_num = $_GET['pre_num'];
	$pre_name = $_GET['pre_name'];
	$dose_freq = $_GET['dose_freq'];
	$max_dose = $_GET['max_dose'];
	$purpose = $_GET['purpose'];
	$device_type = $_GET['device_type'];
	$device_name = $_GET['device_name'];
	$device_no = $_GET['device_no'];

	
	$insert = "INSERT INTO `field_pharmaceuticals` (`field_pharmaceuticals_id`, `prescribed`, `prescription_num`, `prescription_name`, `dose_freq`, `dose_max`, `purpose`, `user_id`)
				VALUES (NULL, '1', '$pre_num', '$pre_name', '$dose_freq', '$max_dose', '$purpose', '$employee[user_id]')";

		mysqli_query($con,$insert);


	$insert1 = "INSERT INTO `medical_supplies` (`medical_supplies_id`, `device_type`, `device_name`, `device_num`, `user_id`) 
				VALUES (NULL, '$device_type', '$device_name', '$device_no', '$employee[user_id]')";

		mysqli_query($con,$insert1);


	$select1 = "SELECT `field_pharmaceuticals`.`field_pharmaceuticals_id` 
				FROM `field_pharmaceuticals` 
				WHERE `field_pharmaceuticals`.`user_id` = '$employee[user_id]' 
				ORDER BY `field_pharmaceuticals`.`field_pharmaceuticals_id` DESC LIMIT 1";

		$query1 = mysqli_query($con,$select1);

		$field_pharmaceuticals_id = mysqli_fetch_assoc($query1);


	$select2 = "SELECT `medical_supplies`.`medical_supplies_id` 
				FROM `medical_supplies`
				WHERE `medical_supplies`.`user_id` = '$employee[user_id]'
				ORDER BY `medical_supplies`.`medical_supplies_id` DESC LIMIT 1";

		$query2 = mysqli_query($con,$select2);

		$medical_supplies_id = mysqli_fetch_assoc($query2);


	$select3 = "SELECT * FROM `victim` WHERE `victim`.`victim_unique_key_id` = '$victim_unique_key_id'";

		$query3 = mysqli_query($con,$select3);

		$victim = mysqli_fetch_assoc($query3);


	$insert2 = "INSERT INTO `field_treatment` (`field_treatment_id`, `victimid`, `treatment`, `field_pharmaceuticals_id`, `medical_supplies_id`, `time_administered`, `end_time`, `treatment_successful`, `treatment_notes`, `disaster_id`, `date_created`, `last_updated`, `user_id`)
				VALUES (NULL, '$victim[victimid]', '$treatment', '$field_pharmaceuticals_id[field_pharmaceuticals_id]', '$medical_supplies_id[medical_supplies_id]', '$start_time', '$end_time', '$success', '$treatment_notes', '70', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$employee[user_id]')";

		mysqli_query($con,$insert2);


	$update = "UPDATE `victim` SET `treatment_received` = '1' WHERE `victim`.`victimid` = '$victim[victimid]'";

		mysqli_query($con,$update);
echo "Completed";

} else{


	$success = $_GET['state'];
	$victim_unique_key_id = $_GET['victim_unique_key_id'];
	$treatment = $_GET['treatment'];
	$treatment_notes = $_GET['treatment_notes'];
	$start_time = $_GET['start_time'].":00";
	$end_time = $_GET['end_time'].":00";
	$pre_num = $_GET['pre_num'];
	$pre_name = $_GET['pre_name'];
	$dose_freq = $_GET['dose_freq'];
	$max_dose = $_GET['max_dose'];
	$purpose = $_GET['purpose'];
	$device_type = $_GET['device_type'];
	$device_name = $_GET['device_name'];
	$device_no = $_GET['device_no'];

	
	$insert = "INSERT INTO `field_pharmaceuticals` (`field_pharmaceuticals_id`, `prescribed`, `prescription_num`, `prescription_name`, `dose_freq`, `dose_max`, `purpose`, `user_id`)
				VALUES (NULL, '1', '$pre_num', '$pre_name', '$dose_freq', '$max_dose', '$purpose', '$employee[user_id]')";

		mysqli_query($con,$insert);


	$insert1 = "INSERT INTO `medical_supplies` (`medical_supplies_id`, `device_type`, `device_name`, `device_num`, `user_id`) 
				VALUES (NULL, '$device_type', '$device_name', '$device_no', '$employee[user_id]')";

		mysqli_query($con,$insert1);


	$select1 = "SELECT `field_pharmaceuticals`.`field_pharmaceuticals_id` 
				FROM `field_pharmaceuticals` 
				WHERE `field_pharmaceuticals`.`user_id` = '$employee[user_id]' 
				ORDER BY `field_pharmaceuticals`.`field_pharmaceuticals_id` DESC LIMIT 1";

		$query1 = mysqli_query($con,$select1);

		$field_pharmaceuticals_id = mysqli_fetch_assoc($query1);


	$select2 = "SELECT `medical_supplies`.`medical_supplies_id` 
				FROM `medical_supplies`
				WHERE `medical_supplies`.`user_id` = '$employee[user_id]'
				ORDER BY `medical_supplies`.`medical_supplies_id` DESC LIMIT 1";

		$query2 = mysqli_query($con,$select2);

		$medical_supplies_id = mysqli_fetch_assoc($query2);


	$select3 = "SELECT * FROM `victim` WHERE `victim`.`victim_unique_key_id` = '$victim_unique_key_id'";

		$query3 = mysqli_query($con,$select3);

		$victim = mysqli_fetch_assoc($query3);


	$insert2 = "INSERT INTO `field_treatment` (`field_treatment_id`, `victimid`, `treatment`, `field_pharmaceuticals_id`, `medical_supplies_id`, `time_administered`, `end_time`, `treatment_successful`, `treatment_notes`, `disaster_id`, `date_created`, `last_updated`, `user_id`)
				VALUES (NULL, '$victim[victimid]', '$treatment', '$field_pharmaceuticals_id[field_pharmaceuticals_id]', '$medical_supplies_id[medical_supplies_id]', '$start_time', '$end_time', '$success', '$treatment_notes, '70', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL)";

		mysqli_query($con,$insert2);

		echo "Enter more details";

		

}
?>