<?php
//Starts session for user page details

  session_start();
  include_once('dbconnect.php');
  $host  = $_SERVER['HTTP_HOST']; //PHP Super GOBALVARIABLE predefined localhost

   
//Get all fields from the log page and store those values in the selected variables

                //disaster
                $disastergroup = $_POST['disaster_group'];

               
                $disasterlevel = $_POST['disasterlevel'];
                $disasterscale = $_POST['disasterscale'];
                $HH =$_POST['time_reghh'];
                $MM=$_POST['time_regmm'];
                $SS=$_POST['time_regss'];
                
              
                //location
                $addressline1 = $_POST['addressline1'];
                $addressline2 = $_POST['addressline2'];
                $citydb = $_POST['citydb'];
                $localitydb = $_POST['localitydb'];
                $countrydb = $_POST['countrydb'];
                $longitudedb = $_POST['longitudedb'];
                $latitudedb = $_POST['latitudedb'];

                
                //Event Description & Instructions
                $description = $_POST['description'];
                $instructions = $_POST['instructions'];

                //User Session
                $user = $_SESSION["userid"]; 


                //Declare pre-defined variables that exist in database

                            $query_user = "SELECT user_id FROM `users` WHERE username = '$user'";
                            $selDATA0_0query = mysqli_query($con,$query_user);
                            $user_id = mysqli_fetch_assoc($selDATA0_0query);


                            $sort_time = "$HH:$MM:$SS";
                            $event_time = date('H:i:s', strtotime($sort_time));
                           
                           
                            $selDATA1_1 = "SELECT disasteralertid_FK FROM disastersystemresponse WHERE level = '$disasterlevel' ";
                            $selDATA1_1query = mysqli_query($con,$selDATA1_1);
                            $alertid = mysqli_fetch_assoc($selDATA1_1query);
                            
                            
                            $selDATA1_2 = "SELECT disastermagid_FK FROM disastermag WHERE magnitude = '$disasterscale' ";
                            $selDATA1_2query = mysqli_query($con,$selDATA1_2);
                            $magnitudeid = mysqli_fetch_assoc($selDATA1_2query);                       

                            
//Log details to appropriate tables in the correct format of Natural/Technological/Nat_Tech 

                if($disastergroup == "tag_nat"){

                                            
                    if(!empty($_POST['type_subsubnat']) && !empty($_POST['type_subnat'])){

                            $disastersubsubtype_nat = $_POST['type_subsubnat'];

                            $SELECT = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disastersubsubtype = '$disastersubsubtype_nat'";

                            $query = mysqli_query($con,$SELECT);
                            $disastertype_id = mysqli_fetch_assoc($query);

                            echo $disastertype_id['disastertype_id'];

                            $InsDATA_disas = "INSERT INTO disaster (disaster_id,ics_structure_id,disastertype1_FK,disastertype2_FK,timesignature,disasteralertid,disastermagid,instructions,description,confirm,user_id) 
                                                VALUES (NULL,NULL,'$disastertype_id[disastertype_id]',NULL,'$event_time','$alertid[disasteralertid_FK]','$magnitudeid[disastermagid_FK]','$instructions','$description','0','$user_id[user_id]') ";
                            mysqli_query($con,$InsDATA_disas);

                            $InsDATA_loc = "INSERT INTO location (location_id,addressline1,addressline2,city,locality,country,longitude,latitude,user_id) 
                                            VALUES (NULL,'$addressline1','$addressline2','$citydb','$localitydb','$countrydb','$longitudedb','$latitudedb','$user_id[user_id]') ";
                            mysqli_query($con,$InsDATA_loc);
                          
                          
                        } elseif (!empty($_POST['type_subnat']) && empty($_POST['type_subsubnat'])){

                            $disastersubtype_nat = $_POST['type_subnat'];

                            $SELECT = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disastersubtype = '$disastersubtype_nat'";

                            $query = mysqli_query($con,$SELECT);
                            $disastertype_id = mysqli_fetch_assoc($query);

                            echo $disastertype_id['disastertype_id'];

                             $InsDATA_disas = "INSERT INTO disaster (disaster_id,ics_structure_id,disastertype1_FK,disastertype2_FK,timesignature,disasteralertid,disastermagid,instructions,description,confirm,user_id) 
                                                VALUES (NULL,NULL,'$disastertype_id[disastertype_id]',NULL,'$event_time','$alertid[disasteralertid_FK]','$magnitudeid[disastermagid_FK]','$instructions','$description','0','$user_id[user_id]') ";
                            mysqli_query($con,$InsDATA_disas);

                            $InsDATA_loc = "INSERT INTO location (location_id,addressline1,addressline2,city,locality,country,longitude,latitude,user_id) 
                                            VALUES (NULL,'$addressline1','$addressline2','$citydb','$localitydb','$countrydb','$longitudedb','$latitudedb','$user_id[user_id]') ";
                            mysqli_query($con,$InsDATA_loc);

                        } else {


                            $disastertypes_nat = $_POST['type_nat'];

                            $SELECT = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disaster_type = '$disastertypes_nat'";

                            $query = mysqli_query($con,$SELECT);
                            $disastertype_id = mysqli_fetch_assoc($query);

                            echo $disastertype_id['disastertype_id'];

                             $InsDATA_disas = "INSERT INTO disaster (disaster_id,ics_structure_id,disastertype1_FK,disastertype2_FK,timesignature,disasteralertid,disastermagid,instructions,description,confirm,user_id) 
                                                VALUES (NULL,NULL,'$disastertype_id[disastertype_id]',NULL,'$event_time','$alertid[disasteralertid_FK]','$magnitudeid[disastermagid_FK]','$instructions','$description','0','$user_id[user_id]') ";
                            mysqli_query($con,$InsDATA_disas);

                            $InsDATA_loc = "INSERT INTO location (location_id,addressline1,addressline2,city,locality,country,longitude,latitude,user_id) 
                                            VALUES (NULL,'$addressline1','$addressline2','$citydb','$localitydb','$countrydb','$longitudedb','$latitudedb','$user_id[user_id]') ";
                            mysqli_query($con,$InsDATA_loc);
                        }
                   
                }

                    elseif($disastergroup == "tag_tech"){


                        if(!empty($_POST['type_subtech']) && !empty($_POST['type_tech'])){

                            $disastersubtype_tech = $_POST['type_subtech'];

                            $SELECT = "SELECT disastertype_id FROM disastertype WHERE disastersubtype = '$disastersubtype_tech'";

                            $query = mysqli_query($con,$SELECT);
                            $disastertype2_id = mysqli_fetch_assoc($query);

                            $InsDATA_disas = "INSERT INTO disaster (disaster_id,ics_structure_id,disastertype1_FK,disastertype2_FK,timesignature,disasteralertid,disastermagid,instructions,description,confirm,user_id) 
                                                VALUES (NULL,NULL,NULL,'$disastertype2_id[disastertype_id]','$event_time','$alertid[disasteralertid_FK]','$magnitudeid[disastermagid_FK]','$instructions','$description','0','$user_id[user_id]') ";
                            mysqli_query($con,$InsDATA_disas);

                            $InsDATA_loc = "INSERT INTO location (location_id,addressline1,addressline2,city,locality,country,longitude,latitude,user_id) 
                                            VALUES (NULL,'$addressline1','$addressline2','$citydb','$localitydb','$countrydb','$longitudedb','$latitudedb','$user_id[user_id]') ";
                            mysqli_query($con,$InsDATA_loc);

                        }  else {

                            $disastertypes_tech = $_POST['type_tech'];

                            $SELECT = "SELECT disastertype_id FROM disastertype WHERE disaster_type = '$disastertypes_tech'";

                            $query = mysqli_query($con,$SELECT);
                            $disastertype2_id = mysqli_fetch_assoc($query);

                            $InsDATA_disas = "INSERT INTO disaster (disaster_id,ics_structure_id,disastertype1_FK,disastertype2_FK,timesignature,disasteralertid,disastermagid,instructions,description,confirm,user_id) 
                                                VALUES (NULL,NULL,NULL,'$disastertype2_id[disastertype_id]','$event_time','$alertid[disasteralertid_FK]','$magnitudeid[disastermagid_FK]','$instructions','$description','0','$user_id[user_id]') ";
                            mysqli_query($con,$InsDATA_disas);

                            $InsDATA_loc = "INSERT INTO location (location_id,addressline1,addressline2,city,locality,country,longitude,latitude,user_id) 
                                            VALUES (NULL,'$addressline1','$addressline2','$citydb','$localitydb','$countrydb','$longitudedb','$latitudedb','$user_id[user_id]') ";
                            mysqli_query($con,$InsDATA_loc);
                        }               
              
                } 
                        else {

                               if(!empty($_POST['type_subsubnat']) && !empty($_POST['type_subtech'])){

                                        $disastersubsubtype_nat = $_POST['type_subsubnat'];
                                        $disastersubtype_tech = $_POST['type_subtech'];

                                        $SELECT1 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disastersubsubtype = '$disastersubsubtype_nat'";
                                        $SELECT2 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disastersubtype = '$disastersubtype_tech'";

                                        $query1 = mysqli_query($con,$SELECT1);
                                        $query2 = mysqli_query($con,$SELECT2);
                                        $disastertype_id = mysqli_fetch_assoc($query1);
                                        $disastertype2_id = mysqli_fetch_assoc($query2);

                                        $InsDATA_disas = "INSERT INTO disaster (disaster_id,ics_structure_id,disastertype1_FK,disastertype2_FK,timesignature,disasteralertid,disastermagid,instructions,description,confirm,user_id) 
                                                            VALUES (NULL,NULL,'$disastertype_id[disastertype_id]','$disastertype2_id[disastertype_id]','$event_time','$alertid[disasteralertid_FK]','$magnitudeid[disastermagid_FK]','$instructions','$description','0','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_disas);

                                        $InsDATA_loc = "INSERT INTO location (location_id,addressline1,addressline2,city,locality,country,longitude,latitude,user_id) 
                                            VALUES (NULL,'$addressline1','$addressline2','$citydb','$localitydb','$countrydb','$longitudedb','$latitudedb','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_loc);


                                } elseif(!empty($_POST['type_subsubnat']) && empty($_POST['type_subtech']) && !empty($_POST['type_tech'])){

                                    $disastersubsubtype_nat = $_POST['type_subsubnat'];
                                    $disastertypes_tech = $_POST['type_tech'];

                                    $SELECT1 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disastersubsubtype = '$disastersubsubtype_nat'";
                                    $SELECT2 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disaster_type = '$disastertypes_tech'";

                                        $query1 = mysqli_query($con,$SELECT1);
                                        $query2 = mysqli_query($con,$SELECT2);
                                        $disastertype_id = mysqli_fetch_assoc($query1);
                                        $disastertype2_id = mysqli_fetch_assoc($query2);

                                        $InsDATA_disas = "INSERT INTO disaster (disaster_id,ics_structure_id,disastertype1_FK,disastertype2_FK,timesignature,disasteralertid,disastermagid,instructions,description,confirm,user_id) 
                                                            VALUES (NULL,NULL,'$disastertype_id[disastertype_id]','$disastertype2_id[disastertype_id]','$event_time','$alertid[disasteralertid_FK]','$magnitudeid[disastermagid_FK]','$instructions','$description','0','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_disas);

                                        $InsDATA_loc = "INSERT INTO location (location_id,addressline1,addressline2,city,locality,country,longitude,latitude,user_id) 
                                            VALUES (NULL,'$addressline1','$addressline2','$citydb','$localitydb','$countrydb','$longitudedb','$latitudedb','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_loc);


                                } elseif(!empty($_POST['type_subnat']) && !empty($_POST['type_subtech']) && empty($_POST['type_subsubnat']) ){

                                    $disastersubtype_nat = $_POST['type_subnat'];
                                    $disastersubtype_tech = $_POST['type_subtech'];

                                    $SELECT1 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disastersubtype = '$disastersubtype_nat'";
                                    $SELECT2 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disastersubtype = '$disastersubtype_tech'";

                                        $query1 = mysqli_query($con,$SELECT1);
                                        $query2 = mysqli_query($con,$SELECT2);
                                        $disastertype_id = mysqli_fetch_assoc($query1);
                                        $disastertype2_id = mysqli_fetch_assoc($query2);

                                        $InsDATA_disas = "INSERT INTO disaster (disaster_id,ics_structure_id,disastertype1_FK,disastertype2_FK,timesignature,disasteralertid,disastermagid,instructions,description,confirm,user_id) 
                                                            VALUES (NULL,NULL,'$disastertype_id[disastertype_id]','$disastertype2_id[disastertype_id]','$event_time','$alertid[disasteralertid_FK]','$magnitudeid[disastermagid_FK]','$instructions','$description','0','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_disas);

                                        $InsDATA_loc = "INSERT INTO location (location_id,addressline1,addressline2,city,locality,country,longitude,latitude,user_id) 
                                            VALUES (NULL,'$addressline1','$addressline2','$citydb','$localitydb','$countrydb','$longitudedb','$latitudedb','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_loc);


                                } elseif(!empty($_POST['type_subnat']) && empty($_POST['type_subtech']) && !empty($_POST['type_tech'])){

                                    $disastersubtype_nat = $_POST['type_subnat'];
                                    $disastertypes_tech = $_POST['type_tech'];

                                    $SELECT1 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disastersubtype = '$disastersubtype_nat'";
                                    $SELECT2 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disaster_type = '$disastertypes_tech'";

                                        $query1 = mysqli_query($con,$SELECT1);
                                        $query2 = mysqli_query($con,$SELECT2);
                                        $disastertype_id = mysqli_fetch_assoc($query1);
                                        $disastertype2_id = mysqli_fetch_assoc($query2);

                                        $InsDATA_disas = "INSERT INTO disaster (disaster_id,ics_structure_id,disastertype1_FK,disastertype2_FK,timesignature,disasteralertid,disastermagid,instructions,description,confirm,user_id) 
                                                            VALUES (NULL,NULL,'$disastertype_id[disastertype_id]','$disastertype2_id[disastertype_id]','$event_time','$alertid[disasteralertid_FK]','$magnitudeid[disastermagid_FK]','$instructions','$description','0','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_disas);

                                        $InsDATA_loc = "INSERT INTO location (location_id,addressline1,addressline2,city,locality,country,longitude,latitude,user_id) 
                                            VALUES (NULL,'$addressline1','$addressline2','$citydb','$localitydb','$countrydb','$longitudedb','$latitudedb','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_loc); 

                                } elseif(!empty($_POST['type_nat']) && !empty($_POST['type_subtech']) && empty($_POST['type_subnat'])){

                                    $disastertypes_nat = $_POST['type_nat'];
                                    $disastersubtype_tech = $_POST['type_subtech'];
                                    
                                    $SELECT1 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disaster_type = '$disastertypes_nat'";
                                    $SELECT2 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disastersubtype = '$disastersubtype_tech'";

                                        $query1 = mysqli_query($con,$SELECT1);
                                        $query2 = mysqli_query($con,$SELECT2);
                                        $disastertype_id = mysqli_fetch_assoc($query1);
                                        $disastertype2_id = mysqli_fetch_assoc($query2);

                                        $InsDATA_disas = "INSERT INTO disaster (disaster_id,ics_structure_id,disastertype1_FK,disastertype2_FK,timesignature,disasteralertid,disastermagid,instructions,description,confirm,user_id) 
                                                            VALUES (NULL,NULL,'$disastertype_id[disastertype_id]','$disastertype2_id[disastertype_id]','$event_time','$alertid[disasteralertid_FK]','$magnitudeid[disastermagid_FK]','$instructions','$description','0','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_disas);

                                        $InsDATA_loc = "INSERT INTO location (location_id,addressline1,addressline2,city,locality,country,longitude,latitude,user_id) 
                                            VALUES (NULL,'$addressline1','$addressline2','$citydb','$localitydb','$countrydb','$longitudedb','$latitudedb','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_loc);

                                } else {

                                    $disastertypes_nat = $_POST['type_nat'];
                                    $disastertypes_tech = $_POST['type_tech'];

                                    $SELECT1 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disaster_type = '$disastertypes_nat'";
                                    $SELECT2 = "SELECT DISTINCT disastertype_id FROM disastertype WHERE disaster_type = '$disastertypes_tech'";

                                        $query1 = mysqli_query($con,$SELECT1);
                                        $query2 = mysqli_query($con,$SELECT2);
                                        $disastertype_id = mysqli_fetch_assoc($query1);
                                        $disastertype2_id = mysqli_fetch_assoc($query2);

                                        $InsDATA_disas = "INSERT INTO disaster (disaster_id,ics_structure_id,disastertype1_FK,disastertype2_FK,timesignature,disasteralertid,disastermagid,instructions,description,confirm,user_id) 
                                                            VALUES (NULL,NULL,'$disastertype_id[disastertype_id]','$disastertype2_id[disastertype_id]','$event_time','$alertid[disasteralertid_FK]','$magnitudeid[disastermagid_FK]','$instructions','$description','0','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_disas);

                                        $InsDATA_loc = "INSERT INTO location (location_id,addressline1,addressline2,city,locality,country,longitude,latitude,user_id) 
                                            VALUES (NULL,'$addressline1','$addressline2','$citydb','$localitydb','$countrydb','$longitudedb','$latitudedb','$user_id[user_id]') ";
                                        mysqli_query($con,$InsDATA_loc);

                                }
                        }


                            //ATTENTION----The above code needs to then sort out NULL values for tag_tech and tag_nat---ATTENTION



                            $selDATA1_3 = "SELECT disaster_id FROM `disaster` WHERE user_id = '$user_id[user_id]' ORDER BY date_time DESC LIMIT 1 ";
                            $selDATA1_3query = mysqli_query($con,$selDATA1_3);
                            $disaster_id = mysqli_fetch_assoc($selDATA1_3query);

                            $selDATA1_4 = "SELECT location_id FROM location WHERE user_id = '$user_id[user_id]' ORDER BY location_id DESC LIMIT 1";
                            $selDATA1_4query = mysqli_query($con,$selDATA1_4);
                            $location_id = mysqli_fetch_assoc($selDATA1_4query);


                            $InsDATA_junc_loc_disas = "INSERT INTO disaster_location (disaster_location_junc_id, disaster_id,location_id) VALUES(NULL,'$disaster_id[disaster_id]','$location_id[location_id]')";
                            mysqli_query($con,$InsDATA_junc_loc_disas);

                            header("Location: http://$host/ems/detect-agency/event-record.php");
                            exit();

                            ?>