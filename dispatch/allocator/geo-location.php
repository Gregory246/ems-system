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
<head>
<title>Locations</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
</head>
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
.w3-sidenav a,.w3-sidenav h4 {padding: 12px;}
.w3-navbar li a {
    padding-top: 12px;
    padding-bottom: 12px;
}
</style>
<body onload="startTime()">
	<!-- Navbar -->
<div class="w3-top">
  <ul class="w3-navbar w3-theme w3-top w3-left-align w3-large">
    <li class="w3-opennav w3-right w3-hide-large">
      <a class="w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="\ems\dispatch\home-page.php" class="w3-theme-l1"><strong>EMS</strong></a></li>
    <li class="w3-hide-small"><a href="\ems\dispatch\allocator\home-page.php" class="w3-hover-white">Home</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\allocator\dispatch.php" class="w3-hover-white">Dispatch</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\allocator\dispatch-views.php" target = "_blank" class="w3-hover-white">Notifiers</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\allocator\event-queries-location.php" class="w3-hover-white">Search</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\allocator\geo-location.php" class="w3-hover-white">Geo-Location</a></li>
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
<form method = "GET" action = "google-directions.php" target = "_blank">
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


<?php



//Establishes a connection with Database server and select the appropriate Database tables and create join
$query1 = "SELECT disaster_location.*, disaster.*, location.* FROM disaster_location JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id 
            JOIN location ON disaster_location.location_id = location.location_id ORDER BY `disaster_location_junc_id` DESC LIMIT 1"; 

$output = mysqli_query($con,$query1);

$print_output = mysqli_fetch_assoc($output);

?>
<label><strong>Event Location:</strong></label>
<table id="myTable" style="width:100%" border=1>
  <tr>
    <th>Address Line 1</th>
	<th>Address Line 2</th>
	<th>Locality</th>
	<th>City</th>
	<th>Country</th>
  </tr>

  <tr>
    <td ><?php echo $print_output['addressline1']; ?></td>
    <td><?php echo $print_output['addressline2']; ?></td> 
    <td ><?php echo $print_output['locality']; ?></td>
    <td ><?php echo $print_output['city']; ?></td>
    <td ><?php echo $print_output['country']; ?></td>
    
  </tr>
</table> 

<input type = "text" id = "addressline1" name = "addressline1" hidden/>
<input type = "text"  id = "addressline2" name = "addressline2" hidden/>
<input type = "text"  id = "locality" name = "locality" hidden/>
<input type = "text"  id = "city" name = "city" hidden/>
<input type = "text"  id = "country" name = "country" hidden/> 
<!-- <button id= "serch" onclick = "geoLocation()">Search!</button><hr> -->
<input type = "submit" id = "submit" value = "Submit!" /><hr>

</form>

</div>
<script type="text/javascript">

				window.onload = function(){
			var addy1 = document.getElementById("myTable").rows[1].cells[0].innerHTML;
			var addy2 = document.getElementById("myTable").rows[1].cells[1].innerHTML;
			var locality = document.getElementById("myTable").rows[1].cells[2].innerHTML;
			var city = document.getElementById("myTable").rows[1].cells[3].innerHTML;
			var country = document.getElementById("myTable").rows[1].cells[4].innerHTML;
			
			document.getElementById("addressline1").value = addy1;
			document.getElementById("addressline2").value = addy2;
			document.getElementById("locality").value = locality;
			document.getElementById("city").value = city;
			document.getElementById("country").value = country;
		};
</script>
<div class="w3-main" style="margin-top:250px"></div>
<br></br><br></br>
  <footer id="myFooter" style="position:relative">
    <div class="w3-container w3-theme-l2 w3-padding-32">
      <h4>Footer</h4>
    </div>

    <div class="w3-container w3-theme-l1">
      <p>Powered by <a href="http://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>

<!-- END MAIN -->
</div>
   
</body>
</html>