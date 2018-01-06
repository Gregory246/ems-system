<?php 
session_start();
session_destroy();//Destroys user's session
$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
header("Location: http://$host/ems/");
exit();
?>