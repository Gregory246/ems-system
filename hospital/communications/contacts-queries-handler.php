<?php 
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');




if(!empty($_GET['agency'])){

$hospital = $_GET['agency'];

$select = "SELECT facility.name, hospital_department.department_name,facility.fax, hospital_employees.* 
			FROM `facility` 
			JOIN hospital_department ON hospital_department.hospital_facility_id = facility.facility_id 
			JOIN hospital_employees ON hospital_employees.hospital_department_id = hospital_department.hospital_department_id 
			WHERE facility.name = '$hospital' ";

$query = mysqli_query($con,$select);
$contacts = mysqli_fetch_assoc($query);

//<input type='button' name='submit' value=" " onclick ="showNewTable()" />

//echo "<strong>"."Contacts:"."</strong>"; 
echo "Works"; 
echo "<table border=1>
<tr>
<th>Department</th>
<th>Department Fax</th>

<th>Employee's Name</th>
<th>Title</th>
<th>Field</th>
<th>Role</th>
<th>Telephone</th>
<th>Cell</th>
<th>Email</th>
</tr>";

do{

	echo "<tr>";
	echo "<td>". $contacts['department_name'] . "</td>"; // row[0]
	echo "<td>". $contacts['fax'] . "</td>";  // row[1]
	echo "<td>". $contacts['fname'] . "&nbsp;" . $contacts['lname'] . "</td>";  // row[3]
	echo "<td>". $contacts['title'] . "</td>";  // row[4]
	echo "<td>". $contacts['field'] . "</td>";  // row[5]
	echo "<td>". $contacts['role'] . "</td>";   // row[6]
	echo "<td>". "<input type='button' style='background-color:#f44336;border:2px solid black;' name='submit' value=" . $contacts['tele'] . " onclick='makeCall(this.value)'/>"."</td>"; // row[7]
	echo "<td>". $contacts['cell'] . "</td>"; // row[8]
	echo "<td>". $contacts['email'] . "</td>"; // row[9]
	echo "</tr>";

} while($contacts = mysqli_fetch_assoc($query));

echo "</table>";

}else{}


if (!empty($_GET['vehicle_emt'])) {
	
	$vehicle_emt = $_GET['vehicle_emt'];

	$select11 = "SELECT vehicleteam.*,employees.*,employees_department_junc.*,department.*,agency.*
                            FROM vehicleteam 
                            JOIN employees ON vehicleteam.advance_tech_FK = employees.employee_id 
                            JOIN employees_department_junc ON employees.employee_id = employees_department_junc.employee_FK_id
                            JOIN department ON employees_department_junc.department_FK_id = department.department_id
                            JOIN agency ON department.agency_id = agency.agency_id
                            WHERE vehicleteam.vehicleteam_id = '$vehicle_emt'";

                $query11 = mysqli_query($con,$select11);

                $contacts = mysqli_fetch_assoc($query11);

echo "<table border=1>
<tr>
<th>Department</th>
<th>Agency</th>

<th>Employee's Name</th>
<th>Title</th>
<th>Field</th>
<th>Telephone</th>
<th>Cell</th>
<th>Email</th>
</tr>";

do{

	echo "<tr>";
	echo "<td>". $contacts['department_name'] . "</td>"; // row[0]
	echo "<td>". $contacts['agency_name'] . "</td>";  // row[1]
	echo "<td>". $contacts['employee_fname'] . "&nbsp;" . $contacts['employee_lname'] . "</td>";  // row[3]
	echo "<td>". $contacts['employee_title'] . "</td>";  // row[4]
	echo "<td>". $contacts['employee_field'] . "</td>";  // row[5]
	echo "<td>". "<input type='button' style='background-color:#f44336;border:2px solid black;' name='submit' value=" . $contacts['employee_tele'] . " onclick='makeCall(this.value)'/>"."</td>"; // row[7]
	echo "<td>". $contacts['employee_cell'] . "</td>"; // row[8]
	echo "<td>". $contacts['employee_email'] . "</td>"; // row[9]
	echo "</tr>";

} while($contacts = mysqli_fetch_assoc($query));

echo "</table>";

} else {}
?>