<?php 

$con = mysqli_connect("localhost","root","") ; //Connects to the Database Server MySQL 

if (!$con) 

{ 

  $output = 'Unable to connect to the database server.'; 

  exit(); 

} 

 

if (!mysqli_set_charset($con, 'utf8')) // Change and sets the default character set to UTF-8

{ 

  $output = 'Unable to set database connection encoding.';  

  exit(); 

} 

 

if (!mysqli_select_db($con, "initial_alert_v0")) 

{ 
  
  $output = 'Unable to locate Database.'; 

  exit(); 

} 
//List of Pre-queries required to show data-list for some drop down menus when the given page is selected

//Select disaster subgroups
	
?>