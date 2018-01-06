<?php	
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
$userid = $_SESSION['userid'];
$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 


//Get's User Id to obtian the vehicleteam of the user
$select_userid = "SELECT `user_id` FROM `users` WHERE `users`.`username` = '$userid' ";

	$query_userid = mysqli_query($con,$select_userid);

	$user_id = mysqli_fetch_assoc($query_userid);

$select = "SELECT employees.user_id, employees.employee_title, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.user_id = '$user_id[user_id]'";

	$query = mysqli_query($con,$select);

	$employee_title = mysqli_fetch_assoc($query);

	//echo implode(",", $employee_title);

	if ($employee_title['employee_title'] == "Ambulance Operator") {
	
	header("Location:http://$host/ems/field-management/ambulance/vehicle-operation/home-page.php");
	exit();

} elseif ($employee_title['employee_title'] == "Emergency Medical Technician") {
	
	header("Location:http://$host/ems/field-management/field/home-page.php");
	exit();

} elseif ($employee_title['employee_title'] == "Advance Emergency Medical Technician") {
	
	header("Location:http://$host/ems/field-management/ambulance/unit-lead/home-page.php");
	exit();

} elseif($employee_title['employee_title'] == "Wilderness Emergency Medical Technician") {

	header("Location:http://$host/ems/field-management/ambulance/unit-lead/home-page.php");
	exit();

} else {

	header("Location: http://$host/ems/field-management/field/access.php");
	exit();
	
}
?>