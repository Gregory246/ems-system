<?php

session_start();

 include_once('dbconnect.php');


if(!isset($_SESSION['userid'])){

  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
  header("Location: http://$host/ems/");
        exit();
}
 

      //For pre-loaded time in selected menus
     $select_agency = "SELECT agency_name FROM `agency` WHERE agency_role = 'Early Warning'";
     $query = mysqli_query($con, $select_agency);
     //$agency = mysqli_fetch_assoc($query);
      

?>
<!DOCTYPE html>
<html>
<head>
  <script type="text/javascript">

  function showNewTable(){

    var period = document.getElementById("period").checked;
    var fromyear = document.getElementById("fromyear").value;

    var toyear = document.getElementById("toyear").value;
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
      xmlhttp.open("GET","informant-queries-handler.php?agency="+agency+"&fromyear="+fromyear+"&toyear="+toyear+"&period="+period,true);
      xmlhttp.send();
  }


  </script>
</head>
<title>Disaster Search</title>
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
    <li><a href="\ems\dispatch\home-page.php" class="w3-theme-l1"><strong>EMS</strong></a></li>
    <li class="w3-hide-small"><a href="\ems\dispatch\home-page.php" class="w3-hover-white">Home</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\log-event1.php" class="w3-hover-white">Log Details</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\dispatch-views.php" class="w3-hover-white">Notifiers</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\event-queries-location.php" class="w3-hover-white">Search</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\contacts-domain-handler.php" class="w3-hover-white">Contacts</a></li>
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

<!-- Sidenav -->
              <nav class="w3-sidenav w3-collapse w3-theme-l5 w3-animate-left" style="z-index:3;width:250px;margin-top:62px;" id="mySidenav">
                <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="close menu">
                    <i class="fa fa-remove"></i>
                </a>
              <h4 style = "font-size: 190%"><b>Search by:</b></h4>
                  <a href="\EMS\dispatch\event-queries-location.php" class="w3-hover-black" style = "font-size:150%">Location</a>
                  <a href="\EMS\dispatch\event-queries-disaster.php" class="w3-hover-black" style = "font-size:150%">Disaster</a>
                  <a href="\EMS\dispatch\event-queries-date.php" class="w3-hover-black" style = "font-size:150%">Date</a>
                  <a href="\EMS\dispatch\event-queries-informant.php" class="w3-hover-black" style = "font-size:150%">Informant</a>
              </nav>

             

<!-- Main content: shift it to the right by 250 pixels when the sidenav is visible -->
<div class="w3-main" style="margin-left:250px">

 

    <body onload="startTime()" >
        <!--Banner top of web-->
        <!--<img src="webpageimages/EMSlogo.jpg" style="width:180px;height:110px;"/>-->
          
            

              <form id = "disastereventsearch_form" action = "" method = "POST" class="form1" >
                <br></br><br>
                <fieldset>
                  <legend>Search Criteria:</legend>
                  <input type="checkbox" name="period" value="period" id="period" onchange="enableFunction5(this)">
                  <label>Period(year) From: </label>
                     <input type="date"  name="fromyear" id="fromyear" disabled > <label>To:</label> 
                     <input type="date"  name="toyear" id="toyear" disabled >&nbsp;&nbsp; <strong>(Optional Fields)</strong><br></br>

                    <!-- <label>Disaster Group:</label>
                     <input type="radio" name="disastergroup" value="disastergroup_nat" checked>Natural&nbsp;
                     <input type="radio" name="disastergroup" value"disastergoup_tech">Technology&nbsp;
                     <input type="radio" name="disastergroup" value"disastergoup_nattech">Natural/Technological&nbsp;&nbsp;<strong>(Optional Fields)</strong><br><br></br>-->

                     <div align="center">
                         <fieldset style = "display:inline-block; vertical-align:left">

                              <legend><strong>Stakeholders:</strong></legend>

                              <label><strong>Entity<strong></strong>:</strong></label>
                                  <select name="agency" id = "agency" required>
                                    <option value="" >Select</option>
                                    <?php while ($row2 = mysqli_fetch_assoc($query)):;?>

                                     <option><?php echo implode("\t", $row2); ?></option>
								                      <?php endwhile;?>
								                     </select>
                                    
                                   <br></br>

                        </fieldset>

                       </div>

                     <br></br>
                     <input type="button" name="submit" value="Search" onclick ="showNewTable()" />&nbsp;<input type = "button" onclick="myReset()" value="Clear fields!"/>
                    <strong><div id="test1" style="margin-left:250px"> </div></strong>
                </fieldset>

              </form>
            
          </div>
          <div id="test" style="margin-left:250px"> </div>
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

      <script type="text/javascript">

                                      function myReset(){

                                        document.getElementById("disastereventsearch_form").reset();
                                      }

                                      </script>
    </html>    