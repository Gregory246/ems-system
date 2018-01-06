<?php
session_start();
include_once('dbconnect.php');

if(!isset($_SESSION['userid'])){

  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
  header("Location: http://$host/ems/");
        exit();
}

error_reporting(0);

$userid = $_SESSION["userid"];

	//For pre-loaded time in selected menus
     $select_agency = "SELECT agency_name FROM `agency` WHERE agency_role = 'Early Warning'";
     $query0 = mysqli_query($con, $select_agency);
     //$agency = mysqli_fetch_assoc($query);

     //For pre-loaded departments in selected menus
     $select = "SELECT user_id FROM users WHERE username = '$userid' ";
     $query = mysqli_query($con,$select);
    $user_id = mysqli_fetch_assoc($query);


     $select2 = "SELECT request_type.type FROM request_type WHERE request_type.request_type_id = 22 OR request_type.request_type_id = 24";

  $query1 = mysqli_query($con,$select2);
  $request = mysqli_fetch_assoc($query1);


  $select3 = "SELECT DISTINCT agency.agency_name,department.department_name, IFNULL(department.department_fax,'~')department_fax,
        employees.employee_fname,employees.employee_lname, employees.user_id
        FROM employees_department_junc JOIN department ON employees_department_junc.department_FK_id = department.department_id 
        JOIN employees ON employees_department_junc.employee_FK_id = employees.employee_id 
        JOIN agency ON department.agency_id = agency.agency_id WHERE employees.user_id = '$user_id[user_id]'";


    $query2 = mysqli_query($con,$select3);

    $user_agency = mysqli_fetch_assoc($query2);

  $select4 = "SELECT DISTINCT agency.agency_name,department.department_name, IFNULL(department.department_fax,'~')department_fax,
        employees.employee_fname,employees.employee_lname
        FROM employees_department_junc JOIN department ON employees_department_junc.department_FK_id = department.department_id 
        JOIN employees ON employees_department_junc.employee_FK_id = employees.employee_id 
        JOIN agency ON department.agency_id = agency.agency_id WHERE agency.agency_name = '$user_agency[agency_name]' ";

    $query3 = mysqli_query($con,$select4);

 
?>
<!DOCTYPE html>
	<html>
	<head>
		<title>Contacts</title>
    <script type="text/javascript">

  function showEmployees(){

     var agency = document.getElementById("agency").value;

    if(agency == ""){

      document.getElementById("test1").innerHTML = "Please select an Agency!";
      return;
    }
      if(window.XMLHttpRequest){
        //for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {

        //For older browsers 
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.onreadystatechange = function(){

          if(this.readyState == 4 && this.status == 200){
            document.getElementById("test").innerHTML = this.responseText;
          }
      }
      xmlhttp.open("GET","contacts-queries-handler.php?agency="+agency,true);
      xmlhttp.send();
  }


  </script>
	</head>

	<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
.w3-sidenav a,.w3-sidenav h4 {padding: 12px;}
.w3-navbar li a {
    padding-top: 12px;
    padding-bottom: 12px;
}
</style>
		<!-- Navbar -->
<div class="w3-top">
  <ul class="w3-navbar w3-theme w3-top w3-left-align w3-large">
    <li class="w3-opennav w3-right w3-hide-large">
      <a class="w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="\ems\detect-agency\home-page.php" class="w3-theme-l1"><strong>EMS</strong></a></li>
    <li class="w3-hide-small"><a href="\ems\detect-agency\home-page.php" class="w3-hover-white">Home</a></li>
    <li class="w3-hide-small"><a href="\EMS\detect-agency\log-event1.php" class="w3-hover-white">Log Details</a></li>
    <li class="w3-hide-small"><a href="\EMS\detect-agency\event-queries-location.php" class="w3-hover-white">Queries</a></li>
    <li class="w3-hide-small"><a href="\EMS\detect-agency\contacts.php" class="w3-hover-white">Contacts</a></li>
    <li class="w3-hide-medium w3-hide-small"><a href="\ems\logout.php" class="w3-hover-white">Log Out</a></li>
    <li class="w3-hide-medium w3-hide-small"><a href="#" class="w3-hover-white"></a></li>

    <p id="clock"></p>
<script>
function startTime() {
    var d = new Date();
    var n = d.toTimeString();
    document.getElementById("clock").innerHTML = n;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>
  </ul>

<!--To align Form in correct position-->
  <script type="text/css">
    .perimeter{
      margin-top:65px;
      width:"100px";
      clear: both; 
    }
    .perimeter input{
      width: "100%";
      clear: both;
    }
  </script>
</div>
<div class="w3-main" style= "text-align:center" >

 

    <body onload="startTime()" >
        <!--Banner top of web-->
        <!--<img src="webpageimages/EMSlogo.jpg" style="width:180px;height:110px;"/>-->
          
            

              <form id = "disastereventsearch_form" action = "" method = "POST" class="form1" >
                <br></br><br>
                <fieldset style = "margin:auto; width:1000px">
                  <legend>Contacts:</legend>
                  

                    <!-- <label>Disaster Group:</label>
                     <input type="radio" name="disastergroup" value="disastergroup_nat" checked>Natural&nbsp;
                     <input type="radio" name="disastergroup" value"disastergoup_tech">Technology&nbsp;
                     <input type="radio" name="disastergroup" value"disastergoup_nattech">Natural/Technological&nbsp;&nbsp;<strong>(Optional Fields)</strong><br><br></br>-->

                     <div align="center">
                         <fieldset style = "display:inline-block">

                              <legend><strong>Stakeholders:</strong></legend>

                              <label><strong>Entity<strong></strong>:</strong></label>
                                  <select name="agency" id = "agency" required>
                                    <option value="" >Select</option>
                                    <?php while ($row2 = mysqli_fetch_assoc($query0)):;?>

                                     <option><?php echo implode("\t", $row2); ?></option>
                                      <?php endwhile;?>
                                     </select>
                                    
                                   <br></br>
                                   
                        </fieldset>

                       </div>

                     <br><strong><div id="test1" align = "center"> </div></strong></br>


                     <input type="button" name="submit" value="Search" onclick ="showEmployees()" />&nbsp;<input type = "button" onclick="myReset()" value="Clear fields!"/>
                    
                </fieldset>
<!-----------------------------------------Notificatin table--------------------------------------- -->
                <label><strong>Notification:</strong></label>
    <table id="notification"  border=1 align="center" >
            <tr>
              <th>Priority </th>
              <th>Authorizing Personnel</th>
              <th>Reason</th>
              <th>Notification Type</th>
              <th>External/Internal</th>
              <th></th>
            </tr>
              <td align="center" ><input type="text" id="priority"/></td>
              <td align="center" ><select  id="authorizer" onchange = "myFunction()" >
         <option value="" selected disabled>Select...</option>
          <?php while ($authorized_by = mysqli_fetch_assoc($query3)):;?>
         <option value="<?=$authorized_by['employee_fname']. ' ' .$authorized_by['employee_lname'];?>"><?php echo $authorized_by['employee_fname']. "&nbsp;" .$authorized_by['employee_lname']; ?></option>
        <?php endwhile;?>
         </select></td>
         <td align="center" ><input type="text" id="purpose"/></td>
         <td align="center" ><select  id="request_type" >
         <option value="" selected disabled>Select...</option>
          <?php while ($request = mysqli_fetch_assoc($query1)):;?>
         <option value="<?=$request['type'];?>"><?php echo $request['type']; ?></option>
        <?php endwhile;?>
         </select></td>
         <td align="center" ><input type="checkbox" name="ext_int" value="" id="ext_int" /></td>
         <td><button type="button" onclick ="notifyUpdate()">UPDATE!</button></td>
          </table>
<!--------------------------------THe End-------------------------------------------------------- -->
              </form>
 <!-- This collects the details of the notification being made by the user who initiates the call  -->             
              <script type="text/javascript">

                    var flip = false;

            function notifyUpdate(){

                
                flip = flip? false:true;
                

                var status1 = confirm("Was the Notification Event Successful?");
                //var status1 = status0;
                //alert(status1);
                var priority = document.getElementById("priority").value;
                var authorizer = document.getElementById("authorizer").value;
                var purpose = document.getElementById("purpose").value;
                var request_type = document.getElementById("request_type").value;
                var ext_int = document.getElementById("ext_int").checked? true:false;

        if(status1 == false || status1 == true){
          xmlhttp = new XMLHttpRequest();
         
      xmlhttp.onreadystatechange = function(){

          if(this.readyState == 4 && this.status == 200){
            document.getElementById("inner").innerHTML = this.responseText;
          }
      }
      
      xmlhttp.open("GET","notification-handler.php?status1="+status1+"&flip="+flip,true);
      xmlhttp.send();
           return;
    }

                if(window.XMLHttpRequest){
        //for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {

        //For older browsers 
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.onreadystatechange = function(){

          if(this.readyState == 4 && this.status == 200){
            document.getElementById("inner").innerHTML = this.responseText;
          }
      }
      xmlhttp.open("GET","notification-handler.php?priority="+priority+"&flip="+flip+"&authorizer="+authorizer+"&purpose="+purpose+"&request_type="+request_type+"&ext_int="+ext_int,true);
      xmlhttp.send();
             
            }

          </script>
            
          </div>
          <hr>
                <div id="inner" border=1 align="center" ></div> <!--<div id="inner1" border=1 align="center" ></div>--><hr><hr>
          <table id="test"  border=1 align="center" >
            <tr>
              <th> </th>
            </tr>
          </table>
<hr>
          

<!-- This collects the details of the notification being made by the user who initiates the call  -->
         <script type="text/javascript">

                    var bool = false;

            function makeCall(call){

                setInterval(checkStatus,5000); //Once makeCall() is initiated this would run the checkStatus function to tell the caller if the called ended the call

                var calls = call.toString(); 

                bool = bool? false:true;

                var agency = document.getElementById("agency").value;

        if(bool == false){

      //document.getElementById("test1").innerHTML = "CALL ENDED!";
      //var status0 = confirm("Was the Notification Event Successful?"); 
      notifyUpdate(); 
      xmlhttp.open("GET","call-handler.php?bool="+bool+"&calls="+calls,true);
      xmlhttp.send();
      return;
    } else {

        document.getElementById("test1").innerHTML = "";
    }

                if(window.XMLHttpRequest){
        //for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
      } else {

        //For older browsers 
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); 
      }

      xmlhttp.onreadystatechange = function(){

          if(this.readyState == 4 && this.status == 200){
            document.getElementById("inner").innerHTML = this.responseText;
          }
      }
      xmlhttp.open("GET","call-handler.php?agency="+agency+"&bool="+bool+"&calls="+calls,true);
      xmlhttp.send();
      document.getElementById("test1").innerHTML = "CALL INITIALIZED!"
             
            } 

          </script>

          <script type="text/javascript">

          function checkStatus(){

              var checkstatus = 1; 
              xmlhttp = new XMLHttpRequest();

          xmlhttp.onreadystatechange = function(){

                  if(this.readyState == 4 && this.status == 200){
                    document.getElementById("test1").innerHTML = this.responseText;
                  }
            }
      
            xmlhttp.open("GET","call-handler.php?checkstatus="+checkstatus,true);
              xmlhttp.send();
                return;
              }


          </script>
      </body>
      <script type="text/javascript">
        function enableFunction5(period){

                          var d = document.getElementById("fromyear");
                          var e = document.getElementById("toyear");

                          d.disabled = period.checked? false:true;
                          e.disabled = period.checked? false:true;

                          if (d.disabled && e.disabled){

                             document.getElementById("fromyear").value = "NULL";
                             document.getElementById("toyear").value = "NULL";
                          }
                        }
      </script>
	</html>