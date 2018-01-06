<?php 
session_start();

 include_once('dbconnect.php');


if(!isset($_SESSION['userid'])){

  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost 
  header("Location: http://$host/ems/");
        exit();
}

        $addy1 = $_GET['addressline1'];
        $addy2 = $_GET['addressline2'];
        $locality = $_GET['locality'];
        $city = $_GET['city'];
        $country = $_GET['country'];

        $destination =  "$addy1+$locality+$country"; //This is used to retrive the lat and long coords for the disaster


        //****THE FOLLOWING ALLOWS YOU TO LOCATE THE VEHICLE OPERATOR CLOSES TO THE DISASTER EVENT******

        //This google API gets the lat_long coordinates of the address
        // address to map

        $url = "http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=".urlencode($destination);
        $lat_long = get_object_vars(json_decode(file_get_contents($url)));

        // Grab the lat_long coordinates from the returned file

        $event_lat  = $lat_long['results'][0]->geometry->location->lat;
        $event_long = $lat_long['results'][0]->geometry->location->lng;

          $rads = M_PI/180;

          //Degree to radian conversion
          $event_lat  *= $rads;
          $event_long *= $rads;

          //Radius of Earth in km
          $radius = 6371.008;



        //This retrives the location and health services from the database
        $select1 = "SELECT DISTINCT facility.*, location.* FROM facility 
                    JOIN location ON facility.location_id = location.location_id  
                    WHERE facility.facility_type = 'Hospital' ";
        $query1 = mysqli_query($con,$select1);
        $hospital_location2 = mysqli_fetch_assoc($query1);

        $hospital_lat = $hospital_location2['latitude'];
        $hospital_long = $hospital_location2['longitude'];
        
        
        do{
         
         $hospital_lat = $hospital_location2['latitude'];
        $hospital_long = $hospital_location2['longitude'];
          
          //Calculating the distance bewteen coordinates using the Haversine Formula between the hospital and event 
          $hospital_lat *= $rads;
          $hospital_long *= $rads; 

        $hdel_lat    = $hospital_lat - $event_lat; //lat2 - lat1
          $hdel_long   = $hospital_long - $event_long; //long2 - long2

          $hospital_a =  (sin($hdel_lat/2) * sin($hdel_lat/2)) + ( cos($event_lat) * cos($hospital_lat) * (sin($hdel_long/2) * sin($hdel_long/2) ) );

          $hospital_a_sqrt = sqrt($hospital_a);       

          $hospital_distance_km[] = 2 * $radius * (asin($hospital_a_sqrt)); //Save the result in the array

          $hospital_find_smallest_values[] = 2 * $radius * (asin($hospital_a_sqrt)); //Save the result in the array, this is done to find the two smallest values

        } while ($hospital_location2 = mysqli_fetch_assoc($query1));


        //$hospital_smallest_distance = min($hospital_distance_km); //Gets the smallest distance between the event and hospital from the array
          asort($hospital_find_smallest_values,SORT_NUMERIC); 
         $hospital_smallest = array_slice($hospital_find_smallest_values,0,true);
         $hospital_2nd_smallest = array_slice($hospital_find_smallest_values,1,true);
         
            
            while ($hospital_distance_key = current($hospital_distance_km)) {

              if ($hospital_distance_key == $hospital_smallest[0]) { //Compares the samllest value in the array and grabs it's key

                $hospital_key_ = key($hospital_distance_km);
                
                
                }

               if ($hospital_distance_key == $hospital_2nd_smallest[0]) {
                  
                  $hospital_key2_ = key($hospital_distance_km);
                  
                } 

              next($hospital_distance_km);
        }
            

           //***THIS GRABS THE HOSPITAL CLOSES TO THE EVENT
        
              $reselect = "SELECT DISTINCT facility.*, location.* FROM facility  
                    JOIN location ON facility.location_id = location.location_id  
                    WHERE facility.facility_type = 'Hospital'";

              $requery = mysqli_query($con,$reselect);

              mysqli_data_seek($requery,$hospital_key_); //The key value would be the same as the MySQL table row values, thus return rows match keys

              $hospital_ = mysqli_fetch_assoc($requery);


              $reselect1 = "SELECT DISTINCT facility.*, location.* FROM facility 
                    JOIN location ON facility.location_id = location.location_id  
                    WHERE facility.facility_type = 'Hospital'";

              $requery1 = mysqli_query($con,$reselect1);

              mysqli_data_seek($requery1,$hospital_key2_); //The key value would be the same as the MySQL table row values, thus return rows match keys

              $hospital1_ = mysqli_fetch_assoc($requery1);

              //echo implode(",", $user_id_);

              //$reselect2 = "SELECT geoLocation_id FROM geolocation WHERE user_id = '$user_id_[user_id]' ORDER BY date_time DESC LIMIT 1 ";
                //$requery2 = mysqli_query($con,$reselect2);
                //$geo_id = mysqli_fetch_assoc($requery2);

               
               //$reselect3 = "SELECT latitude,longitude FROM geolocation WHERE geoLocation_id = '$geo_id[geoLocation_id]' ";
               //$requery3 = mysqli_query($con,$reselect3);
               //$hospital_ = mysqli_fetch_assoc($requery3);


        //This retrives ambulance location user location
        $select2 = "SELECT DISTINCT latitude,longitude FROM geolocation" ;
        $query2 = mysqli_query($con,$select2);
        $coords = mysqli_fetch_assoc($query2);

           
        //This recursively walks through the coords array and with the line of code execution for every row of coordinates
        do{
         
          $vehicle_lat  = $coords['latitude'];
          $vehicle_long = $coords['longitude'];

          $vehicle_lat  *= $rads;
          $vehicle_long *= $rads;

          //Calculating the distance bewteen coordinates using the Haversine Formula

          $del_lat    = $vehicle_lat - $event_lat; //lat2 - lat1
          $del_long   = $vehicle_long - $event_long; //long2 - long2

          $a =  (sin($del_lat/2) * sin($del_lat/2)) + ( cos($event_lat) * cos($vehicle_lat) * (sin($del_long/2) * sin($del_long/2) ) );

          $a_sqrt = sqrt($a);

          $distance_km[] = 2 * $radius * (asin($a_sqrt)); //Save the result in the array


        } while ($coords = mysqli_fetch_assoc($query2)); 

         

        $smallest_distance = min($distance_km); //Gets the smallest distance between the event and vehicle

        //***THIS GRABS THE USER WHO IS CLOSES TO THE EVENT
        while ($distance_key = current($distance_km)) {

              if ($distance_key == $smallest_distance) { //Compares the samllest value in the array and grabs it's key

                 
                $key_ = key($distance_km);

                }
              next($distance_km);
        }

            $select3 = "SELECT DISTINCT * FROM geolocation ";
            
                $query3 = mysqli_query($con,$select3);

                 mysqli_data_seek($query3,$key_); //The key value would be the same as the MySQL table row values, thus return rows match keys

                $vehicle_ = mysqli_fetch_assoc($query3);

                
                

                $select3_1 = "SELECT geoLocation_id FROM geolocation WHERE user_id = '$vehicle_[user_id]' ORDER BY date_time DESC LIMIT 1 ";
                $query3_1 = mysqli_query($con,$select3_1);
                $geo_id = mysqli_fetch_assoc($query3_1);

               

               $select4 = "SELECT latitude,longitude FROM geolocation WHERE geoLocation_id = '$vehicle_[geoLocation_id]' ";
               $query4 = mysqli_query($con,$select4);
               $nearest_coords = mysqli_fetch_assoc($query4);

               
                //Get employee details based on vehicle operator details

                $select5 = "SELECT * FROM employees WHERE user_id = '$vehicle_[user_id]' ";
                $query5 = mysqli_query($con,$select5);
                $employee = mysqli_fetch_assoc($query5);

                $select6 = "SELECT * FROM vehicleteam WHERE operator_FK = '$employee[employee_id]'";
                $query6 = mysqli_query($con,$select6);
                $vehicleteam = mysqli_fetch_assoc($query6);

               
                $select8 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.operator_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query8 = mysqli_query($con,$select8);

                $operator = mysqli_fetch_assoc($query8);


                $select9 = "SELECT vehicleteam.operator_FK,employees.* 
                            FROM vehicleteam JOIN employees ON vehicleteam.assistance_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query9 = mysqli_query($con,$select9);

                $assistant = mysqli_fetch_assoc($query9);


                $select10 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.tech_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query10 = mysqli_query($con,$select10);

                $emt = mysqli_fetch_assoc($query10);


                $select11 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.advance_tech_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query11 = mysqli_query($con,$select11);

                $ademt = mysqli_fetch_assoc($query11);


                $select12 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.paramedic_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query12 = mysqli_query($con,$select12);

                $para = mysqli_fetch_assoc($query12);


                $select13 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.advance_paramedic_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query13 = mysqli_query($con,$select13);

                $adpara = mysqli_fetch_assoc($query13);


                $select14 = "SELECT vehicleteam.operator_FK,employees.employee_fname, employees.employee_lname 
                            FROM vehicleteam JOIN employees ON vehicleteam.wilderness_tech_FK = employees.employee_id 
                            WHERE vehicleteam.vehicleteam_id = '$vehicleteam[vehicleteam_id]'";

                $query14 = mysqli_query($con,$select14);

                $wtech = mysqli_fetch_assoc($query14);


?>
<!DOCTYPE html>
<html>
  <head>
    <title>Distance Matrix service</title>
    <meta http-equiv="refresh" content="">
    <style>
      #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }

      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 100%;
      }

      #right-panel i {
        font-size: 12px;
      }
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
        width: 50%;
      }
      #right-panel {
        float: right;
        width: 48%;
        padding-left: 2%;
      }
      #output {
        font-size: 11px;
      }
    </style>

    <script type="text/javascript">

          function telephoneDispatch(){

            

            var agency_name = document.getElementById("agency_name").value;
            var addressline1 = document.getElementById("addressline1").value;
            var addressline2 = document.getElementById("addressline2").value;
            var locality = document.getElementById("locality").value;
            var city = document.getElementById("city").value;
            var country = document.getElementById("country").value;

            var agency_name1 = document.getElementById("agency_name1").value;
            var addressline11 = document.getElementById("addressline11").value;
            var addressline21 = document.getElementById("addressline21").value;
            var locality1 = document.getElementById("locality1").value;
            var city1 = document.getElementById("city1").value;
            var country1 = document.getElementById("country1").value;

            var team_type = document.getElementById("team_type").value;
            var life_support = document.getElementById("life_support").value;
            var operator = document.getElementById("operator").value;
            var assistant = document.getElementById("assistant").value;
            var emt = document.getElementById("emt").value;
            var ademt = document.getElementById("ademt").value;
            var para = document.getElementById("para").value;
            var adpara = document.getElementById("adpara").value;
            var wtech = document.getElementById("wtech").value;
            var vehicleteam_id = document.getElementById("vehicleteam_id").value;

              xmlhttp = new XMLHttpRequest();

             xmlhttp.onreadystatechange = function(){

                  if(this.readyState == 4 && this.status == 200){
                    document.getElementById("1").innerHTML = this.responseText;
                  }
            }
      
            xmlhttp.open("GET","telephone-dispatch.php?agency_name="+agency_name+"&addressline1="+addressline1+"&addressline2="+addressline2+"&locality="+locality+"&city="+city+"&country="+country+"&agency_name1="+agency_name1+"&addressline11="+addressline11+"&addressline21="+addressline21+"&locality1="+locality1+"&city1="+city1+"&country1="+country1+"&team_type="+team_type+"&life_support="+life_support+"&operator="+operator+"&assistant="+assistant+"&emt="+emt+"&ademt="+ademt+"&para="+para+"&adpara="+adpara+"&wtech="+wtech+"&vehicleteam_id="+vehicleteam_id,true);
            xmlhttp.send();
                return;
              
              }

    </script>
  </head>
  <body>
    <div id="right-panel">
      
      <!-- Table to present hospital details -->
   <label><strong>Hospital:</strong></label>
   <table id="myTable" style="width:100%" border=1>
  <tr>
  <th>Name</th>
  <th>Telephone</th>
  <th>Address Line 1</th>
  <th>Address Line 2</th>
  <th>Locality</th>
  <th>City</th>
  <th>Country</th>
  </tr>

  <tr>
    <td ><input type = "text" id = "agency_name" name = "agency_name" value ="<?php echo $hospital_['name']; ?>" size = "30" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "tel" name = "tel" value ="<?php echo $hospital_['tel']; ?>" size = "25" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "addressline1" name = "addressline1" value ="<?php echo $hospital_['addressline1']; ?>" size = "30" style = "border:0px;background-color:white"  disabled/></td>
    <td><input type = "text" id = "addressline2" name = "addressline2" value ="<?php echo $hospital_['addressline2']; ?>" size = "30" style = "border:0px;background-color:white"  disabled/></td> 
    <td ><input type = "text" id = "locality" name = "locality" value ="<?php echo $hospital_['locality']; ?>" size = "25" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "city" name = "city" value ="<?php echo $hospital_['city']; ?>" size = "25" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "country" name = "country" value ="<?php echo $hospital_['country']; ?>" size = "25" style = "border:0px;background-color:white"  disabled/></td>
  </tr>

  <tr>
    <td ><input type = "text" id = "agency_name1" name = "agency_name1" value ="<?php echo $hospital1_['name']; ?>" size = "30" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "tel1" name = "tel1" value ="<?php echo $hospital1_['tel']; ?>" size = "25" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "addressline11" name = "addressline11" value ="<?php echo $hospital1_['addressline1']; ?>" size = "30" style = "border:0px;background-color:white"  disabled/></td>
    <td><input type = "text" id = "addressline21" name = "addressline21" value ="<?php echo $hospital1_['addressline2']; ?>" size = "30" style = "border:0px;background-color:white"  disabled/></td> 
    <td ><input type = "text" id = "locality1" name = "locality1" value ="<?php echo $hospital1_['locality']; ?>" size = "25" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "city1" name = "city1" value ="<?php echo $hospital1_['city']; ?>" size = "25" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "country1" name = "country1" value ="<?php echo $hospital1_['country']; ?>" size = "25" style = "border:0px;background-color:white"  disabled/></td>
  </tr>
</table>
<br>
<!-- Table to present Vehicle details -->
   <label><strong>Ambulance:</strong></label>
   <table id="myTable" style="width:100%" border=1>
  <tr>
  <th>Team Type</th>
  <th>Life Support</th>
  <th>Operator</th>
  <th>Assistance</th>
  <th>EMT</th>
  <th>Ad-EMT</th>
  <th>Paramedic</th>
  <th>Ad-Para</th>
  <th>Wi-EMT</th>
  </tr>

  <tr>
    <td ><input type = "text" id = "team_type" name = "team_type" value ="<?php echo $vehicleteam['team_type']; ?>" size = "7" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "life_support" name = "life_support" value ="<?php echo $vehicleteam['life_support']; ?>" size = "20" style = "border:0px;background-color:white"  disabled/></td>
    <td><input type = "text" id = "operator" name = "operator" value ="<?php echo $operator['employee_fname']. "&nbsp;" . $operator['employee_lname']; ?>" size = "20" style = "border:0px;background-color:white"  disabled/></td> 
    <td ><input type = "text" id = "assistant" name = "assistant" value ="<?php echo $assistant['employee_fname']. "&nbsp;" . $assistant['employee_lname']; ?>" size = "20" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "emt" name = "emt" value ="<?php echo $emt['employee_fname']. "&nbsp;" . $emt['employee_lname']; ?>" size = "20" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "ademt" name = "ademt" value ="<?php echo $ademt['employee_fname']. "&nbsp;" . $ademt['employee_lname']; ?>" size = "20" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "para" name = "para" value ="<?php echo $para['employee_fname']. "&nbsp;" . $para['employee_lname']; ?>" size = "20" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "adpara" name = "adpara" value ="<?php echo $adpara['employee_fname']. "&nbsp;" . $adpara['employee_lname']; ?>" size = "20" style = "border:0px;background-color:white"  disabled/></td>
    <td ><input type = "text" id = "wtech" name = "wtech" value ="<?php echo $wtech['employee_fname']. "&nbsp;" . $wtech['employee_lname']; ?>" size = "20" style = "border:0px;background-color:white"  disabled/></td>
  </tr>
</table>
    <input type = "text" id = "vehicleteam_id" name = "vehicleteam_id" value ="<?php echo $vehicleteam['vehicleteam_id']; ?>" hidden/>
      <button id = "button" onclick = "telephoneDispatch()">Submit to Telephone Dispatch!</button>

      <div id = "1"></div>
     
<input type="text" id = "test1" name = "test1" value="<?php  echo $hospital_['latitude'];?>" hidden/>

   <input type="text" id = "test2" name = "test2" value="<?php echo $hospital_['longitude'];?>" hidden/> 

   <input type="text" id = "test5" name = "test5" value="<?php  echo $hospital1_['latitude'];?>" hidden/>

   <input type="text" id = "test6" name = "test6" value="<?php echo $hospital1_['longitude'];?>" hidden/>

<input type="text" id = "test3" name = "test4" value="<?php  echo $nearest_coords['latitude'];?>" hidden/> <br>

<input type="text" id = "test4" name = "test4" value="<?php echo $nearest_coords['longitude']; ?>" hidden/> 

<input type="text" id = "test" name = "test" value="<?php echo $destination; ?>" hidden />

      <div>
        <strong>Results</strong>
      </div>
      <div id="output"></div>
    </div>
    <div id="map"></div>
    <script>

      function initMap() {
        var bounds = new google.maps.LatLngBounds;
        var markersArray = [];

        var hos_lat = parseFloat(document.getElementById("test1").value);
        var hos_long = parseFloat(document.getElementById("test2").value);

        var hos1_lat = parseFloat(document.getElementById("test5").value);
        var hos1_long = parseFloat(document.getElementById("test6").value);

        var vehicle_lat = parseFloat(document.getElementById("test3").value);
        var vehicle_long = parseFloat(document.getElementById("test4").value);
        
        var origin1 = {lat: hos_lat, lng: hos_long};
        var origin1_1 = {lat: hos1_lat, lng: hos1_long};
        var origin2 = {lat: vehicle_lat, lng: vehicle_long};

        var destinationA = document.getElementById("test").value;
        //var destinationB = {lat: 10.2780567, lng: -61.4641338};

        var destinationIcon = 'https://chart.googleapis.com/chart?' +
            'chst=d_map_pin_letter&chld=D|FF0000|000000';
        var originIcon = 'https://chart.googleapis.com/chart?' +
            'chst=d_map_pin_letter&chld=O|FFFF00|000000';
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 10.4437014, lng: -61.7004748},
          zoom: 8
        });
        var geocoder = new google.maps.Geocoder;

        var service = new google.maps.DistanceMatrixService; //takes the origin(s) and destination(s) defined by the user and computes the travel distance and journey
        service.getDistanceMatrix({
          origins: [origin1,origin1_1,origin2], //Defines the origin(s) matrix
          destinations: [destinationA],//destinationB], // Defines the destination(s) matrix
          travelMode: 'DRIVING', //Defines the means of transportation
          unitSystem: google.maps.UnitSystem.METRIC, //Defines the UNITS used
          avoidHighways: false,
          avoidTolls: false
        }, function(response, status) {
          if (status !== 'OK') {
            alert('Error was: ' + status);
          } else {
            var originList = response.originAddresses;
            var destinationList = response.destinationAddresses;
            var outputDiv = document.getElementById('output');
            outputDiv.innerHTML = '';
            deleteMarkers(markersArray);

            var showGeocodedAddressOnMap = function(asDestination) {
              var icon = asDestination ? destinationIcon : originIcon;
              return function(results, status) {
                if (status === 'OK') {
                  map.fitBounds(bounds.extend(results[0].geometry.location));
                  markersArray.push(new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                    icon: icon
                  }));
                } else {
                  alert('Geocode was not successful due to: ' + status);
                }
              };
            };

            for (var i = 0; i < originList.length; i++) {
              var results = response.rows[i].elements;
              geocoder.geocode({'address': originList[i]},
                  showGeocodedAddressOnMap(false));
              for (var j = 0; j < results.length; j++) {
                geocoder.geocode({'address': destinationList[j]},
                    showGeocodedAddressOnMap(true));
                outputDiv.innerHTML += originList[i] + ' to ' + destinationList[j] +
                    ': ' + results[j].distance.text + ' in ' +
                    results[j].duration.text + '<br>';
              }
            }
          }
        });
      }

      function deleteMarkers(markersArray) {
        for (var i = 0; i < markersArray.length; i++) {
          markersArray[i].setMap(null);
        }
        markersArray = [];
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAV5TExsK7WgboOPBhDAhroGkYO68pFH5U&callback=initMap">

    </script>
  </body>
</html>