<?php

include ("../../dbconnection.php");
include ("../../dbcheck.php");
$con = dbconnection();
mysqli_set_charset($con, "utf8mb4");
dbcheck($con);
date_default_timezone_set("Europe/Moscow");
$formattedTime =  date("Y-m-d h:i A");

$formattedYear =  date("Y");
$formattedMonth =  date("m");
$formattedDay =  date("d");

$arr = [];

       
$searchQ= "SELECT * FROM `clients` ORDER BY id DESC ";
$exeSearch = mysqli_query($con, $searchQ);

$count = mysqli_num_rows($exeSearch);
if ($count==0) {
    $arr['clients']=[]; 
   
    $arr["success"] = true;
    $arr["message"] = "No Clients ";
  
 }
 else if ($count!=0) {
    while ($row=mysqli_fetch_assoc($exeSearch)) {
        
        $arr["success"] = true;
        $arr["message"] = "Showing Clients";
        $arr['clients'][]=$row;
    }
}
 else {  
   
    $arr["success"] = false;
    $arr["message"] = "error";
  
 }

print (json_encode($arr));


