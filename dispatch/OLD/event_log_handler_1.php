<!DOCTYPE html>
<html>
<body> 
<?php 
		
    session_start();
        include_once('dbconnect.php');
        


        $b = $_GET['b'];

        $c = $_GET['c'];

        $d = $_GET['d'];
      

        $sql_nat_sub = "SELECT DISTINCT disastersubtype FROM disastertype WHERE disaster_type = '$b'";

        $sql_tech_sub = "SELECT DISTINCT disastersubtype FROM disastertype WHERE disaster_type = '$c'";

        $sql_nat_subsub = "SELECT disastersubsubtype FROM disastertype WHERE disastersubtype = '$d'";

      
        $sqlSELECT_3 = mysqli_query($con, $sql_nat_sub);

        $sqlSELECT_4 = mysqli_query($con, $sql_tech_sub);

        $sqlSELECT_5 = mysqli_query($con, $sql_nat_subsub);

     


     while ($assocList_3 = mysqli_fetch_assoc($sqlSELECT_3)){

      	echo "<option value=>". $assocList_3['disastersubtype']. "</option>";
      }

      while ($assocList_4 = mysqli_fetch_assoc($sqlSELECT_4)){

        echo "<option value=>". $assocList_4['disastersubtype']. "</option>";
      }

      while ($assocList_5 = mysqli_fetch_assoc($sqlSELECT_5)){

        echo "<option value=>". $assocList_5['disastersubsubtype']. "</option>";
      }


?>  
</body>
</html>