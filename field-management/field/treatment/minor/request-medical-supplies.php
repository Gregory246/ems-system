<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
//$userid = $_SESSION['userid'];

$disaster_id = $_SESSION['disaster_id'];
$userid = $_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = '$userid'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);


$select5 = "SELECT * FROM `request_type` WHERE `request_type`.`type` LIKE '%Supplies%' OR `request_type`.`type` LIKE '%Pharmaceuticals%'";

  $query5 = mysqli_query($con,$select5);

  $request = mysqli_fetch_assoc($query5);

echo "<form method = 'POST' action = 'submit-medical-handler.php' target = '_blank'> ";

echo " 
      <table id = 'mytable' border = 1>
        <tr>
          <th>Priority</th>
          <th>Purpose</th>
          <th>Note</th>
          <th>Request Type</th>
        </tr>
        <tr>
          <td><input type='text' id='priority' name='priority' required></td>
          <td><input type='text' id='purpose' name='purpose' required></td>
          <td><input type='text' id='note' name='note' required></td>
          <td><select id='request_type_id' name='request_type_id' required>
                          <option value='' selected disabled>Select...</option>
                      "; do { 

                        echo " <option value='".$request['request_type_id']."'>".$request['type'];

                        } while($request = mysqli_fetch_assoc($query5)); echo "</option>
                       </select>
           </td>
        </tr>";

     echo" </table>";
     echo "<input type='text' id='submit' name='submit' value='request' hidden/> ";
     echo "<input type='submit' value='Submit Request!' /> ";
 echo "</form> ";


?>