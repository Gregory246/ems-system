<?php
session_start();
 include_once('dbconnect.php');

      //For pre-loaded disaster types in selected menus
      $query_nat = "SELECT DISTINCT disaster_subgroup FROM `disastertype` WHERE disaster_group = 'Natural'";
      $query_tech = "SELECT DISTINCT disaster_subgroup FROM `disastertype` WHERE disaster_group = 'Technological'";
      $sqlSELECTsubn = mysqli_query($con,$query_nat);
      $sqlSELECTsubt = mysqli_query($con,$query_tech);


      //For pre-loaded time in selected menus
      $query_timehh = "SELECT DISTINCT hour FROM `time_reg`";
      $query_timemm = "SELECT DISTINCT min FROM `time_reg`";
      $query_timess = "SELECT DISTINCT sec FROM `time_reg`";
      $sqlSELECTtimehh = mysqli_query($con, $query_timehh);
      $sqlSELECTtimemm = mysqli_query($con, $query_timemm);
      $sqlSELECTtimess = mysqli_query($con, $query_timess);


      //For pre-loaded required response & magnitude in selected menus 
      $query_alert = "SELECT DISTINCT level FROM `disastersystemresponse`";
      $query_mag = "SELECT DISTINCT magnitude FROM `disastermag`";
      $sqlSELECTalert = mysqli_query($con, $query_alert);
      $sqlSELECTmag = mysqli_query($con, $query_mag);

    ?>

<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" source="jquery-2.4.1.min.js">

    //Clear previos data in the drop-down menu
    function showNewList_nat(str) {
  if (str=="") {
    document.getElementById("disastertypes_nat").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }//When the drop-down menu property changes, this calls the getElement function, calls the function and set the drop-down menu to the retreived data
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("disastertypes_nat").innerHTML=this.responseText;
    }
  }//Sends the request to the handler file to retreive the data from the database
  xmlhttp.open("GET","event_log_handler_.php?disastertype_nat="+str,true);
  xmlhttp.send();
}
</script>
<!--------------------------------------------------------------------------------------------------------------------------------------------------- -->
<script type="text/javascript" source="jquery-2.4.1.min.js">

    //Populates dropdown menus with new data from database
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
<!-- ------------------------------------------------------------------------------------------------------------------------------------------------- -->

<!-- ------------------------------------------------------------------------------------------------------------------------------------------------- -->


</head>
<title>Record Logs</title>
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
</div>

<!-- Main content: shift it to the right by 250 pixels when the sidenav is visible -->
<div class="w3-main" style="margin-top:75px">

  <!--Sets styles for text boxes, images required on screen-->

<style type="text/css">

img
{
  display: block;
  margin:left auto;
}

textarea 
{

    display: block;
  width: 30%;
}


div.fixed1
{
  position:fixed;
  top: 1;
  right: 0.5;
}


div.fixed2
{
  position:fixed;
  top: 100;
  right: 30;
}


</style>



<body onload="startTime()" >
<!--Banner top of web-->
<img src="webpageimages/EMSlogo.jpg" style="width:180px;height:110px;"/>


<!--Begin webpage Form-->

<form id="detectdisaster_form" action="event_details_log_handler.php" method="POST" onsubmit ="return confirm('Is data accurate?')" onchange= "hidden()">

<!-- Data for Disaster details from tables and into tables (Database)-->  
<fieldset>
  <legend>Disaster Details:</legend>


  <label for="disaster_group"><strong>Natural/Technological*:</strong></label>
    <select name="disaster_group" id="disaster_group" required>
      <option value="" selected disabled>Select...</option>
      <option value="tag_nat">Natural</option>
      <option value="tag_tech">Technological</option>
      <option value="tag_nat_tech">Natural/Technological</option>
            
    </select>
     
    <?php echo $_SESSION["userid"]; ?>
    <br></br>

    <label for="disastersubgroup_nat" > <strong>Natural:</strong> </label>
         <select name="disastersubgroup_nat"  id="disastersubgroup_nat" onchange = "showNewList_nat(this.value)" disabled  required>
         <option value="" selected disabled>Select...</option>
          <?php while ($row5 = mysqli_fetch_assoc($sqlSELECTsubn)):;?>
         <option value="<?=$row5['disaster_subgroup'];?>"><?php echo $row5['disaster_subgroup']; ?></option> 
        <?php endwhile;?>
         </select> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


         <label for="disastersubgroup_tech"><strong>Technological:</strong> </label>
         <select name="disastersubgroup_tech" id="disastersubgroup_tech" onchange = "showNewList_tech(this.value)" disabled required>
         <option value="" selected disabled>Select...</option>
         <?php while ($row6 = mysqli_fetch_assoc($sqlSELECTsubt)):;?>
         <option value ="<?=$row6['disaster_subgroup'];?>"><?php echo $row6['disaster_subgroup']; ?></option>
     <?php endwhile;?>
         </select>

<br></br>

          <label><strong>Disaster Types*:</strong></label>&nbsp;
          <select name="disastertypes_nat" id="disastertypes_nat" disabled>
                  <option value="" selected disabled>Select...</option>
                  
        
              </select>&nbsp;&nbsp;
              <input type ="text" name= "type_nat" id ="type_nat" hidden /> <!--These are used to send the selected value to the event details script-->
<script type="text/javascript" source="jquery-2.4.1.min.js">

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
                     

          <label><strong>Disaster Types*:</strong></label>&nbsp;
            <select name="disastertypes_tech" id="disastertypes_tech">
                  <option value='0' selected disabled>Select...</option>
                  </select>
                  <input type ="text" name= "type_tech" id ="type_tech" hidden />

                  <script type="text/javascript" source="jquery-2.4.1.min.js">

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
<br></br>
          <label><strong>Disaster Subtype Nat:</strong></label>&nbsp;&nbsp;
          <select name="disastersubtype_nat" id="disastersubtype_nat">
                  <option value="" selected disabled>Select...</option>

                  </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type ="text" name= "type_subnat" id ="type_subnat" hidden />
                  <script type="text/javascript" source="jquery-2.4.1.min.js">

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
        
        <label><strong>Disaster Sub-subtype Nat:</strong></label>&nbsp;&nbsp;
          <select name="disastersubsubtype_nat" id="disastersubsubtype_nat">
                  <option value="" selected disabled>Select...</option>

                  </select>  
                  <input type ="text" name= "type_subsubnat" id ="type_subsubnat"hidden />
 <br></br> 
           <label><strong>Disaster Subtype Tech:</strong></label>&nbsp;&nbsp;
                     <select name="disastersubtype_tech" id="disastersubtype_tech">
                  <option value="" selected disabled>Select...</option>

                  </select>
                  <input type ="text" name= "type_subtech" id ="type_subtech" hidden />

                  <script type="text/javascript" source = "jquery-2.1.4.min.js">

                  document.getElementById("disastersubsubtype_nat").onchange = function (){
                  var x = document.getElementById("disastersubsubtype_nat").selectedIndex;
                  var y = document.getElementById("disastersubsubtype_nat").options;
                  w = (y[x].text);
                  document.getElementById("type_subsubnat").value = w;
                }
                 </script>

                 <script type="text/javascript" source = "jquery-2.1.4.min.js">
                  document.getElementById("disastersubtype_tech").onchange = function (){
                  var r = document.getElementById("disastersubtype_tech").selectedIndex;
                  var f = document.getElementById("disastersubtype_tech").options;
                  q = (f[r].text);
                  document.getElementById("type_subtech").value = q;

                }
                 </script>
<br></br>

    <label><strong>Time*<strong>(24:00)</strong>:</strong></label>
    <select name="time_reghh" required>
      <option value="" >HH</option>
      <?php while ($row2 = mysqli_fetch_assoc($sqlSELECTtimehh)):
                    ;?>
      
      <option><?php echo implode("\t", $row2); ?></option>
    <?php endwhile;?>
    </select>:

    <select name="time_regmm" required>
      <option value="">MM</option>
      <?php while ($row3 = mysqli_fetch_assoc($sqlSELECTtimemm)):
                    ;?>
      
      <option><?php echo implode("\t", $row3); ?></option>
    <?php endwhile;?>
    </select>:

    <select name="time_regss" required>
      <option value="">SS</option>
      <?php while ($row4 = mysqli_fetch_assoc($sqlSELECTtimess)):
                    ;?>
      
      <option><?php echo implode("\t", $row4); ?></option>
    <?php endwhile;?>
    </select>

    <br></br>

    <label for="level"><strong>Required response*:</strong>(max=5)</label>
    <select name="disasterlevel">
      <option value="">Select...</option>
      <?php while ($row7 = mysqli_fetch_assoc($sqlSELECTalert)):
                    ;?>
      
      <option><?php echo implode("\t", $row7); ?></option>
          <?php endwhile;?>
          </select>
    <br></br>

    <label for="magnitude"><strong>Disaster magnitude*:</strong>(max=10)</label>
    <select name="disasterscale">
      <option value="">Select...</option>
      <?php while ($row8 = mysqli_fetch_assoc($sqlSELECTmag)):
                    ;?>
      
      <option><?php echo implode("\t", $row8); ?></option>
          <?php endwhile;?>
          </select>

    </fieldset>

    <fieldset>
      <legend>Event Location:</legend>

                                   <label>Address Line 1*:</label>&nbsp;&nbsp;
                                   <input input="text" id="addressline1" name="addressline1" placeholder="address line 1..." required/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                   <label>Country*:</label>
                                   <input input="text" id="countrydb" name="countrydb" placeholder="country..." required/>
<br></br>
                                   <label> Address Line 2:</label>&nbsp;&nbsp;
                                   <input input = "text" id="addressline2" name="addressline2" placeholder="address line 2..."/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                   <label>Longitude:</label>
                                   <input input="number" id="longitudedb" name="longitudedb" placeholder="longitude..."/>
<br></br>
                                   <label> City*:</label>&nbsp;&nbsp;
                                   <input input = "text" id="citydb" name="citydb" placeholder="city..." required/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                   <label>Latitude:</label>
                                   <input input="number" id="latitudedb" name="latitudedb" placeholder="latitude..."/>
<br></br>
                                   <label> Locality*:</label>&nbsp;&nbsp;
                                   <input input = "text" id="localitydb" name="localitydb" placeholder="locality..."/>
<br></br>
                                  
                                  <label>Event Description:</label>
                                  <textarea input="text" id="description" name="description" rows="3" cols="4" placeholder="text only..."></textarea>
<br>
                                  <label>Instructions:</label>
                                  <textarea input="text" id="instructions" name="instructions" rows="3" cols="4" placeholder="use full stop ONLY after every instruction..."></textarea>

    </fieldset>
  <br>

<input type="submit" name="submit" value="Submit Data">


</form>

  <footer id="myFooter">
    <div class="w3-container w3-theme-l2 w3-padding-32">
      <h4>Footer</h4>
    </div>

    <div class="w3-container w3-theme-l1">
      <p>Powered by <a href="http://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>

<!-- END MAIN -->
</div>

<script>
// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
    if (mySidenav.style.display === 'block') {
        mySidenav.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidenav.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidenav with the close button
function w3_close() {
    mySidenav.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

<script type="text/javascript">//Enable and Disable selected menu fields

                    document.getElementById("disaster_group").onchange = function () {

                            var x = document.getElementById("disaster_group").value;

                            if(x === 'tag_nat_tech'){

                            document.getElementById("disastersubgroup_nat").disabled = this.value != 'tag_nat_tech';
                            document.getElementById("disastersubgroup_tech").disabled = this.value != 'tag_nat_tech';
                            document.getElementById("disastertypes_nat").disabled = this.value != 'tag_nat_tech';
                             }

                             else if(x === 'tag_nat'){

                              document.getElementById("disastersubgroup_nat").disabled = this.value != 'tag_nat';
                              document.getElementById("disastertypes_nat").disabled = this.value != 'tag_nat';
                              document.getElementById("disastersubgroup_tech").disabled = this.value == 'tag_nat';
                              var reset_tech = document.getElementById("disastersubgroup_tech");
                              reset_tech.selectedIndex = "";
                              
                             }

                             else {

                              document.getElementById("disastersubgroup_tech").disabled = this.value != 'tag_tech';
                              document.getElementById("disastersubgroup_nat").disabled = this.value == 'tag_tech';
                              document.getElementById("disastertypes_nat").disabled = this.value == 'tag_tech';
                              var reset_nat = document.getElementById("disastersubgroup_nat");
                              reset_nat.selectedIndex = "";
                              var reset_typenat = document.getElementById("disastertypes_nat");
                              reset_typenat.value = "";
                             }
                                                             } 


                                 </script>



                                <!-- <script type="text/javascript">//Enable/Disable other fields

                                 document.getElementById("disastersubgroup_nat").onchange = function () {

                                  var sub_nat = document.getElementById("disastersubgroup_nat").selectedIndex;
                                  //alert(sub_nat)
                                  if(sub_nat > 0){

                                    document.getElementById("disastertypes_nat").disabled = false;
                                  }
                                }</script>-->


</body>
</html>
