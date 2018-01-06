<?php
session_start();

 include_once('dbconnect.php');


if(!isset($_SESSION['userid'])){

  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
  header("Location: http://$host/ems/");
        exit();
}
 

?>

<!DOCTYPE html>
<html>
<title>Disaster Info</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
.w3-sidenav a,.w3-sidenav h4 {padding: 12px;}
.w3-navbar li a {
    padding-top: 12px;
    padding-bottom: 12px;
}
</style>
<body>

<!-- Navbar -->
<div class="w3-top">
  <ul class="w3-navbar w3-theme w3-top w3-left-align w3-large">
    <li class="w3-opennav w3-right w3-hide-large">
      <a class="w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
   </li>
    <li><a href="\ems\dispatch\home-page.php" class="w3-theme-l1"><strong>EMS</strong></a></li>
    <li class="w3-hide-small"><a href="\ems\dispatch\psap\home-page.php" class="w3-hover-white">Home</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\psap\monitor-window.php" class="w3-hover-white">Monitor</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\psap\log-event1.php" class="w3-hover-white">Log Event</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\psap\dispatch-views.php" class="w3-hover-white">Notifiers</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\psap\event-queries-location.php" class="w3-hover-white">Search</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\psap\contacts.php" class="w3-hover-white">Contacts</a></li>
    <li class="w3-hide-medium w3-hide-small"><a href="\ems\logout.php" class="w3-hover-white">Log Out</a></li>
    <li class="w3-hide-medium w3-hide-small"><a href="#" class="w3-hover-white"></a></li>

    <p id="clock"></p>
<script>
function startTime() {
    var d = new Date();
    var n = d.toTimeString();
    document.getElementById("clock").innerHTML = n;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>
  </ul>
</div>



<!-- Main content: shift it to the right by 250 pixels when the sidenav is visible -->
<div class="w3-main" style="margin-top:75px">

  <!--Sets styles for text boxes, images required on screen-->

<style type="text/css">

img
{
  display: block;
  margin:left auto;
}

textarea 
{

    display: block;
  width: 30%;
}

</style>



<body onload="startTime()" >
<!--Banner top of web-->

<br>
<button id="myButton" class="submit" style="width:75px; height:25px;text-align:center"  ><strong>Home</strong></button>

<!-- Confirms the last record when updated by IC of Field Management through allocator-->
<button id="myButton" class="submit" style="width:75px; height:25px;text-align:center"  ><strong>Confirm!</strong></button>

<script type="text/javascript">
    document.getElementById("myButton").onclick = function () {
        location.href = "home-page.php";
    }
</script>
<hr>

<div style ="text-align:left">
<?php

//Establishes a connection with Database server and select the appropriate Database tables and create join
$query1 = "SELECT disaster_location.*, disaster.*, location.* FROM disaster_location JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id 
            JOIN location ON disaster_location.location_id = location.location_id ORDER BY `disaster_location_junc_id` DESC LIMIT 1";

$output = mysqli_query($con,$query1);

$print_output = mysqli_fetch_assoc($output);

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
  echo "<td><input type='text' name='addressline1' id='addressline1' size='36' value=". $print_output['addressline1'] . "/></td>";
  echo "<td><input type='text' name='addressline2' id='addressline2'  value=". $print_output['addressline2'] . "/></td>";
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
  echo "<td><input type='text' name='addressline1' id='addressline1' value=". $print_output['addressline1'] . " /></td>";
  echo "<td><input type='text' name='addressline2' id='addressline2'  value=" . $print_output['addressline2'] . " /></td>";
  echo "<td><input type='text' name='locality' id='locality'  value=". $print_output['locality'] . " /></td>";
  echo "<td><input type='text' name='city' id='city'  value=". $print_output['city'] . " /></td>";
  echo "<td><input type='text' name='country' id='country'  value=". $print_output['country'] . " /></td>";
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

?>

</div>
<br></br><br></br><br></br><br></br><br></br><br></br>
  <footer id="myFooter">
    <div class="w3-container w3-theme-l2 w3-padding-32">
      <h4>Footer</h4>
    </div>

    <div class="w3-container w3-theme-l1">
      <p>Powered by <a href="http://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>

<!-- END MAIN -->
</div>

<script>
// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
    if (mySidenav.style.display === 'block') {
        mySidenav.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidenav.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidenav with the close button
function w3_close() {
    mySidenav.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>
