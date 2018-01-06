<?php

//session_start();

 include_once('dbconnect.php');

 $query_nat = "SELECT DISTINCT disaster_subgroup FROM `disastertype` WHERE disaster_group = 'Natural'";
      $query_tech = "SELECT DISTINCT disaster_subgroup FROM `disastertype` WHERE disaster_group = 'Technological'";
      $sqlSELECTsubn = mysqli_query($con,$query_nat);
      $sqlSELECTsubt = mysqli_query($con,$query_tech);

?>

<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
   
   function showNewList_nat(str){

    if(str==""){

      document.getElementById("disastertypes_nat").innerHTML="Select...";
      return;
    } if (window.XMLHttpRequest){
      //for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else {
      // for Older browsers
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function(){

      if (this.readyState == 4 && this.status == 200){
        document.getElementById("disastertypes_nat").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET","event_log_handler_.php?disastertype_nat="+str,true);
    xmlhttp.send();
   }
</script>

<script type="text/javascript">

function showNewList_tech(str) {
  if (str=="") {
    document.getElementById("disastertypes_tech").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("disastertypes_tech").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","event_log_handler_.php?disastertype_tech="+str,true);
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

<!-- Sidenav -->
              <nav class="w3-sidenav w3-collapse w3-theme-l5 w3-animate-left" style="z-index:3;width:250px;margin-top:62px;" id="mySidenav">
                <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="close menu">
                    <i class="fa fa-remove"></i>
                </a>
              <h4 style = "font-size: 190%"><b>Search by:</b></h4>
                  <a href="\EMS\detect-agency\event-queries-location.php" class="w3-hover-black" style = "font-size:150%">Location</a>
                  <a href="\EMS\detect-agency\event-queries-disaster.php" class="w3-hover-black" style = "font-size:150%">Disaster</a>
                  <a href="\EMS\detect-agency\event-queries-date.php" class="w3-hover-black" style = "font-size:150%">Date</a>
                  <a href="\EMS\detect-agency\event-queries-informant.php" class="w3-hover-black" style = "font-size:150%">Informant</a>
              </nav>

             

<!-- Main content: shift it to the right by 250 pixels when the sidenav is visible -->
<div class="w3-main" style="margin-left:250px">

<script type="text/javascript">

function disasterbydisaster(){

  var subgroup_nat = document.getElementById("disastersubgroup_nat").value;
  var type_nat = document.getElementById("type_nat").value;
  var type_subnat = document.getElementById("type_subnat").value;
  var type_subsubnat = document.getElementById("type_subsubnat").value;
  var subgroup_tech = document.getElementById("disastersubgroup_tech").value;
  var type_tech = document.getElementById("type_tech").value;
  var type_subtech = document.getElementById("type_subtech").value;
  var group1 = document.getElementById("group").checked? true:false;
  var group = document.getElementById("group").value;
  var group_nat = document.getElementById("group_nat").checked;
  var group_tech = document.getElementById("group_tech").checked;
  var group_nattech = document.getElementById("group_nattech").checked;

  
  if(group1 === false && subgroup_nat ==""){

    document.getElementById("test1").innerHTML = "Please select a field!";
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
    xmlhttp.open("GET","disaster-queries-handler.php?subgroup_nat="+subgroup_nat+"&subgroup_tech="+subgroup_tech+"&type_nat="+type_nat+"&type_tech="+type_tech+"&type_subnat="+type_subnat+"&type_subsubnat="+type_subsubnat+"&type_subtech="+type_subtech+"&group_nat="+group_nat+"&group_tech="+group_tech+"&group_nattech="+group_nattech+"&group="+group,true);
    xmlhttp.send();

    }

</script>

 

    <body onload="startTime()" >
        <!--Banner top of web-->
        <!--<img src="webpageimages/EMSlogo.jpg" style="width:180px;height:110px;"/>-->
          
            

              <form id = "disastereventsearch_form" action = "" method = "POST" class="form1" >
                <br></br><br>
                <fieldset>
                  <legend>Search Criteria:</legend>
                  
                  <label>Period(year) From: </label>
                     <input type="month" class="search" name="fromyear" required> <label>To:</label> 
                     <input type="month" class "search" name="toyear"  required><br></br><br></br>

                     <fieldset style = "display:inline-block">
                      <legend>Disaster Group:</legend>

                    <input type="checkbox" name="check" value="group" id="group" onchange="enableFunction(this)">&nbsp;&nbsp;
            
                     <input type="radio" name="disastergroup" value="Natural" id = "group_nat" disabled>Natural&nbsp;
                     <input type="radio" name="disastergroup" value ="Technological" id = "group_tech" disabled>Technology&nbsp;
                     <input type="radio" name="disastergroup" value = "nattech" id = "group_nattech" disabled>Natural/Technological&nbsp;&nbsp;<strong>Check to search by Groups ONLY</strong>
                     </fieldset><br><br></br>

                     <div align="center">
                         <fieldset style = "display:inline-block; vertical-align:left">

                              <legend><strong>Natural Selection:</strong></legend>

                              <label>Subgroup</label>&nbsp;
                              
                              <select name= "disastersubgroup_nat" id = "disastersubgroup_nat" onchange="showNewList_nat(this.value)">
                                <option value="" selected disabled>Select...</option>
                                <?php while ($row5 = mysqli_fetch_assoc($sqlSELECTsubn)):;?>
                                <option value="<?=$row5['disaster_subgroup'];?>"><?php echo $row5['disaster_subgroup']; ?></option>
                                <?php endwhile;?>
                              </select><br></br>
                            
                              <label>Type</label>&nbsp;
                              <select name="disastertypes_nat" id="disastertypes_nat">
                                <option value="" selected disabled>Select...</option>

                              </select><br></br>
                              <input type="text" name="type_nat" id="type_nat" hidden/><!--To store nat_type value-->
<script type="text/javascript" >

document.getElementById("disastertypes_nat").onchange = function () {

            var x = document.getElementById("disastertypes_nat").selectedIndex;
            var y = document.getElementById("disastertypes_nat").options;
            z = (y[x].text);
            w = (y[x].text);
            document.getElementById("type_nat").value = w;

   //Populates dropdown menus with new data from database
       if (z =="") {
    document.getElementById("disastersubtype_nat").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {

      document.getElementById("disastersubtype_nat").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","event_log_handler_1.php?b="+z,true);
  xmlhttp.send();
}

</script>
                              <label>Subtype</label>&nbsp;
                              <select name="disastersubtype_nat" id="disastersubtype_nat">
                                <option value="" selected disabled>Select...</option>

                              </select><br></br>
                              <input type="text" name="type_subnat" id="type_subnat" hidden />
                              <script type="text/javascript">
document.getElementById("disastersubtype_nat").onchange = function () {

            var x = document.getElementById("disastersubtype_nat").selectedIndex;
            var y = document.getElementById("disastersubtype_nat").options;
            z = (y[x].text);
            w = (y[x].text);
            document.getElementById("type_subnat").value = w;

   //Populates dropdown menus with new data from database
       if (z =="") {
    document.getElementById("disastersubsubtype_nat").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {

      document.getElementById("disastersubsubtype_nat").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","event_log_handler_1.php?d="+z,true);
  xmlhttp.send();
}

                              </script>

                              <label>Sub-subtype</label>&nbsp;
                              <select name="disastersubsubtype_nat" id="disastersubsubtype_nat">
                                <option value="" selected disabled>Select...</option>

                              </select>
                              <input type="text" name="type_subsubnat" id ="type_subsubnat" hidden/>

                              <script type="text/javascript">

                              document.getElementById("disastersubsubtype_nat").onchange = function () {

            var subx = document.getElementById("disastersubsubtype_nat").selectedIndex;
            var suby = document.getElementById("disastersubsubtype_nat").options;
            subz = (suby[subx].text);
            document.getElementById("type_subsubnat").value = subz;
          }
                              </script>
                        </fieldset>

                        <fieldset style="display:inline-block; vertical-align:right">

                              <legend><strong>Technological Selection:</strong></legend>

                              <label>Subgroup</label>&nbsp;

                              <select name="disastersubgroup_tech" id="disastersubgroup_tech" onchange="showNewList_tech(this.value)">
                                <option value="" selected disabled>Select...</option>
                                <?php while ($row6 = mysqli_fetch_assoc($sqlSELECTsubt)):;?>
                                <option value ="<?=$row6['disaster_subgroup'];?>"><?php echo $row6['disaster_subgroup']; ?></option>
                                <?php endwhile;?>
                              </select><br></br>

                              <label>Type</label>&nbsp;
                              <select name="disastertypes_tech" id="disastertypes_tech">
                                <option value="" selected disabled>Select...</option>

                              </select><br></br>
                              <input type="text" name="type_tech" id="type_tech" hidden />

                              <script type="text/javascript">
document.getElementById("disastertypes_tech").onchange = function () {

                    
            var x = document.getElementById("disastertypes_tech").selectedIndex;
            var y = document.getElementById("disastertypes_tech").options;
            z = (y[x].text);
            w = (y[x].text);
            document.getElementById("type_tech").value = w;
   //Populates dropdown menus with new data from database
       if (z =="") {
    document.getElementById("disastersubtype_tech").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp = new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {

      document.getElementById("disastersubtype_tech").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","event_log_handler_1.php?c="+z,true);
  xmlhttp.send();
}

                              </script>

                              <label>Subtype</label>&nbsp;
                              <select name="disastersubtype_tech" id="disastersubtype_tech">
                                <option value="" selected disabled>Select...</option>

                              </select>
                              <input type="text" name="type_subtech" id="type_subtech" hidden />

                              <script type="text/javascript">

                              document.getElementById("disastersubtype_tech").onchange = function () {

            var subi = document.getElementById("disastersubtype_tech").selectedIndex;
            var subk = document.getElementById("disastersubtype_tech").options;
            subz = (subk[subi].text);
            document.getElementById("type_subtech").value = subz;
          }
                              </script>

                        </fieldset>
                     </div>

                     <br></br>
                     <input type="button" name="submit" value="Search" onclick ="disasterbydisaster()" />&nbsp;<input type = "button" onclick="myReset()" value="Clear fields!" />
                     <strong><div id="test1" style="margin-left:250px"></div></strong>
                </fieldset>

              </form>
            
          </div>

          <div id="test" style="margin-left:250px"> </div>



          <script type="text/javascript">

          function enableFunction(group){
                                  var a = document.getElementById("group_nat");
                                  var b = document.getElementById("group_tech");
                                  var c = document.getElementById("group_nattech");

                                  a.disabled = group.checked? false:true;
                                  b.disabled = group.checked? false:true;
                                  c.disabled = group.checked? false:true;

                                  if (a.disabled && b.disabled && c.disabled){

                             document.getElementById("group_nat").checked = false;
                             document.getElementById("group_tech").checked = false;
                             document.getElementById("group_nattech").checked = false;
                          }
                                 }

          </script>
      </body>
</html>