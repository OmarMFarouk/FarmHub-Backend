<?php

include("../../dbconnection.php");
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["user_id"]) && !empty($_POST["user_id"])) {
        $userId =  mysqli_real_escape_string($con, $_POST["user_id"]);
        $arr = [];

        $searchQuery = "SELECT * FROM `users` WHERE `user_id` = ?";
        $stmt = $con->prepare($searchQuery);
        $stmt->bind_param("i", $userId); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

        
         $arr["success"] = true;
         $arr["message"] = "Fetching User Data."; 
         $arr['user_data'] = $user;
               
        
        } else {
            $arr["success"] = false;
            $arr["message"] = "User ID  Doesn't Exist.";
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