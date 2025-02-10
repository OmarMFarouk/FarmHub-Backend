<?php


include "../common/file_type_detector.php";
include "../../../dbconnection.php";

date_default_timezone_set('Africa/Kampala');
$formattedTime = date("Y-m-d h:i A");
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST["listing_title"]) && !empty($_POST["listing_title"]) && 
        isset($_POST["listing_body"]) && !empty($_POST["listing_body"])     &&
        isset($_POST["listing_price"]) && !empty($_POST["listing_price"])     &&
        isset($_POST["listing_userId"]) && !empty($_POST["listing_userId"])
        ) {
            
        $listingTitle = mysqli_real_escape_string($con, $_POST["listing_title"]);
        $listingBody = mysqli_real_escape_string($con, $_POST["listing_body"]);
        $listingPrice = mysqli_real_escape_string($con, $_POST["listing_price"]);
        $userId = mysqli_real_escape_string($con, $_POST["listing_userId"]);
        $arr = [];

        // Use prepared statements for security
        $insertQuery = "INSERT INTO `listings` (`listing_title`, `listing_body`, `listing_price` , `listing_status`,  `listing_views`, `listing_shares`, `listing_userId`, `listing_dateCreated`, `listing_dateUpdated`) 
        VALUES (?, ?, ?, 'active', '0', '0', ?, ?, ?)";
        $stmt = $con->prepare($insertQuery);
        $stmt->bind_param("ssssss", $listingTitle, $listingBody,$listingPrice,$userId,$formattedTime,$formattedTime); 
        $result =  $stmt->execute();;

        if ($result) {
            $listingId = mysqli_insert_id($con);

                $tmpName = $_FILES["file"]['tmp_name'];
                $targetFile = "../../../media/listings/$listingId-" . basename($_FILES["file"]['name']);
                $fileLocation= "http://192.168.1.10/farm_hub/media/listings/$listingId-" . basename($_FILES["file"]['name']);
                $fileType = isImageOrVideo($tmpName);
               
                move_uploaded_file($tmpName, $targetFile);
                $fileQuery = "INSERT INTO `files`(`file_link`, `file_type`, `file_referenceType`, `file_referenceId`, `file_status`, `file_dateCreated`, `file_dateUpdated`) 
                VALUES (?,?,'listing',?,'active',?,?)";
                $ftmt = $con->prepare($fileQuery);
                $ftmt->bind_param("sssss", $fileLocation,$fileType, $listingId,$formattedTime,$formattedTime); 
                $ftmt->execute();

            $arr["success"] = true;
            $arr["message"] = "Listing Posted Successfully."; 
           
           
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