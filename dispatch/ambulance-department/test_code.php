<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//error_reporting(0);
  $userid ="wayl"  ;   //$_SESSION['userid'];


//Get's User Id to obtian the vehicleteam of the user
$select_userid = "SELECT `user_id` FROM `users` WHERE `users`.`username` = '$userid' ";

$query_userid = mysqli_query($con,$select_userid);

	$user_id = mysqli_fetch_assoc($query_userid);


	$employee_id = $_GET['f1'];

	$select = "SELECT `employees`.*, CONCAT(employee_fname,' ',employee_lname)employee_name FROM `employees` WHERE `employees`.`employee_id` = '$employee_id' ";

	$query = mysqli_query($con,$select);

	$employee_name = mysqli_fetch_assoc($query);


if ($_GET["bin"] == "true") {

	$select2 = "SELECT `operator_FK`, `assistance_FK`, `tech_FK`, `advance_tech_FK`, `paramedic_FK`, `advance_paramedic_FK`, `wilderness_tech_FK` 
			FROM `vehicleteam` WHERE `user_id`= '$user_id[user_id]' ORDER BY `vehicleteam_id` DESC LIMIT 1";

	$query2 = mysqli_query($con,$select2);

	$vehicleteam = mysqli_fetch_assoc($query2);



	if (empty($vehicleteam['operator_FK'] && empty($vehicleteam['assistance_FK']) && empty($vehicleteam['tech_FK']) && empty($vehicleteam['advance_tech_FK']) && empty($vehicleteam['paramedic_FK']) && empty($vehicleteam['advance_paramedic_FK']) && empty($vehicleteam['wilderness_tech_FK'])) {
		
	
		if ($employee_name['employee_title'] == 'Ambulance Operator') {
			
			$insert = "INSERT INTO `vehicleteam` (`operator_FK`) VALUES ('$employee_id')";

			$query = mysqli_query($con,$insert);

		} elseif ($employee_name['employee_title'] == 'Ambulance Care Assistance') {
			
			$insert = "INSERT INTO `vehicleteam` (`assistance_FK`) VALUES ('$employee_id')";

			$query = mysqli_query($con,$insert);

		} elseif ($employee_name['employee_title'] == 'Emergency Medical Technician') {
		
			$insert = "INSERT INTO `vehicleteam` (`tech_FK`) VALUES ('$employee_id')";

			$query = mysqli_query($con,$insert);	

		} elseif ($employee_name['employee_title'] == 'Advance Emergency Medical Technician') {
			
			$insert = "INSERT INTO `vehicleteam` (`advance_tech_FK`) VALUES ('$employee_id')";

			$query = mysqli_query($con,$insert);

		} elseif ($employee_name['employee_title'] == 'Paramedic') {
			
			$insert = "INSERT INTO `vehicleteam` (`paramedic_FK`) VALUES ('$employee_id')";

			$query = mysqli_query($con,$insert);

		} elseif ($employee_name['employee_title'] == 'Advance Practice Paramedic') {
			
			$insert = "INSERT INTO `vehicleteam` (`advance_paramedic_FK`) VALUES ('$employee_id')";

			$query = mysqli_query($con,$insert);

		} elseif ($employee_name['employee_title'] == 'Wilderness Emergency Medical Technician') {
			
			$insert = "INSERT INTO `vehicleteam` (`wilderness_tech_FK`) VALUES ('$employee_id')";

			$query = mysqli_query($con,$insert);

		}

	} elseif (condition) {
		# code...
	}
	



	$select6 = "SELECT * FROM vehicleteam WHERE operator_FK = '$employee[employee_id]'";
                $query6 = mysqli_query($con,$select6);
                $vehicleteam = mysqli_fetch_assoc($query6);

               
                $select8 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.operator_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query8 = mysqli_query($con,$select8);

                $operator = mysqli_fetch_assoc($query8);


                $select9 = "SELECT vehicleteam.operator_FK,employees.* 
                            FROM vehicleteam JOIN employees ON vehicleteam.assistance_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query9 = mysqli_query($con,$select9);

                $assistant = mysqli_fetch_assoc($query9);


                $select10 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.tech_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query10 = mysqli_query($con,$select10);

                $emt = mysqli_fetch_assoc($query10);


                $select11 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.advance_tech_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query11 = mysqli_query($con,$select11);

                $ademt = mysqli_fetch_assoc($query11);


                $select12 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.paramedic_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query12 = mysqli_query($con,$select12);

                $para = mysqli_fetch_assoc($query12);


                $select13 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.advance_paramedic_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query13 = mysqli_query($con,$select13);

                $adpara = mysqli_fetch_assoc($query13);


                $select14 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.wilderness_tech_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query14 = mysqli_query($con,$select14);

                $wtech = mysqli_fetch_assoc($query14);
}

/*----------------------------------------------------------------------------------------------------------------------------------*/

if($_GET["bin"] == "false"){

}

echo "<fieldset style='display:inline'>
		<legend><strong>Select Vehicle Team:</strong></legend>
			<br>

		<table id = 'mytable2' border = 1>
        <tr>
          <th>Name</th>
          <th>Title</th>
          <th>Contact No.</th> 
          <th>Email</th>
        </tr>";

        do {
        	
        	echo "
        <tr>
          <td><input type='text' id='current_location' name='current_location' value='".$operator_name."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value='".$operator."' style = 'border:0px;background-color:white;text-align:center;width:310px' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value='".$employee_name['employee_tele']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value='".$employee_name['employee_email']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
        </tr>

         <tr>
          <td><input type='text' id='current_location' name='current_location' value='".$assistant_name."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value='".$assistant."' style = 'border:0px;background-color:white;text-align:center;width:310px' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value='".$employee_name['employee_tele']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value='".$employee_name['employee_email']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
        </tr>

         <tr>
          <td><input type='text' id='current_location' name='current_location' value='".$emt_name."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value='".$emt."' style = 'border:0px;background-color:white;text-align:center;width:310px' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value='".$employee_name['employee_tele']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value='".$employee_name['employee_email']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
        </tr>

         <tr>
          <td><input type='text' id='current_location' name='current_location' value='".$aemt_name."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value='".$aemt."' style = 'border:0px;background-color:white;text-align:center;width:310px' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value='".$employee_name['employee_tele']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value='".$employee_name['employee_email']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
        </tr>

         <tr>
          <td><input type='text' id='current_location' name='current_location' value='".$paramedic_name."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value='".$paramedic."' style = 'border:0px;background-color:white;text-align:center;width:310px' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value='".$employee_name['employee_tele']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value='".$employee_name['employee_email']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
        </tr>

         <tr>
          <td><input type='text' id='current_location' name='current_location' value='".$aparamedic_name."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value='".$aparamedic."' style = 'border:0px;background-color:white;text-align:center;width:310px' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value='".$employee_name['employee_tele']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value='".$employee_name['employee_email']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
        </tr>

         <tr>
          <td><input type='text' id='current_location' name='current_location' value='".$wemt_name."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value='".$wemt."' style = 'border:0px;background-color:white;text-align:center;width:310px' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value='".$employee_name['employee_tele']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value='".$employee_name['employee_email']."' style = 'border:0px;background-color:white;text-align:center' disabled></td>
        </tr>";
   
        } while ($employee_name = mysqli_fetch_assoc($query));


echo "</fieldset>";

?>