<?php

include "../../dbconnection.php";
$con = dbconnection();
date_default_timezone_set('Africa/Kampala');
$formattedTime = date("Y-m-d h:i A");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["room_id"]) && !empty($_POST["room_id"])&&
        isset($_POST["user_id"]) && !empty($_POST["user_id"])
        ) {
            
       
        $roomId = mysqli_real_escape_string($con, $_POST["room_id"]);
        $userId = mysqli_real_escape_string($con, $_POST["user_id"]);
        $arr = [];
        $searchQuery = "UPDATE  `chat_messages` SET `message_status` = 'read' WHERE `message_roomId` = '$roomId' AND `message_userId` != '$userId' ";
        $stmt = $con->prepare($searchQuery);
        $result = $stmt->execute();
      


        if ($result) {
         
         $arr["success"] = true;
         $arr["message"] = "Messages status changed to read."; 
      
      
        } else {
            $arr["success"] = false;
            $arr["message"] = "Some Inputs Are Missing.";
        } 
        
        } else {
            $arr["success"] = false;
            $arr["message"] = "DATABASE ERROR.";
        }

        $stmt->close();
    
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