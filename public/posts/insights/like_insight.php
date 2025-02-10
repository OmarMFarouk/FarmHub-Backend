<?php

include "../../../dbconnection.php";

date_default_timezone_set('Africa/Kampala');
$formattedTime = date("Y-m-d h:i A");
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["insight_id"]) && !empty($_POST["insight_id"]) && 
        isset($_POST["is_liked"]) && !empty($_POST["is_liked"])     &&
        isset($_POST["user_id"]) && !empty($_POST["user_id"])
        ) {
            
        $insightId = mysqli_real_escape_string($con, $_POST["insight_id"]);
        $isLiked = mysqli_real_escape_string($con, $_POST["is_liked"]);
        $userId = mysqli_real_escape_string($con, $_POST["user_id"]);
        $arr = [];

        $searchQuery = "SELECT * FROM `likes` WHERE `like_referenceType` = 'insight' AND  `like_referenceId` = '$insightId' ";
        $stmt = $con->prepare($searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1)
     {
        $updateQuery = "UPDATE `insights` SET `insight_likes` = `insight_likes` - 1 WHERE `insight_id` = '$insightId'";
        $likeQuery = "DELETE FROM `likes` WHERE `like_referenceType` = 'insight' AND `like_referenceId` = '$insightId'";
       
     }
     else {
        $updateQuery = "UPDATE `insights` SET `insight_likes` = `insight_likes` + 1 WHERE `insight_id` = '$insightId'";
        $likeQuery = "INSERT INTO `likes`(`like_referenceType`, `like_referenceId`, `like_userId`, `like_dateCreated`)
                      VALUES ('insight','$insightId','$userId','$formattedTime')";
     }

            $Likestmt = $con->prepare($likeQuery);
            $Likestmt->execute();;

            $stmt = $con->prepare($updateQuery);
            $result =  $stmt->execute();;
            $arr["success"] = true;
            $arr["message"] = "Action Performed Successfully."; 
           
           
       


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