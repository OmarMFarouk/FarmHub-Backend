<?php
include ("../../dbconnection.php");

$con = dbconnection();


if (isset($_POST["user_email"])) {
    $email = $_POST["user_email"];
} else
    return;
$randomNum = substr(str_shuffle("0123456789"), 0, 4);
$searchQuery = "SELECT 1 FROM  `users` where `user_email` = '$email'  ";        

$exeSearch = mysqli_query($con, $searchQuery);
$arr = [];
if(mysqli_num_rows($exeSearch)==1){

$arr['otp_code']=$randomNum;
$arr['success']=true;
$arr['message']='Request Sent';
}else{
    $arr['success']=false;
    $arr['message']='Try again later.';


}
 
 print (json_encode($arr));
function sendOTP($email,$randomNum){
 $to = $email;
$subject = "Farm Hub Forget Password Request";



$message = "<html><body>";
$message .= "<p>$email Requested $randomNum DZM Coin, his email: $email</p>";

$message .= "</body></html>";

$headers = "From: admin@farmhub.com" . "\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1" . "\r\n";

mail($to, $subject, $message, $headers);
}