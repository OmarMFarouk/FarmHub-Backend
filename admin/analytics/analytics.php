<?php
include ("../../dbconnection.php");
$con = dbconnection();
date_default_timezone_set("Europe/Moscow");
$formattedTime =  date("Y-m-d h:i A");


$analyticsQuery = "SELECT * FROM `daily_analytics` order by id desc limit 5";           
$exeAnalytics = mysqli_query($con, $analyticsQuery);



$arr = [];
 if(mysqli_num_rows($exeAnalytics) > 0){
while ($row = mysqli_fetch_assoc($exeAnalytics)) {
     $arr["success"] = true;
      $arr["message"] = 'Showing Analytics';
    $arr['analytics'][]=$row;
}}
else {$arr['analytics']=[];}

 
 print (json_encode($arr));
 
 
 