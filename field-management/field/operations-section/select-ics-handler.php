<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

$disaster_id = $_SESSION['disaster_id']; //From the home page of this domain

$select = "SELECT * 
			FROM `ics_branches`
			WHERE `ics_branches`.`ics_branches_id`
			NOT IN (SELECT `ics_structure`.`branch_id_FK` FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' )
			AND `ics_branches`.`branch` = 'Multi Branch Director'
			OR `ics_branches`.`ics_branches_id`
			NOT IN (SELECT `ics_structure`.`branch_id_FK` FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' )
			AND `ics_branches`.`branch` = 'Medical Division Supervisor'
			OR `ics_branches`.`ics_branches_id`
			NOT IN (SELECT `ics_structure`.`branch_id_FK` FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' )
			AND `ics_branches`.`branch` = 'Patient Transportation Group Supervisor'
			OR `ics_branches`.`ics_branches_id`
			NOT IN (SELECT `ics_structure`.`branch_id_FK` FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' )
			AND `ics_branches`.`branch` = 'Medical Communications Coordinator'
			OR `ics_branches`.`ics_branches_id`
			NOT IN (SELECT `ics_structure`.`branch_id_FK` FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' )
			AND `ics_branches`.`branch` = 'Emergency Vehicle Ambulance Coordinator'
			OR `ics_branches`.`ics_branches_id`
			NOT IN (SELECT `ics_structure`.`branch_id_FK` FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' )
			AND `ics_branches`.`branch` = 'Treatment Unit Leader'
			OR `ics_branches`.`ics_branches_id`
			NOT IN (SELECT `ics_structure`.`branch_id_FK` FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' )
			AND `ics_branches`.`branch` = 'Triage Unit Leader' ";

	$query = mysqli_query($con,$select);

	$ics_branches = mysqli_fetch_assoc($query);


$select3 = "SELECT * 
			FROM `ics_branches`
			WHERE `ics_branches`.`ics_branches_id`
			IN (SELECT `ics_structure`.`branch_id_FK` FROM `ics_structure` 
					WHERE `ics_structure`.`disaster_id` = '$disaster_id'
					AND `ics_structure`.`branch_id_FK` IS NOT NULL)";

	$query3 = mysqli_query($con,$select3);

	$ics_branches3 = mysqli_fetch_assoc($query3);


$select1 = "SELECT `employees`.*, CONCAT(employee_fname,' ',employee_lname)employee_name 
			FROM `employees` 
			WHERE `employees`.`employee_id`
			NOT IN (SELECT `ics_structure`.`employee_id_FK` FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id')
			AND `employees`.`employee_field` !='Dispatch'
			AND `employees`.`employee_field` !='Telecommunications'
			AND `employees`.`employee_field` !='Geology'";

	$query1 = mysqli_query($con,$select1);

	$employee = mysqli_fetch_assoc($query1);




echo "<form method = 'POST' action = 'submit-ics.php' > ";

	echo "<label><strong>ICS Structure:</strong></label> 
	      <table id = 'mytable' border = 1>
	        <tr>
	          <th>Branch</th>
	          <th>Assignee</th>
	          <th>Commander</th>
	          <th>Update</th>
	        </tr>
	        <tr>
	          <td align='center' >
	          <select id='branch_id' name='branch_id' required>
	              <option value='' selected disabled>Select...</option>
	             "; do { 

	             		echo " <option value='".$ics_branches['ics_branches_id']."'>".$ics_branches['branch'];

	             	} while($ics_branches = mysqli_fetch_assoc($query)); echo "</option>
	            </select>
	          </td>
	          <td>
	          <select id='employee_id' name='employee_id' required>
	              <option value='' selected disabled>Select...</option>
	             "; do { 

	             		echo " <option value='".$employee['employee_id']."'>".$employee['employee_name']."\n||\n".$employee['employee_title'];

	             	} while($employee = mysqli_fetch_assoc($query1)); echo "</option>
	            </select>
	            </td>
	          <td>
	          <select id='employee_reportto_id' name='employee_reportto_id' required>
	              <option value='' selected disabled>Select...</option>
	             "; do { 

	             		echo " <option value='".$ics_branches3['ics_branches_id']."'>".$ics_branches3['branch'];

	             	} while($ics_branches3 = mysqli_fetch_assoc($query3)); echo "</option>
	            </select>
	            </td>
	          <td><input type='submit' value='Submit' /></td>
	          <input type='text' id='disaster_id' name='disaster_id' value='".$disaster_id."' hidden />
	        </tr>";
     echo" </table><br>";
echo "</from>";

?>