<?php

include ("../../dbconnection.php");
include ("../../dbcheck.php");
$con = dbconnection();
dbcheck($con);
date_default_timezone_set("Europe/Moscow");
$formattedTime =  date("Y-m-d h:i A");

$formattedYear =  date("Y");
$formattedMonth =  date("m");
$formattedDay =  date("d");

$arr = [];

if ( isset($_POST["client_id"])){
    $id = $_POST["client_id"];
} else
    return;
if ( isset($_POST["duration"])){
    $duration = $_POST["duration"];
} else
    return;
    if ( isset($_POST["price"])){
        $price = $_POST["price"];
    } else
        return;
        if ( isset($_POST["type"])){
            $type = $_POST["type"];
        } else
            return;
       
$updateQuery = "UPDATE `daily_analytics` SET `revenue`= `revenue`+$price , `visits`= `visits`+1  WHERE DAY(`date`) =$formattedDay AND MONTH(`date`)=$formattedMonth  AND YEAR(`date`)=$formattedYear ";

$clientQuery = "UPDATE `clients` SET `type` = '$type' , `current_duration`= '$duration',`last_renewal`= '$formattedTime' WHERE `id`='$id'  ";

$exeClient = mysqli_query($con, $clientQuery);
if (!$exeClient) { 
   
    $arr["success"] = false;
    $arr["message"] = "Error ";
  
 } else {  
    $exeUpdate = mysqli_query($con, $updateQuery);
    
    $exeSubs = mysqli_query($con, "INSERT INTO `subscription`(`client_id`, `profit`, `duration`, `date`) VALUES ('$id','$price','$duration','$formattedTime')  ");

    $arr["success"] = true;
    $arr["message"] = "Client Updated";
   

      
 }
     

   
 


   

print (json_encode($arr));


