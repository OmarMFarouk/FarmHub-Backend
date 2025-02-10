<?php

include "../common/file_type_detector.php";
include "../../../dbconnection.php";
date_default_timezone_set('Africa/Kampala');
$formattedTime = date("Y-m-d h:i A");
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["insight_title"]) && !empty($_POST["insight_title"]) && 
        isset($_POST["insight_body"]) && !empty($_POST["insight_body"])     &&
        isset($_POST["insight_userId"]) && !empty($_POST["insight_userId"])
        ) {
            
        $insightTitle = mysqli_real_escape_string($con, $_POST["insight_title"]);
        $insightBody = mysqli_real_escape_string($con, $_POST["insight_body"]);
        $userId = mysqli_real_escape_string($con, $_POST["insight_userId"]);
        $arr = [];

        // Use prepared statements for security
        $insertQuery = "INSERT INTO `insights` (`insight_title`, `insight_body`, `insight_status`, `insight_likes`, `insight_views`, `insight_shares`, `insight_comments`, `insight_userId`, `insight_dateCreated`, `insight_dateUpdated`) 
        VALUES (?, ?, 'active', '0', '0', '0', '0', ?, ?, ?)";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param("sssss", $insightTitle, $insightBody,$userId,$formattedTime,$formattedTime); 
        $result =  $stmt->execute();;

        if ($result) {
            $insightId = mysqli_insert_id($con);
          
             
                    $tmpName = $_FILES["file"]['tmp_name'];
                    $targetFile = "../../../media/insights/$insightId-" . basename($_FILES["file"]['name']);
                    $fileLocation= "http://192.168.1.10/farm_hub/media/insights/$insightId-" . basename($_FILES["file"]['name']);
                    $fileType = isImageOrVideo($tmpName);
                   
                    move_uploaded_file($tmpName, $targetFile);
                    $fileQuery = "INSERT INTO `files`(`file_link`, `file_type`, `file_referenceType`, `file_referenceId`, `file_status`, `file_dateCreated`, `file_dateUpdated`) 
                    VALUES (?,?,'insight',?,'active',?,?)";
                    $ftmt = $con->prepare($fileQuery);
                    $ftmt->bind_param("sssss", $fileLocation,$fileType, $insightId,$formattedTime,$formattedTime); 
                    $ftmt->execute();
       
             
           
          
            

            $arr["success"] = true;
            $arr["message"] = "Insight Posted Successfully."; 
           
           
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