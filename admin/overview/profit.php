<?php
include ("../../dbconnection.php");
$con = dbconnection();


$datesQuery = "SELECT * from subscription ORDER BY id DESC ";          
$exeDatesQuery = mysqli_query($con, $datesQuery);




$arr = [];

 if(mysqli_num_rows($exeDatesQuery) ==0){
    $arr['all_transactions']='0';
 }
 if(mysqli_num_rows($exeDatesQuery) !=0){
    while ($row =mysqli_fetch_assoc($exeDatesQuery) ) {
     
        $arr['all_transactions'][]=$row;



    }
   
 }
 
 print (json_encode($arr));
 
 
 