<?php
session_start();

 include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
error_reporting(0);

if(!isset($_SESSION['userid'])){

  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
  header("Location: http://$host/ems/");
        exit();
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Home</title>
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

.facebook-button {
  background: url('answer-logo.png') left center no-repeat;
  padding-left: 15px;
  width: 4px;
  height: 5px;
}
</style>
<body onload = "startTime()">

<!-- Navbar-->

<div class="w3-top">
  <ul class="w3-navbar w3-theme w3-top w3-left-align w3-large">
    <li class="w3-opennav w3-right w3-hide-large">
      <a class="w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="\ems\dispatch\home-page.php" class="w3-theme-l1"><strong>EMS</strong></a></li>
    <li class="w3-hide-small"><a href="\EMS\field-management\ambulance\unit-lead\home-page.php" class="w3-hover-white">Home</a></li>
    <li class="w3-hide-small"><a href="\EMS\field-management\ambulance\unit-lead\scene-details.php" class="w3-hover-white">Arrival</a></li> 
    <li class="w3-hide-small"><a href="\EMS\field-management\ambulance\unit-lead\in-coming-calls.php" class="w3-hover-white">In-coming Calls</a></li> 
    <li class="w3-hide-small"><a href="\EMS\field-management\ambulance\unit-lead\dispatch-comms.php" class="w3-hover-white">Dispatch</a></li> <!--
    <li class="w3-hide-small"><a href="\EMS\field-management\ambulance\unit-lead\" class="w3-hover-white">#</a></li> -->&#9855;
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
	<div style = "text-align:center">
		<!-- This is for the log of the most recent disaster-->


<strong><div id = "inner" style = "color:red" ></div></strong><hr>
<div id = "inner1" style = "align:center;border:1px" ></div> <br><br>
 </div>
 

</div>


<script type="text/javascript">


	 		function incoming_call(bit){

          alert("incoming_call works");
					var accepted_call = bit;

        					
					xmlhttp = new XMLHttpRequest();

					xmlhttp.onreadystatechange = function(){

          				if(this.readyState == 4 && this.status == 200){
            				document.getElementById("inner").innerHTML = this.responseText;
          				}
      			}
      
     			 	xmlhttp.open("GET","called-handler.php?accepted_call="+accepted_call,true);
      				xmlhttp.send();
           			return;
				} 


</script>

<script type="text/javascript">
                
                setInterval(callActivity,500);
               
        function callActivity(){

                //setInterval(hospitalCapacity,500);

              var update = true;

            xmlhttp = new XMLHttpRequest();

          xmlhttp.onreadystatechange = function(){

                  if(this.readyState == 4 && this.status == 200){
                    document.getElementById("inner1").innerHTML = this.responseText;
                  }
            }
      
            xmlhttp.open("GET","incoming-call-checker.php",true);
              xmlhttp.send();
                return;

        }

</script>

<script type="text/javascript">
      
      //Directs User to page to return missed call
      function returnMissedCall(employee_tel){

          window.open("http://localhost:85/EMS/field-management/ambulance/unit-lead/call-missed-returned.php?employee_tel="+employee_tel);

      }

</script>

<script type="text/javascript">

	function endCall(){

		

		var endcall_confirm = confirm("ARE YOU SURE YOU WANT TO END CALL?");

		if (endcall_confirm == true) {
				
				xmlhttp = new XMLHttpRequest();

					xmlhttp.onreadystatechange = function(){

          				if(this.readyState == 4 && this.status == 200){
            				document.getElementById("inner").innerHTML = this.responseText;
          				}
      			}
      
     			 	xmlhttp.open("GET","end-call-handler-receiver.php?endcall_confirm="+endcall_confirm,true);
      				xmlhttp.send();
           			return;

		} else{ }
	}


</script>

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