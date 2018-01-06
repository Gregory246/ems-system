<?php 
session_start();

 include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

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

$_SESSION['cuurent_call'] = $call_ext_hospital['call_ext_hospital_id'];

$select_caller = "SELECT call_ext_hospital.user_id, employees.*, CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name,agency.agency_name,department.*, employees_department_junc.* 
                      FROM `call_ext_hospital` JOIN `employees` ON call_ext_hospital.user_id = employees.user_id 
                        JOIN employees_department_junc ON employees.employee_id = employees_department_junc.employee_FK_id  
                        JOIN department ON employees_department_junc.department_FK_id = department.department_id 
                        JOIN agency ON department.agency_id = agency.agency_id 
                        WHERE call_ext_hospital.call_ext_hospital_id = '$call_ext_hospital[call_ext_hospital_id]' ";

    $query_caller = mysqli_query($con,$select_caller);
    $caller = mysqli_fetch_assoc($query_caller);

//Y-m-d 

$call_date = date("s", strtotime("00:00:00")); // Converts calls date_time to date and Hour ONLY date("Y-m-d H", strtotime($call_ext_hospital['date_time']))

date_default_timezone_set("Etc/GMT+4");
$date = date("s");// Gets the current date of the local time server 

echo $call_date. "&nbsp;&nbsp;" . $date; echo "&nbsp;";
$secs = $call_date - $date;
$timer = (string)$secs;
echo $timer;
echo "<hr>";

$start_time = date("H:i:s", strtotime($call_ext_hospital['start_time'])); // Converts calls date_time to date and Hour ONLY date("Y-m-d H", strtotime($call_ext_hospital['date_time']))
$end_time = date("H:i:s", strtotime($call_ext_hospital['end_time']));


//Checks the calls logged on x-date within the current user time-server 'Hour'
if ($call_ext_hospital['status'] == 1 && empty($call_ext_hospital['call_accepted'])  && empty($call_ext_hospital['call_ended']) && empty($call_ext_hospital['time_out']) ) {

	
	     echo "Incoming Call from"."&nbsp;".$caller['employee_name']."&nbsp;".$caller['employee_tele']."<br>";
       echo "ACCEPT CALL? >>>>"."<button id = 'button' style = 'color:red' onclick = 'incoming_call(1)'>ANSWER!</button>"."<<<<"; echo "&nbsp;&nbsp;";
       echo "DECLINE?"."<button id = 'button1' style = 'color:red' onclick = 'incoming_call(0)'>DECLINE</button>"."";
	     


} elseif ($call_ext_hospital['status'] == 1 && empty($call_ext_hospital['call_accepted'])  && empty($call_ext_hospital['call_ended']) && $start_time == $end_time && $date == $call_date ) {
  
      echo "Call Timed-out";

      $update = "UPDATE `call_ext_hospital` SET `time_out` = '1' WHERE `call_ext_hospital`.`call_ext_hospital_id` = '$call_ext_hospital[call_ext_hospital_id]' ";

      mysqli_query($con,$update);

} elseif ($call_ext_hospital['status'] == 1 && $call_ext_hospital['call_accepted'] == 1  && empty($call_ext_hospital['call_ended']) ) {
  
  echo "The callis still active...";

  echo "<button onclick = 'endCall()' style = 'color:red' >End Call !</button><br>"."To Terminate Current CALL!";

} else {


      $select_missed_call = "SELECT call_ext_hospital_missed.*, CONCAT(employees.employee_fname,' ', employees.employee_lname)employee_name,employees_department_junc.*,employees.*,department.*,agency.* 
                 FROM call_ext_hospital_missed 
                 JOIN `employees` ON call_ext_hospital_missed.user_id = employees.user_id 
                  JOIN employees_department_junc ON employees.employee_id = employees_department_junc.employee_FK_id 
                  JOIN department ON employees_department_junc.department_FK_id = department.department_id
                  JOIN agency ON department.agency_id = agency.agency_id
                        WHERE call_ext_hospital_missed.call_ext_hospital_id = '$call_ext_hospital[call_ext_hospital_id]'";

        $query_missed_call = mysqli_query($con,$select_missed_call) or die("");

        $missed_call_info = mysqli_fetch_assoc($query_missed_call);

        if (mysqli_num_rows($query_missed_call) > 0) {
          
          echo "<strong>"."Missed Call(s)"."</strong>";
echo "<div style = 'margin-left:250px' >";

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
  echo "<td>". "<input type='button' style='background-color:#f44336;border:2px solid black;' name='submit' value=" . $missed_call_info['employee_tele'] . " onclick='returnMissedCall(this.value)'/>" . "</td>";  // row[1]
  echo "<td>". $missed_call_info['employee_cell'] . "</td>";  // row[3]
  echo "<td>". $missed_call_info['employee_title'] . "</td>";  // row[4]
  echo "<td>". $missed_call_info['agency_name'] . "</td>";  // row[5]
  echo "<td>". $missed_call_info['employee_email'] . "</td>";   // row[6]
  echo "<td>". $missed_call_info['department_name'] . "</td>"; // row[7]
  echo "</tr>";

} while($missed_call_info = mysqli_fetch_assoc($query_missed_call));

echo "</table>";
echo "</div>";

        } else {

          echo "No Current Activity!";

        }
}

?>