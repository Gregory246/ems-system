<?php 
include_once('dbconnect.php');

$agency = $_GET['agency'];

$select = "SELECT agency.agency_name,department.department_name, IFNULL(department.department_fax,'~')department_fax,
			employees.employee_fname,employees.employee_lname,employees.employee_title,employees.employee_field,employees.employee_role,employees.employee_tele,
			employees.employee_cell,employees.employee_email 
		FROM employees_department_junc JOIN department ON employees_department_junc.department_FK_id = department.department_id 
		JOIN employees ON employees_department_junc.employee_FK_id = employees.employee_id 
		JOIN agency ON department.agency_id = agency.agency_id WHERE agency.agency_name = '$agency' ";
$query = mysqli_query($con,$select);
$contacts = mysqli_fetch_assoc($query);

//<input type='button' name='submit' value=" " onclick ="showNewTable()" />

//echo "<strong>"."Contacts:"."</strong>";
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
	echo "<td>". $contacts['department_fax'] . "</td>";  // row[1]
	//echo "<td>". $contacts['employee_fname'] . "</td>";	 // row[2]
	echo "<td>". $contacts['employee_fname'] . "&nbsp;" . $contacts['employee_lname'] . "</td>";  // row[3]
	echo "<td>". $contacts['employee_title'] . "</td>";  // row[4]
	echo "<td>". $contacts['employee_field'] . "</td>";  // row[5]
	echo "<td>". $contacts['employee_role'] . "</td>";   // row[6]
	echo "<td>". "<input type='button' style='background-color:#f44336;border:2px solid black;' name='submit' value=" . $contacts['employee_tele'] . " onclick='makeCall(this.value)'/>"."</td>"; // row[7]
	echo "<td>". $contacts['employee_cell'] . "</td>"; // row[8]
	echo "<td>". $contacts['employee_email'] . "</td>"; // row[9]
	echo "</tr>";

} while($contacts = mysqli_fetch_assoc($query));

echo "</table>";


?>