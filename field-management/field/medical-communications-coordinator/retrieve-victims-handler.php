<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
//error_reporting(0);


//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
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

//Victim Data
	$select1 = "SELECT field_treatment.*,victim.* 
				FROM victim 
				JOIN field_treatment ON victim.victimid = field_treatment.victimid 
				WHERE victim.disaster_id = '70' 
				ORDER BY victim.dispatch_ready DESC"; //Remove dummy value 

          $query1 = mysqli_query($con,$select1);

          $victim_key = mysqli_fetch_assoc($query1);  

//In_patient Data
  $select2 = "SELECT in_patient.*,victim.* 
              FROM victim 
              JOIN in_patient ON victim.in_patient_id = in_patient.in_patient_id 
              WHERE victim.disaster_id = '70' 
              ORDER BY victim.dispatch_ready DESC"; //Remove dummy value 

          $query2 = mysqli_query($con,$select2);

          $patient = mysqli_fetch_assoc($query2);

if(mysqli_num_rows($query1) > 0) {
       

echo "<fieldset style='display:inline'>
		<legend><strong>Impact Zone to Evacuation:</strong></legend>
			<br>

		<table id = 'mytable1' border = 1>
        <tr>
          <th>Victim ID</th>
          <th>Current Location</th>
          <th>Completed Treatment</th>
          <th>Treatment Ended</th>
          <th>Evacuation Code</th>
          <th>Priority</th>	
          <th>Ready to Dispatch</th>
          <th>Victim in Transit</th>
        </tr>";

 do {  

 	if ($victim_key['treatment_received'] == 1) {
        	
        	$treatment_completed = "YES";
        	
        } else {

        	$treatment_completed = "NO";
        } 

  if (empty($victim_key['evacuation_triage_tag'])) {
    
    $victim_key['evacuation_triage_tag'] = "NA";

  } elseif ($victim_key['evacuation_triage_tag'] == "BLACK") {
    
    $victim_key['evacuation_triage_tag'] = "NA";

  }


  if (empty($victim_key['dispatch_priority'])) {
    
    $victim_key['dispatch_priority'] = "NA";
    
  }


  if ($victim_key['dispatch_ready'] == 1) {
          
          $dispatch_ready = "YES";
          
        } else {

          $dispatch_ready = "NO";
        } 


  if ($victim_key['transit_status'] == 1) {
          
          $transit_status = "YES";
          
        } else {

          $transit_status = "NO";
        }

  //This finds the Victim's current location in the Database       

  if ($victim_key['victim_doa'] == '1') {
          
      $current_location = 'Morgue Area';
         
    } elseif (!empty($victim_key['on_site_triage_tag']) && empty($victim_key['medical_triage_tag']) ) {
     
     $current_location = $victim_key['on_site_triage_tag']."&nbsp;"."Collecting&nbsp;Point";

   } elseif (!empty($victim_key['medical_triage_tag']) && empty($victim_key['treatment_personnel']) ) {
     
     $current_location = $victim_key['medical_triage_tag']."&nbsp;"."Triage&nbsp;Area";

   } elseif (!empty($victim_key['treatment_personnel']) && $victim_key['treatment_received'] == '0' ) {
     
     $current_location = "Treatment&nbsp;Area";

   } elseif ($victim_key['treatment_received'] == '1' && empty($victim_key['evacuation_triage_tag']) ) {
     
     $current_location = "Evacuation Triage Area";

   } elseif ($victim_key['evacuation_triage_tag'] == 'BLACK') {
     
     $current_location = "Morgue Area";

   } elseif (!empty($victim_key['evacuation_triage_tag']) && !empty($victim_key['dispatch_priority']) && $victim_key['transit_status'] == '0' ) {
     
     $current_location = $victim_key['dispatch_priority']."&nbsp;"."Evacuation&nbsp;Area";

   } elseif ($victim_key['transit_status'] = '1' && empty($victim_key['facility_id']) ) {
     
     $current_location = "Dispatched to Hospital";

   } elseif (!empty($victim_key['facility_id'])  ) {
     # code...
   }
 	
 	echo "
        <tr>
          <td><input type='text' id='victim_unique_key_id' name='victim_unique_key_id' value=".$victim_key['victim_unique_key_id']." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='current_location' name='current_location' value=".$current_location." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value=".$treatment_completed." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value=".$victim_key['end_time']." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value=".$victim_key['evacuation_triage_tag']." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='dispatch_priority' name='dispatch_priority' value=".$victim_key['dispatch_priority']." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='dispatch_ready' name='dispatch_ready' value=".$dispatch_ready." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='transit_status' name='transit_status' value=".$transit_status." style = 'border:0px;background-color:white;text-align:center' disabled></td>
        </tr>";

 } while ( $victim_key = mysqli_fetch_assoc($query1));

 echo " </table></fieldset>";

} else {

  echo "Awaiting Victims!";

}

//------------------------------------------------------------------------------------------------------- 
echo "<hr>";


if (mysqli_num_rows($query2) > 0) {
  

  echo "<fieldset style='display:inline'>
    <legend><strong>Impact Zone to Evacuation:</strong></legend>
      <br>

    <table id = 'mytable1' border = 1>
        <tr>
          <th>Victim ID</th>
          <th>Current Location</th>
          <th>Completed Treatment</th>
          <th>Treatment Ended</th>
          <th>Evacuation Code</th>
          <th>Priority</th> 
          <th>Ready to Dispatch</th>
          <th>Victim in Transit</th>
        </tr>";

 do {  

  if ($victim_key['treatment_received'] == 1) {
          
          $treatment_completed = "YES";
          
        } else {

          $treatment_completed = "NO";
        } 


  if ($victim_key['dispatch_ready'] == 1) {
          
          $dispatch_ready = "YES";
          
        } else {

          $dispatch_ready = "NO";
        } 


  if ($victim_key['transit_status'] == 1) {
          
          $transit_status = "YES";
          
        } else {

          $transit_status = "NO";
        }

  //This finds the Victim's current location in the Database       

  if ($victim_key['on_site_triage_tag'] == '1') {
          
      $current_location = 'Morgue Area';
         
    } elseif (!empty($victim_key['on_site_triage_tag']) && empty($victim_key['medical_triage_tag']) ) {
     
     $current_location = $victim_key['on_site_triage_tag']."&nbsp;"."Collecting&nbsp;Point";

   } elseif (!empty($victim_key['medical_triage_tag']) && empty($victim_key['treatment_personnel']) ) {
     
     $current_location = $victim_key['medical_triage_tag']."&nbsp;"."Triage&nbsp;Area";

   } elseif (!empty($victim_key['treatment_personnel']) && $victim_key['treatment_received'] == '0' ) {
     
     $current_location = "Treatment&nbsp;Area";

   } elseif ($victim_key['treatment_received'] == '1' && empty($victim_key['evacuation_triage_tag']) ) {
     
     $current_location = "Evacuation Triage Area";

   } elseif (!empty($victim_key['evacuation_triage_tag']) && !empty($victim_key['dispatch_priority']) && $victim_key['transit_status'] == '0' ) {
     
     $current_location = $victim_key['dispatch_priority']."&nbsp;"."Evacuation&nbsp;Area";

   } elseif ($victim_key['transit_status'] = '1' && empty($victim_key['facility_id']) ) {
     
     $current_location = "Dispatched to Hospital";

   } elseif (!empty($victim_key['facility_id'])  ) {
     # code...
   }
  
  echo "
        <tr>
          <td><input type='text' id='victim_unique_key_id' name='victim_unique_key_id' value=".$victim_key['victim_unique_key_id']." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='current_location' name='current_location' value=".$current_location." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='treatment_completed' name='treatment_completed' value=".$treatment_completed." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='end_time' name='end_time' value=".$victim_key['end_time']." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='classification' name='classification' value=".$victim_key['evacuation_triage_tag']." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='dispatch_priority' name='dispatch_priority' value=".$victim_key['dispatch_priority']." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='dispatch_ready' name='dispatch_ready' value=".$dispatch_ready." style = 'border:0px;background-color:white;text-align:center' disabled></td>
          <td><input type='text' id='transit_status' name='transit_status' value=".$transit_status." style = 'border:0px;background-color:white;text-align:center' disabled></td>
        </tr>";

 } while ( $victim_key = mysqli_fetch_assoc($query1));

 echo " </table></fieldset>";


} else {

  echo "Victims has no Patient ID as yet!";
}

?>