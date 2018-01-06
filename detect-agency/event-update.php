<?php

//session_start();
 
 include_once('dbconnect.php');
 

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
    <li><a href="\ems\detect-agency\home-page.php" class="w3-theme-l1"><strong>EMS</strong></a></li>
    <li class="w3-hide-small"><a href="\ems\detect-agency\home-page.php" class="w3-hover-white">Home</a></li>
    <li class="w3-hide-small"><a href="\EMS\detect-agency\log-event1.php" class="w3-hover-white">Log Details</a></li>
    <li class="w3-hide-small"><a href="" class="w3-hover-white">Queries</a></li>
    <li class="w3-hide-small"><a href="\EMS\detect-agency\contacts.php" class="w3-hover-white">Contacts</a></li>
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
<img src="webpageimages/EMSlogo.jpg" style="width:180px;height:110px;"/>
<br></br><br></br>

<div style ="text-align:center">
<?php

      //$sqlSELECT = mysqli_query($con, 'SELECT disastergroup FROM disastergroups');

     //$sqlSELECTsubn = mysqli_query($con, 'SELECT subgroup_nat FROM disastersubgroup_nat');

     //$sqlSELECTsubt = mysqli_query($con, 'SELECT subgroup_tech FROM disastersubgroup_tech');

//Establishes a connection with Database server and select the appropriate Database
$query1 = "SELECT disaster_location.*, disaster.*, location.* FROM disaster_location JOIN disaster ON disaster_location.disaster_id = disaster.disasterid 
            JOIN location ON disaster_location.location_id = location.locationid ORDER BY `disaster_location_junc_id` DESC LIMIT 1";

$output = mysqli_query($con,$query1);

$dummy = mysqli_query($con,'SELECT * FROM disaster ORDER BY disasterid DESC LIMIT 1');

$num_rows = mysqli_num_rows($dummy);

$output = mysqli_query($con,$query1);

$print_output = mysqli_fetch_assoc($output);

$disastertype1_FKid = $print_output['disastertype1_FK'];//To retrieve the FK_1 id for $query1 current record 

$disastertype2_FKid = $print_output['disastertype2_FK'];//To retrieve the FK_2 id for $query1 current record

$magnitude_FKid = " SELECT magnitude FROM disastermag WHERE disastermagid_FK = '$print_output[disastermagid]'";//Retrieve the FK value of magnitude for current record
$magnitude_FKid_query = mysqli_query($con,$magnitude_FKid);
$mag_level = mysqli_fetch_assoc($magnitude_FKid_query);


$responselevel = "SELECT level FROM disastersystemresponse WHERE disasteralertid_FK = '$print_output[disasteralertid]' ";//Retrieve the FK value of required response for current record
$magnitude_FKid_query = mysqli_query($con,$magnitude_FKid);
$responselevel_FKid_query = mysqli_query($con,$responselevel);
$response = mysqli_fetch_assoc($responselevel_FKid_query);


$query2 = "SELECT * FROM disastertype WHERE disastertype_id = '$disastertype1_FKid' ";
$output2 = mysqli_query($con,$query2);
$print_output2 = mysqli_fetch_assoc($output2);


//PLEASE READ ME!!: THE NEXT STEP IS TO ORGANIZE THE TABLE BELOW TO THE NEW QUERIES ABOVE,


echo "<table width=100% frame=above border=1>
<tr>
<th>Date</th>
<th>Disaster Group</th>
<th>Technological</th>
<th>Natural</th>
<th>Type_1</th>
<th>Sub_Type_1</th>
<th>Type_2</th>
<th>Sub_Type_2</th> 
<th>Scale</th>
<th>Required Response</th>
<th>Event Time</th>
</tr>";
 
if($num_rows > 0){

while($print_output = mysqli_fetch_assoc($output))

{
    //$row1['disastergroup']

  //$row1 = mysqli_fetch_assoc($sqlSELECT);
  $row5 = mysqli_fetch_assoc($sqlSELECTsubn);
  $row6 = mysqli_fetch_assoc($sqlSELECTsubt);


  echo "<form action=detectingdisaster_log.php method=POST>";
  echo "<tr>";
  echo "<td>". $print_output['date_time'] . "</td>";

  echo "<td>" . "<select name=disastergroup> <option value=>" . $print_output['disastergroup'] . "</option> <option value=>"  .  "$rowoutput[disastergroup]" . "</option></select>" .  "  </td>";

  echo "<td>" . "<select name=subgroup_tech> <option value=>" . $print_output['subgroup_tech'] . "</option>" . "  <option value=>"  . "$row6[subgroup_tech]" . "</option></select>" .  " </td>";

  echo "<td>". "<select name=disastersubgroup_nat required> <option value=>" . $print_output['subgroup_nat'] . "</option>" . "  <option value=>"  . "$row5[subgroup_nat]" . "</option></select>" .  " </td>";

  echo "<td>" .  "<input type=text name=disastertype value=" . $print_output['disastertype'] .  " </td>";

  echo "<td>". "<input type=text name=disastersubtype value=" . $print_output['disastersubtype'] . " </td>";

  echo "<td>". "<input type=text name=disastertype2 value=" . $print_output['disastertype2'] . " </td>";

  echo "<td>". "<input type=text name=disastersubtype1 value=" . $print_output['disastersubtype1'] . " </td>";

  echo "<td>". $print_output['magnitude'] . "</td>";
  echo "<td>". $print_output['level'] . "</td>";
  echo "<td>". $print_output['timesignature'] . "</td>";
  echo "</tr>";
  break;
  echo "</form>";
}

echo "</table>";


echo "<table width=100% frame=above border=1>
 <tr>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>Locality</th>
<th>City</th>
<th>Country</th>
</tr>";

while($print_output = mysqli_fetch_assoc($output))
{
  echo "<form action=detectingdisaster_log.php method=POST>";
  echo "<tr>";
  echo "<td>" . "<input type=text name=addressline1 value=" . $print_output['addressline1'] . " </td>";
  echo "<td>". "<input type=text name=addressline2 value=" . $print_output['addressline2'] . " </td>";
  echo "<td>". "<input type=text name=locality value=" . $print_output['locality'] . " </td>";
  echo "<td>". "<input type=text name=city value=" . $print_output['city'] . " </td>";
  echo "<td>". "<input type=text name=country value=" . $print_output['country'] . " </td>";
  echo "</tr>";
  break;
  echo "</form>";
}


echo "</table>";

echo "<input type=submit name=submit value=UPDATE>";

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
