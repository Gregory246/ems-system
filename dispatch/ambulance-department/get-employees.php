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


$select_emsvehicle = "SELECT * FROM `emsvehicle` WHERE `emsvehicle`.`agency_id`= '$agency[agency_id]'";

		$queryems = mysqli_query($con,$select_emsvehicle);

		$emsvehicle = mysqli_fetch_assoc($queryems);


$select1 = "SELECT agency.*, department.*,`employees`.*, CONCAT(employee_fname,' ',employee_lname)employee_name, employees_department_junc.* 
			FROM `employees_department_junc`
	          JOIN department ON employees_department_junc.department_FK_id = department.department_id
	          JOIN employees ON employees_department_junc.employee_FK_id = employees.employee_id
	          JOIN agency ON department.agency_id = agency.agency_id
			WHERE `employees`.`employee_field` = 'Emergency Response'
			AND `employees`.`employee_title` NOT LIKE 'Communications Operator'
			AND agency.agency_name LIKE CONCAT('%',substring_index('$agency[agency_name]',' ','3'),'%') ";

	$query1 = mysqli_query($con,$select1);

	$employee = mysqli_fetch_assoc($query1);

/*To take care of the last two records by the user*/

$select2 = "SELECT `vehicleteam_id`, `operator_FK`, `assistance_FK`, `tech_FK`, `advance_tech_FK`, `paramedic_FK`, `advance_paramedic_FK`, `wilderness_tech_FK` 
			FROM `vehicleteam` WHERE `user_id`= '$user_id[user_id]' AND `vehicleteam_id` = '$_SESSION[vehicleteam_id]' ORDER BY `vehicleteam_id` DESC LIMIT 1";

	$query2 = mysqli_query($con,$select2);

	$vehicleteam = mysqli_fetch_assoc($query2);


$select21 = "SELECT `vehicleteam_id`, `operator_FK`, `assistance_FK`, `tech_FK`, `advance_tech_FK`, `paramedic_FK`, `advance_paramedic_FK`, `wilderness_tech_FK` 
			FROM `vehicleteam` WHERE `user_id`= '$user_id[user_id]' ORDER BY `vehicleteam_id` DESC LIMIT 1";

	$query21 = mysqli_query($con,$select21);

	$vehicleteam1 = mysqli_fetch_assoc($query21);

	//$_SESSION['vehicleteam_id'] = $vehicleteam['vehicleteam_id'];


	echo "<fieldset style='display:inline'>
		<legend><strong>Vehicle Team Details:</strong></legend>
		<table id = 'mytable2' border = 1>
        <tr>
          <th>Team Code</th>
          <th>Support</th>
          <th>Vehicle Class</th> 
        </tr>";

        
        	
        	echo "
        <tr>
          <td>
          		<select id='team_class' name='team_class' required>
	              <option value='' selected disabled>Select...</option>
	              <option value='ALPHA'>ALPHA</option>
	              <option value='BETA'>BETA</option>
	              <option value='GAMMA'>GAMMA</option>
	            </select>
        	</td>
          <td>
          		<select id='life_support' name='life_support' required>
	              <option value='' selected disabled>Select...</option>
	              <option value='ALS'>Advance Life Support</option>
	              <option value='BLS'>Basic Life Support</option>
	            </select>
            </td>
          <td>
          		<select id='vehicle_id' name='vehicle_id' required>
	              <option value='' selected disabled>Select...</option>
	             "; do { 

	             		echo " <option value='".$emsvehicle['emsvehicle_id']."'>".$emsvehicle['vehicletype'];

	             	} while($emsvehicle = mysqli_fetch_assoc($queryems)); echo "</option>
	            </select>
            </td>
        </tr>
         ";
echo "</table>";


echo "<hr>";

echo "
		<label><strong>Ambulance Qualified Memebers:</strong></label>
			

		<table id = 'mytable1' onclick = 'clickEvent()' border = 1>
        <tr>
          <th>Selected</th>
          <th>Name</th>
          <th>Title</th>
          <th>Contact No.</th> 
          <th>Email</th>
        </tr>";
        		$count = 0;
        do { 
        	//Checks the last vehicle team logged by this agency and if team members doesn't exist on last vehicle team then print to screen
        	if( 	 ($employee['employee_id'] != $vehicleteam['operator_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam['assistance_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam['tech_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam['paramedic_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam['advance_paramedic_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam['wilderness_tech_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam['advance_tech_FK'])
    			 AND ($employee['employee_id'] != $vehicleteam1['operator_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam1['assistance_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam1['tech_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam1['paramedic_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam1['advance_paramedic_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam1['wilderness_tech_FK']) 
    			 AND ($employee['employee_id'] != $vehicleteam1['advance_tech_FK']) 
        	){
        	
        	echo "
        <tr>
          <td align ='center' ><input type='checkbox' onchange = 'selectEmployee()' id='victim_unique_key_id' name='victim_unique_key_id' value='".$employee['employee_id']."' style = 'border:0px;background-color:white;text-align:center' ></td>
          <td><input type='text' id='current_location' name='current_location' value='".$employee['employee_name']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value='".$employee['employee_title']."' style = 'border:0px;background-color:white;text-align:center;width:310px' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value='".$employee['employee_tele']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value='".$employee['employee_email']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
        </tr>";
    } else {echo "(".$count++.")";}

        } while ($employee = mysqli_fetch_assoc($query1));

echo "</table>";
echo "</fieldset><br>
		 		";

echo "<button id='mybutton1' onclick='setTeams()'>Set Team</button>";


	
//Gets the most recent Disaster Event ID
//$disaster_id = $_SESSION['disaster_id'];

?>