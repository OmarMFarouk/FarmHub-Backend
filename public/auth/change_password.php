<?php

include("../../dbconnection.php");

// Establish database connection
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if password is provided in the POST request
    if (
        isset($_POST["user_password"]) && !empty($_POST["user_password"]) &&
        isset($_POST["user_email"]) && !empty($_POST["user_email"])
        ) {
        
        $password = password_hash($_POST["user_password"], PASSWORD_BCRYPT); // Use password_hash for better security
        $email = mysqli_escape_string($con, $_POST['user_email']) ; // Hardcoded user_id (consider replacing with dynamic input for scalability)
        $arr = [];

        // Use prepared statements to prevent SQL injection
        $updateQuery = "UPDATE `users` SET `user_password` = ? WHERE `user_email` = ?";
        $stmt = $con->prepare($updateQuery);
        $stmt->bind_param("si", $password, $email);

        if ($stmt->execute()) {
            $arr["success"] = true;
            $arr["message"] = "Password is changed successfully"; // Arabic message for success
        } else {
            $arr["success"] = false;
            $arr["message"] = "Something went wrong, please try again later"; // Arabic message for error
        }

        $stmt->close(); // Close the statement
    } else {
        $arr["success"] = false;
        $arr["message"] = "Some inputs are missing, try again."; // Arabic message for missing password
    }
} else {
    $arr["success"] = false;
    $arr["message"] = "Incorrect Request"; // Arabic message for invalid request
}

// Close the database connection
$con->close();

// Output the JSON response
header('Content-Type: application/json; charset=utf-8');
echo json_encode($arr, JSON_UNESCAPED_UNICODE);

?>
