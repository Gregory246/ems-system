<?php 
session_start();

 include_once('dbconnect.php');


if(isset($_SESSION['userid'])){

  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost

  $username = $_SESSION['userid']; 

 //Returns User Tier and directs to appropriate EMS.php section
$res = "SELECT tier_level_id_FK FROM users WHERE username = '$username' LIMIT 1";
$resquery = mysqli_query($con,$res);
$fetch_resquery = mysqli_fetch_assoc($resquery);

$arry_to_strg_fetch_resquery1 = implode("", $fetch_resquery); //Converts array to string 

$res2 = "SELECT tier_level_class FROM tier_level WHERE tier_level_id = '$arry_to_strg_fetch_resquery1'";
$resquery2 = mysqli_query($con,$res2);
$fetch_resquery2 = mysqli_fetch_assoc($resquery2);

$arry_to_strg_fetch_resquery2 = implode("", $fetch_resquery2);

if ($arry_to_strg_fetch_resquery2 == 100)
	{
		header("Location: http://$host/ems/detect-agency/home-page.php");
				exit();
	}

	elseif ($arry_to_strg_fetch_resquery2 == 200)
	{
		header("Location: http://$host/ems/dispatch/home-page.php");
				exit();

	}

	elseif ($arry_to_strg_fetch_resquery2 == 300) {
		//"Location: http://$host/ems/logout.php" //Location: http://$host/ems/field-management/usher-file1.php
		header("Location: http://$host/ems/logout.php");
		exit();
	}

	elseif ($arry_to_strg_fetch_resquery2 == 400) {
		
		header("Location: http://$host/ems/");
		exit();
	}

	elseif ($arry_to_strg_fetch_resquery2 == 500) {
		
		header("Location: http://$host/ems/logout.php");
		exit();
	}


} else{
 

$host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 

$file = 'ems/index.php'; // points to specified file and then store in variable



//To prevent SQL injections and clear invalid characters
//$username = $_POST['username'];
//$loginid = $_POST['loginid'];

//Store User's session ID in Golbal Variable




//=====================================================+++++++++++++++++++++++++++++++++++++++++++++=============================================================



$username = trim($_POST['username']);
  $username = strip_tags($username);
  $username = htmlspecialchars($username);
  
  $loginid = trim($_POST['loginid']);
  $loginid = strip_tags($loginid);
  $loginid = htmlspecialchars($loginid);

if(empty($username)){
   $error = true;
   $usernameError = "Please enter your email address.";
   } else {$error = false;}
  
  if(empty($loginid)){
   $error = true;
   $loginidError = "Please enter your password.";
     } else {$error = false;}

if(!$error) //Ensures user can not instert empty string

{
//Verify User Exist
$result = "SELECT username,loginid FROM users WHERE username = '$username' AND loginid = '$loginid' LIMIT 1";
$resultquery = mysqli_query($con,$result) ;//or header("Location: http://$host/$file"); //Or if user doesn't exist redirect page to Location:$host/$file


if (mysqli_num_rows($resultquery) ==1)

{
$loginsrecord = mysqli_fetch_assoc($resultquery);



//Returns User Tier and directs to appropriate EMS.php section
$res = "SELECT user_id FROM users WHERE username = '$username' AND loginid = '$loginid' LIMIT 1";
$resquery = mysqli_query($con,$res);
$fetch_resquery = mysqli_fetch_assoc($resquery);

$arry_to_strg_fetch_resquery = implode("", $fetch_resquery); //Converts array to string 

$res1 = "SELECT tier_level_id_FK FROM users WHERE user_id = '$arry_to_strg_fetch_resquery'";
$resquery1 = mysqli_query($con,$res1);
$fetch_resquery1 = mysqli_fetch_assoc($resquery1);

$arry_to_strg_fetch_resquery1 = implode("",$fetch_resquery1);

$res2 = "SELECT tier_level_class FROM tier_level WHERE tier_level_id = '$arry_to_strg_fetch_resquery1'";
$resquery2 = mysqli_query($con,$res2);
$fetch_resquery2 = mysqli_fetch_assoc($resquery2);

$arry_to_strg_fetch_resquery2 = implode("", $fetch_resquery2);



	if($loginsrecord['username'] != $username && $loginsrecord['loginid'] != $loginid)

	{
		header("Location: http://$host/ems/");
				exit();
	}

//--------------------------SYSTEM DOMAINS------------------------------------//
	elseif ($arry_to_strg_fetch_resquery2 == 100)
	{
		$_SESSION["userid"] = $_POST['username'];
		header("Location: http://$host/ems/detect-agency/home-page.php");
				exit();
	}

	elseif ($arry_to_strg_fetch_resquery2 == 200)
	{
		$_SESSION["userid"] = $_POST['username'];
		header("Location: http://$host/ems/dispatch/usher-file.php");
				exit();

	}

	elseif ($arry_to_strg_fetch_resquery2 == 300) {
		
		$_SESSION["userid"] = $_POST['username'];
		header("Location: http://$host/ems/field-management/usher-file1.php");
		exit();
	}

	elseif ($arry_to_strg_fetch_resquery2 == 400) {
		
		$_SESSION["userid"] = $_POST['username'];
		header("Location: http://$host/ems/field-management/field/access.php");
		exit();
	}

	else {
					$_SESSION["userid"] = $_POST['username'];
		header("Location: http://$host/ems/hospital/usher-file.php");
				exit();
	}

}

else{

	 	  
		mysqli_close($con);
		exit();
}

}

else{
	
     header("Location: http://$host/$file");

   
}

}
?>