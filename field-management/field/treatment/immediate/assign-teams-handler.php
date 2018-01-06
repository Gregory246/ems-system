<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
//$userid = $_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = 'jess'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);


	//$disaster_id = $_SESSION['disaster_id']; //From even field-management/ambulance/unit-lead/event-record-handler.php


	$select1 = "SELECT * FROM victim WHERE victim.medical_triage_tag = 'IMMEDIATE' AND victim.disaster_id = '70' AND victim.treatment_personnel IS NULL"; //Remove dummy value 

          $query1 = mysqli_query($con,$select1);

          $victim = mysqli_fetch_assoc($query1);

          do {
          	
          	$unique_key[] = $victim['victim_unique_key_id']; 

          } while ($victim = mysqli_fetch_assoc($query1));

          $victim_key = current($unique_key);

          if(mysqli_num_rows($query1) == 0){

          	echo "No MINOR INJURY victims triaged at this point! Please wait!";

          } else {


  	$select2 = "SELECT * FROM victim WHERE victim.medical_triage_tag = 'MINOR' AND victim.disaster_id = '70' AND victim.treatment_personnel IS NOT NULL AND victim.treatment_received = 1"; //Remove dummy value

  		  $query2 = mysqli_query($con,$select2);

  		  //$field_treatment = mysqli_fetch_assoc($query2);


  	$select3 = "SELECT * FROM ics_structure WHERE ics_structure.branch_id_FK = '21'";

  		$query3 = mysqli_query($con,$select3);

  		$ics_structure = mysqli_fetch_assoc($query3);

  		do {
  			
  			$ics_employee[] = $ics_structure['employee_id_FK'];

  		} while ( $ics_structure = mysqli_fetch_assoc($query3));

  		$medic = current($ics_employee);	  

  		$select5 = "SELECT CONCAT(employees.employee_fname,' ',employees.employee_lname)employee_name FROM employees WHERE employees.employee_id = '$medic' ";  //MAY NEED TO ADD MY DATA TO DATABASE BECAUSE THIS PERSON SHOULD BE A PHYSICIAN/ANESTHESIOLOGIST/SURGEON,
																		                                        //THIS COULD BE SOMEONE FROM A MUNICIPAL COOP OR RED-CROSS
				$query5 = mysqli_query($con,$select5);

				$employee_name = mysqli_fetch_assoc($query5);

        if (mysqli_num_rows($query2) > 0) {
        	
        	$unavailable_medic = mysqli_fetch_assoc($query2); //Available team members who were currently occupied with a victim    $row = current($available_medic)

        			do {

		        		$unavailable[] = $unavailable_medic['practioner_personnel'];

        			} while ($unavailable_medic = mysqli_fetch_assoc($query4));


        			do {
        		
        				$medical_team_member[] = $ics_structure['employee_id_FK'];

        			} while ($ics_structure = mysqli_fetch_assoc($query3));

        	
        			$available_medic = array_diff($unavailable, $medical_team_member);

        			$medic2 = current($available_medic);



        			$select5 = "SELECT CONCAT(employees.employee_fname,' ',employees.employee_lname)employee_name FROM employees WHERE employees.employee_id = '$medic2' ";  //MAY NEED TO ADD MY DATA TO DATABASE BECAUSE THIS PERSON SHOULD BE A PHYSICIAN/ANESTHESIOLOGIST/SURGEON,
																		                                        //THIS COULD BE SOMEONE FROM A MUNICIPAL COOP OR RED-CROSS
				$query5 = mysqli_query($con,$select5);

				$employee_name2 = mysqli_fetch_assoc($query5);

				echo "A";

				echo "<form method = 'POST' action='submit-medic.php' target='_blank'>  ";
        			echo "<fieldset style='display:inline'>
		<legend><strong>START Triage:</strong></legend>
			<br>

		<table id = 'mytable1' border = 1>
        <tr>
          <th>Victim ID</th>
          <th>Classification</th>	
          <th>Update</th>
        </tr>";

 
 	
 	echo "
        <tr>
          <td><input type='text' id ='' name ='' value=".$victim_key." style = 'border:0px;background-color:white' disabled></td>
          <td><input type='text' id='' name='' value=".$employee_name['employee_name']." style = 'border:0px;background-color:white' disabled></td>          
          <td><button type='submit' >Update</button></td>
        </tr>";

  echo" <input type='text' id ='victim_unique_key' name ='victim_unique_key' value=".$victim_key." style = 'border:0px;background-color:white' hidden>
  		<input type='text' id='employee_id' name='employee_id' value=".$medic2." style = 'border:0px;background-color:white' hidden>";
 

 echo " </table></fieldset>";
 echo "</form>  ";

        } else { echo "B";

        	echo "<form method = 'POST' action='submit-medic.php' target='_blank'>  ";
        	echo "<fieldset style='display:inline'>
		<legend><strong>START Triage:</strong></legend>
			<br>

		<table id = 'mytable1' border = 1>
        <tr>
          <th>Victim ID</th>
          <th>Medical Treatment Personnel</th>	
          <th>Update</th>
        </tr>";


 	
 	echo "
        <tr>
          <td><input type='text' id ='' name ='' value=".$victim_key." style = 'border:0px;background-color:white' disabled></td>
          <td><input type='text' id='' name='' value=".$employee_name['employee_name']." style = 'border:0px;background-color:white' disabled></td>          
          <td><button type='submit' >Update</button></td>
        </tr>";

 	echo" <input type='text' id ='victim_unique_key' name ='victim_unique_key' value=".$victim_key." style = 'border:0px;background-color:white' hidden>
 		  <input type='text' id='employee_id' name='employee_id' value=".$medic." style = 'border:0px;background-color:white' hidden>";

 echo " </table></fieldset>";
 echo "</form>  ";
        }

}

?>