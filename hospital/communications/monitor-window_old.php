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
</style>
<body onload = "startTime();incoming_call()">

<!-- Navbar-->

<div class="w3-top">
  <ul class="w3-navbar w3-theme w3-top w3-left-align w3-large">
    <li class="w3-opennav w3-right w3-hide-large">
      <a class="w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="\ems\dispatch\home-page.php" class="w3-theme-l1"><strong>EMS</strong></a></li>
<!-- <li class="w3-hide-small"><a href="\ems\dispatch\psap\home-page.php" class="w3-hover-white">Home</a></li> -->
    <li class="w3-hide-small"><a href="\EMS\hospital\communications\monitor-window.php" class="w3-hover-white"  >Monitor</a></li>
<!-- <li class="w3-hide-small"><a href="\EMS\dispatch\psap\log-event1.php" class="w3-hover-white">Log Event</a></li> -->
    <li class="w3-hide-small"><a href="\EMS\hospital\communications\dispatch-views.php" class="w3-hover-white" target="_blank">Notifiers</a></li> 
    <li class="w3-hide-small"><a href="\EMS\hospital\communications\event-command-post.php" class="w3-hover-white" target="_blank">Command Post Call</a></li>
    <li class="w3-hide-small"><a href="\EMS\hospital\communications\contacts.php" class="w3-hover-white">Contacts</a></li>
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
<?php 
//session_start();

//error_reporting(0);

//Gets the user of the web-page


$userid = $_SESSION["userid"];

$select = "SELECT user_id FROM users WHERE username = '$userid' ";
$query = mysqli_query($con,$select);
$user_id = mysqli_fetch_assoc($query);

$select1 = "SELECT hospital_employees_id FROM hospital_employees WHERE hospital_employees.user_id = '$user_id[user_id]'";
$query1 = mysqli_query($con,$select1);
$employee_id = mysqli_fetch_assoc($query1);

$select2 = "SELECT call_ext_hospital FROM hospital_ext_calls_junc WHERE receiver_hospital = '$employee_id[hospital_employees_id]' ORDER BY hospital_ext_calls_junc_id DESC LIMIT 1";
$query2 = mysqli_query($con,$select2);
$call_ext_hospital_id = mysqli_fetch_assoc($query2);

$select3 = "SELECT * FROM call_ext_hospital WHERE call_ext_hospital_id = '$call_ext_hospital_id[call_ext_hospital]'";
$query3 = mysqli_query($con,$select3);
$call_ext_hospital = mysqli_fetch_assoc($query3);


$call_date = date("Y-m-d H", strtotime($call_ext_hospital['date_time'])); // Converts calls date_time to date and Hour ONLY date("Y-m-d H", strtotime($call_ext_hospital['date_time']))

date_default_timezone_set("Etc/GMT+4");
$date = date("Y-m-d H");// Gets the current date of the local time server 

echo $call_date. "&nbsp;&nbsp;" . $date;
echo "<hr>";

//Checks the calls logged on x-date within the current user time-server 'Hour'
if ($call_date == $date ) {

	//echo $call_ext['status'] ."\n"; echo $call_ext['callext_id'] ."\n";
	
	if ($call_ext_hospital['status'] == "1") {

    $userid = $_SESSION["userid"];

$select = "SELECT user_id FROM users WHERE username = '$userid' ";
$query = mysqli_query($con,$select);
$user_id = mysqli_fetch_assoc($query);

$select1 = "SELECT hospital_employees_id FROM hospital_employees WHERE hospital_employees.user_id = '$user_id[user_id]'";
$query1 = mysqli_query($con,$select1);
$employee_id = mysqli_fetch_assoc($query1);

$select2 = "SELECT call_ext_hospital FROM hospital_ext_calls_junc WHERE receiver_hospital = '$employee_id[hospital_employees_id]' ORDER BY hospital_ext_calls_junc_id DESC LIMIT 1";
$query2 = mysqli_query($con,$select2);
$call_ext_hospital_id = mysqli_fetch_assoc($query2);

$select3 = "SELECT * FROM call_ext_hospital WHERE call_ext_hospital_id = '$call_ext_hospital_id[call_ext_hospital]'";
$query3 = mysqli_query($con,$select3);
$call_ext_hospital = mysqli_fetch_assoc($query3);


		//On refresh this gets the name of the caller 
		
		$select4 = "SELECT user_id FROM call_ext_hospital WHERE call_ext_hospital_id = '$call_ext_hospital[call_ext_hospital_id]'";
		$query4 = mysqli_query($con,$select4);
		$user_id = mysqli_fetch_assoc($query4); //Get's the user_id of that call record who is the caller

		$select5 = "SELECT employee_fname, employee_lname FROM employees WHERE employees.user_id = '$user_id[user_id]'";
		$query5 = mysqli_query($con, $select5);
		$employee = mysqli_fetch_assoc($query5);

		$employee_name = $employee['employee_fname']."\n".$employee['employee_lname'];

    $select_caller = "SELECT call_ext_hospital.user_id, employees.*, CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name,agency.agency_name,department.*, employees_department_junc.* 
                      FROM `call_ext_hospital` JOIN `employees` ON call_ext_hospital.user_id = employees.user_id 
                        JOIN employees_department_junc ON employees.employee_id = employees_department_junc.employee_FK_id  
                        JOIN department ON employees_department_junc.department_FK_id = department.department_id 
                        JOIN agency ON department.agency_id = agency.agency_id 
                        WHERE call_ext_hospital.call_ext_hospital_id = '$call_ext_hospital[call_ext_hospital_id]' ";

    $query_caller = mysqli_query($con,$select_caller);
    $caller = mysqli_fetch_assoc($query_caller);

echo "<strong>"."Caller"."</strong>";
echo "<div style = 'margin-left:340px' >";

 echo "<table border=1>
<tr>
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
  echo "<td>". $caller['employee_name'] . "</td>"; // row[0]
  echo "<td>". $caller['employee_tele'] . "</td>";  // row[1]
  echo "<td>". $caller['employee_cell'] . "</td>";  // row[3]
  echo "<td>". $caller['employee_title'] . "</td>";  // row[4]
  echo "<td>". $caller['agency_name'] . "</td>";  // row[5]
  echo "<td>". $caller['employee_email'] . "</td>";   // row[6]
  echo "<td>". $caller['department_name'] . "</td>"; // row[7]
  echo "</tr>";

} while($caller = mysqli_fetch_assoc($query_caller));

echo "</table>";

echo "</div>";
echo "<br>";

		echo "<strong>CALL ACCEPTED!</strong>"; echo "<br>";

	} else {

    $userid = $_SESSION["userid"];

$select = "SELECT user_id FROM users WHERE username = '$userid' ";
$query = mysqli_query($con,$select);
$user_id = mysqli_fetch_assoc($query);

$select1 = "SELECT hospital_employees_id FROM hospital_employees WHERE hospital_employees.user_id = '$user_id[user_id]'";
$query1 = mysqli_query($con,$select1);
$employee_id = mysqli_fetch_assoc($query1);

$select2 = "SELECT call_ext_hospital FROM hospital_ext_calls_junc WHERE receiver_hospital = '$employee_id[hospital_employees_id]' ORDER BY hospital_ext_calls_junc_id DESC LIMIT 1";
$query2 = mysqli_query($con,$select2);
$call_ext_hospital_id = mysqli_fetch_assoc($query2);

$select3 = "SELECT * FROM call_ext_hospital WHERE call_ext_hospital_id = '$call_ext_hospital_id[call_ext_hospital]'";
$query3 = mysqli_query($con,$select3);
$call_ext_hospital = mysqli_fetch_assoc($query3); 


   

      $select = "SELECT call_ext_hospital_missed.*, CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name,employees_department_junc.*,employees.*,department.*,agency.* 
                 FROM call_ext_hospital_missed 
                 JOIN `employees` ON call_ext_hospital_missed.user_id = employees.user_id 
                  JOIN employees_department_junc ON employees.employee_id = employees_department_junc.employee_FK_id 
                  JOIN department ON employees_department_junc.department_FK_id = department.department_id
                  JOIN agency ON department.agency_id = agency.agency_id
                        WHERE call_ext_hospital_missed.call_ext_hospital_id = '$call_ext_hospital[call_ext_hospital_id]'";

        $query = mysqli_query($con,$select);

        $missed_call_info = mysqli_fetch_assoc($query);

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
  echo "<td>". $missed_call_info['employee_tele'] . "</td>";  // row[1]
  echo "<td>". $missed_call_info['employee_cell'] . "</td>";  // row[3]
  echo "<td>". $missed_call_info['employee_title'] . "</td>";  // row[4]
  echo "<td>". $missed_call_info['agency_name'] . "</td>";  // row[5]
  echo "<td>". $missed_call_info['employee_email'] . "</td>";   // row[6]
  echo "<td>". $missed_call_info['department_name'] . "</td>"; // row[7]
  echo "</tr>";

} while($missed_call_info = mysqli_fetch_assoc($query));

echo "</table>";
echo "</div>";
echo "<br>";
  }

}

?>
<!-- This is for the log of the most recent disaster-->
<script type="text/javascript">
		
		function disaster_records(){


			xmlhttp = new XMLHttpRequest();

					xmlhttp.onreadystatechange = function(){

          				if(this.readyState == 4 && this.status == 200){
            				document.getElementById("inner1").innerHTML = this.responseText;
          				}
      			}
      
     			 	xmlhttp.open("GET","disaster-record.php",true);
      				xmlhttp.send();
           			return;
				
		}


</script>

<input type ="text" name="caller" id="caller" value="<?php echo $caller['employee_name']; ?>" hidden />
<input type ="text" name="employee_name" id="employee_name" value="<?php echo $employee_name; ?>" hidden />
<input type ="text" name="callext_id" id="callext_id" value="<?php echo $call_ext_hospital_id['call_ext_hospital']; ?>" hidden />
<input type ="text" name="call_accepted" id="call_accepted" value="<?php echo $call_ext_hospital['call_accepted']; ?>" hidden />
<input type ="text" name="status" id="status" value="<?php echo $call_ext_hospital['status']; ?>" hidden />
<button onclick = "endCall()" style = "color:red" >End Call !</button><br>
<strong><div id = "inner" style = "color:red" ></div></strong><hr>

 </div>
 <div id = "inner1" style = "color:red;align:center;border:1px" ></div> <br><br>

</div>
<div id = "approve" style = "color:red;text-align:center"><button onclick = "alert()" >Alert Hospital!</button><br></div>

<script type="text/javascript">


	 		function incoming_call(){

        var caller = document.getElementById("caller").value;
	 			var employee_name = document.getElementById("employee_name").value;
				var callext_id = document.getElementById("callext_id").value;
				var call_accepted = document.getElementById("call_accepted").value;
				var status = document.getElementById("status").value;

				if (employee_name != "" && call_accepted == ""){

					var accepted_call = confirm("Incoming CALL! from "+employee_name+"ACCEPT?");

        					
					xmlhttp = new XMLHttpRequest();

					xmlhttp.onreadystatechange = function(){

          				if(this.readyState == 4 && this.status == 200){
            				document.getElementById("inner").innerHTML = this.responseText;
          				}
      			}
      
     			 	xmlhttp.open("GET","called-handler.php?accepted_call="+accepted_call+"&callext_id="+callext_id,true);
      				xmlhttp.send();
           			return;

				} if(status == 0) { 

					document.getElementById("inner").innerHTML = "NO ACTIVE INCOMING CALLS...";
				} 		
	}


</script>

<script type="text/javascript">
                
               
        function alert(){

                //setInterval(hospitalCapacity,500);

              var update = true;

            xmlhttp = new XMLHttpRequest();

          xmlhttp.onreadystatechange = function(){

                  if(this.readyState == 4 && this.status == 200){
                    document.getElementById("approve").innerHTML = this.responseText;
                  }
            }
      
            xmlhttp.open("GET","aprroval.php?update="+update,true);
              xmlhttp.send();
                return;

        }

</script>
<script type="text/javascript">

	function endCall(){

		var callext_id = document.getElementById("callext_id").value;

		var endcall_confirm = confirm("ARE YOU SURE YOU WANT TO END CALL?");

		if (endcall_confirm == true) {
				alert("This AJAX endCall if statement works!")
				xmlhttp = new XMLHttpRequest();

					xmlhttp.onreadystatechange = function(){

          				if(this.readyState == 4 && this.status == 200){
            				document.getElementById("inner").innerHTML = this.responseText;
          				}
      			}
      
     			 	xmlhttp.open("GET","called-handler.php?endcall_confirm="+endcall_confirm+"&callext_id="+callext_id,true);
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





