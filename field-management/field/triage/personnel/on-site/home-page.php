<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//if(!isset($_SESSION['userid'])){

//  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
//  header("Location: http://$host/ems/");
//        exit();
//}
      
      date_default_timezone_set("Etc/GMT+4");
      $date = date("Y-m-d");// Gets the current date of the local time server



      $select = "SELECT disaster.*,location.*, CONCAT(location.addressline1,' ',location.addressline2,' ',location.city,' ',location.locality,' ',location.country)location, disaster_location.*
                 FROM disaster_location
                 JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id
                 JOIN location ON disaster_location.location_id = location.location_id";
                 //WHERE date(disaster.date_time) = '$date'";

         $query = mysqli_query($con,$select);

         //$disaster = mysqli_fetch_assoc($query);


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
    <li class="w3-hide-small"><a href="\EMS\field-management\field\triage\personnel\on-site\home-page.php" class="w3-hover-white">Triage</a></li> <!--
    <li class="w3-hide-small"><a href="\EMS\field-management\" class="w3-hover-white">#</a></li> 
    <li class="w3-hide-small"><a href="\EMS\field-management\" class="w3-hover-white">#</a></li> 
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



<body onload="startTime()" >
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
 <?php echo $date; ?>

 <fieldset>
  <legend><strong>Victim:</strong></legend>
    <br>
      <table id = 'mytable' border = 1>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Age</th>
          <th>Sex</th>
          <th>Victim State</th>
          <th>Victim Class</th>
          <th>Location</th>
        </tr>
        <tr>
          <td><input type="text" id="fname" name="fname" required></td>
          <td><input type="text" id="lname" name="lname" required></td>
          <td><input type="int" id="age" name="age" style="width:30px" required></td>
          <td>
            <select id="sex" name="sex" required>
              <option value="" selected disabled>Select...</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </td>
          <td>
            <select id="doa" name="doa" required>
                <option value="" selected disabled>Select...</option>
                <option value ="0">Alive</option>
                <option value ="1">Dead</option>
            </select>
          </td>
          <td>
            <select id="classification" name="classification" required>
              <option value="" selected disabled>Select...</option>
              <option value="ACUTE">ACUTE</option>
              <option value="NON-ACUTE">NON-ACUTE</option>
            </select>
          </td>
          <td>
            <select id="location" name="location" required>
              <option value="" selected disabled>Select...</option>
              <?php while($disaster = mysqli_fetch_assoc($query)):;?>
              <option value"<?=$disaster['location'];?>"><?php echo $disaster['location'];?></option>
            <?php endwhile;?>
            </select>
          </td>
        </tr>
      </table>
 </fieldset>
 <br>
  <button type="button" onclick="victims()">Submit</button>

<div id= "test"></div>
<div id = "geo" ></div>

<script type="text/javascript">

      function resetTable(){

        document.getElementById("fname").value = "";
        document.getElementById("lname").value = "";
        document.getElementById("age").value = "";
        document.getElementById("sex").selectedIndex = 0;
        document.getElementById("doa").selectedIndex = 0;
        document.getElementById("classification").selectedIndex = 0;
        document.getElementById("location").selectedIndex = 0;
      }

</script>

<!--This retrieves the most recent disaster event where the user is required to respond      -->
<script type="text/javascript">
          var counter = 0;
  function victims(){
        
       var fname = document.getElementById("fname").value;
       var lname = document.getElementById("lname").value;
       var age = document.getElementById("age").value;
       var e = document.getElementById("doa");
       var doa = e.options[e.selectedIndex].value;
       var f = document.getElementById("classification");
       var victim_class = f.options[f.selectedIndex].value;
       var g = document.getElementById("location"); sex
       var location = g.options[g.selectedIndex].value;
       var h = document.getElementById("sex"); 
       var sex = h.options[h.selectedIndex].value;


       //Creates unique ID for every victim

       var initial = fname.charAt(0).toUpperCase() + lname.charAt(0).toUpperCase();

        var d = new Date();
        var year = d.getFullYear();
        //var month = d.getMonth();
        //var day = d.getDay();

        var date_ = year;

        var newdate = date_.toString();

        var incre = counter++;

        var strincre = incre.toString();

        var uniqID = newdate+initial+strincre;

    //------------------------------------------

        var bit = confirm("Data correct?");

       if (bit == false) {

         
       } else {

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
xmlhttp.open("GET","victims-record-handler.php?fname="+fname+"&lname="+lname+"&age="+age+"&doa="+doa+"&victim_class="+victim_class+"&location="+location+"&uniqID="+uniqID+"&sex="+sex,true);
      xmlhttp.send();
      resetTable(); }
  }


  </script>

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