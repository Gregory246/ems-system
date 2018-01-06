<?php 

//NOTES: ***TAKE THE FOLLOWING ACTION IN ORDER TO AVOID DUPLICATED DATA BEING STORED IN DATABASE FOR COORDINATES

session_start();
include_once('dbconnect.php');
//error_reporting(0);

$userid = $_SESSION['userid'];

 $latitude = utf8_encode($_GET['latitude']);
 $longitude = utf8_encode($_GET['longitude']);


//Selects the columns and trims additional 0's 
 $select1 = "SELECT TRIM(TRAILING '0' FROM latitude)latitude,TRIM(TRAILING '0' FROM longitude)longitude FROM geolocation ORDER BY geolocation_id DESC LIMIT 1";
 $query1 = mysqli_query($con,$select1);
 $coords = mysqli_fetch_assoc($query1);

 $previous_element = implode(",", $coords);


 $geo_array[] = "$latitude,$longitude";


$last_element = implode("", $geo_array);

//Compares last coordinates with previous coordinates to avoid data duplication
 if ($last_element == $previous_element) {
 	
 		echo "You're currently in the same location...";

 } else {

 		echo "Tracking...";

 	//First convert string to float in order to store the correct data type in the database table geolocation for it's coordinate values
 	$lat = $latitude;
 	$long = $longitude;

 	//Get the user_id of the session in progress
 	$select = "SELECT user_id FROM users WHERE username = '$userid' ";
 	$query = mysqli_query($con,$select);
 	$user_id = mysqli_fetch_assoc($query);


 	$insert = "INSERT INTO geolocation (geoLocation_id,latitude,longitude,user_id) VALUES (NULL,'$lat','$long','$user_id[user_id]')";
 	mysqli_query($con,$insert);

 }



?>