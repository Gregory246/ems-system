<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
$userid = "davi"; //$_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = '$userid'";

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);


$fname = $_GET['fname'];
$lname = $_GET['lname'];
$age = $_GET['age'];
$sex = $_GET['sex'];
$doa = $_GET['doa'];
$victim_class = $_GET['victim_class'];
$location = $_GET['location'];
$uniqID = $_GET['uniqID'];

//*********this code gets the disaster ID associated with a particular location for that day so the ID can be associated with the victim**********//
	date_default_timezone_set("Etc/GMT+4");
      $date = date("Y-m-d");// Gets the current date of the local time server

$select = "SELECT disaster.*,location.*,disaster_location.*,CONCAT(location.addressline1,' ',location.addressline2,' ',location.city,' ',location.locality,' ',location.country) AS location 
			FROM disaster_location
                 JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id
                 JOIN location ON disaster_location.location_id = location.location_id";
                 WHERE date(disaster.date_time) = '$date'";

   $query = mysqli_query($con,$select);

   $id = mysqli_fetch_assoc($query);

   do {
   	
   	$location_array[] = $id['location'];

   } while ( $id = mysqli_fetch_assoc($query));

   //print_r($location_array);

while ($check = current($location_array)) {
	
	if ($check == $location) {
		
		$key = key($location_array);
		//echo $key;
	}

	next($location_array);
}

$query1 = mysqli_query($con,$select);

mysqli_data_seek($query1,$key);

$disaster_id = mysqli_fetch_assoc($query1);

//***************************************************End***********************************************************//

	$insert = "INSERT INTO `victim` (`victimid`, `victim_unique_key_id`, `victim_fname`, `victim_lname`, `victim_age`, `victim_sex`, `victim_doa`, `smart_tag_num`, `on_site_triage_tag`, `on_site_triage_personnel`, `medical_triage_tag`, `start_triage_id`, `treatment_personnel`, `treatment_received`, `evacuation_triage_tag`, `evacuation_triage_personnel`, `dispatch_priority`, `dispatch_ready`, `scene_sizeup_id`, `disaster_id`, `victim_MR_FK`, `transit_status`, `facility_id`, `in_patient_id`, `date_created`, `last_updated`, `user_id`) 
				VALUES (NULL, '$uniqID', '$fname', '$lname', '$age', '$sex', '$doa', NULL, '$victim_class', '$employee[employee_id]', NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '$disaster_id[disaster_id]', NULL, '0', NULL, NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL)";

	   mysqli_query($con,$insert);

if (mysqli_affected_rows($con) >0) {
	
	echo "Victim Classified";
} else {

	echo "Sorry something went wrong please log details again!";
}

?>