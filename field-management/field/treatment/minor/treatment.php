<?php
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//if(!isset($_SESSION['userid'])){

//  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
//  header("Location: http://$host/ems/");
//        exit();
//}
      
    //  date_default_timezone_set("Etc/GMT+4");
    //  $date = date("Y-m-d");// Gets the current date of the local time server

     // $disaster_id = $_SESSION['disaster_id']; //From get-disaster-id.php in Field directory 

     // $select = "SELECT disaster.*,location.*, CONCAT(location.addressline1,' ',location.addressline2,' ',location.city,' ',location.locality,' ',location.country)location, disaster_location.*
       //          FROM disaster_location
       //          JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id
        //         JOIN location ON disaster_location.location_id = location.location_id
         //        WHERE date(disaster.date_time) = '$date'";

        // $query = mysqli_query($con,$select);

        // $disaster = mysqli_fetch_assoc($query);

      // $select1 = "SELECT * FROM victim WHERE victim.disaster_id = '$disaster_id' ";

        //  $query1 = mysqli_query($con,$select);

        //  $victim_key = mysqli_fetch_assoc($query1) ;

?>
<!DOCTYPE html>
<html>
<head>
<title>Disaster Info</title>
<meta http-equiv="refresh" content="">

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
    <li class="w3-hide-small"><a href="\EMS\field-management\field\treatment\minor\home-page.php" class="w3-hover-white">Medical Teams</a></li> 
    <li class="w3-hide-small"><a href="\EMS\field-management\field\treatment\minor\assign-teams.php" class="w3-hover-white">Assign Teams</a></li> 
    <li class="w3-hide-small"><a href="\EMS\field-management\field\treatment\minor\treatment.php" class="w3-hover-white">Treatment</a></li><!--
    <li class="w3-hide-small"><a href="\EMS\field-management\" class="w3-hover-white">#</a></li> 
    <li class="w3-hide-small"><a href="\EMS\field-management\" class="w3-hover-white">#</a></li> --> &#9855;
    <li class="w3-hide-medium w3-hide-small"><a href="\ems\logout.php" class="w3-hover-white">Log Out</a></li>
    </li> 

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



<body onload="startTime();getVictim()" >
<!--Banner top of web-->

<br>
<button id="myButton" class="submit" style="width:75px; height:25px;text-align:center"  ><strong>Home</strong></button>


<script type="text/javascript">
    document.getElementById("myButton").onclick = function () {
        location.href = "home-page.php";
    }
</script>
<hr>

<div align = "center">
 <?php //echo $_SESSION['userid'] ?> 
<p><strong>ALL FIELDS ARE MANDATORY. IN THE EVENT A FIELD DOES NOT APPLY USE "NOT REQUIRED" AND THEN SUBMIT!</strong></p>
<button id="myButton" style="width:150px; height:30px;" onclick="requestTeams()"><strong>Request Supplies</strong></button><!--
<button id="myButton1" style="width:150px; height:30px;" onclick="establishTeams()"><strong>Establish Teams</strong></button> -->
<br></br>
<div id= "medicalrequest"></div>

<hr>
<div id = "test1" ></div>
<br>

<script type="text/javascript">

      function resetTable(){

          document.getElementById("complete").checked? = true:false;
          document.getElementById("victim_unique_key_id").value = "" ;
          document.getElementById("treatment").value = "";
          
          document.getElementById("pre_num").value = "";
          document.getElementById("pre_name").value = "";
          document.getElementById("dose_freq").value = "";
          document.getElementById("max_dose").value = "";
          document.getElementById("purpose").value = "";
          document.getElementById("device_type").value = "";
          document.getElementById("device_name").value = "";
          document.getElementById("device_no").value = "";
      }
</script>


<script type="text/javascript">
      
      function getVictim(){

           

          if(window.XMLHttpRequest){
        //for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {

        //For older browsers 
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.onreadystatechange = function(){

          if(this.readyState == 4 && this.status == 200){
            document.getElementById("test1").innerHTML = this.responseText;
          }
      }
xmlhttp.open("GET","treatment-handler.php",true);
      xmlhttp.send();
      
      }

</script>

<script type="text/javascript">
      
      function victimTreatment(){

          var complete = document.getElementById("complete").checked;
          var victim_unique_key_id = document.getElementById("victim_unique_key_id").value;
          var treatment = document.getElementById("treatment").value;
          var start_time = document.getElementById("start_time").value;
          var end_time = document.getElementById("end_time").value;
          var pre_num = document.getElementById("pre_num").value;
          var pre_name = document.getElementById("pre_name").value;
          var dose_freq = document.getElementById("dose_freq").value;
          var max_dose = document.getElementById("max_dose").value;
          var purpose = document.getElementById("purpose").value;
          var device_type = document.getElementById("device_type").value;
          var device_name = document.getElementById("device_name").value;
          var device_no = document.getElementById("device_no").value;
           

          if(window.XMLHttpRequest){
        //for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {

        //For older browsers 
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.onreadystatechange = function(){

          if(this.readyState == 4 && this.status == 200){
            document.getElementById("test1").innerHTML = this.responseText;
          }
      }
xmlhttp.open("GET","submit-treatment-handler.php?complete="+complete+"&victim_unique_key_id="+victim_unique_key_id+"&treatment="+treatment+"&start_time="+start_time+"&end_time="+end_time+"&pre_num="+pre_num+"&pre_name="+pre_name+"&dose_freq="+dose_freq+"&max_dose="+max_dose+"&purpose="+purpose+"&device_type="+device_type+"&device_name="+device_name+"&device_no="+device_no,true);
      xmlhttp.send();
       resetTable();
      getVictim();
      }

</script>

<script type="text/javascript">
      
      function requestTeams(){

          if(window.XMLHttpRequest){
        //for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {

        //For older browsers 
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.onreadystatechange = function(){

          if(this.readyState == 4 && this.status == 200){
            document.getElementById("medicalrequest").innerHTML = this.responseText;
          }
      }
xmlhttp.open("GET","request-medical-supplies.php",true);
      xmlhttp.send();
       resetTable();
      }

</script>

<!--This retrieves the most recent disaster event where the user is required to respond      -->


  <!--This sends the user's geo-location to the database for vehicle tracking purposes -->
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