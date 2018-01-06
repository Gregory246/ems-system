<?php
session_start();
include_once('dbconnect.php');
error_reporting(0);

//Firstly create a join to find if the vehicle operator is logged by dispatched for response to a disaster seen... 
//then show the neccessary disaster event details on user's home page if not show nothing
$select10 = "SELECT vehicleteam_id FROM ems_response";
$query10 = mysqli_query($con,$select10);
$ems_response_operator = mysqli_fetch_assoc($query10);


//Get the current user
$userid = $_SESSION['userid'];

$select11 = "SELECT users.*,employees.* 
      FROM users 
      JOIN employees ON users.user_id = employees.user_id 
      WHERE username = '$userid' ";
$query11 = mysqli_query($con,$select11);
$user_id = mysqli_fetch_assoc($query11);

$select11_1 = "SELECT * FROM vehicleteam WHERE $user_id[employee_id] 
              IN ( `operator_FK`, `assistance_FK`, `tech_FK`, `advance_tech_FK`, `paramedic_FK`, `advance_paramedic_FK`, `wilderness_tech_FK`)
              ORDER BY `vehicleteam`.`vehicleteam_id` DESC LIMIT 1";
  $query11_1 = mysqli_query($con,$select11_1);
  $vehicleteam_id = mysqli_fetch_assoc($query11_1);

  //echo $vehicleteam_id['vehicleteam_id'];

//Determines the user's vehicle team ID in database
//$select_team = "SELECT `employees`.*,`users`.*,`vehicleteam`.* FROM `employees`
 //     JOIN `users` ON `employees`.`user_id` = `users`.`user_id`
 //     JOIN `vehicleteam` ON `employees`.`employee_id` = `vehicleteam`.`tech_FK` WHERE `employees`.`user_id` = '$user_id[user_id]' ";

 // $query_team = mysqli_query($con,$select_team);

  //$vehicleteam = mysqli_fetch_assoc($query_team);

//This ensures that the EMS vehicle belonging to user is not updated until recognized by Allocator as EMS Response

while($ems_response_operator = mysqli_fetch_assoc($query10)){

//echo implode(",",$ems_response_operator)."&nbsp;&nbsp;".$vehicleteam_id['vehicleteam_id'];

if($ems_response_operator['vehicleteam_id'] == $vehicleteam_id['vehicleteam_id']){

//Establishes a connection with Database server and select the appropriate Database tables and create join
$query1 = "SELECT disaster_location.*, disaster.*, location.* FROM disaster_location JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id 
            JOIN location ON disaster_location.location_id = location.location_id ORDER BY `disaster_location_junc_id` DESC LIMIT 1"; 

$output = mysqli_query($con,$query1);

$print_output = mysqli_fetch_assoc($output);

$_SESSION['disaster_id'] = $print_output['disaster_id'];

$disastertype1_FKid = $print_output['disastertype1_FK'];//To retrieve the FK_1 id for $query1 current record 

$disastertype2_FKid = $print_output['disastertype2_FK'];//To retrieve the FK_2 id for $query1 current record

$magnitude_FKid = " SELECT magnitude FROM disastermag WHERE disastermagid_FK = '$print_output[disastermagid]'";//Retrieve the FK value of magnitude for current record
$magnitude_FKid_query = mysqli_query($con,$magnitude_FKid);
$mag_level = mysqli_fetch_assoc($magnitude_FKid_query);


$responselevel = "SELECT level FROM disastersystemresponse WHERE disasteralertid_FK = '$print_output[disasteralertid]' ";//Retrieve the FK value of required response for current record
$responselevel_FKid_query = mysqli_query($con,$responselevel);
$response = mysqli_fetch_assoc($responselevel_FKid_query);

$select_1 = "SELECT instructions FROM disaster WHERE date_time = '$print_output[date_time]' ";
$query_select_1 = mysqli_query($con, $select_1);
$instructions = mysqli_fetch_assoc($query_select_1);

$select_2 = "SELECT description FROM disaster WHERE date_time = '$print_output[date_time]' ";
$query_select_2 = mysqli_query($con, $select_2);
$description = mysqli_fetch_assoc($query_select_2);

$select_3 = "SELECT caller_fname, caller_lname, caller_tel, caller_type FROM caller WHERE caller.disaster_id = '$print_output[disaster_id]'";
$query_select_3 = mysqli_query($con,$select_3);
$caller = mysqli_fetch_assoc($query_select_3);


//This if condition is to determine weather Event details are to be displayed on user's page based on event date and local date

$event_date = date("Y-m-d", strtotime($print_output['date_time'])); // Converts disaster date_time to date ONLY

date_default_timezone_set("Etc/GMT+4");
$date = date("Y-m-d");// Gets the current date of the local time server 

echo $date;


if($event_date == $date ){

//This prints a table based on the condition of disaster types, whether 2 or 1 type of disaster. 

if(!empty($disastertype2_FKid) && !empty($disastertype1_FKid)){

  
$query2 = "SELECT DISTINCT disaster_type FROM disastertype WHERE disastertype_id = '$disastertype1_FKid' "; //Retreive the disaster type 1
$output2 = mysqli_query($con,$query2);
$print_output2 = mysqli_fetch_assoc($output2);


$query3 = "SELECT DISTINCT disaster_type FROM disastertype WHERE disastertype_id = '$disastertype2_FKid' "; //Retreive the disaster type 2
$output3 = mysqli_query($con,$query3);
$print_output3 = mysqli_fetch_assoc($output3);


echo"Event Details:";
echo "<table border=1>
<tr>
<th>Natural Event</th>
<th>Technological Event</th>
<th>Date & Time Event Logged</th>
<th>Time Event Occurred(24HH)</th>
<th>Required Response</th>
<th>Disaster Magnitude</th>
<th>Instructions</th>
<th>Description</th>
</tr>";

while($print_output)
{
  echo "<tr>";
  echo "<td>". $print_output2['disaster_type'] . "</td>";
  echo "<td>". $print_output3['disaster_type'] . "</td>";
  echo "<td>". $print_output['date_time'] . "</td>";
  echo "<td>". $print_output['timesignature'] . "</td>";
  echo "<td>". $response['level'] . "</td>";
  echo "<td>". $mag_level['magnitude'] . "</td>";
  echo "<td>". $instructions['instructions'] . "</td>";
  echo "<td>". $description['description'] . "</td>";
  break;
}

echo "</table>";

echo "<hr>";

echo"Event Location:";
echo "<table border=1>
<tr>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>Locality</th>
<th>City</th>
<th>Country</th>
</tr>";

while($print_output){
  echo "<td>". $print_output['addressline1'] . "</td>";
  echo "<td>". $print_output['addressline2'] . "</td>";
  echo "<td>". $print_output['locality'] . "</td>";
  echo "<td>". $print_output['city'] . "</td>";
  echo "<td>". $print_output['country'] . "</td>";
  echo "</tr>";
  break;
}

echo "</table>";

echo "<hr>";

echo"Caller Details:";
echo "<table border=1>
<tr>
<th>Name</th>
<th>Telephone</th>
<th>Type</th>
</tr>";

while($caller){
  echo "<td>". $caller['caller_fname'] . "&nbsp;" . $caller['caller_lname'] . "</td>";
  echo "<td>". $caller['caller_tel'] . "</td>";
  echo "<td>". $caller['caller_type'] . "</td>";
  echo "</tr>";
  break;
}

echo "</table>";


}//To avoid errors in the event this field is empty

if(!empty($disastertype2_FKid) && empty($disastertype1_FKid)){

$query3 = "SELECT DISTINCT disaster_type FROM disastertype WHERE disastertype_id = '$disastertype2_FKid' "; //Retreive the disaster type 2
$output3 = mysqli_query($con,$query3);
$print_output3 = mysqli_fetch_assoc($output3);


echo"Event Details:";
echo "<table border=1>
<tr>
<th>Technological Event</th>
<th>Date & Time Event Logged</th>
<th>Time Event Occurred(24HH)</th>
<th>Required Response</th>
<th>Disaster Magnitude</th>
<th>Instructions</th>
<th>Description</th>
</tr>";

while($print_output)
{
  echo "<tr>";
  echo "<td>". $print_output3['disaster_type'] . "</td>";
  echo "<td>". $print_output['date_time'] . "</td>";
  echo "<td>". $print_output['timesignature'] . "</td>";
  echo "<td>". $response['level'] . "</td>";
  echo "<td>". $mag_level['magnitude'] . "</td>";
  echo "<td>". $instructions['instructions'] . "</td>";
  echo "<td>". $description['description'] . "</td>";
  break;
}

echo "</table>";

echo "<hr>";

echo"Event Location:";
echo "<table border=1>
<tr>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>Locality</th>
<th>City</th>
<th>Country</th>
</tr>";

while($print_output){
  echo "<td>". $print_output['addressline1'] . "</td>";
  echo "<td>". $print_output['addressline2'] . "</td>";
  echo "<td>". $print_output['locality'] . "</td>";
  echo "<td>". $print_output['city'] . "</td>";
  echo "<td>". $print_output['country'] . "</td>";
  echo "</tr>";
  break;
}

echo "</table>";

echo "<hr>";

echo"Caller Details:";
echo "<table border=1>
<tr>
<th>Name</th>
<th>Telephone</th>
<th>Type</th>
</tr>";

while($caller){
  echo "<td>". $caller['caller_fname'] . "&nbsp;" . $caller['caller_lname'] . "</td>";
  echo "<td>". $caller['caller_tel'] . "</td>";
  echo "<td>". $caller['caller_type'] . "</td>";
  echo "</tr>";
  break;
}

echo "</table>";
}

if(empty($disastertype2_FKid) && !empty($disastertype1_FKid)){

  $query2 = "SELECT DISTINCT disaster_type FROM disastertype WHERE disastertype_id = '$disastertype1_FKid' "; //Retreive the disaster type 1
$output2 = mysqli_query($con,$query2);
$print_output2 = mysqli_fetch_assoc($output2);



echo"Event Details:";
echo "<table border=1>
<tr>
<th>Natural Event</th>
<th>Date & Time Event Logged</th>
<th>Time Event Occurred(24HH)</th>
<th>Required Response</th>
<th>Disaster Magnitude</th>
<th>Instructions</th>
<th>Description</th>
</tr>";

while($print_output)
{
  echo "<tr>";
  echo "<td>". $print_output2['disaster_type'] . "</td>";
  echo "<td>". $print_output['date_time'] . "</td>";
  echo "<td>". $print_output['timesignature'] . "</td>";
  echo "<td>". $response['level'] . "</td>";
  echo "<td>". $mag_level['magnitude'] . "</td>";
  echo "<td>". $instructions['instructions'] . "</td>";
  echo "<td>". $description['description'] . "</td>";
  echo "</tr>";
  break;
}

echo "</table>";

echo "<hr>";

echo"Event Location:";
echo "<table border=1>
<tr>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>Locality</th>
<th>City</th>
<th>Country</th>
</tr>";

while($print_output){
  echo "<tr>";
  echo "<td>". $print_output['addressline1'] . "</td>";
  echo "<td>". $print_output['addressline2'] . "</td>";
  echo "<td>". $print_output['locality'] . "</td>";
  echo "<td>". $print_output['city'] . "</td>";
  echo "<td>". $print_output['country'] . "</td>";
  echo "</tr>";
  break;
}

echo "</table>";

echo "<hr>";

echo"Caller Details:";
echo "<table border=1>
<tr>
<th>Name</th>
<th>Telephone</th>
<th>Type</th>
</tr>";

while($caller){
  echo "<td>". $caller['caller_fname'] . "&nbsp;" . $caller['caller_lname'] . "</td>";
  echo "<td>". $caller['caller_tel'] . "</td>";
  echo "<td>". $caller['caller_type'] . "</td>";
  echo "</tr>";
  break;
}

echo "</table>";
}

} else{     

  echo "<p style ='text-align:center;color:red;font-size:30px'>"."<strong>"."No Recent Disasters. Checking System, Please wait...<br>and<br> Remember to have a Great Day!
        "."</strong>"."</p>";

}


} else{

  //echo "<p style ='text-align:center;color:red;font-size:30px'>"."<strong>"."No Recent Event Updates. Checking System, Please wait..."."</strong>"."</p>";
}

}//End of while loop
?>