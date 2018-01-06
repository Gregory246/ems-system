<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
$disaster_id = $_SESSION['disaster_id']; //From the home page of this domain

$branch_id = $_POST['branch_id']; //Branch ID of ICS for disaster
$employee_id = $_POST['employee_id'];//Employee selected from employee list, assigned to ICS
$employee_reportto_id = $_POST['employee_reportto_id'];//Commander

$insert = "	INSERT INTO `ics_structure` (`ics_structure_id`, `branch_id_FK`, `employee_id_FK`, `reports_to_id`, `date_created`, `updated`, `disaster_id`) 
			VALUES (NULL, '$branch_id', '$employee_id', '$employee_reportto_id', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '$disaster_id')";

	mysqli_query($con,$insert);

if (mysqli_affected_rows($con) > 0) {
	
	echo "	<script type='text/javascript'>

   			var conf = confirm('Assignee Logged. Click OK to proceed');
   				
   				if (conf != 'true') {
   				
   				window.open('http://localhost:85/ems/field-management/field/command-post/incident-command-system.php');
   				window.close();
 	 			}

		</script>";

} else {

	echo "	<script type='text/javascript'>

   			var conf = confirm('SORRY SOMETHING WENT WRONG PLEASE TRY AGAIN. Click OK to proceed');
   				
   				if (conf != 'true') {
   				
   				window.open('http://localhost:85/ems/field-management/field/command-post/incident-command-system.php');
   				window.close();
 	 			}

		</script>";
}



?>