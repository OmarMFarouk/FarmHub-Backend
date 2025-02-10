<?php

include "../../dbconnection.php";
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["user_id"]) && !empty($_POST["user_id"])
        ) {
            
       
        $userId = mysqli_real_escape_string($con, $_POST["user_id"]);
        $arr = [];
        $arr['chats']=[];

        $searchQuery = "SELECT * FROM `chat_rooms` WHERE `room_u1` = '$userId' or `room_u2` = '$userId' ORDER BY `room_dateUpdated` DESC";
        $stmt = $con->prepare($searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result) {
          while ($chat = $result->fetch_assoc()) {
            if ($chat['room_u1']==$userId) {
                $participantId= $chat['room_u2'];
            }else{
                $participantId= $chat['room_u1'];
            }
            $participantQuery = "SELECT * FROM `users`  WHERE `user_id` = ? ";
            $atmt = $con->prepare($participantQuery);
            $atmt->bind_param("i",  $participantId); 
            $atmt->execute();
            $participantResult = $atmt->get_result()->fetch_assoc(); 
            $chat['participant_info']=$participantResult;
            $messagesQuery = "SELECT * FROM `chat_messages` WHERE `message_roomId` = ? ORDER BY `message_id` ASC ";
            $atmt = $con->prepare($messagesQuery);
            $atmt->bind_param("i",  $chat['room_id']); 
            $atmt->execute();$result = $atmt->get_result();
            $chat['messages']=[];
            while ($message = $result->fetch_assoc()) {
            $chat['messages'][]=$message;
            }
            $arr['chats'][]=$chat;
        }
            
        
         $arr["success"] = true;
         $arr["message"] = "Fetching Chats."; 
      
      
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