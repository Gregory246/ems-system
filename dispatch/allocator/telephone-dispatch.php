<?php

session_start();
include_once('dbconnect.php');
//error_reporting(0);

$userid = $_SESSION['userid'];

//From allocators google-directions
 $agency_name = $_GET['agency_name'];
 $addressline1 = $_GET['addressline1'];
 $addressline2 = $_GET['addressline2'];
 $locality = $_GET['locality'];
 $city = $_GET['city'];
 $country = $_GET['country'];

 $agency_name1 = $_GET['agency_name1'];
 $addressline11 = $_GET['addressline11'];
 $addressline21 = $_GET['addressline21'];
 $locality1 = $_GET['locality1'];
 $city1 = $_GET['city1'];
 $country1 = $_GET['country1'];

 $team_type = $_GET['team_type'];
 $life_support = $_GET['life_support'];
 $operator = $_GET['operator'];
 $assistant = $_GET['assistant'];
 $emt = $_GET['emt'];
 $ademt = $_GET['ademt'];
 $para = $_GET['para'];
 $adpara = $_GET['adpara'];
 $wtech = $_GET['wtech'];
 $vehicleteam_id = $_GET['vehicleteam_id'];

$select0 = "SELECT facility_id FROM facility WHERE name = '$agency_name' OR name = '$agency_name1' ";
$query0 = mysqli_query($con,$select0);
$row = mysqli_fetch_assoc($query0);

//$min = min($row);
//$max = max($row);



//$select = "SELECT facility_id FROM facility WHERE name = '$agency_name'";
//$query = mysqli_query($con,$select);
//$agency_id = mysqli_fetch_assoc($query);

//$select1 = "SELECT facility_id FROM facility WHERE name = '$agency_name1'";
//$query1 = mysqli_query($con,$select1);
//$agency1_id = mysqli_fetch_assoc($query1);

$select2 = "SELECT user_id FROM users WHERE username = '$userid' ";
$query2 = mysqli_query($con,$select2);
$user_id = mysqli_fetch_assoc($query2);


do{
$insert = "INSERT INTO `hospital_vehicle_availability` (`hospital_vehicle_availability_id`, `type`, `status`, `date_time`, `updated_by`, `stage`, `user_id`) 
			VALUES (NULL, '1', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '1', '$user_id[user_id]')";

mysqli_query($con,$insert);

	$total[] = implode("", $row);

}while($row = mysqli_fetch_assoc($query0));

$min = min($total);

$max = max($total);

echo $min;
echo $max;

$select3 = "SELECT hospital_vehicle_availability_id FROM hospital_vehicle_availability WHERE user_id = '$user_id[user_id]' AND type = 1 ORDER BY hospital_vehicle_availability_id DESC LIMIT 2";
$query3 = mysqli_query($con,$select3);
mysqli_data_seek($query3,0);
$hospital_vehicle_availability_H1_id = mysqli_fetch_assoc($query3);

$_SESSION['hospital_vehicle_availability_H1_id'] = $hospital_vehicle_availability_H1_id['hospital_vehicle_availability_id']; //use in tele and radio update

//echo $hospital_vehicle_availability_H1_id['hospital_vehicle_availability_id'];

$select31 = "SELECT hospital_vehicle_availability_id FROM hospital_vehicle_availability WHERE user_id = '$user_id[user_id]' AND type = 1 ORDER BY hospital_vehicle_availability_id DESC LIMIT 2";
$query31 = mysqli_query($con,$select31);
mysqli_data_seek($query31,1);
$hospital_vehicle_availability_H2_id = mysqli_fetch_assoc($query31);

$_SESSION['hospital_vehicle_availability_H2_id'] = $hospital_vehicle_availability_H2_id['hospital_vehicle_availability_id'];//use in tele and radio update		

$insert1 = "INSERT INTO hospital_availability_junc (hospital_availability_junc_id,facility_id,hospital_vehicle_availability_id)
			VALUES (NULL,'$min','$hospital_vehicle_availability_H1_id[hospital_vehicle_availability_id]')";

		mysqli_query($con,$insert1);

$insert11 = "INSERT INTO hospital_availability_junc (hospital_availability_junc_id,facility_id,hospital_vehicle_availability_id)
			VALUES (NULL,'$max','$hospital_vehicle_availability_H2_id[hospital_vehicle_availability_id]')";

		mysqli_query($con,$insert11);		



$insert4 = "INSERT INTO `hospital_vehicle_availability` (`hospital_vehicle_availability_id`, `type`, `status`, `date_time`, `updated_by`, `stage`, `user_id`) 
			VALUES (NULL, '0', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '1', '$user_id[user_id]')";
mysqli_query($con,$insert4);

$select4 = "SELECT hospital_vehicle_availability_id FROM hospital_vehicle_availability WHERE user_id = '$user_id[user_id]' AND type = 0 ORDER BY hospital_vehicle_availability_id DESC LIMIT 1";
$query4 = mysqli_query($con,$select4);
$hospital_vehicle_availability_V_id = mysqli_fetch_assoc($query4);

$_SESSION['hospital_vehicle_availability_V_id'] = $hospital_vehicle_availability_V_id['hospital_vehicle_availability_id'];

$insert2 = "INSERT INTO vehicleteam_availabilty_junc (vehicleteam_availabilty_junc_id,vehicleteam_id,hospital_vehicle_availability_id)
			VALUES (NULL,'$vehicleteam_id','$hospital_vehicle_availability_V_id[hospital_vehicle_availability_id]')"; 

mysqli_query($con,$insert2);

echo "Telephone Dispatcher Prompted!";

echo "<br>";

echo "<button id= 'button' onclick = 'window.close()'>Close Window!</button>";


?>