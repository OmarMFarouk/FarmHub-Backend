<?php

include "../../../dbconnection.php";
include "../common/file_type_detector.php";

date_default_timezone_set('Africa/Kampala');
$formattedTime = date("Y-m-d h:i A");
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["comment_body"]) && !empty($_POST["comment_body"]) && 
        isset($_POST["insight_id"]) && !empty($_POST["insight_id"])     &&
        isset($_POST["user_id"]) && !empty($_POST["user_id"])
        ) {
            
        $commentBody = mysqli_real_escape_string($con, $_POST["comment_body"]);
        $insightId = mysqli_real_escape_string($con, $_POST["insight_id"]);
        $userId = mysqli_real_escape_string($con, $_POST["user_id"]);
        $arr = [];

        // Use prepared statements for security
        $insertQuery = "INSERT INTO `insights_comments`(`comment_body`, `comment_userId`, `comment_likes`, `comment_status`, `comment_insightId`, `comment_dateCreated`, `comment_dateUpdated`) 
        VALUES (?, ?, '0', 'active', ?, ?, ?)";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param("sssss", $commentBody, $userId,$insightId,$formattedTime,$formattedTime); 
        $result =  $stmt->execute();;

        if ($result) {
            $updateQuery = "UPDATE `insights` SET `insight_comments` = `insight_comments` + 1 WHERE `insight_id` = ?";
            $stmt = $con->prepare($updateQuery);
            $stmt->bind_param("s", $insightId); 
            $result =  $stmt->execute();;

            $arr["success"] = true;
            $arr["message"] = "Insight Comment Added Successfully."; 
           
           
        } else {
            $arr["success"] = false;
            $arr["message"] = "Something Went Wrong, Try Again Later.";
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