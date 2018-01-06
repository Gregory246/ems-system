<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 

//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
//$userid = $_SESSION['userid'];

$disaster_id = $_SESSION['disaster_id'];
$userid = $_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = '$userid'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);



if ($_POST['submit'] == "request") {
	
	echo $priority = $_POST['priority'];
	echo $purpose = $_POST['purpose'];
	echo $note = $_POST['note'];
	echo $request_type_id = $_POST['request_type_id'];


	if (empty($note)) {
		
		$insert = "INSERT INTO `request` (`request_id`, `request_type_id`, `priority`, `status`, `purpose`, `note`, `authorized_by`, `external`, `domain`, `date_created`, `last_updated`, `user_id`) 
					VALUES (NULL, '$request_type_id', '$priority', '0', '$purpose', NULL, '$employee[employee_id]', '0', 'MINOR-TREATMENT', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL)";

			mysqli_query($con,$insert);

						if(mysqli_affected_rows($con) > 0){

							echo "	<script type='text/javascript'>

					   			var conf = confirm('Request Logged. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://$host/ems/field-management/field/treatment/minor/home-page.php');
					   				window.close();
					 	 			}

							</script>";
						} else {
							
							echo "	<script type='text/javascript'>

					   			var conf = confirm('Sorry Request failed please try again. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://$host/ems/field-management/field/treatment/minor/home-page.php');
					   				window.close();
					 	 			}

							</script>";							

						}

	} else {


$insert = "INSERT INTO `request` (`request_id`, `request_type_id`, `priority`, `status`, `purpose`, `note`, `authorized_by`, `external`, `domain`, `date_created`, `last_updated`, `user_id`) 
			VALUES (NULL, '$request_type_id', '$priority', '0', '$purpose', '$note', '$employee[employee_id]', '0', 'MINOR-TREATMENT', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, NULL)";

			mysqli_query($con,$insert);

						if(mysqli_affected_rows($con) > 0){

							echo "	<script type='text/javascript'>

					   			var conf = confirm('Request Logged. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://$host/ems/field-management/field/treatment/minor/home-page.php');
					   				window.close();
					 	 			}

							</script>";
						} else {
							
							echo "	<script type='text/javascript'>

					   			var conf = confirm('Sorry Request failed please try again. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://$host/ems/field-management/field/treatment/minor/home-page.php');
					   				window.close();
					 	 			}

							</script>";

						}
	}//


}//

?>