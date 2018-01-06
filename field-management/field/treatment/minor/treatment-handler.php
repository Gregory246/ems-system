<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');


//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
$userid = $_SESSION['userid'];

$disaster_id = $_SESSION['disaster_id'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = '$userid'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);

$select = "SELECT * FROM `victim` WHERE `victim`.`treatment_personnel` = '29' AND `victim`.`treatment_received` = '0' AND `victim`.`disaster_id` = '$disaster_id' ORDER BY `victim`.`date_created` ASC LIMIT 1 ";

	$query = mysqli_query($con,$select);

	$victim_id = mysqli_fetch_assoc($query);

$select1 = "SELECT * FROM `field_pharmaceuticals`";


	if (mysqli_num_rows($query) > 0) {
		
		echo "<fieldset style='display:inline'>
  <legend><strong>Medical Treatment:</strong></legend>
 
  	<button type = 'button' onclick ='victimTreatment()'>Submit Treatment</button>
    <div style ='text-align:center;color:red'>Check Treatment Complete when victim is ONLY ready-to-receive Health Care treatment or Does not REQUIRE further Treatment!<br>
    <label><strong>Treatment Complete</strong></label>&nbsp;&nbsp;<input type='checkbox' id='complete' name='complete'  required></div>
    ";


    echo "
    <label>Treatment</label> 
      <table id = 'mytable' border = 1>
        <tr>
          <th>Victim ID</th>
          <th>Treatment</th>
          <th>Time Administered</th>
          <th>Time Ended</th>
          <th>Treatment Successful</th>
          <th>Notes</th>
        </tr>
        <tr>
          <td><input type='text' id='victim_unique_key_id' name='victim_unique_key_id' value=".$victim_id['victim_unique_key_id']." style = 'border:0px;background-color:white' disabled></td>
          <td><input type='text' id='treatment' name='treatment' placeholder = 'e.g anaesthesia' required></td>
          <td><input type='time' id='start_time' name='start_time' style = 'width:160px' required></td>
          <td><input type='time' id='end_time' name='end_time'  required></td>
          <td align='center' >
          <select id='state' name='state' required>
              <option value='' selected disabled>Select...</option>
              <option value='YES'>YES</option>
              <option value='NO'>NO</option>
              <option value='DIED'>DIED</option>
            </select>
          </td>
          <td><input type='text' id='treatment_notes' name='treatment_notes' placeholder = 'e.g blood lost' required></td>
        </tr>";

     echo" </table><br>";


     echo " 
     <label>Prescription</label>
      <table id = 'mytable1' border = 1>
        <tr>
          <th>Prescription No#</th>
          <th>Prescription Name</th>
          <th>Dose Freq</th>
          <th>Maximum Dosage</th>
          <th>Purpose</th>
        </tr>
        <tr>
          <td><input type='text' id='pre_num' name='pre_num' placeholder = 'e.g ABC 123-456-789' required></td>
          <td><input type='text' id='pre_name' name='pre_name' placeholder='e.g morphine (PF) injection' required></td>
          <td><input type='text' id='dose_freq' name='dose_freq' placeholder = 'e.g 30mg/1hr'  required></td>
          <td><input type='text' id='max_dose' name='max_dose' placeholder = 'e.g 200mg'  required></td>
          <td><input type='text' id='purpose' name='purpose' placeholder = 'e.g for pain'  required></td>
        </tr>";

     echo" </table><br>";

     echo " 
     <label>Medical Supplies</label>
      <table id = 'mytable1' border = 1>
        <tr>
          <th>Type</th>
          <th>Name</th>
          <th>Device No#</th>
        </tr>
        <tr>
          <td><input type='text' id='device_type' name='device_type' placeholder = 'e.g body support' required></td>
          <td><input type='text' id='device_name' name='device_name' placeholder = 'e.g crutch' required></td>
          <td><input type='text' id='device_no' name='device_no' placeholder = 'e.g NA'  required></td>
        </tr>";

     echo" </table>
 </fieldset><br>
 <span style = 'color:red' ><strong>NB:Dose Frequency (No# unit of measure/Hr) and Maximum Dosage (max No# unit of measure)</strong></span>";

	} else {

		echo "Waiting for your ID to be assigned to a victim!";
	}

	?>