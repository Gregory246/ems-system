<?php 
session_start();
include_once('dbconnect.php');
error_reporting(0);
 
 $bool = "false";//$_GET['bool'];

 //$agency = $_GET['agency'];
 //$_GET['flip'] == "true" && 

 $userid = $_SESSION["userid"];

    //echo $_GET['flip']; 

if(($_GET['status1'] == "false" || $_GET['status1'] == "true") && $_GET['flip'] == "true"){

  $status1 = $_GET['status1'];
  $priority = $_GET['priority'];
  $authorizer = $_GET['authorizer'];
  $purpose = $_GET['purpose'];
  $request_type = $_GET['request_type'];
  $ext_int = $_GET['ext_int'];

echo "Notification logged!";

  $select2 = "SELECT request_type.request_type_id FROM request_type WHERE request_type.type = '$request_type'"; 

  $query1 = mysqli_query($con,$select2);
  $request = mysqli_fetch_assoc($query1);

  

  $select5 = "SELECT employee_id FROM employees
              WHERE MATCH(employees.employee_fname, employees.employee_lname) AGAINST('$authorizer')";
      $query5 = mysqli_query($con,$select5);

        $employee_id = mysqli_fetch_assoc($query5)

  $select = "SELECT user_id FROM users WHERE username = '$userid' ";
  $query = mysqli_query($con,$select);
  $user_id = mysqli_fetch_assoc($query);



  $insert_notification = "INSERT INTO notification (notification_id,priority,status,purpose,type,authorized_by,external,user_id) 
                          VALUES (NULL,'$priority',$status1,'$purpose','$request[request_type_id]','$employee_id[employee_id]',$ext_int,'$user_id[user_id]')";
  //mysqli_query($con,$insert_notification);



  //$select1 = "SELECT notification.priority, notification.purpose, notification.type, notifcation.authorized_by, notification.external, request_type.type, employees.employee_fname, employees.employee_lname
     //   FROM notification JOIN request_type ON notification.type = request_type.type JOIN employees ON notification.authorized_by = employees.employee_id";


    //$query1_0 = mysqli_query($con,$select1);
    //$notification = mysqli_fetch_assoc($query1_0);


  }//Assigns a notification to a call
  if (($_GET['status1'] == "false" || $_GET['status1'] == "true") && $_GET['flip'] != "true") ) {
    
    $status1 = $_GET['status1'];

    echo $status1; echo "notification updated";

    $select = "SELECT user_id FROM users WHERE username = '$userid' ";
  $query = mysqli_query($con,$select);
  $user_id = mysqli_fetch_assoc($query);

      $select1 = "UPDATE notification SET status = $status1 WHERE notification.user_id = '$user_id[user_id]' ORDER BY notification.notification_id DESC LIMIT 1";
      mysqli_query($con,$select1);


        $select2 = "SELECT callext_id FROM call_ext WHERE call_ext.user_id = '$user_id[user_id]' ORDER BY call_ext.callext_id DESC LIMIT 1";

        $select3 = "SELECT notification_id FROM notification WHERE notification.user_id = '$user_id[user_id]' ORDER BY notification.notification_id DESC LIMIT 1";

        $query2 = mysqli_query($con,$select2);

        $query3 = mysqli_query($con,$select3);

        $callext_id = mysqli_fetch_assoc($query2);

        $notification_id = mysqli_fetch_assoc($query3);

        $insert_call_note = "INSERT INTO call_ext_notify_junc (call_ext_notify_junc_id,callext_id,notification_id) 
                              VALUES (NULL,'$callext_id[callext_id]','$notification_id[notification_id]') "; 

                              mysqli_query($con,$insert_call_note);

  }


?>