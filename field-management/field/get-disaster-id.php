<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 

//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
//$userid = $_SESSION['userid'];

//$select4 = "SELECT employees.*, users.username 
//			FROM employees JOIN users ON employees.user_id = users.user_id 
//			WHERE users.username = '$userid'";

//	$query4 = mysqli_query($con,$select4);

//	$employee = mysqli_fetch_assoc($query4);

$location = $_POST['location'];


//*********this code gets the disaster ID associated with a particular location for that day so the ID can be associated with the victim**********//
	date_default_timezone_set("Etc/GMT+4");
      $date = date("Y-m-d");// Gets the current date of the local time server

$select = "SELECT disaster.*,location.*,disaster_location.*,CONCAT(location.addressline1,' ',location.addressline2,' ',location.city,' ',location.locality,' ',location.country) AS location 
			FROM disaster_location
                 JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id
                 JOIN location ON disaster_location.location_id = location.location_id
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

$_SESSION['disaster_id'] = $disaster_id['disaster_id']; //To be used in usher-file pointed at below and web-pages of serveral different users

header("Location: http://$host/ems/field-management/field/usher-file.php");
exit();

//***************************************************End***********************************************************//

?>