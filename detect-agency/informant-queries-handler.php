<?php 
include_once('dbconnect.php');

$agency = $_GET['agency'];

//Selects the id of that given Agency
$select = "SELECT agency_id FROM agency WHERE agency_name = '$agency'";

$query = mysqli_query($con,$select);

$agency_id = mysqli_fetch_assoc($query);


//Selects the Department id's that is associated with that given agency
$select1 = "SELECT department_id FROM department WHERE department.agency_id = '$agency_id[agency_id]' ";

$query1 = mysqli_query($con,$select1);

while ($department_id = mysqli_fetch_assoc($query1)){

$row[] = $department_id['department_id'];

}


//Recursively walks through the department array in order to select all employee id foreign keys in employees_department table
function walk_throu1(&$value){

$con = mysqli_connect("localhost","root","");
mysqli_select_db($con, "initial_alert_v0");

	$select2_1 = "SELECT DISTINCT employee_FK_id FROM employees_department_junc WHERE employees_department_junc.department_FK_id = '$value' ";

    $query1_1 = mysqli_query($con,$select2_1);
    $employee_FK_id = mysqli_fetch_assoc($query1_1);

 	$value = $employee_FK_id['employee_FK_id']; //Change original values of the array as the function walks through
	
	return;
}


array_walk_recursive($row, "walk_throu1");
//**filters array of duplicate and empty values**
$employee_id = array_unique(array_filter($row));
//-----------------------------------------------------------------------------

//Recursively walks through the department array in order to select all employee id foreign keys in employees_department table
function walk_throu2(&$value){

		$con = mysqli_connect("localhost","root","");
		mysqli_select_db($con, "initial_alert_v0");

	$select3 = "SELECT DISTINCT user_id FROM employees WHERE employees.employee_id = '$value' ";

	$query2_1 = mysqli_query($con,$select3);

    $user_id = mysqli_fetch_assoc($query2_1);

	$value = $user_id['user_id'];
	echo "<hr>";
}


array_walk_recursive($employee_id, "walk_throu2");
$user_id = $employee_id;
//print_r(($user_id));
//--------------------------------------------------------------------- 


if($_GET['period'] == "true"){

	$fromyear = $_GET['fromyear'];
	$toyear = $_GET['toyear'];

	$select4 = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
				JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
				JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
				JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK 
				WHERE disaster.date_time BETWEEN CAST('$fromyear' AS DATE) AND CAST('$toyear'AS DATE) AND disaster.user_id =" . implode('',$user_id)." ";

		$query3 = mysqli_query($con,$select4);

echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>aDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

while($disasters = mysqli_fetch_assoc($query3))
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

} 

echo "</table>";

} else {

	echo implode("", $user_id);

	$select4 = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disaster.user_id =" . implode('',$user_id)." ";

		$query3 = mysqli_query($con,$select4);

		echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>bDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

while($disasters = mysqli_fetch_assoc($query3))
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

} 

echo "</table>";
}

?>