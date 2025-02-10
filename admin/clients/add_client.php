<?php

include ("../../dbconnection.php");
include ("../../dbcheck.php");
$con = dbconnection();
dbcheck($con);
$formattedTime =  date("Y-m-d h:i A");

$formattedYear =  date("Y");
$formattedMonth =  date("m");
$formattedDay =  date("d");

$arr = [];

if ( isset($_POST["name"])){
    $name = $_POST["name"];
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
                    if ( isset($_POST["phone_number"])){
            $phone = $_POST["phone_number"];
        } else
            return;
       
$updateQuery = "UPDATE `daily_analytics` SET `revenue`= `revenue`+$price , `visits`= `visits`+1, `new_clients`=`new_clients`+1  WHERE DAY(`date`) =$formattedDay AND MONTH(`date`)=$formattedMonth  AND YEAR(`date`)=$formattedYear ";

$clientQuery = "INSERT INTO `clients`(`name`,`phone_number`, `type`, `current_duration`, `date_created`, `last_renewal`) VALUES ('$name','$phone','$type','$duration','$formattedTime','$formattedTime')  ";

$exeClient = mysqli_query($con, $clientQuery);
if (!$exeClient) { 
   
    $arr["success"] = false;
    $arr["message"] = "Error ";
  
 } else {  
    $exeUpdate = mysqli_query($con, $updateQuery);
    $searchQ= "SELECT * FROM `clients` WHERE `date_created`='$formattedTime' AND `type`='$type' AND `name`='$name'  ";
    $row=mysqli_fetch_assoc(mysqli_query($con,$searchQ));
    $exeSubs = mysqli_query($con, "INSERT INTO `subscription`(`client_id`, `profit`, `duration`, `date`) VALUES (".$row['id'].",'$price','$duration','$formattedTime')  ");

    $arr["success"] = true;
    $arr["message"] = "Client Added";
   

      
 }
     

   
 


   

print (json_encode($arr));


