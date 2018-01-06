<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');



//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
$userid = $_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = '$userid'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);

$select5 = "SELECT * FROM employees WHERE employees.employee_title = '' ";  //MAY NEED TO ADD MY DATA TO DATABASE BECAUSE THIS PERSON SHOULD BE A PHYSICIAN/ANESTHESIOLOGIST/SURGEON,
							 //THIS COULD BE SOMEONE FROM A MUNICIPAL COOP OR RED-CROSS
	$query5 = mysqli_query($con,$select5);

	$specialist = mysqli_fetch_assoc($query5);

	$disaster_id = $_SESSION['disaster_id']; //From even field-management/ambulance/unit-lead/event-record-handler.php

	
	$select1 = "SELECT * FROM victim WHERE victim.treatment_received = '1'
				AND victim.evacuation_triage_tag IS NULL 
				AND victim.disaster_id = '$disaster_id'"; //Remove dummy value 

          $query1 = mysqli_query($con,$select1);

          $query2 = mysqli_query($con,$select1);

          $victim_key = mysqli_fetch_assoc($query1);  

          $victim_key2 = mysqli_fetch_assoc($query2);


  $select0 = "SELECT field_treatment.*,victim.* 
				FROM victim 
				JOIN field_treatment ON victim.victimid = field_treatment.victimid
				WHERE victim.treatment_received = '1'
				AND victim.evacuation_triage_tag IS NULL 
				AND victim.disaster_id = '$disaster_id'
				LIMIT 1";

		$query0 = mysqli_query($con,$select0);

		$victim_treatment = mysqli_fetch_assoc($query0);

$count1 = 0;
$count2 = 0;
$var = "";

/*This function checks the amount of YES to NO and outputs an OUTCOME. This can be updated with a smarter algorithm at a later date*/

do {

	if($victim_treatment['treatment_successful'] == "YES"){

		$count1++ ;

	} elseif ($victim_treatment['treatment_successful'] == "NO") {
		
		$count2++ ;

	} else {

		$var = "dead";
	}

} while ($victim_treatment = mysqli_fetch_assoc($query0));


if (mysqli_num_rows($query1) > 0) {

echo "<fieldset style='display:inline'>
		<legend><strong>Victim Treatment Success:</strong></legend>
			<br>

		<table id = 'mytable1' border = 1>
        <tr>
          <th>Victim ID</th>	
          <th>Outcome</th>
        </tr>";

do {

	if ($var == "dead") {
		
		$outcome = "VICTIM DIED";

	} elseif ($count1 > $count2) {
		
		$outcome = "STABILIZED";

	} elseif ($count1 < $count2) {
		
		$outcome = "NOT STABILIZED";

	} else{

		$outcome = "SEMI-STABILIZED";

	}

	echo "<tr>
          <td><input type='text' id='victim_unique_key_id' name='victim_unique_key_id' value=".$victim_key2['victim_unique_key_id']." style = 'border:0px;background-color:white' disabled></td>
          <td>".$outcome."</td>
          ";
} while ($victim_key2 = mysqli_fetch_assoc($query2));

 echo " </table></fieldset>";

/***********************************************************************/
echo "<fieldset style='display:inline'>
		<legend><strong>Evacuation Triage:</strong></legend>
			<br>

		<table id = 'mytable1' border = 1>
        <tr>
          <th>Victim ID</th>
          <th>Classification</th>	
          <th>Update</th>
        </tr>";

 do {
 	
 	echo "
        <tr>
          <td><input type='text' id='victim_unique_key_id' name='victim_unique_key_id' value=".$victim_key['victim_unique_key_id']." style = 'border:0px;background-color:white' disabled></td>
          <td>
	          <select id='classification' name='classification' required>
	              <option value='' selected disabled>Select...</option>
	              <option value='RED'>RED</option>
	              <option value='YELLOW'>YELLOW</option>
	              <option value='GREEN'>GREEN</option>
	              <option value='BLACK'>BLACK</option>
	            </select>
           </td>
           <td><button type='button' onclick='submitTriage()'>Update</button></td>
        </tr>";

 } while ( $victim_key = mysqli_fetch_assoc($query1));

 echo " </table></fieldset>";

} else {

  echo "Please wait as there are not victims awaiting Evacuation Triage as yet!";
}

?>