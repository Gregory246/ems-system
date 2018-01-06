<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

if(!isset($_SESSION['userid'])){

  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
  header("Location: http://$host/ems/");
        exit();
}

$userid = $_SESSION['userid'];

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
<body onload = "startTime();incoming_call()">

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
<?php

if (!empty($_GET['employee_tel'])) {
	
	$employee_tel = $_GET['employee_tel']; //If page is called from missed calls

//*****************************
  $select_ = "(SELECT employees.employee_id, 'employees' AS type FROM employees WHERE employees.employee_tele = '$employee_tele')
      UNION 
      (SELECT hospital_employees.hospital_employees_id, 'hospital_employees' AS type FROM hospital_employees WHERE hospital_employees.tele = '$employee_tele')";

  $query_ = mysqli_query($con,$select_);

  $employee_type = mysqli_fetch_assoc($query_);
//******************************

  if ($employee_type['type'] == 'employees') {
    
    $select_missed_call = "SELECT call_ext_missed.*, CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name,employees_department_junc.*,employees.*,department.*,agency.* 
                 FROM call_ext_missed 
                 JOIN `employees` ON call_ext_missed.user_id = employees.user_id 
                  JOIN employees_department_junc ON employees.employee_id = employees_department_junc.employee_FK_id 
                  JOIN department ON employees_department_junc.department_FK_id = department.department_id
                  JOIN agency ON department.agency_id = agency.agency_id
                        WHERE call_ext_missed.callext_id = '$call_ext[callext_id]'";

        $query_missed_call = mysqli_query($con,$select_missed_call) or die("");

        $missed_call_info = mysqli_fetch_assoc($query_missed_call);



echo "<strong>"."Missed Call(s)"."</strong>";
echo "<div style = 'margin-left:100px' >";

 echo "<table border=1>
<tr>
<th>Message</th>
<th>Name</th>
<th>Telephone</th>  
<th>Cell</th>
<th>Job Title</th>
<th>Agency</th>
<th>Email</th>
<th>Department</th> 
</tr>";
 
 

do{

  echo "<tr>";
  echo "<td>". $missed_call_info['note'] . "</td>";
  echo "<td>". $missed_call_info['employee_name'] . "</td>"; // row[0]
  echo "<td>". "<input type='button' style='background-color:#f44336;border:2px solid black;' name='submit' value=" . $missed_call_info['employee_tele'] . " onclick='makeCall(this.value)' />" . "</td>";  // row[1]
  echo "<td>". $missed_call_info['employee_cell'] . "</td>";  // row[3]
  echo "<td>". $missed_call_info['employee_title'] . "</td>";  // row[4]
  echo "<td>". $missed_call_info['agency_name'] . "</td>";  // row[5]
  echo "<td>". $missed_call_info['employee_email'] . "</td>";   // row[6]
  echo "<td>". $missed_call_info['department_name'] . "</td>"; // row[7]
  echo "</tr>";

} while($missed_call_info = mysqli_fetch_assoc($query_missed_call));

echo "</table>";
echo "</div>";//*******END****

  } else {


    $select_missed_call = "SELECT call_ext_hospital_missed.*, CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name,employees_department_junc.*,employees.*,department.*,agency.* 
                 FROM call_ext_hospital_missed 
                 JOIN `employees` ON call_ext_hospital_missed.user_id = employees.user_id 
                  JOIN employees_department_junc ON employees.employee_id = employees_department_junc.employee_FK_id 
                  JOIN department ON employees_department_junc.department_FK_id = department.department_id
                  JOIN agency ON department.agency_id = agency.agency_id
                        WHERE employees.employee_tele = '$employee_tel'";

        $query_missed_call = mysqli_query($con,$select_missed_call) or die("");

        $missed_call_info = mysqli_fetch_assoc($query_missed_call);



echo "<strong>"."Missed Call(s)"."</strong>";
echo "<div style = 'margin-left:100px' >";

 echo "<table border=1>
<tr>
<th>Message</th>
<th>Name</th>
<th>Telephone</th>  
<th>Cell</th>
<th>Job Title</th>
<th>Agency</th>
<th>Email</th>
<th>Department</th> 
</tr>";
 
 

do{

  echo "<tr>";
  echo "<td>". $missed_call_info['note'] . "</td>";
  echo "<td>". $missed_call_info['employee_name'] . "</td>"; // row[0]
  echo "<td>". "<input type='button' style='background-color:#f44336;border:2px solid black;' name='submit' value=" . $missed_call_info['employee_tele'] . " onclick='makeCall(this.value)' />" . "</td>";  // row[1]
  echo "<td>". $missed_call_info['employee_cell'] . "</td>";  // row[3]
  echo "<td>". $missed_call_info['employee_title'] . "</td>";  // row[4]
  echo "<td>". $missed_call_info['agency_name'] . "</td>";  // row[5]
  echo "<td>". $missed_call_info['employee_email'] . "</td>";   // row[6]
  echo "<td>". $missed_call_info['department_name'] . "</td>"; // row[7]
  echo "</tr>";

} while($missed_call_info = mysqli_fetch_assoc($query_missed_call));

echo "</table>";
echo "</div>";
  }
//****************
	
}

?>

<input type ="text" name="employee_tel" id="employee_tel" value="<?php echo $employee_tel ?>" hidden />
<!--<input type ="text" name="employee_name" id="employee_name" value="<?php  ?>" hidden />
<input type ="text" name="callext_id" id="callext_id" value="<?php  ?>" hidden />
<input type ="text" name="call_accepted" id="call_accepted" value="<?php  ?>" hidden />
<input type ="text" name="status" id="status" value="<?php   ?>" hidden /> -->

<strong><div id = "inner" style = "color:red" ></div></strong><hr>
<div id = "inner1" style = "align:center;border:1px" ></div> <br><br>
 </div>
 

</div>
<div id = "approve" style = "color:red;text-align:center"><button onclick = "alert()" >Alert Hospital!</button><br></div>

 <script type="text/javascript">

               //onclick='makeCall(this.value)'     

            function makeCall(call){

               // var employee_tel = document.getElementById("employee_tel").value; 
                var calls = call.toString(); 

                
                setChecker(1);
                

        xmlhttp = new XMLHttpRequest();
     
      xmlhttp.onreadystatechange = function(){

          if(this.readyState == 4 && this.status == 200){
            document.getElementById("inner").innerHTML = this.responseText;
          }
      }
      xmlhttp.open("GET","call-handler.php?calls="+calls,true);
      xmlhttp.send();
      document.getElementById("test1").innerHTML = "CALL INITIALIZED!"
             
            } 

          </script>


<script type="text/javascript">

          function setChecker(bit){

            if (bit == 1) {

              var loop = setInterval(setCheckerSET,5000);

            } else{

              clearInterval(loop);
              endCall();
            }
        }

        function endCall(){

             var xmlhttp = new XMLHttpRequest();

            xmlhttp.open("GET","end-call-handler.php",true);
              xmlhttp.send();
                return;
              }

          function setCheckerSET(){

              xmlhttp = new XMLHttpRequest();

          xmlhttp.onreadystatechange = function(){

                  if(this.readyState == 4 && this.status == 200){
                    document.getElementById("inner1").innerHTML = this.responseText;
                  }
            }
      
            xmlhttp.open("GET","call-status-checker-handler.php",true);
              xmlhttp.send();
                return;
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