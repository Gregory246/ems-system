<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//error_reporting(0);
$userid = $_SESSION['userid'];

//Get's User Id to obtian the vehicleteam of the user
$select_userid = "SELECT `user_id` FROM `users` WHERE `users`.`username` = '$userid' ";

	$query_userid = mysqli_query($con,$select_userid);

	$user_id = mysqli_fetch_assoc($query_userid);


$select1 = "SELECT `employees`.*, CONCAT(employee_fname,' ',employee_lname)employee_name FROM `employees` WHERE `employees`.`employee_title` = 'Medical Staff' ";

	$query1 = mysqli_query($con,$select1);


	$employee = mysqli_fetch_assoc($query1);

	

//Gets the most recent Disaster Event ID
$disaster_id = $_SESSION['disaster_id'];

//This selects any possible employee who's employee_title maye have been registered as Medical Staff within the ICS_Structure
$select2 = "SELECT * FROM `ics_structure` 
			WHERE `ics_structure`.`disaster_id` = '$disaster_id' 
			AND 
			(      `ics_structure`.`branch_id_FK` = 21 
				OR `ics_structure`.`branch_id_FK` = 22 
				OR `ics_structure`.`branch_id_FK` = 23 
				OR `ics_structure`.`branch_id_FK` = 19 
				OR `ics_structure`.`branch_id_FK` = 24 
				OR `ics_structure`.`branch_id_FK` = 16 
				OR `ics_structure`.`branch_id_FK` = 15 
				OR `ics_structure`.`branch_id_FK` = 14 
				OR `ics_structure`.`branch_id_FK` = 13 
				OR `ics_structure`.`branch_id_FK` = 12 
				OR `ics_structure`.`branch_id_FK` = 11 
				OR `ics_structure`.`branch_id_FK` = 9
			) ";

	$query2 = mysqli_query($con,$select2);

	$ics_structure = mysqli_fetch_assoc($query2);	

//DUMPS ALL VALUES INTO ARRAY
do {

		$employee_id_FK[] = $ics_structure['employee_id_FK'];
	
} while ( $ics_structure = mysqli_fetch_assoc($query2));



//DUMPS ALL VALUES INTO ARRAY
do {

		$employee_id[] = $employee['employee_id'];
	
} while ( $employee = mysqli_fetch_assoc($query1));


//Check for matches and return the difference
$medicalteam = array_diff($employee_id, $employee_id_FK);

$medicalteam0 = current($medicalteam);
				next($medicalteam);
$medicalteam1 = current($medicalteam);
				next($medicalteam);
$medicalteam2 = current($medicalteam);
//*******************************************


$select3 = "SELECT `employees`.*, CONCAT(employee_fname,' ',employee_lname)employee_name FROM `employees` WHERE `employees`.`employee_id` = '$medicalteam0' ";

	$query3 = mysqli_query($con,$select3);

	$team_member1 = mysqli_fetch_assoc($query3);


$select4 = "SELECT `employees`.*, CONCAT(employee_fname,' ',employee_lname)employee_name FROM `employees` WHERE `employees`.`employee_id` = '$medicalteam1' ";

	$query4 = mysqli_query($con,$select4);

	$team_member2 = mysqli_fetch_assoc($query4);	


$select5 = "SELECT `employees`.*, CONCAT(employee_fname,' ',employee_lname)employee_name FROM `employees` WHERE `employees`.`employee_id` = '$medicalteam2' ";

	$query5 = mysqli_query($con,$select5);

	$team_member3 = mysqli_fetch_assoc($query5);



		
		echo "<strong>"."<div style = 'color:red' >"."Treatment Teams Generated:"."</div>"."</strong>"; 

		echo "<form method = 'POST' action = 'submit-handler.php' target = '_blank'>";

			
				echo"
		 		<label><strong>Minor Treatment Team:</strong></label>

		 		<table id = 'mytable' border = 1>
			        <tr>
			          <th>Member I</th>
			          <th>Member II</th>
			          <th>Member III</th>
			        </tr>
			        <tr>
			          <td><input type='text' id='' name='' value=".$team_member1['employee_name']." disabled></td>
			          <td><input type='text' id='' name='' value=".$team_member2['employee_name']." disabled></td>
			          <td><input type='text' id='' name='' value=".$team_member3['employee_name']." disabled></td>
			        </tr>";

     				echo" </table>";

     				echo "<input type='text' id='team_member1' name='team_member1' value=".$team_member1['employee_id']." hidden>
				          <input type='text' id='team_member2' name='team_member2' value=".$team_member2['employee_id']." hidden>
				          <input type='text' id='team_member3' name='team_member3' value=".$team_member3['employee_id']." hidden>";

				     echo "<input type='text' id='submit' name='submit' value='establish' hidden/> ";
		 		echo"<br><br>";

		 		echo "<input type = 'submit' value = 'Submit!' /><br>
		 		</form> ";

?>