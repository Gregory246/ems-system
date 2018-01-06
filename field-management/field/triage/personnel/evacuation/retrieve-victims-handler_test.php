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

	
	$select1 = "SELECT victim_unique_key_id 
				FROM victim 
				WHERE victim.treatment_received = '1'
				AND victim.evacuation_triage_tag IS NULL 
				AND victim.disaster_id = '$disaster_id'
				ORDER BY victim.victimid ASC
                LIMIT 1"; //Remove dummy value 

          $query1 = mysqli_query($con,$select1);

          $query2 = mysqli_query($con,$select1);

          $victim_key = mysqli_fetch_assoc($query1);  

          $victim_key2 = mysqli_fetch_assoc($query2);


  $select0 = "SELECT field_treatment.victimid, COUNT(victim.victimid) AS success 
				FROM victim 
				JOIN field_treatment ON victim.victimid = field_treatment.victimid
				WHERE victim.treatment_received = '1'
                AND field_treatment.treatment_successful = 'YES'
				AND victim.evacuation_triage_tag IS NULL 
				AND victim.disaster_id = '$disaster_id'
                GROUP BY field_treatment.victimid
                ORDER BY field_treatment.victimid ASC
                LIMIT 1";

		$query0 = mysqli_query($con,$select0);

		$victim_treatment = mysqli_fetch_assoc($query0);

$select0_1 = "SELECT field_treatment.victimid, COUNT(victim.victimid) AS fail 
				FROM victim 
				JOIN field_treatment ON victim.victimid = field_treatment.victimid
				WHERE victim.treatment_received = '1'
                AND field_treatment.treatment_successful = 'NO'
				AND victim.evacuation_triage_tag IS NULL 
				AND victim.disaster_id = '$disaster_id'
                GROUP BY field_treatment.victimid
                ORDER BY field_treatment.victimid ASC
                LIMIT 1";

        $query0_1 = mysqli_query($con,$select0_1);

		$victim_treatment1 = mysqli_fetch_assoc($query0_1);

$select0_2 = "SELECT field_treatment.victimid, COUNT(victim.victimid) AS died 
				FROM victim 
				JOIN field_treatment ON victim.victimid = field_treatment.victimid
				WHERE victim.treatment_received = '1'
                AND field_treatment.treatment_successful = 'DIED'
				AND victim.evacuation_triage_tag IS NULL 
				AND victim.disaster_id = '$disaster_id'
                GROUP BY field_treatment.victimid
				ORDER BY field_treatment.victimid ASC
                LIMIT 1";

        $query0_2 = mysqli_query($con,$select0_2);

		$victim_treatment2 = mysqli_fetch_assoc($query0_2);

$count1 = 0;
$count2 = 0;
$var = "";

/*This function checks the amount of YES to NO and outputs an OUTCOME. This can be updated with a smarter algorithm at a later date*/



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

	if (!empty($victim_treatment2['died'])) {
		
		$outcome = "VICTIM DIED";

	} elseif ($victim_treatment['success'] > $victim_treatment1['fail']) {
		
		$outcome = "STABILIZED";

	} elseif ($victim_treatment['success'] < $victim_treatment1['fail']) {
		
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

/****************************************\/***********************************************/
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