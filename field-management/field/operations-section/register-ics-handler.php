<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');

$disaster_id = "76"; //$_SESSION['disaster_id']; //From the home page of this domain

$select = "SELECT DISTINCT `employees`.`employee_title` FROM `employees` ORDER BY `employees`.`employee_title` ASC";
	$query = mysqli_query($con,$select);
	$employee = mysqli_fetch_assoc($query);

$select1 = "SELECT DISTINCT `employees`.`employee_field` 
			FROM `employees` 
			WHERE `employees`.`employee_field` != 'Geology' 
			AND `employees`.`employee_field` != 'Telecommunications'
			AND `employees`.`employee_field` != 'Dispatch' 
			ORDER BY `employees`.`employee_field` ASC";
	$query1 = mysqli_query($con,$select1);
	$employee1 = mysqli_fetch_assoc($query1);


$select2 = "SELECT DISTINCT `agency_type` FROM `agency` ORDER BY `agency_type` ASC";
	$query2 = mysqli_query($con,$select2);
	$agency2 = mysqli_fetch_assoc($query2);

$select3 = "SELECT DISTINCT `agency_role` FROM `agency` WHERE `agency_role`!= 'Early Warning' ORDER BY `agency_role` ASC";
	$query3 = mysqli_query($con,$select3);
	$agency3 = mysqli_fetch_assoc($query3);

$select4 = "SELECT DISTINCT `department_name` FROM `department` ORDER BY `department_name` ASC";
	$query4 = mysqli_query($con,$select4);
	$department = mysqli_fetch_assoc($query4);

$select5 = "SELECT * FROM `agency`
			WHERE `agency_role`!= 'Early Warning'
			ORDER BY `agency_name` ASC";
	$query5 = mysqli_query($con,$select5);
	$agency5 = mysqli_fetch_assoc($query5);

$select6 = "SELECT DISTINCT `department`.`department_name`,`department`.`department_id`,`agency`.* 
			FROM `department`
			JOIN `agency` ON `department`.`agency_id` = `agency`.`agency_id` 
			WHERE `agency`.`agency_role`!= 'Early Warning'
			ORDER BY `department`.`department_name` ASC";
	$query6 = mysqli_query($con,$select6);
	$department6 = mysqli_fetch_assoc($query6);

/*-------------------------------Registration Begins Here---------------------------------*/

echo "<form method = 'POST' action ='submit-registration.php'> ";

	echo "<fieldset>
			<legend><strong>Registration Form:</strong></legend>";
			echo "<label style = 'text-align:left' ><strong>Employee Details</strong></label><br>";
				echo "<label>Employee Name:</label>
						<input text='text' id='fname' name='fname' placeholder='First name' required>&nbsp;&nbsp;
						<input text='text' id='lname' name='lname' placeholder='Last name' required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

							<label>Employee Title:</label>
								<select id='employee_title' name='employee_title' required>
		              				<option value='' selected disabled>Select...</option>
		             			"; do { 

		             				echo " <option value='".$employee['employee_title']."'>".$employee['employee_title'];

		             				} while($employee = mysqli_fetch_assoc($query)); echo "</option>
		           				 </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	           				 <label>Employee Field:</label>
								<select id='employee_field' name='employee_field' required>
		              				<option value='' selected disabled>Select...</option>
		             			"; do { 

		             				echo " <option value='".$employee1['employee_field']."'>".$employee1['employee_field'];

		             				} while($employee1 = mysqli_fetch_assoc($query1)); echo "</option>
		           				 </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<hr>

           				 	<label>Employee Role:</label>
								<input text='text' id='role' name='role' placeholder='Admin' required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

          				 	<label>Employee Contact:</label>
								<input text='text' id='tele' name='tele' placeholder='Telephone e.g 18681113333' style = 'width:225px' required>&nbsp;&nbsp;
								<input text='text' id='cell' name='cell' placeholder='Cellular e.g 18681113333' style = 'width:225px' required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

							<label>Employee Email:</label>
								<input text='email' id='email' name='email' placeholder='e.g characters@server.com' style = 'width:225px' required>&nbsp;&nbsp;";

						echo "<p><span style='color:red'><strong>Employee belongs to already existing Agency? If Yes continue, If No check 'Existing Agency'</strong></span></p>
								<label>Existing Agency:</label>
									<input type='checkbox' id='swtch' name='swtch' onchange='hideFunction()' /> ";
			echo "</fieldset>";	
//------------------------------If Agency Exist-------------------------------------
			echo "<fieldset id='fieldset1'>";

			echo "<label align='left' ><strong>Agency Detials</strong></label><br>";
				echo "<label>Agency Name:</label>
						<select id='agency_name' name='agency_name' required>
		              				<option value='' selected disabled>Select...</option>
		             			"; do { 

		             				echo " <option value='".$agency5['agency_id']."'>".$agency5['agency_name'];

		             				} while($agency5 = mysqli_fetch_assoc($query5)); echo "</option>
		           				 </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

       				 <label>Agency Departments:</label>
								<select id='department_name' name='department_name' required>
		              				<option value='' selected disabled>Select...</option>
		             			"; do { 

		             				echo " <option value='".$department6['department_id']."'>".$department6['department_name']."\n||\n"."<span style='color:red'>".$department6['agency_name']."</span>";

		             				} while($department6 = mysqli_fetch_assoc($query6)); echo "</option>
		           				 </select><br><br>";

       				 echo "<input type='submit' value='Register!'/>";


			echo "</fieldset>";				
//--------------------------------------------------------------------------			
			echo "<fieldset id='fieldset' style='display:none'>";

			echo "<label align='left' ><strong>Agency Detials</strong></label><br>";
				echo "<label>Agency Name:</label>
						<input text='text' id='agency_name' name='agency_name' placeholder='e.g Red Cross Society' style = 'width:400px' required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

							<lable>Agency Type:</label>
								<select id='agency_type' name='agency_type' required>
		              				<option value='' selected disabled>Select...</option>
		             			"; do { 

		             				echo " <option value='".$agency2['agency_type']."'>".$agency2['agency_type'];

		             				} while($agency2 = mysqli_fetch_assoc($query2)); echo "</option>
		           				 </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	           				 <lable>Agency Role:</label>
								<select id='agency_role' name='agency_role' required>
		              				<option value='' selected disabled>Select...</option>
		             			"; do { 

		             				echo " <option value='".$agency3['agency_role']."'>".$agency3['agency_role'];

		             				} while($agency3 = mysqli_fetch_assoc($query3)); echo "</option>
		           				 </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<hr>

	           				 <label>Agency Contact:</label>
								<input text='text' id='agency_tele' name='agency_tele' placeholder='Telephone e.g 18681113333' style = 'width:225px' required>&nbsp;&nbsp;
								<input text='text' id='agency_fax' name='agency_fax' placeholder='Fax e.g 18681113333' style = 'width:225px' required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

							<label>Agency Email:</label>
								<input text='email' id='agency_email' name='agency_email' placeholder='e.g characters@server.com' style = 'width:225px' required>&nbsp;&nbsp;

							<label>Agency Website:</label>
								<input text='url' id='agency_url' name='agency_url' placeholder='e.g www.agency.com' style = 'width:225px' required>&nbsp;&nbsp;<hr>

							<label>Agency Departments:</label>
								<select id='department_name' name='department_name' required>
		              				<option value='' selected disabled>Select...</option>
		             			"; do { 

		             				echo " <option value='".$department['department_name']."'>".$department['department_name'];

		             				} while($department = mysqli_fetch_assoc($query4)); echo "</option>
		           				 </select><br><br>";

       				 echo "<input type='submit' value='Register!'/>";

	echo "</fieldset>";

echo "</form>";

//switch
echo "	<script type='text/javascript'>
			
			 function hideFunction() {
			 	alert('1');
			
               
          }
   			

		</script>";


//else{
//                  document.getElementById('agency_name').value = '';
//                  document.getElementById('agency_tele').value = '';
//                  document.getElementById('agency_fax').value = '';
//                  document.getElementById('agency_email').value = '';
//                  document.getElementById('agency_url').value = '';
//
//                  document.getElementById('agency_type').selectedIndex = '0';
//                  document.getElementById('agency_role').selectedIndex = '0';
//                  document.getElementById('department_name').selectedIndex = '0';
//
//                }		

?>