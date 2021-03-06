<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

 // if(!isset($_SESSION['userid'])){

 // $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
 // header("Location: http://$host/ems/");
  //exit();
//}
?>
<!DOCTYPE html>
<html>
<head> 
<script src="webphone_api.js"></script>
</head>
<title>Home</title>
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
<body onload = "startTime()">

<!-- Navbar-->

<div class="w3-top">
  <ul class="w3-navbar w3-theme w3-top w3-left-align w3-large">
    <li class="w3-opennav w3-right w3-hide-large">
      <a class="w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="\ems\field-management\field\command-post\home-page.php" class="w3-theme-l1"><strong>EMS</strong></a></li>
    <li class="w3-hide-small"><a href="\ems\field-management\field\medical-division\home-page.php" class="w3-hover-white">Establish Divisions</a></li>
    
    <li class="w3-hide-small"><a href="#" class="w3-hover-white">Notifiers</a></li>
    <li class="w3-hide-small"><a href="\ems\field-management\field\medical-division\resources.php" class="w3-hover-white">Resources Required</a></li>
    <li class="w3-hide-small"><a href="\ems\field-management\field\medical-division\" class="w3-hover-white">Contacts</a></li>
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


<div class="w3-main" style="margin-top:250px">

 <div align = "center">

  <button id="myButton" style="width:150px; height:30px;" onclick="establishTeams()"><strong>Select Team</strong></button>
  <button id="myButton1" style="width:150px; height:30px;" onclick="registerTeams()"><strong>Register Team</strong></button>
<br>

<p><strong>Establish Unit Leaders and Managers from Database using "Select Team" button.<br>
            Else Register Member using "Register Team" button.
            <span style = 'color:red'>All fields MUST be entered for registration process.</span></strong></p>

<div id = "test" ></div>
<hr>
<div id = "test1" ></div>


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
            document.getElementById("test").innerHTML = this.responseText;
          }
      }
      xmlhttp.open("GET","select-ics-handler.php",true);
      xmlhttp.send();

  }

</script>

<script type="text/javascript">
        
          function registerTeams(){

          

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
            hideFunction(1);
          }
      }
      xmlhttp.open("GET","register-ics-handler.php",true);
      xmlhttp.send();
  }

</script>

<script type='text/javascript'>
      
       function hideFunction(init) {

        var x = document.getElementById("swtch").checked;

        

        if (x === true) { 
          
          document.getElementById('fieldset').style.display = 'block';
          document.getElementById('fieldset').disabled = false;
          document.getElementById('fieldset1').disabled = true;
          document.getElementById('fieldset1').style.display = 'none';

        } else { 

          document.getElementById('fieldset').disabled = true;
          document.getElementById('fieldset').style.display = 'none';
          document.getElementById('fieldset1').disabled = false;
          document.getElementById('fieldset1').style.display = 'block';

        }

        
                  
          }
        

    </script>

<script type="text/javascript">
  
</script>

<script type="text/javascript">
    
</script>
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

?>