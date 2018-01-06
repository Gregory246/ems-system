<?php
include_once('dbconnect.php');

//+subgroup_nat+"&subgroup_tech="+subgroup_tech+"&type_nat="
//+type_nat+"&type_tech="+type_tech+"&type_subnat="+type_subnat+"&type_subsubnat="+type_subsubnat+"&type_subtech="+type_subtech

//&group_nat="+group_nat+"&group_tech="+group_tech+"&group_nattech="+group_nattech+"&group="+group

//echo $_GET['group_nat'];
//echo $_GET['group_tech'];
//echo $_GET['group_nattech'];

if (($_GET['group_tech']) == "true" && ($_GET['group_nattech']) == "false" && ($_GET['group_nat']) == "false") {


    $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disaster_group = 'Technological'";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>TDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";
}

elseif (($_GET['group_nat']) == "true" && ($_GET['group_nattech']) == "false" && ($_GET['group_tech']) == "false") {


    $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disaster_group = 'Natural'";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>KDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";
}

elseif (($_GET['group_nattech']) == "true" && ($_GET['group_nat']) == "false" && ($_GET['group_tech']) == "false") {


    $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>MDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";
}

elseif(!empty($_GET['subgroup_nat'] && !empty($_GET['subgroup_tech'])) && empty($_GET['type_nat']) && empty($_GET['type_tech']) ){

    //Returns disasters based on subgroups natural and technological 

    $subgroup_nat = $_GET['subgroup_nat'];
    $subgroup_tech = $_GET['subgroup_tech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK";
                   // WHERE disastertype.disaster_subgroup = '$subgroup_nat' OR disastertype.disaster_subgroup = '$subgroup_tech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>1Disaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['subgroup_nat'] && empty($_GET['subgroup_tech'])) && empty($_GET['type_nat']) && empty($_GET['type_tech']) ){

    //Returns disasters based on natural subgroup ONLY!

    $subgroup_nat = $_GET['subgroup_nat'];
    

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disaster_subgroup = '$subgroup_nat' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>2Disaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['subgroup_nat'] && empty($_GET['subgroup_tech'])) && !empty($_GET['type_nat']) && empty($_GET['type_subnat']) ){

    //Returns natural disaster types

    $type_nat = $_GET['type_nat'];
    

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disaster_type = '$type_nat' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>3Disaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['type_nat'] && empty($_GET['subgroup_tech'])) && !empty($_GET['type_subnat']) && empty($_GET['type_subsubnat'])){

    //Returns natural disaster subtypes ONLY

    $type_subnat = $_GET['type_subnat'];
    

        $select = "SELECT disaster.*, disastertype.*, disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disastersubtype = '$type_subnat' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>4Disaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disastersubtype'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['type_nat'] && empty($_GET['subgroup_tech'])) && !empty($_GET['type_subnat']) && !empty($_GET['type_subsubnat'])){

    //Returns natural disaster subsubtypes ONLY

    $type_subsubnat = $_GET['type_subsubnat'];
    

        $select = "SELECT disaster.*, disastertype.*, disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disastersubsubtype = '$type_subsubnat' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>5Disaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disastersubsubtype'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(empty($_GET['subgroup_nat']) && empty($_GET['type_nat']) && !empty($_GET['subgroup_tech']) && empty($_GET['type_tech']) && empty($_GET['type_subnat']) && empty($_GET['type_subsubnat'])){

    //Returns techological  subgroups ONLY

    $subgroup_tech = $_GET['subgroup_tech'];
    

        $select = "SELECT disaster.*, disastertype.*, disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disaster_subgroup = '$subgroup_tech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>6Disaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['type_tech']) && empty($_GET['type_subtech']) && empty($_GET['subgroup_nat']) && empty($_GET['type_nat'] && !empty($_GET['subgroup_tech'])) && empty($_GET['type_subnat']) && empty($_GET['type_subsubnat'])){

    //Returns techological  type ONLY

    $type_tech = $_GET['type_tech'];
    

        $select = "SELECT disaster.*, disastertype.*, disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disaster_type = '$type_tech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>7Disaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['type_tech']) && !empty($_GET['type_subtech']) && empty($_GET['subgroup_nat']) && empty($_GET['type_nat'] && !empty($_GET['subgroup_tech'])) && empty($_GET['type_subnat']) && empty($_GET['type_subsubnat'])){

    //Returns techological  subtype ONLY

    $type_subtech = $_GET['type_subtech'];
    

        $select = "SELECT disaster.*, disastertype.*, disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disastersubtype = '$type_subtech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>8Disaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['type_subsubnat'] && !empty($_GET['type_subtech'])) && !empty($_GET['type_subnat']) && !empty($_GET['type_tech']) ){

    //Returns disasters based on natural subsubtype and technological subtype 

    $type_subsubnat = $_GET['type_subsubnat'];
    $type_subtech = $_GET['type_subtech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disastersubsubtype = '$type_subsubnat' OR disastertype.disastersubtype = '$type_subtech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>9Disaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['type_subsubnat'] && empty($_GET['type_subtech'])) && !empty($_GET['type_subnat']) && !empty($_GET['type_tech']) ){

    //Returns disasters based on natural subsubtype and technological type 

    $type_subsubnat = $_GET['type_subsubnat'];
    $type_tech = $_GET['type_tech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disastersubsubtype = '$type_subsubnat' OR disastertype.disaster_type = '$type_tech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>aDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['type_subsubnat'] && !empty($_GET['subgroup_tech'])) && !empty($_GET['type_subnat']) && empty($_GET['type_tech']) ){

    //Returns disasters based on natural subsubtype and technological Subgroups 

    $type_subsubnat = $_GET['type_subsubnat'];
    $subgroup_tech = $_GET['subgroup_tech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disastersubsubtype = '$type_subsubnat' OR disastertype.disaster_subgroup = '$subgroup_tech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>bDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(empty($_GET['type_subsubnat'] && !empty($_GET['type_subtech'])) && !empty($_GET['type_subnat']) && !empty($_GET['type_tech']) ){

    //Returns disasters based on natural subtype and technological subtype 

    $type_subnat = $_GET['type_subnat'];
    $type_subtech = $_GET['type_subtech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disastersubtype = '$type_subnat' OR disastertype.disastersubtype = '$type_subtech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>cDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(empty($_GET['type_subsubnat'] && empty($_GET['type_subtech'])) && !empty($_GET['type_subnat']) && !empty($_GET['type_tech']) ){

    //Returns disasters based on natural subtype and technological type 

    $type_subnat = $_GET['type_subnat'];
    $type_tech = $_GET['type_tech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disastersubtype = '$type_subnat' OR disastertype.disaster_type = '$type_tech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>dDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(empty($_GET['type_subsubnat'] && !empty($_GET['subgroup_tech'])) && !empty($_GET['type_subnat']) && empty($_GET['type_tech']) ){

    //Returns disasters based on natural subtype and technological subgroup

    $type_subnat = $_GET['type_subnat'];
    $subgroup_tech = $_GET['subgroup_tech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disastersubtype = '$type_subnat' OR disastertype.disaster_subgroup = '$subgroup_tech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>eDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['type_nat'] && !empty($_GET['type_subtech'])) && empty($_GET['type_subnat']) && !empty($_GET['type_tech']) ){

    //Returns disasters based on natural type and technological subtype

    $type_nat = $_GET['type_nat'];
    $type_subtech = $_GET['type_subtech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disaster_type = '$type_nat' OR disastertype.disastersubtype = '$type_subtech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>fDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['type_nat'] && empty($_GET['type_subtech'])) && empty($_GET['type_subnat']) && !empty($_GET['type_tech']) ){

    //Returns disasters based on natural type and technological type

    $type_nat = $_GET['type_nat'];
    $type_tech = $_GET['type_tech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disaster_type = '$type_nat' OR disastertype.disaster_type = '$type_tech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>fDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(!empty($_GET['type_nat'] && !empty($_GET['subgroup_tech'])) && empty($_GET['type_subnat']) && empty($_GET['type_tech']) ){

    //Returns disasters based on natural type and technological subgroup

    $type_nat = $_GET['type_nat'];
    $subgroup_tech = $_GET['subgroup_tech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disaster_type = '$type_nat' OR disastertype.disaster_subgroup = '$subgroup_tech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>gDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(empty($_GET['type_nat'] && !empty($_GET['subgroup_nat'])) && !empty($_GET['type_subtech']) && !empty($_GET['type_tech']) ){

    //Returns disasters based on natural subgroup and technological subtype

    $subgroup_nat = $_GET['subgroup_nat'];
    $type_subtech = $_GET['type_subtech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disaster_subgroup = '$subgroup_nat' OR disastertype.disastersubtype = '$type_subtech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>hDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

}

elseif(empty($_GET['type_nat'] && !empty($_GET['subgroup_nat'])) && empty($_GET['type_subtech']) && !empty($_GET['type_tech']) ){

    //Returns disasters based on natural subgroup and technological type

    $subgroup_nat = $_GET['subgroup_nat'];
    $type_tech = $_GET['type_tech'];

        $select = "SELECT disaster.*, disastertype.disaster_type, disastertype.disaster_subgroup , disastermag.magnitude,disastersystemresponse.level FROM disaster 
                    JOIN disastertype ON disaster.disastertype1_FK = disastertype.disastertype_id OR disaster.disastertype2_FK = disastertype.disastertype_id 
                    JOIN disastermag ON disaster.disastermagid = disastermag.disastermagid_FK 
                    JOIN disastersystemresponse ON disaster.disasteralertid = disastersystemresponse.disasteralertid_FK
                    WHERE disastertype.disaster_subgroup = '$subgroup_nat' OR disastertype.disaster_type = '$type_tech' ";

                $query = mysqli_query($con,$select);

                $disasters = mysqli_fetch_assoc($query);

                $select1 = "SELECT victim.disasterid_FK FROM victim";

                $query1 = mysqli_query($con,$select1);

                $victim_by_disaster = mysqli_fetch_assoc($query1);

                
echo "<strong>"."Event Details:"."</strong>";
echo "<table border=1>
<tr>
<th>iDisaster Type</th>
<th>Date & Time of Entry</th>
<th>Time Occurred</th>
<th>Required Response</th>
<th>Disaster Scale</th>
<th>Instructions</th>
<th>Description</th>
<th>Last Updated</th>
</tr>";

do
{

echo "<tr>";
echo "<td>". $disasters['disaster_type'] . "</td>";
echo "<td>". $disasters['date_time'] . "</td>";
echo "<td>". $disasters['timesignature'] . "</td>";
echo "<td>". $disasters['level'] . "</td>";
echo "<td>". $disasters['magnitude'] . "</td>";
echo "<td>". $disasters['instructions'] . "</td>";
echo "<td>". $disasters['description'] . "</td>";
echo "<td>". $disasters['last_update'] . "</td>";
echo "</tr>";

  
} while($disasters = mysqli_fetch_assoc($query));

echo "</table>";          

} else{ echo "<strong>"."Un-recognized search! Please try again!"."</strong>";}
?>