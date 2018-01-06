<?php
session_start();
include_once('dbconnect.php');


//Get the last record stored by the allocator from the session. Called from telephone-dispatch.php
$hospital_vehicle_availability_H1_id = $_SESSION['hospital_vehicle_availability_H1_id'];
$hospital_vehicle_availability_H2_id = $_SESSION['hospital_vehicle_availability_H2_id'];
$hospital_vehicle_availability_V_id = $_SESSION['hospital_vehicle_availability_V_id'];

//Select the facility based on the availability id's 

$select = "SELECT hospital_availability_junc.*,hospital_vehicle_availability.*,facility.*,location.*
			FROM hospital_vehicle_availability 
			JOIN hospital_availability_junc ON hospital_vehicle_availability.hospital_vehicle_availability_id = hospital_availability_junc.hospital_vehicle_availability_id
			JOIN facility ON hospital_availability_junc.facility_id = facility.facility_id
			JOIN location ON facility.location_id = location.location_id 
			WHERE hospital_vehicle_availability.hospital_vehicle_availability_id = '$hospital_vehicle_availability_H1_id' ";

	$query = mysqli_query($con,$select);

	$hospital_ = mysqli_fetch_assoc($query);


$select1 = "SELECT hospital_availability_junc.*,hospital_vehicle_availability.*,facility.*,location.*
			FROM hospital_vehicle_availability 
			JOIN hospital_availability_junc ON hospital_vehicle_availability.hospital_vehicle_availability_id = hospital_availability_junc.hospital_vehicle_availability_id
			JOIN facility ON hospital_availability_junc.facility_id = facility.facility_id
			JOIN location ON facility.location_id = location.location_id 
			WHERE hospital_vehicle_availability.hospital_vehicle_availability_id = '$hospital_vehicle_availability_H2_id' ";

	$query1 = mysqli_query($con,$select1);

	$hospital1_ = mysqli_fetch_assoc($query1);

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



    if ($hospital_['status'] == 1 && $hospital1_['status'] == 1 && $vehicleteam['status'] == 1) {
    	

    	echo "<label><strong>Hospital:</strong></label>
   <table id='myTable' style='width:100%' border=1>
  <tr>
  <th>Name</th>
  <th>Telephone</th>
  <th>Address Line 1</th>
  <th>Address Line 2</th>
  <th>Locality</th>
  <th>City</th>
  <th>Country</th>
  </tr>

  <tr>
    <td >".$hospital_['name']."</td>
    <td >".$hospital_['tel']."</td>
    <td >".$hospital_['addressline1']."</td>
    <td>".$hospital_['addressline2']."</td> 
    <td >".$hospital_['locality']."</td>
    <td >".$hospital_['city']."</td>
    <td >".$hospital_['country']."</td>
  </tr>

  <tr>
    <td >".$hospital1_['name']."</td>
    <td >".$hospital1_['tel']."</td>
    <td >".$hospital1_['addressline1']."</td>
    <td>".$hospital1_['addressline2']."</td> 
    <td >".$hospital1_['locality']."</td>
    <td >".$hospital1_['city']."</td>
    <td >".$hospital1_['country']."</td>
  </tr>
</table>
<br>
<!-- Table to present Vehicle details -->
   <label><strong>Ambulance:</strong></label>
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

    } elseif ($hospital_['status'] == 1 && $hospital1_['status'] == 1 && $vehicleteam['status'] == 0) {
    	
    	echo "<label><strong>Hospital:</strong></label>
   <table id='myTable' style='width:100%' border=1>
  <tr>
  <th>Name</th>
  <th>Telephone</th>
  <th>Address Line 1</th>
  <th>Address Line 2</th>
  <th>Locality</th>
  <th>City</th>
  <th>Country</th>
  </tr>

  <tr>
    <td >".$hospital_['name']."</td>
    <td >".$hospital_['tel']."</td>
    <td >".$hospital_['addressline1']."</td>
    <td>".$hospital_['addressline2']."</td> 
    <td >".$hospital_['locality']."</td>
    <td >".$hospital_['city']."</td>
    <td >".$hospital_['country']."</td>
  </tr>

  <tr>
    <td >".$hospital1_['name']."</td>
    <td >".$hospital1_['tel']."</td>
    <td >".$hospital1_['addressline1']."</td>
    <td>".$hospital1_['addressline2']."</td> 
    <td >".$hospital1_['locality']."</td>
    <td >".$hospital1_['city']."</td>
    <td >".$hospital1_['country']."</td>
  </tr>
</table>
<br>
  
  Please contact another vehicleteam, current team is unavailble!";

    } elseif ($hospital_['status'] == 1 && $hospital1_['status'] == 0 && $vehicleteam['status'] == 1) {
    	
    	echo "<label><strong>Hospital:</strong></label>
   <table id='myTable' style='width:100%' border=1>
  <tr>
  <th>Name</th>
  <th>Telephone</th>
  <th>Address Line 1</th>
  <th>Address Line 2</th>
  <th>Locality</th>
  <th>City</th>
  <th>Country</th>
  </tr>

  <tr>
    <td >".$hospital_['name']."</td>
    <td >".$hospital_['tel']."</td>
    <td >".$hospital_['addressline1']."</td>
    <td>".$hospital_['addressline2']."</td> 
    <td >".$hospital_['locality']."</td>
    <td >".$hospital_['city']."</td>
    <td >".$hospital_['country']."</td>
  </tr>
</table>
<br>
Please contact a secondary hospital, second hospital is unavailable. 
<br>
<!-- Table to present Vehicle details -->
   <label><strong>Ambulance:</strong></label>
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

    } elseif ($hospital_['status'] == 0 && $hospital1_['status'] == 1 && $vehicleteam['status'] == 1) {
    	

    	echo "<label><strong>Hospital:</strong></label>
   <table id='myTable' style='width:100%' border=1>
  <tr>
  <th>Name</th>
  <th>Telephone</th>
  <th>Address Line 1</th>
  <th>Address Line 2</th>
  <th>Locality</th>
  <th>City</th>
  <th>Country</th>
  </tr>

  <tr>
    <td >".$hospital1_['name']."</td>
    <td >".$hospital1_['tel']."</td>
    <td >".$hospital1_['addressline1']."</td>
    <td>".$hospital1_['addressline2']."</td> 
    <td >".$hospital1_['locality']."</td>
    <td >".$hospital1_['city']."</td>
    <td >".$hospital1_['country']."</td>
  </tr>
</table>
<br>
Please contact a secondary hospital, first hospital is unavailable.
<br>
<!-- Table to present Vehicle details -->
   <label><strong>Ambulance:</strong></label>
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

    } elseif ($hospital_['status'] == 0 && $hospital1_['status'] == 1 && $vehicleteam['status'] == 0) {
    	
    	echo "<label><strong>Hospital:</strong></label>
   <table id='myTable' style='width:100%' border=1>
  <tr>
  <th>Name</th>
  <th>Telephone</th>
  <th>Address Line 1</th>
  <th>Address Line 2</th>
  <th>Locality</th>
  <th>City</th>
  <th>Country</th>
  </tr>

  <tr>
    <td >".$hospital1_['name']."</td>
    <td >".$hospital1_['tel']."</td>
    <td >".$hospital1_['addressline1']."</td>
    <td>".$hospital1_['addressline2']."</td> 
    <td >".$hospital1_['locality']."</td>
    <td >".$hospital1_['city']."</td>
    <td >".$hospital1_['country']."</td>
  </tr>
</table>
<br>
Please contact secondary Hospital and another Vehicle Team!";

    } elseif ($hospital_['status'] == 0 && $hospital1_['status'] == 0 && $vehicleteam['status'] == 1) {
    	
    	echo "
<!-- Table to present Vehicle details -->
   <label><strong>Ambulance:</strong></label>
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
</table>
<br>
Please contact another hospital ";

    } elseif ($hospital_['status'] == 0 && $hospital1_['status'] == 0 && $vehicleteam['status'] == 0) {
    	
    	echo "All resources are unavailable please search for other hospitals and ambulances";

    } elseif ( empty($hospital_['status'])  && empty($hospital1_['status'])  && empty($vehicleteam['status']) ) {
    	
    	echo "No response from Telephone Dispatch as yet!";

    } elseif ($hospital_['status'] == 0 && $hospital1_['status'] == 0 && empty($vehicleteam['status']) ) {
    	
    	echo "Hospitals unavailable. Please contact another hospital. <br> No response from vehicle team as yet";

    } elseif ($hospital_['status'] == 0 && empty($hospital1_['status']) && $vehicleteam['status'] == 0) {
    	
    	echo "Primary Hospital unavailable. No repsonse from secondary hospital as yet. Please contact another hospital <br>
    			Vehicle team unavailable. Please contact another team!";

    } elseif ($hospital_['status'] == 0 && empty($hospital1_['status'])  && empty($vehicleteam['status']) ) {
    	
    	echo "Primary Hospital unavailable. Waiting for response from Secondary hospital and Vehicle Team!";

    } elseif (empty($hospital_['status'])  && $hospital1_['status'] == 0  && empty($vehicleteam['status']) ) {
    	
    	echo "Secondary Hospital unavailable. Waiting for response from Primary hospital and Vehicle Team!";

    } elseif (empty($hospital_['status'])  && empty($hospital1_['status'])  && $vehicleteam['status'] == 0) {
    	
    	echo "Waiting for response from Primary & Secondary hospitals and Vehicle Team is unavailable! please choose another";

    } elseif (empty($hospital_['status'])  && empty($hospital1_['status'])  && $vehicleteam['status'] == 1) {
    	
    	echo "Waiting for response from Primary & Secondary hospitals<br>";

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

    } elseif (empty($hospital_['status'])  && $hospital1_['status'] == 1  && empty($vehicleteam['status'])) {
    	
    	echo "Waiting for response from Primary hospital and Vehicle Team <br>";

    	echo "<label><strong>Hospital:</strong></label>
   <table id='myTable' style='width:100%' border=1>
  <tr>
  <th>Name</th>
  <th>Telephone</th>
  <th>Address Line 1</th>
  <th>Address Line 2</th>
  <th>Locality</th>
  <th>City</th>
  <th>Country</th>
  </tr>

  <tr>
    <td >".$hospital1_['name']."</td>
    <td >".$hospital1_['tel']."</td>
    <td >".$hospital1_['addressline1']."</td>
    <td>".$hospital1_['addressline2']."</td> 
    <td >".$hospital1_['locality']."</td>
    <td >".$hospital1_['city']."</td>
    <td >".$hospital1_['country']."</td>
  </tr>
</table>";

    } elseif (empty($hospital_['status']) && $hospital1_['status'] == 1 && $vehicleteam['status'] == 1) {
    	
    	echo "Waiting for response from Primary hospital <br>";

    	echo "<label><strong>Hospital:</strong></label>
   <table id='myTable' style='width:100%' border=1>
  <tr>
  <th>Name</th>
  <th>Telephone</th>
  <th>Address Line 1</th>
  <th>Address Line 2</th>
  <th>Locality</th>
  <th>City</th>
  <th>Country</th>
  </tr>

  <tr>
    <td >".$hospital1_['name']."</td>
    <td >".$hospital1_['tel']."</td>
    <td >".$hospital1_['addressline1']."</td>
    <td>".$hospital1_['addressline2']."</td> 
    <td >".$hospital1_['locality']."</td>
    <td >".$hospital1_['city']."</td>
    <td >".$hospital1_['country']."</td>
  </tr>
</table>
<br>
<!-- Table to present Vehicle details -->
   <label><strong>Ambulance:</strong></label>
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


    } elseif ($hospital_['status'] == 1 && empty($hospital1_['status']) && $vehicleteam['status'] == 1) {
    	
    	echo "Waiting for response from Secondary hospital<br>";

    	echo "<label><strong>Hospital:</strong></label>
   <table id='myTable' style='width:100%' border=1>
  <tr>
  <th>Name</th>
  <th>Telephone</th>
  <th>Address Line 1</th>
  <th>Address Line 2</th>
  <th>Locality</th>
  <th>City</th>
  <th>Country</th>
  </tr>

  <tr>
    <td >".$hospital_['name']."</td>
    <td >".$hospital_['tel']."</td>
    <td >".$hospital_['addressline1']."</td>
    <td>".$hospital_['addressline2']."</td> 
    <td >".$hospital_['locality']."</td>
    <td >".$hospital_['city']."</td>
    <td >".$hospital_['country']."</td>
  </tr>
</table>
<br>
<!-- Table to present Vehicle details -->
   <label><strong>Ambulance:</strong></label>
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

    } elseif ($hospital_['status'] == 1 && $hospital1_['status'] == 1 && empty($vehicleteam['status']) ) {
    	
    	echo "Waiting for response from Vehicle Team<br>";

    	echo "<label><strong>Hospital:</strong></label>
   <table id='myTable' style='width:100%' border=1>
  <tr>
  <th>Name</th>
  <th>Telephone</th>
  <th>Address Line 1</th>
  <th>Address Line 2</th>
  <th>Locality</th>
  <th>City</th>
  <th>Country</th>
  </tr>

  <tr>
    <td >".$hospital_['name']."</td>
    <td >".$hospital_['tel']."</td>
    <td >".$hospital_['addressline1']."</td>
    <td>".$hospital_['addressline2']."</td> 
    <td >".$hospital_['locality']."</td>
    <td >".$hospital_['city']."</td>
    <td >".$hospital_['country']."</td>
  </tr>

  <tr>
    <td >".$hospital1_['name']."</td>
    <td >".$hospital1_['tel']."</td>
    <td >".$hospital1_['addressline1']."</td>
    <td>".$hospital1_['addressline2']."</td> 
    <td >".$hospital1_['locality']."</td>
    <td >".$hospital1_['city']."</td>
    <td >".$hospital1_['country']."</td>
  </tr>
</table>
<br>";

    } else {

    	echo "No Disaster Warnings issued!";
    }


echo "<hr>";

$disaster_id = $_SESSION['disaster_event_id']; //From allocator's home-page, this is the most recent disaster event ID

$select_ics = "SELECT * FROM `ics_structure` WHERE `ics_structure`.`disaster_id` = '$disaster_id' ";

	$query_ics = mysqli_query($con,$select_ics);

	$ics_structure = mysqli_fetch_assoc($query_ics);

	if (mysqli_num_rows($query_ics) == 0) {
		
		echo "No Units Responded to this Event as yet!";

	} elseif (mysqli_num_rows($query_ics) == 3) {

		echo "Initial Response Command System have been Established! Incident Commander is ";

		$select = "SELECT * FROM `ics_structure` 
					WHERE `ics_structure`.`disaster_id` = '$disaster_id' OR `ics_structure`.`branch_id_FK` = '1' 
					ORDER BY `ics_structure`.`date_created` DESC LIMIT 1";

			$query = mysqli_query($con,$select);

			$ics_structure = mysqli_fetch_assoc($query);

		$select1 = "SELECT `ics_structure`.*, CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name FROM `ics_structure` 
					JOIN `employees` ON  `ics_structure`.`employee_id_FK` = `employees`.`employee_id` ";

			$query1 = mysqli_query($con,$select1);

			$incident_command = mysqli_fetch_assoc($query1);

			echo "<button id = 'mybutton' onclick = 'call(this.value)'>".$incident_command['employee_name']."</button>" ; //Call Function can be created to can this employee directly
	
	} elseif (mysqli_num_rows($query_ics) > 3) {
		
		echo "Incident Command Established! Please Report to...";
	}
?>