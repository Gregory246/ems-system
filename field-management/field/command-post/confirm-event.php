<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
//error_reporting(0);

$disaster_id = $_SESSION['disaster_id'];

if ($_GET["confirm_event"] == "1") {
	
	$confirm = 1;

	echo $confirm;


$update = "UPDATE `disaster` SET `confirm` = '$confirm' WHERE `disaster`.`disaster_id` = '$disaster_id' ";

	$query = mysqli_query($con,$update);

}

echo "Hello";

?>