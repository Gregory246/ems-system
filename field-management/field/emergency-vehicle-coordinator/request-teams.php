<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

//*************UNCOMMENT ONCE LOGIN IS FIXED*****************
//$userid = $_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = 'jess'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);

echo "<form method = 'POST' action = 'submit-handler.php' target = '_blank'> ";

echo " 
      <table id = 'mytable' border = 1>
        <tr>
          <th>Priority</th>
          <th>Purpose</th>
          <th>Note</th>
        </tr>
        <tr>
          <td><input type='text' id='priority' name='priority' required></td>
          <td><input type='text' id='purpose' name='purpose' required></td>
          <td><input type='text' id='note' name='note' required></td>
        </tr>";

     echo" </table>";
     echo "<input type='text' id='submit' name='submit' value='request' hidden/> ";
     echo "<input type='submit' value='Submit Request!' /> ";
 echo "</form> ";


?>