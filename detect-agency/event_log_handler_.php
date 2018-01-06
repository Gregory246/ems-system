<!DOCTYPE html>
<html>
<body> 
<?php 
		
     session_start();
        include_once('dbconnect.php');

        $sqlSELECT = mysqli_query($con, 'SELECT DISTINCT disaster_type FROM disastertype');

        //Retreives variable from XMLHttpRequest

        $q = $_GET['disastertype_nat'];

        $p = $_GET['disastertype_tech'];

        $b = $_GET['b'];

        //MySQL queries to select data from columns in the disaster table that matches the input variable of the user
        $sql_nat = "SELECT DISTINCT disaster_type FROM disastertype WHERE disaster_subgroup = '$q'";

        $sql_tech = "SELECT DISTINCT disaster_type FROM disastertype WHERE disaster_subgroup = '$p'";

        $sql_nat_sub = "SELECT DISTINCT disastersubtype FROM disastertype WHERE disaster_type = '$b'";

        //Sends query to the Database server
        $sqlSELECT_1 = mysqli_query($con, $sql_nat);

        $sqlSELECT_2 = mysqli_query($con, $sql_tech);

        $sqlSELECT_3 = mysqli_query($con, $sql_nat_sub);

       
        //Fetches the retrived data o the database and sends data back to XMLHttpRequest
      while ($assocList_1 = mysqli_fetch_assoc($sqlSELECT_1)){

      	echo "<option value=>". $assocList_1['disaster_type']. "</option>";
      }


     while ($assocList_2 = mysqli_fetch_assoc($sqlSELECT_2)){

      	echo "<option value=>".$assocList_2['disaster_type']. "</option>";
     }
   
?>  

<!--
<form action="" method="GET">
 <label for="disastersubtype" > <strong>Disaster Type:</strong> </label>
         <select name="disastersubtype"  id="disastersubtype">
         <option value="">Select...</option>
         <//?php while ($assocList_1 = mysqli_fetch_assoc($sqlSELECT_1)):;?>
         <option value="</?=$assocList_1['disastersubtype'];?>"></?php echo $assocList_1['disastersubtype']; ?></option>
     </?php endwhile;?>
         </select>
</form>-->
</body>
</html>
        




