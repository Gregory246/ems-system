<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 

$select = "SELECT `request`.*,`request_type`.*
					FROM `request`
					JOIN `request_type` ON `request`.`request_type_id` = `request_type`.`request_type_id`
					WHERE `request_type`.`type` LIKE '%Pharmaceuticals%'";

		$query = mysqli_query($con,$select);

		$request = mysqli_fetch_assoc($query);

	$select1 = "SELECT COUNT(`request`.`request_type_id`) AS count,`request_type`.* 
				FROM `request`
				JOIN `request_type` ON `request`.`request_type_id` = `request_type`.`request_type_id`
				WHERE `request_type`.`type` LIKE '%Pharmaceuticals%'
				GROUP BY `request`.`request_type_id`";

		$query1 = mysqli_query($con,$select1);

		$count = mysqli_fetch_assoc($query1);

if(mysqli_num_rows($query) > 0){

echo " 
      <table id = 'mytable' border = 1>
        <tr>
          <th>Required</th>
          <th>Total</th>
        </tr>
        <tr>
          <td><input type='text' id='priority' name='priority' value ='".$request['type']."' required></td>
          <td align = 'center'><input type='text' id='purpose' name='purpose' value ='".$count['count']."' required></td>
        </tr>";

     echo" </table>";
} else {

	echo "No Request as yet!";

}
?>