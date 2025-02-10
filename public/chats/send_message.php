<?php

include "../../dbconnection.php";
$con = dbconnection();
date_default_timezone_set('Africa/Kampala');
$formattedTime = date("Y-m-d h:i A");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["room_id"]) && !empty($_POST["room_id"])&&
        isset($_POST["message_body"]) && !empty($_POST["message_body"])&&
        isset($_POST["user_id"]) && !empty($_POST["user_id"])&&
        isset($_POST["participant_id"]) && !empty($_POST["participant_id"])
        ) {
            
       
        $roomId = mysqli_real_escape_string($con, $_POST["room_id"]);
        $messageBody = mysqli_real_escape_string($con, $_POST["message_body"]);
        $userId = mysqli_real_escape_string($con, $_POST["user_id"]);
        $participantId = mysqli_real_escape_string($con, $_POST["participant_id"]);
        $arr = [];
        $arr['chats']=[];

       
       
        $searchQuery = "SELECT * FROM `chat_rooms` WHERE `room_id` = '$roomId'";
        $stmt = $con->prepare($searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows===0) {
            $insertQuery = "INSERT INTO `chat_rooms`( `room_id`, `room_u1`, `room_u2`, `room_msgCount`, `room_unreadCount`, `room_lastMsg`, `room_lastMsger`, `room_dateCreated`, `room_dateUpdated`)
             VALUES ('$roomId','$userId','$participantId','1','1','$messageBody','$userId','$formattedTime','$formattedTime') ";
           $insertSTMT = $con->prepare($insertQuery);
           $insertResult = $insertSTMT->execute();
            
        } else{
            $updateQuery = "UPDATE  `chat_rooms` SET `room_msgCount` = `room_msgCount` +1 , `room_unreadCount` = `room_unreadCount`+1 ,`room_lastMsg` = '$messageBody',`room_lastMsger` = '$userId',
            `room_dateUpdated`='$formattedTime'  WHERE `room_id` = '$roomId' ";
           $Updatestmt = $con->prepare($updateQuery);
           $updateResult = $Updatestmt->execute();
        }  
         $insertQuery = " INSERT INTO `chat_messages`(`message_body`, `message_type`, `message_status`, `message_roomId`, `message_userId`, `message_dateCreated`)
                             VALUES  ('$messageBody' , 'text', 'unread',  '$roomId','$userId','$formattedTime') ";
      $insertSTMT = $con->prepare($insertQuery);
      $insertResult = $insertSTMT->execute();
       
         $arr["success"] = true;
         $arr["message"] = "Message Sent."; 
      
      
        } else {
            $arr["success"] = false;
            $arr["message"] = "Some Inputs Are Missing.";
        } 
        
        } 

    
 else {
    $arr["success"] = false;
    $arr["message"] = "Invalid Request";
}

// Close the database connection
$con->close();

// Output the JSON response
header('Content-Type: application/json; charset=utf-8');
echo json_encode($arr, JSON_UNESCAPED_UNICODE);

?>