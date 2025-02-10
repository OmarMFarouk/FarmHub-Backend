<?php

include("../../dbconnection.php");
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["user_id"]) && !empty($_POST["user_id"])) {
        $userId =  mysqli_real_escape_string($con, $_POST["user_id"]);
        $arr = [];
        $tmpName = $_FILES["file"]['tmp_name'];
        $targetFile = "../../media/avatars/user_$userId.jpeg";
        $fileLocation= "http://192.168.1.10/farm_hub/media/avatars/user_$userId.jpeg";


        if (file_exists($targetFile)) {unlink($targetFile);}
     
        move_uploaded_file($tmpName, $targetFile);
        
        $searchQuery = "UPDATE `users` SET `user_avatar` = ? WHERE `user_id` = ? ";
        $stmt = $con->prepare($searchQuery);
        $stmt->bind_param("ss",$fileLocation, $userId); 
        $result= $stmt->execute();
   
        if ($result) {
           
         $arr["success"] = true;
         $arr["message"] = "Avatar Updated Successfully."; 
        
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