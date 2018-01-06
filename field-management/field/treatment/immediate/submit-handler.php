<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 

//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
//$userid = $_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = 'jess'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);



if ($_POST['submit'] == "request") {
	
	$priority = $_POST['priority'];
	$purpose = $_POST['purpose'];
	$note = $_POST['note'];

	if (empty($note)) {
		
		$insert = "INSERT INTO `request` (`request_id`, `request_type_id`, `priority`, `status`, `purpose`, `note`, `authorized_by`, `external`, `domain`, `date_created`, `last_updated`, `user_id`) 
					VALUES (NULL, '11', '$priority', '0', '$purpose', NULL, '$employee[employee_id]', '0', 'MINOR-TREATMENT', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL)";

			mysqli_query($con,$insert);

		echo "Request Sent!";

	} else {

		$insert = "INSERT INTO `request` (`request_id`, `request_type_id`, `priority`, `status`, `purpose`, `note`, `authorized_by`, `external`, `domain`, `date_created`, `last_updated`, `user_id`) 
					VALUES (NULL, '11', '$priority', '0', '$purpose', '$note', '$employee[employee_id]', '0', 'MINOR-TREATMENT', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL)";

			mysqli_query($con,$insert);

		echo "Request Sent!";
	}


} elseif ($_POST['submit'] == "establish") {

	$team_member1 = $_POST['team_member1'];
	$team_member2 = $_POST['team_member2'];
	$team_member3 = $_POST['team_member3']; //$disaster_id
	
	echo $team_member1."|".$team_member2."|".$team_member3;

		$insert = "INSERT INTO `ics_structure` (`ics_structure_id`, `branch_id_FK`, `employee_id_FK`, `reports_to_id`, `date_created`, `updated`, `disaster_id`) 
			VALUES (NULL, '22', '$team_member1','13', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$disaster_id')";

			mysqli_query($con,$insert);

		$insert1 = "INSERT INTO `ics_structure` (`ics_structure_id`, `branch_id_FK`, `employee_id_FK`, `reports_to_id`, `date_created`, `updated`, `disaster_id`) 
			VALUES (NULL, '22', '$team_member2', '13', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$disaster_id')";

			mysqli_query($con,$insert1);

		$insert2 = "INSERT INTO `ics_structure` (`ics_structure_id`, `branch_id_FK`, `employee_id_FK`, `reports_to_id`, `date_created`, `updated`, `disaster_id`) 
			VALUES (NULL, '22', '$team_member3', '13', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$disaster_id')";

			$query = mysqli_query($con,$insert2);


}





//header("Location: http://$host/ems/field-management/field/treatment/minor/home-page.php");
//exit();
?>