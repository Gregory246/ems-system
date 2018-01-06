<?php 
session_start();
include_once('dbconnect.php');

$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 

$userid = $_SESSION['userid'];

$select = "SELECT user_id FROM users WHERE username = '$userid' ";
$query = mysqli_query($con,$select);
$user_id = mysqli_fetch_assoc($query);

$select1 = "SELECT employee_title FROM employees WHERE employees.user_id = '$user_id[user_id]'";

$query1 = mysqli_query($con,$select1);
$employee_title = mysqli_fetch_assoc($query1);

if ($employee_title['employee_title'] == "Allocator") {
	
	header("Location: http://$host/ems/dispatch/allocator-contacts.php"); //Own Contacts page set up based on USE CASES
	exit();
}
elseif ($employee_title['employee_title'] == "Radio Dispatcher") {
	
	header("Location: http://$host/ems/dispatch/radio-dispatch-contacts.php"); //Own Contacts page set up based on USE CASES
	exit();
}
elseif ($employee_title['employee_title'] == "Telephone Dispatcher") {
	
	header("Location: http://$host/ems/dispatch/telephone-dispatch-contacts.php"); //Own Contacts page set up based on USE CASES
	exit();
}else{

	header("Location: http://$host/ems/dispatch/home-page.php"); //Own Contacts page set up based on USE CASES
	exit();
}
?>