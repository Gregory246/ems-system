<?php
session_start();
include_once('dbconnect.php');

if(isset($_SESSION['hospital_vehicle_availability_V_id'])){
$hospital_vehicle_availability_V_id = $_SESSION['hospital_vehicle_availability_V_id']; //From telephone-radio-updates
$disaster_id = $_SESSION['disaster_event_id'];//From home-page
$userid = $_SESSION['userid'];

$select2 = "SELECT users.*,employees.* 
			FROM users 
			JOIN employees ON users.user_id = employees.user_id 
			WHERE username = '$userid' ";
$query2 = mysqli_query($con,$select2);
$user = mysqli_fetch_assoc($query2);

//Select the vehicle based on the availability id

$select3 = "SELECT `vehicleteam_availabilty_junc`.*, `vehicleteam`.*, `hospital_vehicle_availability`.*
			FROM `hospital_vehicle_availability`
			JOIN vehicleteam_availabilty_junc ON hospital_vehicle_availability.hospital_vehicle_availability_id = vehicleteam_availabilty_junc.hospital_vehicle_availability_id
			JOIN vehicleteam ON vehicleteam_availabilty_junc.vehicleteam_id = vehicleteam.vehicleteam_id
			WHERE hospital_vehicle_availability.hospital_vehicle_availability_id = '$hospital_vehicle_availability_V_id'";

	$query3 = mysqli_query($con,$select3);

	$vehicleteam = mysqli_fetch_assoc($query3);

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

echo "<form method = 'POST' action = 'respond-unit-submit.php' target = '_blank'> ";
echo "<fieldset>
    	<legend><strong>Responding Unit:</strong></legend>
      		<br>";                

echo "<label><strong>Ambulance:</strong></label>
   <table id='myTable1' style='width:100%' border=1>
  <tr>
  <th>Team Type</th>
  <th>Life Support</th> 
  <th>Operator</th>
  <th>Assistance</th>
  <th>EMT</th>
  <th>Ad-EMT</th>
  <th>Paramedic</th>
  <th>Ad-Para</th>
  <th>Wi-EMT</th>
  </tr>

  <tr>
  	<td >".$vehicleteam['team_type']."</td>
    <td >".$vehicleteam['life_support']."</td>
    <td>".$operator['employee_fname']. "&nbsp;" . $operator['employee_lname']."</td> 
    <td >".$assistant['employee_fname']. "&nbsp;" . $assistant['employee_lname']."</td>
    <td >".$emt['employee_fname']. "&nbsp;" . $emt['employee_lname']."</td>
    <td >".$ademt['employee_fname']. "&nbsp;" . $ademt['employee_lname']."</td>
    <td >".$para['employee_fname']. "&nbsp;" . $para['employee_lname']."</td>
    <td >".$adpara['employee_fname']. "&nbsp;" . $adpara['employee_lname']."</td>
    <td >".$wtech['employee_fname']. "&nbsp;" . $wtech['employee_lname']."</td>
  </tr>
</table>";
echo "<br>";

echo "<label><strong>First Responding Team?:</strong></label> &nbsp;&nbsp;
		<input type = 'radio' id = 'first_response' name = 'first_response' value = '1' />Yes &nbsp;&nbsp;
		<input type = 'radio' id = 'first_response' name = 'first_response' value = '0' />No";

echo "<input type = 'text' id = 'vehcileteam_id' name = 'vehcileteam_id' value = '".$vehicleteam['vehicleteam_id']."' hidden />";

echo "<input type = 'text' id = 'employee_id' name = 'employee_id' value = '".$user['employee_id']."' hidden />";

echo "<input type = 'text' id = 'disaster_id' name = 'disaster_id' value = '".$disaster_id."' hidden />";

echo "</fieldset><br>";
echo "<input type = 'submit'  value = 'Dispatch!' />";
echo "</form>";
} 

date_default_timezone_set("Etc/GMT+4");
$date = date("Y-m-d");

$disaster_id = $_SESSION['disaster_event_id'];//From home-page
$userid = $_SESSION['userid'];

$select2 = "SELECT users.*,employees.* 
      FROM users 
      JOIN employees ON users.user_id = employees.user_id 
      WHERE username = '$userid' ";
$query2 = mysqli_query($con,$select2);
$user = mysqli_fetch_assoc($query2);

//Select the vehicle based on the availability id

$select3 = "SELECT `vehicleteam_availabilty_junc`.*, `vehicleteam`.*, `hospital_vehicle_availability`.*
      FROM `hospital_vehicle_availability`
      JOIN vehicleteam_availabilty_junc ON hospital_vehicle_availability.hospital_vehicle_availability_id = vehicleteam_availabilty_junc.hospital_vehicle_availability_id
      JOIN vehicleteam ON vehicleteam_availabilty_junc.vehicleteam_id = vehicleteam.vehicleteam_id
      WHERE hospital_vehicle_availability.type = 0
      AND hospital_vehicle_availability.status = 1
      AND DATE(hospital_vehicle_availability.updated_by) = '$date' 
      ORDER BY hospital_vehicle_availability.hospital_vehicle_availability_id  DESC LIMIT 1 ";

  $query3 = mysqli_query($con,$select3);

  $vehicleteam = mysqli_fetch_assoc($query3);

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

echo "<form method = 'POST' action = 'respond-unit-submit.php' target = '_blank'> ";
echo "<fieldset>
      <legend><strong>Responding Unit:</strong></legend>
          <br>";                

echo "<label><strong>Ambulance:</strong></label>
   <table id='myTable1' style='width:100%' border=1>
  <tr>
  <th>Team Type</th>
  <th>Life Support</th> 
  <th>Operator</th>
  <th>Assistance</th>
  <th>EMT</th>
  <th>Ad-EMT</th>
  <th>Paramedic</th>
  <th>Ad-Para</th>
  <th>Wi-EMT</th>
  </tr>

  <tr>
    <td >".$vehicleteam['team_type']."</td>
    <td >".$vehicleteam['life_support']."</td>
    <td>".$operator['employee_fname']. "&nbsp;" . $operator['employee_lname']."</td> 
    <td >".$assistant['employee_fname']. "&nbsp;" . $assistant['employee_lname']."</td>
    <td >".$emt['employee_fname']. "&nbsp;" . $emt['employee_lname']."</td>
    <td >".$ademt['employee_fname']. "&nbsp;" . $ademt['employee_lname']."</td>
    <td >".$para['employee_fname']. "&nbsp;" . $para['employee_lname']."</td>
    <td >".$adpara['employee_fname']. "&nbsp;" . $adpara['employee_lname']."</td>
    <td >".$wtech['employee_fname']. "&nbsp;" . $wtech['employee_lname']."</td>
  </tr>
</table>";
echo "<br>";

echo "<label><strong>First Responding Team?:</strong></label> &nbsp;&nbsp;
    <input type = 'radio' id = 'first_response' name = 'first_response' value = '1' />Yes &nbsp;&nbsp;
    <input type = 'radio' id = 'first_response' name = 'first_response' value = '0' />No";

echo "<input type = 'text' id = 'vehcileteam_id' name = 'vehcileteam_id' value = '".$vehicleteam['vehicleteam_id']."' hidden />";

echo "<input type = 'text' id = 'employee_id' name = 'employee_id' value = '".$user['employee_id']."' hidden />";

echo "<input type = 'text' id = 'disaster_id' name = 'disaster_id' value = '".$disaster_id."' hidden />";

echo "</fieldset><br>";
echo "<input type = 'submit'  value = 'Dispatch!' />";
echo "</form>";

?>