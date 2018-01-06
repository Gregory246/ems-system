<?php

session_start();

 include_once('dbconnect.php');


if(!isset($_SESSION['userid'])){

  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
  header("Location: http://$host/ems/");
        exit();
}
 

      

?>
<!DOCTYPE html>
<html>
<head>
  <script type="text/javascript">

    function disasterbylocation(){

      var p_riod = document.getElementById("period").checked? true:false;
      var str_from = document.getElementById("fromyear").value;
      var str_to = document.getElementById("toyear").value;
      var addy = document.getElementById("addy").checked? true:false;
      var adline1 = document.getElementById("adl1").value;
      var loca = document.getElementById("loca").value;
      var cnty = document.getElementById("cnty").value;
      var city = document.getElementById("city").value;
      var coord = document.getElementById("coord").value;
      var coord1 = document.getElementById("coord1").value;
      var lokey = document.getElementById("lokey").checked? true:false;
      var conty = document.getElementById("conty").checked? true:false;
      var city1 = document.getElementById("city1").checked? true:false;


    if( addy == false && p_riod == false && lokey == false && conty == false && city1 == false){

      document.getElementById("test").innerHTML= "Please Enter A Period OR an Address or otherwise!";
      return;
    } 
     if (window.XMLHttpRequest){
      //for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // for Older browsers
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function(){

      if (this.readyState == 4 && this.status == 200){
        document.getElementById("test").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET","location-queries-handler.php?fromyear="+str_from+"&toyear="+str_to+"&adline1="+adline1+"&loca="+loca+"&cnty="+cnty+"&city="+city+"&coord="+coord+"&coord1="+coord1,true);
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
<body>

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
                <fieldset >
                  <legend>Search Criteria:</legend>
                  
                  <input type="checkbox" name="period" value="period" id="period" onchange="enableFunction5(this)">
                     
                  <label>Period(year) From: </label>
                     <input type="date" class="search" name="fromyear" id="fromyear" disabled> <label>To:</label> 
                     <input type="date" class "search" name="toyear" id ="toyear"  disabled>&nbsp;&nbsp;<strong>(Optional Field)</strong><br></br>

                    <strong><hr></strong>

                     <input type="checkbox" name="addressline1" value="addressline1" id="addy" onchange="enableFunction(this)"><label for="addy">Address Line 1: </label><input type="text" class="" name="addressline1" id="adl1" disabled><br></br>

                     <input type="checkbox" name="locality" value="locality" id="lokey" onchange="enableFunction1(this)"><label>Locality: </label><input type="text"  name="locality" id="loca" disabled>
                    <br></br>

                    <input type="checkbox" name="country" value="country" id="conty" onchange="enableFunction2(this)"><label>Country: </label><input type="text"  name="country" id="cnty" disabled><br></br>

                    <input type="checkbox" name="city" value="city" id="city1" onchange="enableFunction3(this)"><label>City: </label><input type="text"  name="city" id="city" disabled><br></br>

                    <input type="checkbox" name="coordinate" value="coordinate" id="coor" onchange="enableFunction4(this)" ><label>Coordinates: </label>&nbsp;&nbsp;<strong>(Optional Field)</strong><br>

                    <lable>Longtitude: </label><input type="text" class="" name="longtitude" id="coord" disabled>

                    <label>Latitude: </label><input type="text" class="" name="latitude" id="coord1" disabled><br></br>

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

                                function enableFunction0(location_disaster){
                                  var a = document.getElementById("disastergroup_nat");
                                  var b = document.getElementById("disastergroup_tech");
                                  var c = document.getElementById("disastergroup_nattech");

                                  a.disabled = location_disaster.checked? false:true;
                                  b.disabled = location_disaster.checked? false:true;
                                  c.disabled = location_disaster.checked? false:true;

                                  if (a.disabled && b.disabled && c.disabled){

                             document.getElementById("disastergroup_nat").checked = false;
                             document.getElementById("disastergroup_tech").checked = false;
                             document.getElementById("disastergroup_nattech").checked = false;
                          }
                                 }

                                 


                                </script>

                                      <script>
                                          function enableFunction(addy) {
                                              var x =document.getElementById("adl1"); //Gets current state of textbox 
                                              x.disabled = addy.checked? false:true; //Checks the the state to being disabled
                                              if (!x.disabled){x.focus();} else{
                                                document.getElementById("adl1").value = "";
                                              }         //If the state is not disabled then trigger the state of the textbox. This event is implicitly applicable to a limited set of elements, such as form elements
                                          }

                                            
                                                      function enableFunction1(lokey) {
                                                        var t = document.getElementById("loca");
                                                        t.disabled = lokey.checked? false:true;
                                                        if (!t.disabled){t.focus();} else{
                                                          document.getElementById("loca").value = "";
                                                        }
                                                  }

                                                    function enableFunction2(conty) {
                                                      var u = document.getElementById("cnty");
                                                        u.disabled = conty.checked? false:true;
                                                        if (!u.disabled){u.focus();} else{
                                                          document.getElementById("cnty").value = "";
                                                        }
                                              }

                                                        function enableFunction3(city1) {
                                                          var v = document.getElementById("city");
                                                        v.disabled = city1.checked? false:true;
                                                        if (!v.disabled){v.focus();} else{
                                                          document.getElementById("city").value = "";
                                                        }
                                                        }

                                                          function enableFunction4(coor) {
                                                          var w = document.getElementById("coord");
                                                          w.disabled  = coor.checked? false:true;
                                                        if (!w.disabled){w.focus();} else{
                                                          document.getElementById("coord").value = "";
                                                          document.getElementById("coord1").value = "";
                                                        }

                                                              var z = document.getElementById("coord1");
                                                          z.disabled  = coor.checked? false:true;
                                                        if (z.disabled){z.focus();}

                                                        }

                                                            
                                         </script>

                                      <script type="text/javascript">

                                      function myReset(){

                                        document.getElementById("disastereventsearch_form").reset();
                                      }

                                      </script>

                                      <input type="button" name="submit" value="Search" onclick ="disasterbylocation()" />&nbsp;<input type = "button" onclick="myReset()" value="Clear fields!" />

                </fieldset>

              </form>
            <p>Location field is mandatory</p>
            
          </div>
          <div id="test" style="margin-left:250px"> </div>
      </body>
    </html>    