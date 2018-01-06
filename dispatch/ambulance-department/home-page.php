<?php
session_start();

include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//if(!isset($_SESSION['userid'])){

//  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
//  header("Location: http://$host/ems/");
//        exit();
//}

$userid ="wayl"  ;   //$_SESSION['userid'];


//Get's User Id to obtian the vehicleteam of the user
$select_userid = "SELECT `user_id` FROM `users` WHERE `users`.`username` = '$userid' ";

$query_userid = mysqli_query($con,$select_userid);

  $user_id = mysqli_fetch_assoc($query_userid);

      
    $select2 = "SELECT `vehicleteam_id`, `operator_FK`, `assistance_FK`, `tech_FK`, `advance_tech_FK`, `paramedic_FK`, `advance_paramedic_FK`, `wilderness_tech_FK` 
      FROM `vehicleteam` WHERE `user_id`= '$user_id[user_id]' ORDER BY `vehicleteam_id` DESC LIMIT 1";

  $query2 = mysqli_query($con,$select2);

  $vehicleteam = mysqli_fetch_assoc($query2);

  $_SESSION['vehicleteam_id'] = $vehicleteam['vehicleteam_id'];

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
    <li class="w3-hide-small"><a href="\ems\dispatch\telephone-dispatch\home-page.php" class="w3-hover-white">Teams</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\telephone-dispatch\in-coming-calls.php" class="w3-hover-white">In-Coming Calls</a></li> <!--
    <li class="w3-hide-small"><a href="#" class="w3-hover-white">#</a></li>
    <li class="w3-hide-small"><a href="#" class="w3-hover-white">#</a></li>
    <li class="w3-hide-small"><a href="#" class="w3-hover-white">#</a></li>
    <li class="w3-hide-small"><a href="#" class="w3-hover-white">#</a></li> -->
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
 <?php //echo $_SESSION['userid'] ?>
<p><strong>PLEASE SELECT VEHICLE TEAM DETAILS AND THEN ASSIGN MEMBER TO VEHICLE TEAM </strong></p>
<button id="myButton1" style="width:150px; height:30px;" onclick="establishTeams()"><strong>Establish Teams</strong></button>
<?php echo $_SESSION['vehicleteam_id']; ?>
<hr>
<div id = "test1" ></div>
<hr>
<div id= "test2"></div>
<br>

<script type="text/javascript">
              
              function selectEmployee(){
    
        document.getElementById("mytable1").onclick = function(event){
          

            event = event || window.event; //for IE8 backward compatibility
        var target = event.target || event.srcElement; //for IE8 backward compatibility
        while (target && target.nodeName != 'TR') {
            target = target.parentElement;
        }
        var cells = target.cells; //cells collection
        //var cells = target.getElementsByTagName('td'); //alternative
        if (!cells.length || target.parentNode.nodeName == 'THEAD') { //if clicked row is within thead
            return;
        }
     
        var f1 = cells[0].children[0].value;
        var bin = cells[0].children[0].checked;

        var e = document.getElementById("team_class");
        var team_class = e.options[e.selectedIndex].value;

       var f = document.getElementById("life_support");
        var life_support = f.options[f.selectedIndex].value;

        var g = document.getElementById("vehicle_id");
        var vehicle_id = g.options[g.selectedIndex].value;

        if(window.XMLHttpRequest){
               //for IE7+, Firefox, Chrome, Opera, Safari
               xmlhttp = new XMLHttpRequest();
             } else {
       
               //For older browsers 
               xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
             }
       
             xmlhttp.onreadystatechange = function(){
       
                 if(this.readyState == 4 && this.status == 200){
                   document.getElementById("test2").innerHTML = this.responseText;
                 }
             }
             xmlhttp.open("GET","set-employees.php?bin="+bin+"&f1="+f1+"&team_class="+team_class+"&life_support="+life_support+"&vehicle_id="+vehicle_id,true);
             xmlhttp.send();                          
             establishTeams();
       }
                
   }   
</script>


<script type="text/javascript">
      
      function setTeams(){

        var bin = false;

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
xmlhttp.open("GET","set-employees.php?bin="+bin,true);
      xmlhttp.send();
       resetTable();
      }

</script>

<!--This retrieves the most recent disaster event where the user is required to respond      -->

<script type="text/javascript">

      function establishTeams(){

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
xmlhttp.open("GET","get-employees.php?",true);
      xmlhttp.send();
       //resetTable1();
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