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
<title>Disaster Info</title>
<meta http-equiv="refresh" content="15 ">
<script type="text/javascript">
   		
            function showLocation(position) {
               var latitude = position.coords.latitude;
               var longitude = position.coords.longitude;
               //alert("Latitude : " + latitude + " Longitude: " + longitude);

               document.getElementById('txthint1').value = latitude;
               document.getElementById('txthint2').value = longitude;
            }

            function errorHandler(err) {
               if(err.code == 1) {
                  alert("Error: Access is denied!");
               }
               
               else if( err.code == 2) {
                  alert("Error: Position is unavailable!");
               }
            }
   			
            function getLocation(){

               if(navigator.geolocation){
                  // timeout at 60000 milliseconds (60 seconds)
                  var options = {timeout:60000};
                  navigator.geolocation.getCurrentPosition(showLocation, errorHandler, options);
               }
               
               else{
                  alert("Sorry, browser does not support geolocation!");
               }
            };
   			
         </script>
</head>
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


<!-- Navbar -->
<div class="w3-top">
  <ul class="w3-navbar w3-theme w3-top w3-left-align w3-large">
    <li class="w3-opennav w3-right w3-hide-large">
      <a class="w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="\ems\dispatch\home-page.php" class="w3-theme-l1"><strong>EMS</strong></a></li>
    <li class="w3-hide-small"><a href="\ems\dispatch\allocator\home-page.php" class="w3-hover-white">Home</a></li>
    <!--<li class="w3-hide-small"><a href="\EMS\dispatch\allocator\log-event1.php" class="w3-hover-white">Update</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\allocator\dispatch-views.php" class="w3-hover-white">Notifiers</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\allocator\event-queries-location.php" class="w3-hover-white">Search</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\allocator\geo-location.php" class="w3-hover-white">Geo-Location</a></li> -->
    <li class="w3-hide-medium w3-hide-small"><a href="\ems\logout.php" class="w3-hover-white">Log Out</a></li>
    <li class="w3-hide-medium w3-hide-small"><a href="#" class="w3-hover-white"></a></li> 

    <p align="center" id="clock"></p>
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



<body onload="startTime();disasterevent();getLocation();setintval()" >
<!--Banner top of web-->

<br>
<button id="myButton" class="submit" style="width:75px; height:25px;text-align:center"  ><strong>Home</strong></button>
<script type="text/javascript">
    document.getElementById("myButton").onclick = function () {
        location.href = "home-page.php";
    }
</script>
<hr>

<div style ="text-align:left">
	<input type="text" id="txthint1" name="txthint1" /> <br><br>
         <input type="text" id="txthint2" name="txthint2" /> 
<div id= "test"></div>
<div id = "geo" ></div>
<!--This retrieves the most recent disaster event where the user is required to respond      -->
<script type="text/javascript">

  function disasterevent(){

    
      if(window.XMLHttpRequest){
        //for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {

        //For older browsers 
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.onreadystatechange = function(){

          if(this.readyState == 4 && this.status == 200){
            document.getElementById("test").innerHTML = this.responseText;
          }
      }
      xmlhttp.open("GET","event-record-handler.php",true);
      xmlhttp.send();
  }


  </script>

  <script type="text/javascript">
//Set interval to send the coordinates to the database 'just' before the user's page is refreshed. 
        function setintval(){

          setInterval(geoTrack,10000);

        }
  </script>

  <!--This sends the user's geo-location to the database for vehicle tracking purposes -->
  <script type="text/javascript">


    function geoTrack() {

    	var latitude = document.getElementById('txthint1').value ; //Converts String to decimal and then stores value in variable
        var longitude = document.getElementById('txthint2').value ;

 // } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("geo").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET", "send_geoLocation.php?latitude=" +latitude+"&longitude="+longitude,true);
  xmlhttp.send();
}
   
</script>

</div>
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