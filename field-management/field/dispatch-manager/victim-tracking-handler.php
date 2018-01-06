<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/ems/dbconnect.php');
error_reporting(0);

/*************UNCOMMENT ONCE LOGIN IS FIXED*****************/ 
//$userid = $_SESSION['userid'];

$select4 = "SELECT employees.*, users.username 
			FROM employees JOIN users ON employees.user_id = users.user_id 
			WHERE users.username = 'jess'";//Remove Dummy value 

	$query4 = mysqli_query($con,$select4);

	$employee = mysqli_fetch_assoc($query4);

$select5 = "SELECT * FROM employees WHERE employees.employee_title = '' ";  //MAY NEED TO ADD MY DATA TO DATABASE BECAUSE THIS PERSON SHOULD BE A PHYSICIAN/ANESTHESIOLOGIST/SURGEON,
																		                                        //THIS COULD BE SOMEONE FROM A MUNICIPAL COOP OR RED-CROSS
	$query5 = mysqli_query($con,$select5);

	$specialist = mysqli_fetch_assoc($query5);

	//$disaster_id = $_SESSION['disaster_id']; //From even field-management/ambulance/unit-lead/event-record-handler.php


	$select1 = "SELECT field_treatment.*,victim.* 
				FROM victim 
				JOIN field_treatment ON victim.victimid = field_treatment.victimid 
				WHERE victim.treatment_received = '1' 
				AND victim.evacuation_triage_tag IS NOT NULL
        AND victim.dispatch_priority IS NULL 
				AND victim.disaster_id = '70' 
				ORDER BY victim.last_updated ASC LIMIT 1"; //Remove dummy value 

          $query1 = mysqli_query($con,$select1);

          $victim_key = mysqli_fetch_assoc($query1);
?>