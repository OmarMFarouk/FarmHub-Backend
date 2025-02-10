<?php
include ("../../dbconnection.php");
$con = dbconnection();
$formattedTime =  date("Y-m-d h:i A");

$formattedYear =  date("Y");
$formattedMonth =  date("m");
$formattedDay =  date("d");

$dayProfit = "SELECT * FROM `daily_analytics` WHERE DAY(date)=$formattedDay AND MONTH(date)=$formattedMonth AND YEAR(date)=$formattedYear";           
$exeDay = mysqli_query($con, $dayProfit);

$monthProfit = "SELECT SUM(`profit`) FROM `subscription` WHERE MONTH(date)=$formattedMonth AND YEAR(date)=$formattedYear";           
$exeMonth = mysqli_query($con, $monthProfit);

$yearProfit = "SELECT SUM(`profit`) FROM `subscription` WHERE YEAR(date)=$formattedYear";           
$exeYear = mysqli_query($con, $yearProfit);

$dayClient ="SELECT * FROM `daily_analytics` WHERE DAY(date)=$formattedDay AND MONTH(date)=$formattedMonth AND YEAR(date)=$formattedYear";           
$exeDayClient = mysqli_query($con, $dayClient);

$monthClient = "SELECT COUNT(*) FROM `clients` WHERE MONTH(`date_created`)=$formattedMonth AND YEAR(date_created)=$formattedYear";           
$exeMonthClient = mysqli_query($con, $monthClient);

$allClients = "SELECT COUNT(*) FROM `clients` ";          
$exeAllClients = mysqli_query($con, $allClients);



$arr = [];
$arr['success']=true;
 if(mysqli_num_rows($exeDay) == 0){
       
    $arr['day_profit']='0';
 }
 if(mysqli_num_rows($exeDay) !=0){
    $arr['day_profit']=mysqli_fetch_assoc($exeDay)['revenue'];
 }
 if(mysqli_num_rows($exeMonth) !=0){
 $arr['month_profit']= mysqli_fetch_assoc($exeMonth)['SUM(`profit`)'];
 }
 if(mysqli_num_rows($exeYear) !=0){
    $arr['year_profit']= mysqli_fetch_assoc($exeYear)['SUM(`profit`)'];
    
 }

 if(mysqli_num_rows($exeDay) == 0){
       
    $arr['day_client']='0';
 }
 if(mysqli_num_rows($exeDayClient) !=0){
    $arr['day_client']=mysqli_fetch_assoc($exeDayClient)['new_clients'];
 }
 if(mysqli_num_rows($exeMonthClient) ==0){
    $arr['month_client']='0';
 }
 if(mysqli_num_rows($exeMonthClient) !=0){
    $arr['month_client']=mysqli_fetch_assoc($exeMonthClient)['COUNT(*)'];
 }
 if(mysqli_num_rows($exeAllClients) ==0){
    $arr['all_client']='0';
 }
 if(mysqli_num_rows($exeAllClients) !=0){
    $arr['all_client']=mysqli_fetch_assoc($exeAllClients)['COUNT(*)'];
 }
 
 print (json_encode($arr));
 
 
 