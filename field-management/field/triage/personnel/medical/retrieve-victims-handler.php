<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');



//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
$userid = $_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = 'jess'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);

$select5 = "SELECT * FROM employees WHERE employees.employee_title = '' ";  //MAY NEED TO ADD MY DATA TO DATABASE BECAUSE THIS PERSON SHOULD BE A PHYSICIAN/ANESTHESIOLOGIST/SURGEON,
																		                                        //THIS COULD BE SOMEONE FROM A MUNICIPAL COOP OR RED-CROSS
	$query5 = mysqli_query($con,$select5);

	$specialist = mysqli_fetch_assoc($query5);

	$disaster_id = $_SESSION['disaster_id']; //From even field-management/ambulance/unit-lead/event-record-handler.php


	$select1 = "SELECT * FROM victim WHERE victim.medical_triage_tag IS NULL AND victim.disaster_id = '$disaster_id '"; //Remove dummy value 

          $query1 = mysqli_query($con,$select1);

          $victim_key = mysqli_fetch_assoc($query1); 

if (mysqli_num_rows($query1) > 0 ){
        

  echo "<fieldset style='display:inline'>
  <legend><strong>Victim Injuries:</strong></legend>
 
  	<button type = 'button' onclick ='insertInjury()'>Add Injury</button> <div style ='text-align:center'>Injuries are added to Victim at the top of the START Triage table!</div>
    ";


    echo " 
      <table id = 'mytable' border = 1>
        <tr>
          <th>Type</th>
          <th>Severity</th>
          <th>Nature of Injuries</th>
          <th>Area of Body</th>
        </tr>
        <tr>
          <td><input type='text' id='type' name='type' required></td>
          <td><input type='text' id='severity' name='severity' required></td>
          <td><input type='text' id='noi' name='noi'  required></td>
          <td><input type='text' id='aob' name='aob'  required></td>
        </tr>";

     echo" </table>
 </fieldset>
 <br>";

echo "<fieldset style='display:inline'>
		<legend><strong>START Triage:</strong></legend>
			<br>

		<table id = 'mytable1' border = 1>
        <tr>
          <th>Victim ID</th>
          <th>Classification</th>	
          <th>Walking</th>
          <th>Breathing</th>
          <th>Position-Airway</th>
          <th>Respiratory Rate</th>
          <th>Perfusion</th>
          <th>Mental State</th>
          <th>Update</th>
        </tr>";

 do {
 	
 	echo "
        <tr>
          <td><input type='text' id='victim_unique_key_id' name='victim_unique_key_id' value=".$victim_key['victim_unique_key_id']." style = 'border:0px;background-color:white' disabled></td>
          <td>
	          <select id='classification' name='classification' required>
	              <option value='' selected disabled>Select...</option>
	              <option value='MINOR'>MINOR</option>
	              <option value='DELAYED'>DELAYED</option>
	              <option value='IMMEDIATE'>IMMEDIATE</option>
	              <option value='EXPECTANT'>EXPECTANT</option>
	            </select>
           </td>
            <td>
          <select id='walk' name='walk' required>
              <option value='' selected disabled>Select...</option>
              <option value='YES'>YES</option>
              <option value='NO'>NO</option>
            </select>
          </td>
          <td>
	          <select id='breathe' name='breathe' required>
	              <option value='' selected disabled>Select...</option>
	              <option value='YES'>YES</option>
	              <option value='NO'>NO</option>
	            </select>
           </td>
          <td>
	          <select id='airway' name='airway' required>
	              <option value='' selected disabled>Select...</option>
				  <option value='SPONTANEOUS'>SPONTANEOUS</option>
	              <option value='APNEA'>APNEA</option>
	              <option value='NOT REQUIRED'>NOT REQUIRED</option>
	            </select>
           </td>
          <td>
	          <select id='resp' name='resp' required>
	              <option value='' selected disabled>Select...</option>
	              <option value='GREATER THAN 30 bpm'>GREATER THAN 30 bpm</option>
	              <option value='LESS THAN 30 bpm'>LESS THAN 30 bpm</option>
	            </select>
           </td>
          <td>
	          <select id='pref' name='perf' required>
	              <option value='' selected disabled>Select...</option>
	              <option value='PRESENT PULSE'>PRESENT PULSE</option>
	              <option value='ABSENT PULSE'>ABSENT PULSE</option>
	            </select>
           </td>
          <td>
	          <select id='mental' name='mental' required>
	              <option value='' selected disabled>Select...</option>
	              <option value='OBEY COMMAND'>OBEY COMMAND</option>
	              <option value='DOES NOT OBEY COMMAND'>DOES NOT OBEY COMMAND</option>
	            </select>
           </td>
           <td><button type='button' onclick='submitTriage()'>Update</button></td>
        </tr>";

 } while ( $victim_key = mysqli_fetch_assoc($query1));

 echo " </table></fieldset>";

 } else {

  echo "Victims being Assessed Please Wait...";

 }

?>