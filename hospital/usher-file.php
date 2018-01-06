<?php 
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 

$username = $_SESSION['userid'];

$select = "SELECT hospital_employees.user_id, hospital_employees.title, users.username 
			FROM hospital_employees JOIN users ON hospital_employees.user_id = users.user_id 
			WHERE users.username = '$username'";

	$query = mysqli_query($con,$select);

		$employee_title = mysqli_fetch_assoc($query);


if ($employee_title['title'] == "Emergency Communications Coordinator") {
	
	header("Location:http://$host/ems/hospital/communications/monitor-window.php");
	exit();

} elseif ($employee_title['title'] == "") {
	
	header("Location:http://$host/ems/hospital");
	exit();

} elseif ($employee_title['title'] == "") {
	
	header("Location:http://$host/ems/hospital");
	exit();

} elseif($employee_title['title'] == "") {

	header("Location:http://$host/ems/hospital");
	exit();
}

?>