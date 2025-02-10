<?php

$formattedTime =  date("Y-m-d h:i A");
function dbconnection() {

//     $con=mysqli_connect("127.0.0.1","feroo_flutter","GGJbond007","feroo_flutter");

$con= mysqli_connect("p:127.0.0.1:4306","root","","farm_hub");
mysqli_set_charset($con, "utf8mb4");    
return $con;

;}