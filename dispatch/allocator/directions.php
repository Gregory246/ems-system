<?php 
include_once('dbconnect.php');



?>
<!DOCTYPE html>
<html>
  <head>
    <title>Distance Matrix service</title>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
  </head>
  <style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
.w3-sidenav a,.w3-sidenav h4 {padding: 12px;}
.w3-navbar li a {
    padding-top: 12px;
    padding-bottom: 12px;
}
</style>
  <body onload="startTime()">
    <!-- Navbar -->
<div class="w3-top">
  <ul class="w3-navbar w3-theme w3-top w3-left-align w3-large">
    <li class="w3-opennav w3-right w3-hide-large">
      <a class="w3-hover-white w3-large w3-theme-l1" href="javascript:void(0)" onclick="w3_open()"><i class="fa fa-bars"></i></a>
    </li>
    <li><a href="\ems\dispatch\home-page.php" class="w3-theme-l1"><strong>EMS</strong></a></li>
    <li class="w3-hide-small"><a href="\ems\dispatch\allocator\home-page.php" class="w3-hover-white">Home</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\allocator\dispatch.php" class="w3-hover-white">Dispatch</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\allocator\dispatch-views.php" target = "_blank" class="w3-hover-white">Notifiers</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\allocator\event-queries-location.php" class="w3-hover-white">Search</a></li>
    <li class="w3-hide-small"><a href="\EMS\dispatch\allocator\geo-location.php" class="w3-hover-white">Geo-Location</a></li>
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
<div class="w3-main" style="margin-top:75px">
  <?php
//Establishes a connection with Database server and select the appropriate Database tables and create join
$query1 = "SELECT disaster_location.*, disaster.*, location.* FROM disaster_location JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id 
            JOIN location ON disaster_location.location_id = location.location_id ORDER BY `disaster_location_junc_id` DESC LIMIT 1"; 

$output = mysqli_query($con,$query1);

$print_output = mysqli_fetch_assoc($output);

echo"Event Location:";
echo "<table border=1>
<tr>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>Locality</th>
<th>City</th>
<th>Country</th>
</tr>";

while($print_output){
  echo "<td><input type = 'text' name = 'addressline1' id = 'addressline1' value=". $print_output['addressline1'] . " /></td>";
  echo "<td><input type = 'text' name = 'addressline2' id = 'addressline2' value=". $print_output['addressline2'] . " /></td>";
  echo "<td><input type = 'text' name = 'locality' id = 'locality' value=". $print_output['locality'] . " /></td>";
  echo "<td><input type = 'text' name = 'city' id = 'city' value=". $print_output['city'] . " /></td>";
  echo "<td><input type = 'text' name = 'country' id = 'country' value=". $print_output['country'] . " /></td>";
  echo "</tr>";
  break;
}

echo "</table>";
?>
<button id= "serch" onclick = "geoLocation()">Search!</button><hr>

    <div id="right-panel">
      <div id="inputs">
        <pre>
var origin1 = {lat: 55.930, lng: -3.118};
var origin2 = 'Greenwich, England';
var destinationA = 'Stockholm, Sweden';
var destinationB = {lat: 50.087, lng: 14.421};
        </pre>
      </div>
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

        var origin1 = {lat: 10.6352177, lng: -61.3971372};
        var origin2 = {lat: 10.6352177, lng: -61.3971372};
        var destinationA = 'Port+of+Spain+General+Hospital';
        //var destinationB = {lat: 10.2780567, lng: -61.4641338};

        var destinationIcon = 'https://chart.googleapis.com/chart?' +
            'chst=d_map_pin_letter&chld=D|FF0000|000000';
        var originIcon = 'https://chart.googleapis.com/chart?' +
            'chst=d_map_pin_letter&chld=O|FFFF00|000000';
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 55.53, lng: 9.4},
          zoom: 10
        });
        var geocoder = new google.maps.Geocoder;

        var service = new google.maps.DistanceMatrixService; //takes the origin(s) and destination(s) defined by the user and computes the travel distance and journey
        service.getDistanceMatrix({
          origins: [origin1, origin2], //Defines the origin(s) matrix
          destinations: [destinationA, ],//destinationB], // Defines the destination(s) matrix
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
  </div>
  <div class="w3-main" style="margin-top:250px"></div>
<br></br><br></br>
  <footer id="myFooter" style="position:relative">
    <div class="w3-container w3-theme-l2 w3-padding-32">
      <h4>Footer</h4>
    </div>

    <div class="w3-container w3-theme-l1">
      <p>Powered by <a href="http://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>

<!-- END MAIN -->
</div>
  </body>
</html>