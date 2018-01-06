<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//error_reporting(0);
  $userid ="wayl"  ;   //$_SESSION['userid'];


//Get's User Id to obtian the vehicleteam of the user
$select_userid = "SELECT `user_id` FROM `users` WHERE `users`.`username` = '$userid' ";

$query_userid = mysqli_query($con,$select_userid);

	$user_id = mysqli_fetch_assoc($query_userid);

$select_agency = "SELECT agency.*, department.*, employees.*, employees_department_junc.* 
                  FROM `employees_department_junc`
                  JOIN department ON employees_department_junc.department_FK_id = department.department_id
                  JOIN employees ON employees_department_junc.employee_FK_id = employees.employee_id
                  JOIN agency ON department.agency_id = agency.agency_id
                  WHERE employees.user_id = '$user_id[user_id]' ";

      $query0 = mysqli_query($con,$select_agency);

      $agency = mysqli_fetch_assoc($query0);


$select1 = "SELECT agency.*, department.*,`employees`.*, CONCAT(employee_fname,' ',employee_lname)employee_name, employees_department_junc.* 
			FROM `employees_department_junc`
	          JOIN department ON employees_department_junc.department_FK_id = department.department_id
	          JOIN employees ON employees_department_junc.employee_FK_id = employees.employee_id
	          JOIN agency ON department.agency_id = agency.agency_id
			WHERE `employees`.`employee_field` = 'Emergency Response'
			AND agency.agency_name LIKE CONCAT('%',substring_index('$agency[agency_name]',' ','3'),'%') ";

	$query1 = mysqli_query($con,$select1);

	$employee = mysqli_fetch_assoc($query1);



$select2 = "SELECT `operator_FK`, `assistance_FK`, `tech_FK`, `advance_tech_FK`, `paramedic_FK`, `advance_paramedic_FK`, `wilderness_tech_FK` 
			FROM `vehicleteam` WHERE `user_id`= '$user_id[user_id]' ORDER BY `vehicleteam_id` DESC LIMIT 1";

	$query2 = mysqli_query($con,$select2);

	$vehicleteam = mysqli_fetch_assoc($query2);


echo "<fieldset style='display:inline'>
		<legend><strong>Ambulance Qualified Memebers:</strong></legend>
			<br>

		<table id = 'mytable1' border = 1>
        <tr>
          <th>Selected</th>
          <th>Name</th>
          <th>Title</th>
          <th>Contact No.</th> 
          <th>Email</th>
        </tr>";

        do { echo $employee['employee_id'];
        	//Checks the last vehicle team logged by this agency and if team members doesn't exist on last vehicle team then print to screen
        	if( 	($employee['employee_id'] != $vehicleteam['operator_FK']) 
        		AND ($employee['employee_id'] != $vehicleteam['assistance_FK']) 
        		AND ($employee['employee_id'] != $vehicleteam['tech_FK']) 
        		AND ($employee['employee_id'] != $vehicleteam['paramedic_FK']) 
        		AND ($employee['employee_id'] != $vehicleteam['advance_paramedic_FK']) 
        		AND ($employee['employee_id'] != $vehicleteam['wilderness_tech_FK']) 
        		AND ($employee['employee_id'] != $vehicleteam['advance_tech_FK']) 
        	){
        	
        	echo "
        <tr>
          <td align ='center' ><input type='checkbox' onchange = 'selectEmployee()' id='victim_unique_key_id' name='victim_unique_key_id' value='".$employee['employee_id']."' style = 'border:0px;background-color:white;text-align:center' ></td>
          <td><input type='text' id='current_location' name='current_location' value='".$employee['employee_name']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value='".$employee['employee_title']."' style = 'border:0px;background-color:white;text-align:center;width:310px' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value='".$employee['employee_tele']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value='".$employee['employee_email']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
        </tr>";
    } else {echo "W";}

        } while ($employee = mysqli_fetch_assoc($query1));


echo "</fieldset>";



	
//Gets the most recent Disaster Event ID
//$disaster_id = $_SESSION['disaster_id'];

/*This selects any possible employee who's employee_title maye have been registered as Medical Staff within the ICS_Structure*/
$select2 = "SELECT * FROM `ics_structure` 
			WHERE `ics_structure`.`disaster_id` = '70' 
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