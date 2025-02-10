<?php
include "../../../dbconnection.php";
$con = dbconnection();

if (isset($_POST["post_type"])) { $postType= $_POST["post_type"];} else return;
if (isset($_POST["post_id"])) { $postId= $_POST["post_id"];} else return;

if ($postType=='insight') {
    $updateQuery = "UPDATE `insights` SET `insight_shares`=`insight_shares` +1  WHERE `insight_id` = '$postId' ";
    $exeUpdate = mysqli_query($con, $updateQuery);
    
}else {
  
    $updateQuery = "UPDATE `listings` SET `listing_shares`= `listing_shares` +1  WHERE `listing_id` = '$postId' ";
    $exeUpdate = mysqli_query($con, $updateQuery);
    
}