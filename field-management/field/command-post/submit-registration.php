<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

$userid = $_SESSION['userid'];


//Get's User Id 
$select_userid = "SELECT `user_id` FROM `users` WHERE `users`.`username` = '$userid' ";

$query_userid = mysqli_query($con,$select_userid);

	$user_id = mysqli_fetch_assoc($query_userid);



if (empty($_POST['agency_type'])) {/***********IF USER DOESN'T NEED TO REGISTER NEW AGENCY****************/
	
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$employee_title = $_POST['employee_title'];
	$employee_field = $_POST['employee_field'];
	$role = $_POST['role'];
	$tele = $_POST['tele'];
	$cell = $_POST['cell'];
	$email = $_POST['email'];

	$agency_name = $_POST['agency_name'];
	$department_name = $_POST['department_name'];


	//$ = $_POST[''];

	$strtolowercase = strtolower($fname); //Converts to lower case

	$strlength = strlen($strtolowercase);//Gets the length of the string

	//Prepares the string to Username and then logs the user, employee, department, agency details in database

	if ($strlength > 4) { /*******************************CHECKS ON USERNAME GREATER THAN LENGTH OF 4***************/
		
		$username = substr($strtolowercase, 0, 4); 
		$count = 0;

		$select = "SELECT * FROM `users`";
			$query = mysqli_query($con,$select);
			$users = mysqli_fetch_assoc($query);

		do {

				if ($username == $users['username']) {
					$digit = $count++;

					$username1 = substr($username, 0, 3).$digit;

				} else {

					$username1 = $username;
				}

			} while ($users = mysqli_fetch_assoc($query));	

			$insert = "INSERT INTO `users` (`user_id`, `username`, `loginid`, `tier_level_id_FK`,`user_parent_id`) 
						VALUES (NULL, '$username1', '1234', '4','$user_id[user_id]')";

				mysqli_query($con,$insert);


			$select1 = "SELECT * FROM `users` WHERE `user_parent_id` ='$user_id[user_id]' ORDER BY `user_id`  DESC LIMIT 1";

				$query1 = mysqli_query($con,$select1);

				$user_id1 = mysqli_fetch_assoc($query1);


			$insert1 = "INSERT INTO `employees` (`employee_id`, `user_id`, `employee_fname`, `employee_lname`, `employee_title`, `employee_field`, `employee_role`, `employee_tele`, `employee_cell`, `employee_email`, `create_date`, `Last_update`) 
						VALUES (NULL, '$user_id1[user_id]', '$fname', '$lname', '$employee_title', '$employee_field', '$role', '$tele', '$cell', '$email', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

				mysqli_query($con,$insert1);
				

			$select2 = "SELECT * FROM `employees` WHERE `user_id` = '$user_id1[user_id]' ";

				$query2 = mysqli_query($con,$select2);

				$employee = mysqli_fetch_assoc($query2);


			$insert2 = "INSERT INTO `employees_department_junc` (`employee_department_junc_id`, `employee_FK_id`, `department_FK_id`) 
						VALUES (NULL, '$employee[employee_id]', '$department_name')";

				mysqli_query($con,$insert2);


				if (mysqli_affected_rows($con) > 0) {
	
						echo "	<script type='text/javascript'>

					   			var conf = confirm('Personnel Registered. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";

					} else {

						echo "	<script type='text/javascript'>

					   			var conf = confirm('SORRY SOMETHING WENT WRONG PLEASE TRY AGAIN. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";
					}



	} elseif($strlength == 4) { /************************CHECKS ON USERNAME BEING LENGTH OF FOUR***************/

		$username = $strtolowercase;

		$count = 0;

		$select = "SELECT * FROM `users`";
			$query = mysqli_query($con,$select);
			$users = mysqli_fetch_assoc($query);

		do {

				if ($username == $users['username']) {
					$digit = $count++;

					$username1 = substr($username, 0, 3).$digit;

				} else {

					$username1 = $username;
				}

			} while ($users = mysqli_fetch_assoc($query));	

			$insert = "INSERT INTO `users` (`user_id`, `username`, `loginid`, `tier_level_id_FK`,`user_parent_id`) 
						VALUES (NULL, '$username1', '1234', '4','$user_id[user_id]')";

				mysqli_query($con,$insert);


			$select1 = "SELECT * FROM `users` WHERE `user_parent_id` ='$user_id[user_id]' ORDER BY `user_id`  DESC LIMIT 1";

				$query1 = mysqli_query($con,$select1);

				$user_id1 = mysqli_fetch_assoc($query1);


			$insert1 = "INSERT INTO `employees` (`employee_id`, `user_id`, `employee_fname`, `employee_lname`, `employee_title`, `employee_field`, `employee_role`, `employee_tele`, `employee_cell`, `employee_email`, `create_date`, `Last_update`) 
						VALUES (NULL, '$user_id1[user_id]', '$fname', '$lname', '$employee_title', '$employee_field', '$role', '$tele', '$cell', '$email', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

				mysqli_query($con,$insert1);
				

			$select2 = "SELECT * FROM `employees` WHERE `user_id` = '$user_id1[user_id]' ";

				$query2 = mysqli_query($con,$select2);

				$employee = mysqli_fetch_assoc($query2);


			$insert2 = "INSERT INTO `employees_department_junc` (`employee_department_junc_id`, `employee_FK_id`, `department_FK_id`) 
						VALUES (NULL, '$employee[employee_id]', '$department_name')";

				mysqli_query($con,$insert2);


				if (mysqli_affected_rows($con) > 0) {
	
						echo "	<script type='text/javascript'>

					   			var conf = confirm('Personnel Registered. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";

					} else {

						echo "	<script type='text/javascript'>

					   			var conf = confirm('SORRY SOMETHING WENT WRONG PLEASE TRY AGAIN. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";
					}

		

	} else { /**********************IF USERNAME IS LESS THAN LENGTH OF FOUR************************/

		$count = 0;

		$username = $strtolowercase.$count;

		
		$select = "SELECT * FROM `users`";
			$query = mysqli_query($con,$select);
			$users = mysqli_fetch_assoc($query);

		do {

				if ($username == $users['username']) {
					$digit = $count++;

					$username1 = substr($username, 0, 3).$digit;

				} else {

					$username1 = $username;
				}

			} while ($users = mysqli_fetch_assoc($query));	

			$insert = "INSERT INTO `users` (`user_id`, `username`, `loginid`, `tier_level_id_FK`,`user_parent_id`) 
						VALUES (NULL, '$username1', '1234', '4','$user_id[user_id]')";

				mysqli_query($con,$insert);


			$select1 = "SELECT * FROM `users` WHERE `user_parent_id` ='$user_id[user_id]' ORDER BY `user_id`  DESC LIMIT 1";

				$query1 = mysqli_query($con,$select1);

				$user_id1 = mysqli_fetch_assoc($query1);


			$insert1 = "INSERT INTO `employees` (`employee_id`, `user_id`, `employee_fname`, `employee_lname`, `employee_title`, `employee_field`, `employee_role`, `employee_tele`, `employee_cell`, `employee_email`, `create_date`, `Last_update`) 
						VALUES (NULL, '$user_id1[user_id]', '$fname', '$lname', '$employee_title', '$employee_field', '$role', '$tele', '$cell', '$email', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

				mysqli_query($con,$insert1);
				

			$select2 = "SELECT * FROM `employees` WHERE `user_id` = '$user_id1[user_id]' ";

				$query2 = mysqli_query($con,$select2);

				$employee = mysqli_fetch_assoc($query2);


			$insert2 = "INSERT INTO `employees_department_junc` (`employee_department_junc_id`, `employee_FK_id`, `department_FK_id`) 
						VALUES (NULL, '$employee[employee_id]', '$department_name')";

				mysqli_query($con,$insert2);


				if (mysqli_affected_rows($con) > 0) {
	
						echo "	<script type='text/javascript'>

					   			var conf = confirm('Personnel Registered. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";

					} else {

						echo "	<script type='text/javascript'>

					   			var conf = confirm('SORRY SOMETHING WENT WRONG PLEASE TRY AGAIN. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";
					}

	}


}else { /***********OTHERWISE IF USER DOES NEED TO REGISTER NEW AGENCY****************/

	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$employee_title = $_POST['employee_title'];
	$employee_field = $_POST['employee_field'];
	$role = $_POST['role'];
	$tele = $_POST['tele'];
	$cell = $_POST['cell'];
	$email = $_POST['email'];

	$agency_name = $_POST['agency_name'];
	$agency_type = $_POST['agency_type'];
	$agency_role = $_POST['agency_role'];
	$agency_tele = $_POST['agency_tele'];
	$agency_fax = $_POST['agency_fax'];
	$agency_email = $_POST['agency_email'];
	$agency_url = $_POST['agency_url'];


	$department_name = $_POST['department_name'];

		$strtolowercase = strtolower($fname); //Converts to lower case

	$strlength = strlen($strtolowercase);//Gets the length of the string

	//Prepares the string to Username and then logs the user, employee, department, agency details in database

	if ($strlength > 4) { /*******************************CHECKS ON USERNAME GREATER THAN LENGTH OF 4***************/
		
		$username = substr($strtolowercase, 0, 4); 
		$count = 0;

		$select = "SELECT * FROM `users`";
			$query = mysqli_query($con,$select);
			$users = mysqli_fetch_assoc($query);

		do {

				if ($username == $users['username']) {
					$digit = $count++;

					$username1 = substr($username, 0, 3).$digit;

				} else {

					$username1 = $username;
				}

			} while ($users = mysqli_fetch_assoc($query));	

			$insert = "INSERT INTO `users` (`user_id`, `username`, `loginid`, `tier_level_id_FK`,`user_parent_id`) 
						VALUES (NULL, '$username1', '1234', '4','$user_id[user_id]')";

				mysqli_query($con,$insert);


			$select1 = "SELECT * FROM `users` WHERE `user_parent_id` ='$user_id[user_id]' ORDER BY `user_id`  DESC LIMIT 1";

				$query1 = mysqli_query($con,$select1);

				$user_id1 = mysqli_fetch_assoc($query1);

			$insert3 = "INSERT INTO `agency` (`agency_id`, `agency_name`, `agency_type`, `agency_field`, `agency_role`, `agency_tele`, `agency_fax`, `agency_email`, `agency_webpage`, `user_id`) 
						VALUES (NULL, '$agency_name', '$agency_type', '$agency_field', '$agency_role', '$agency_tele', '$agency_fax', '$agency_email', '$agency_url', '$user_id[user_id]')";

				mysqli_query($con,$insert3);

			$select3 = "SELECT * FROM `agency` WHERE `agency`.`user_id` = '$user_id[user_id]' ORDER BY `agency`.`agency_id`  DESC LIMIT 1 ";

				$query3 = mysqli_query($con,$select3);

				$agency = mysqli_fetch_assoc($query3);

			$insert4 = "INSERT INTO `department` (`department_id`, `department_name`, `department_fax`, `agency_id`, `user_id`) 
						VALUES (NULL, '$department_name', NULL, '$agency[agency_id]', '$user_id[user_id]')";

				mysqli_query($con,$insert4);

			$select4 = "SELECT * FROM `department` WHERE `user_id` = '$user_id[user_id]' ORDER BY `department`.`department_id`  DESC LIMIT 1 ";

				$query4 = mysqli_query($con,$select4);

				$department = mysqli_fetch_assoc($query4);


			$insert1 = "INSERT INTO `employees` (`employee_id`, `user_id`, `employee_fname`, `employee_lname`, `employee_title`, `employee_field`, `employee_role`, `employee_tele`, `employee_cell`, `employee_email`, `create_date`, `Last_update`) 
						VALUES (NULL, '$user_id1[user_id]', '$fname', '$lname', '$employee_title', '$employee_field', '$role', '$tele', '$cell', '$email', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

				mysqli_query($con,$insert1);
				

			$select2 = "SELECT * FROM `employees` WHERE `user_id` = '$user_id1[user_id]' ";

				$query2 = mysqli_query($con,$select2);

				$employee = mysqli_fetch_assoc($query2);


			$insert2 = "INSERT INTO `employees_department_junc` (`employee_department_junc_id`, `employee_FK_id`, `department_FK_id`) 
						VALUES (NULL, '$employee[employee_id]', '$department[department_id]')";

				mysqli_query($con,$insert2);


				if (mysqli_affected_rows($con) > 0) {
	
						echo "	<script type='text/javascript'>

					   			var conf = confirm('Personnel Registered. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";

					} else {

						echo "	<script type='text/javascript'>

					   			var conf = confirm('SORRY SOMETHING WENT WRONG PLEASE TRY AGAIN. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";
					}



	} elseif($strlength == 4) { /************************CHECKS ON USERNAME BEING LENGTH OF FOUR***************/

		$username = $strtolowercase;

		$count = 0;

		$select = "SELECT * FROM `users`";
			$query = mysqli_query($con,$select);
			$users = mysqli_fetch_assoc($query);

		do {

				if ($username == $users['username']) {
					$digit = $count++;

					$username1 = substr($username, 0, 3).$digit;

				} else {

					$username1 = $username;
				}

			} while ($users = mysqli_fetch_assoc($query));	

			$insert = "INSERT INTO `users` (`user_id`, `username`, `loginid`, `tier_level_id_FK`,`user_parent_id`) 
						VALUES (NULL, '$username1', '1234', '4','$user_id[user_id]')";

				mysqli_query($con,$insert);


			$select1 = "SELECT * FROM `users` WHERE `user_parent_id` ='$user_id[user_id]' ORDER BY `user_id`  DESC LIMIT 1";

				$query1 = mysqli_query($con,$select1);

				$user_id1 = mysqli_fetch_assoc($query1);

			$insert3 = "INSERT INTO `agency` (`agency_id`, `agency_name`, `agency_type`, `agency_field`, `agency_role`, `agency_tele`, `agency_fax`, `agency_email`, `agency_webpage`, `user_id`) 
						VALUES (NULL, '$agency_name', '$agency_type', '$agency_field', '$agency_role', '$agency_tele', '$agency_fax', '$agency_email', '$agency_url', '$user_id[user_id]')";

				mysqli_query($con,$insert3);

			$select3 = "SELECT * FROM `agency` WHERE `agency`.`user_id` = '$user_id[user_id]' ORDER BY `agency`.`agency_id`  DESC LIMIT 1 ";

				$query3 = mysqli_query($con,$select3);

				$agency = mysqli_fetch_assoc($query3);

			$insert4 = "INSERT INTO `department` (`department_id`, `department_name`, `department_fax`, `agency_id`, `user_id`) 
						VALUES (NULL, '$department_name', NULL, '$agency[agency_id]', '$user_id[user_id]')";

				mysqli_query($con,$insert4);

			$select4 = "SELECT * FROM `department` WHERE `user_id` = '$user_id[user_id]' ORDER BY `department`.`department_id`  DESC LIMIT 1 ";

				$query4 = mysqli_query($con,$select4);

				$department = mysqli_fetch_assoc($query4);


			$insert1 = "INSERT INTO `employees` (`employee_id`, `user_id`, `employee_fname`, `employee_lname`, `employee_title`, `employee_field`, `employee_role`, `employee_tele`, `employee_cell`, `employee_email`, `create_date`, `Last_update`) 
						VALUES (NULL, '$user_id1[user_id]', '$fname', '$lname', '$employee_title', '$employee_field', '$role', '$tele', '$cell', '$email', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

				mysqli_query($con,$insert1);
				

			$select2 = "SELECT * FROM `employees` WHERE `user_id` = '$user_id1[user_id]' ";

				$query2 = mysqli_query($con,$select2);

				$employee = mysqli_fetch_assoc($query2);


			$insert2 = "INSERT INTO `employees_department_junc` (`employee_department_junc_id`, `employee_FK_id`, `department_FK_id`) 
						VALUES (NULL, '$employee[employee_id]', '$department[department_id]')";

				mysqli_query($con,$insert2);


				if (mysqli_affected_rows($con) > 0) {
	
						echo "	<script type='text/javascript'>

					   			var conf = confirm('Personnel Registered. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";

					} else {

						echo "	<script type='text/javascript'>

					   			var conf = confirm('SORRY SOMETHING WENT WRONG PLEASE TRY AGAIN. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";
					}

		

	} else { /**********************IF USERNAME IS LESS THAN LENGTH OF FOUR************************/

		$count = 0;

		$username = $strtolowercase.$count;

		
		$select = "SELECT * FROM `users`";
			$query = mysqli_query($con,$select);
			$users = mysqli_fetch_assoc($query);

		do {

				if ($username == $users['username']) {
					$digit = $count++;

					$username1 = substr($username, 0, 3).$digit;

				} else {

					$username1 = $username;
				}

			} while ($users = mysqli_fetch_assoc($query));	

			$insert = "INSERT INTO `users` (`user_id`, `username`, `loginid`, `tier_level_id_FK`,`user_parent_id`) 
						VALUES (NULL, '$username1', '1234', '4','$user_id[user_id]')";

				mysqli_query($con,$insert);


			$select1 = "SELECT * FROM `users` WHERE `user_parent_id` ='$user_id[user_id]' ORDER BY `user_id`  DESC LIMIT 1";

				$query1 = mysqli_query($con,$select1);

				$user_id1 = mysqli_fetch_assoc($query1);

			$insert3 = "INSERT INTO `agency` (`agency_id`, `agency_name`, `agency_type`, `agency_field`, `agency_role`, `agency_tele`, `agency_fax`, `agency_email`, `agency_webpage`, `user_id`) 
						VALUES (NULL, '$agency_name', '$agency_type', '$agency_field', '$agency_role', '$agency_tele', '$agency_fax', '$agency_email', '$agency_url', '$user_id[user_id]')";

				mysqli_query($con,$insert3);

			$select3 = "SELECT * FROM `agency` WHERE `agency`.`user_id` = '$user_id[user_id]' ORDER BY `agency`.`agency_id`  DESC LIMIT 1 ";

				$query3 = mysqli_query($con,$select3);

				$agency = mysqli_fetch_assoc($query3);

			$insert4 = "INSERT INTO `department` (`department_id`, `department_name`, `department_fax`, `agency_id`, `user_id`) 
						VALUES (NULL, '$department_name', NULL, '$agency[agency_id]', '$user_id[user_id]')";

				mysqli_query($con,$insert4);

			$select4 = "SELECT * FROM `department` WHERE `user_id` = '$user_id[user_id]' ORDER BY `department`.`department_id`  DESC LIMIT 1 ";

				$query4 = mysqli_query($con,$select4);

				$department = mysqli_fetch_assoc($query4);


			$insert1 = "INSERT INTO `employees` (`employee_id`, `user_id`, `employee_fname`, `employee_lname`, `employee_title`, `employee_field`, `employee_role`, `employee_tele`, `employee_cell`, `employee_email`, `create_date`, `Last_update`) 
						VALUES (NULL, '$user_id1[user_id]', '$fname', '$lname', '$employee_title', '$employee_field', '$role', '$tele', '$cell', '$email', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

				mysqli_query($con,$insert1);
				

			$select2 = "SELECT * FROM `employees` WHERE `user_id` = '$user_id1[user_id]' ";

				$query2 = mysqli_query($con,$select2);

				$employee = mysqli_fetch_assoc($query2);


			$insert2 = "INSERT INTO `employees_department_junc` (`employee_department_junc_id`, `employee_FK_id`, `department_FK_id`) 
						VALUES (NULL, '$employee[employee_id]', '$department[department_id]')";

				mysqli_query($con,$insert2);


				if (mysqli_affected_rows($con) > 0) {
	
						echo "	<script type='text/javascript'>

					   			var conf = confirm('Personnel Registered. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";

					} else {

						echo "	<script type='text/javascript'>

					   			var conf = confirm('SORRY SOMETHING WENT WRONG PLEASE TRY AGAIN. Click OK to proceed');
					   				
					   				if (conf != 'true') {
					   				
					   				window.open('http://localhost:85/ems/field-management/field/operations-section/home-page.php');
					   				window.close();
					 	 			}

							</script>";
					}



} //THE END

}

?>