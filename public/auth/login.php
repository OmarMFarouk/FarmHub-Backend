<?php

include("../../dbconnection.php");
date_default_timezone_set('Africa/Kampala');
$formattedTime = date("Y-m-d h:i A");
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input (basic validation)
    if (isset($_POST["credential"]) && !empty($_POST["credential"]) && isset($_POST["password"]) && !empty($_POST["password"])) {
        $credential = mysqli_real_escape_string($con, $_POST["credential"]);
        $password = mysqli_real_escape_string($con, $_POST["password"]);
        $arr = [];

        // Use prepared statements for security
        $searchQuery = "SELECT * FROM `users` WHERE `user_name` = ? OR `user_email` = ?";
        $stmt = $con->prepare($searchQuery);
        $stmt->bind_param("ss", $credential, $credential); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

        
            if (password_verify($password, $user['user_password'])) {
                $arr["success"] = true;
                $arr["message"] = "Logging In."; 
                $arr['user_id'] = $user['user_id'];
                unset($user['password']); 
            } else {
                $arr["success"] = false;
                $arr["message"] = "Incorrect Password.";
            }
        } else {
            $arr["success"] = false;
            $arr["message"] = "Credentials Doesn't Exist.";
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