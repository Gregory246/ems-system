<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
error_reporting(0);


/*************UNCOMMENT ONCE LOGIN IS FIXED*****************/
//$userid = $_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = 'jess'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);

$select5 = "SELECT * FROM employees WHERE employees.employee_title = '' ";  //MAY NEED TO ADD MY DATA TO DATABASE BECAUSE THIS PERSON SHOULD BE A PHYSICIAN/ANESTHESIOLOGIST/SURGEON,
																		                                        //THIS COULD BE SOMEONE FROM A MUNICIPAL COOP OR RED-CROSS
	$query5 = mysqli_query($con,$select5);

	$specialist = mysqli_fetch_assoc($query5);

	//$disaster_id = $_SESSION['disaster_id']; //From even field-management/ambulance/unit-lead/event-record-handler.php


	$select1 = "SELECT field_treatment.*,victim.* 
				FROM victim 
				JOIN field_treatment ON victim.victimid = field_treatment.victimid 
				WHERE victim.treatment_received = '1' 
				AND victim.evacuation_triage_tag IS NOT NULL AND victim.evacuation_triage_tag != 'BLACK'
        AND victim.dispatch_priority IS NULL 
				AND victim.disaster_id = '70' 
				ORDER BY victim.last_updated ASC LIMIT 1"; //Remove dummy value 

          $query1 = mysqli_query($con,$select1);

          $victim_key = mysqli_fetch_assoc($query1);  

if (mysqli_num_rows($query1) > 0) {
       

echo "<fieldset style='display:inline'>
		<legend><strong>Ready for Dispatch Victims:</strong></legend>
			<br>

		<table id = 'mytable1' border = 1>
        <tr>
          <th>Victim ID</th>
          <th>Completed Treatment</th>
          <th>Treatment Ended</th>
          <th>Evacuation Code</th>
          <th>Priority</th>	
          <th>Ready to Dispatch</th>
          <th>Update</th>
        </tr>";

 do {  

 	if ($victim_key['treatment_received'] == 1) {
        	
        	$treatment_completed = "YES";
        	
        } else {

        	$treatment_completed = "NO";
        } 
 	
 	echo "
        <tr>
          <td><input type='text' id='victim_unique_key_id' name='victim_unique_key_id' value=".$victim_key['victim_unique_key_id']." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value=".$treatment_completed." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value=".$victim_key['end_time']." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value=".$victim_key['evacuation_triage_tag']." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td>
          <select id='priority' name='priority' required>
              <option value='' selected disabled>Select...</option>
              <option value='HIGH'>HIGH</option>
              <option value='MEDIUM'>MEDIUM</option>
              <option value='LOW'>LOW</option>
            </select>
          </td>
          <td align='center' ><input type='checkbox' id='ready' name='ready'  required></td>
          <td><button type='button' onclick='submitPriority()' style='width:160px'>Update</button></td>
        </tr>";

 } while ( $victim_key = mysqli_fetch_assoc($query1));

 echo " </table></fieldset>";

} else {

  echo "Awaiting Victims!";
}

?>