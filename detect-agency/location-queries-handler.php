<?php 
include_once('dbconnect.php');

//fromyear="+str_from+"&toyear="str_to+"&adline1="+adline1+"&loca="+loca+"&cnty="+cnty+"&city="+city+"&coord="+coord+"&coord1="+coord1

//This code covers a variation of possible combinations that user may enter in order to find the locations of disasters


if(!empty($_GET['adline1']) && ( empty($_GET['loca']) && empty($_GET['cnty']) && empty($_GET['city']) && empty($_GET['coord']) ) ){


$addressline1 = $_GET['adline1'];



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE location.addressline1 = '$addressline1' ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";

}//----------------------------//

 elseif(!empty($_GET['adline1']) && ( !empty($_GET['loca']) && empty($_GET['cnty']) && empty($_GET['city']) && empty($_GET['coord']) )){

    $addressline1 = $_GET['adline1'];
    $locality = $_GET['loca'];


            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE location.addressline1 = '$addressline1' AND location.locality = '$locality' ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}

elseif(!empty($_GET['adline1']) && ( !empty($_GET['loca']) && !empty($_GET['city']) && empty($_GET['cnty']) && empty($_GET['coord']) )){

    $addressline1 = $_GET['adline1'];
    $locality = $_GET['loca'];
    $country = $_GET['city'];



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE location.addressline1 = '$addressline1' AND location.locality = '$locality' AND location.city = '$city'
                     ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}

elseif(!empty($_GET['adline1']) && ( !empty($_GET['loca']) && !empty($_GET['city']) && !empty($_GET['cnty']) && empty($_GET['coord']) )){

    $addressline1 = $_GET['adline1'];
    $locality = $_GET['loca'];
    $city = $_GET['city'];
    $country = $_GET['cnty'];
    



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE location.addressline1 = '$addressline1' AND location.locality = '$locality' AND location.country = '$country' AND location.city = '$city'
                     ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}


elseif(!empty($_GET['loca']) && ( empty($_GET['adline1']) && empty($_GET['city'])  && empty($_GET['cnty']) && empty($_GET['coord']) )){

    
    $locality = $_GET['loca'];
    



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE  location.locality = '$locality' 
                     ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}

elseif(!empty($_GET['loca']) && ( empty($_GET['adline1']) && !empty($_GET['city'])&& empty($_GET['cnty'])  && empty($_GET['coord']) )){

    
    $locality = $_GET['loca'];
    $city = $_GET['city'];



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE  location.locality = '$locality' AND location.city = '$city'
                     ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}

elseif(!empty($_GET['loca']) && ( empty($_GET['adline1']) && !empty($_GET['city']) && !empty($_GET['cnty']) && empty($_GET['coord']) )){

    
    $locality = $_GET['loca'];
    $city = $_GET['city'];
    $country = $_GET['country'];
    



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE  location.locality = '$locality' AND location.country = '$country' AND location.city = '$city'
                     ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}

elseif(!empty($_GET['city']) && ( empty($_GET['adline1']) && empty($_GET['loca']) && empty($_GET['cnty']) && empty($_GET['coord']) )){

    
   
    $country = $_GET['cnty'];
    $city = $_GET['city'];



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE  location.country = '$country' AND location.city = '$city'
                     ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}


elseif(!empty($_GET['city']) && ( empty($_GET['adline1']) && empty($_GET['loca']) && !empty($_GET['cnty']) && empty($_GET['coord']) )){

    
   
    $country = $_GET['cnty'];
    $city = $_GET['city'];



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE  location.country = '$country' AND location.city = '$city'
                     ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}

elseif(!empty($_GET['cnty']) && ( empty($_GET['adline1']) && empty($_GET['loca']) && empty($_GET['city']) && empty($_GET['coord']) )){

    
   
    $country = $_GET['cnty'];
   



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE  location.country = '$country' 
                     ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}

elseif(!empty($_GET['adline1']) && ( empty($_GET['loca']) && !empty($_GET['city']) && empty($_GET['cnty']) && empty($_GET['coord']) )){

    
   
    $addressline1 = $_GET['adline1'];
    $city = $_GET['city'];
   



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE  location.addressline1 = '$addressline1' AND location.city = '$city'
                     ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}

elseif(!empty($_GET['adline1']) && ( empty($_GET['loca']) && empty($_GET['city']) && !empty($_GET['cnty']) && empty($_GET['coord']) )){

    
   
    $addressline1 = $_GET['adline1'];
    $country = $_GET['cnty'];
   



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE  location.addressline1 = '$addressline1' AND location.country = '$country'
                     ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}

elseif(!empty($_GET['loca']) && ( empty($_GET['adline1']) && empty($_GET['city']) && !empty($_GET['cnty']) && empty($_GET['coord']) )){

    
   
    $locality = $_GET['loca'];
    $country = $_GET['cnty'];
   



            $select = "SELECT disaster_location.*, location.*,disaster.date_time ,disaster.disastertype1_FK,disaster.disastertype2_FK FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    WHERE  location.locality = '$locality' AND location.country = '$country'
                     ORDER BY `disaster_location_junc_id` DESC";

                    $query = mysqli_query($con, $select);

                    $disaster_by_addressline = mysqli_fetch_assoc($query);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disaster_by_addressline['date_time'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype1_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['disastertype2_FK'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline1'] . "</td>";
echo "<td>". $disaster_by_addressline['addressline2'] . "</td>";
echo "<td>". $disaster_by_addressline['city'] . "</td>";
echo "<td>". $disaster_by_addressline['locality'] . "</td>";
echo "<td>". $disaster_by_addressline['country'] . "</td>";
echo "<td>". $disaster_by_addressline['longitude'] . "</td>";
echo "<td>". $disaster_by_addressline['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_addressline = mysqli_fetch_assoc($query));

echo "</table>";


}

elseif (!empty($_GET['fromyear']) && !empty($_GET['toyear'])){

    $fromyear = $_GET['fromyear'];
    $toyear = $_GET['toyear'];



        $select = "SELECT disaster_location.*, disaster.* , location.*, disastertype.disaster_type FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id 
                    WHERE disaster.date_time BETWEEN CAST('$fromyear' AS DATE) AND CAST('$toyear'AS DATE) ORDER BY `disaster_location_junc_id` DESC";

                    $select1 = "SELECT disaster_location.*, disaster.* , location.*, disastertype.disaster_type FROM disaster_location 
                    JOIN disaster ON disaster_location.disaster_id = disaster.disaster_id JOIN location ON disaster_location.location_id = location.location_id 
                    JOIN disastertype ON disaster.disastertype2_FK = disastertype.disastertype_id 
                    WHERE disaster.date_time BETWEEN CAST('$fromyear' AS DATE) AND CAST('$toyear'AS DATE) ORDER BY `disaster_location_junc_id` DESC";

        $query = mysqli_query($con, $select);
        $query1 = mysqli_query($con, $select1);

        $disaster_by_location1 = mysqli_fetch_assoc($query1);
        $disaster_by_location = mysqli_fetch_assoc($query);

        //This is to include the disaster type with the query by for the locations
        //$select1 = "SELECT disastertype.disaster_type,disastertype.disastersubtype,disastertype.disastersubsubtype,disaster.* FROM disastertype,disaster WHERE disastertype.disastertype_id = '$disaster_by_location[disastertype1_FK]'";
        //$select2 = "SELECT disastertype.disaster_type,disastertype.disastersubtype,disastertype.disastersubsubtype,disaster.* FROM disastertype,disaster WHERE disastertype.disastertype_id = '$disaster_by_location[disastertype2_FK]'";


        //$query_select1 = mysqli_query($con,$select1);
        //$query_select2 = mysqli_query($con,$select2);

        //$natural = mysqli_fetch_assoc($query_select1);
        //$technological = mysqli_fetch_assoc($query_select2);



echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>Date & Time of Entry</th>
<th>Natural Type</th>
<th>Technological Type</th>
<th>Address Line 1</th>
<th>Address Line 2</th>
<th>City</th>
<th>Locality</th>
<th>Country</th>
<th>Longitude</th>
<th>Latitude</th>
</tr>";

do
{


echo "<tr>";
echo "<td>". $disaster_by_location['date_time'] . "</td>";
echo "<td>". $disaster_by_location['disaster_type'] . "</td>";
echo "<td>". $disaster_by_location1['disaster_type'] . "</td>";
echo "<td>". $disaster_by_location['addressline1'] . "</td>";
echo "<td>". $disaster_by_location['addressline2'] . "</td>";
echo "<td>". $disaster_by_location['city'] . "</td>";
echo "<td>". $disaster_by_location['locality'] . "</td>";
echo "<td>". $disaster_by_location['country'] . "</td>";
echo "<td>". $disaster_by_location['longitude'] . "</td>";
echo "<td>". $disaster_by_location['latitude'] . "</td>";
echo "</tr>";

  
} while($disaster_by_location = mysqli_fetch_assoc($query) AND $disaster_by_location1 = mysqli_fetch_assoc($query1));


echo "</table>";
        
}


?>