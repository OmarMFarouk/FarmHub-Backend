<?php

include("../../dbconnection.php");
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["user_id"]) && !empty($_POST["user_id"])&&
        isset($_POST["user_fullName"]) && !empty($_POST["user_fullName"])&&
        isset($_POST["user_orgName"]) && !empty($_POST["user_orgName"])&&
        isset($_POST["user_phone"]) && !empty($_POST["user_phone"])&&
        isset($_POST["user_email"]) && !empty($_POST["user_email"])
       ) {
        $userId =  mysqli_real_escape_string($con, $_POST["user_id"]);
        $fullName=  mysqli_real_escape_string($con, $_POST["user_fullName"]);
        $email =  mysqli_real_escape_string($con, $_POST["user_email"]);
        $phone =  mysqli_real_escape_string($con, $_POST["user_phone"]);
        $orgName =  mysqli_real_escape_string($con, $_POST["user_orgName"]);
        $arr = [];

        $searchQuery = "UPDATE `users` SET `user_fullName` = ? , `user_orgName` = ? , `user_phone`=  ? , `user_email`= ?  WHERE `user_id` = ? ";
        $stmt = $con->prepare($searchQuery);
        $stmt->bind_param("sssss",$fullName,$orgName,$phone,$email, $userId); 
        $result=  $stmt->execute();
      

        if ($result) {
           
         $arr["success"] = true;
         $arr["message"] = "Profile Updated Successfully."; 
        
        } else {
            $arr["success"] = false;
            $arr["message"] = "Something went wrong try again later.";
        }

        $stmt->close();
    } else {
        $arr["success"] = false;
        $arr["message"] = "Some Inputs Are Missing.";
    }
} else {
    $arr["success"] = false;
    $arr["message"] = "Invalid Request";
}

// Close the database connection
$con->close();

// Output the JSON response
header('Content-Type: application/json; charset=utf-8');
echo json_encode($arr, JSON_UNESCAPED_UNICODE);

?>