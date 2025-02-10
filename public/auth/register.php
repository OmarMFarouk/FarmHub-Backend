<?php

include("../../dbconnection.php");
$con = dbconnection();

date_default_timezone_set('Africa/Kampala');
$formattedTime = date("Y-m-d h:i A");
$ip = $_SERVER['REMOTE_ADDR'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        isset($_POST["user_name"]) && !empty($_POST["user_name"])
        && isset($_POST["user_password"]) && !empty($_POST["user_password"])
        && isset($_POST["user_fullname"]) && !empty($_POST["user_fullname"])
        && isset($_POST["user_email"]) && !empty($_POST["user_email"])
        && isset($_POST["user_location"]) && !empty($_POST["user_location"])
        && isset($_POST["user_phone"]) && !empty($_POST["user_phone"])
        && isset($_POST["user_orgName"]) && !empty($_POST["user_orgName"])
        && isset($_POST["user_hwid"]) && !empty($_POST["user_hwid"])
    ) {
        $username = mysqli_real_escape_string($con, $_POST["user_name"]);
        $fullName = mysqli_real_escape_string($con, $_POST["user_fullname"]);
        $email = mysqli_real_escape_string($con, $_POST["user_email"]);
        $location = mysqli_real_escape_string($con, $_POST["user_location"]);
        $phone = mysqli_real_escape_string($con, $_POST["user_phone"]);
        $orgName = mysqli_real_escape_string($con, $_POST["user_orgName"]);
        $hwid = mysqli_real_escape_string($con, $_POST["user_hwid"]);

     
        $passwordHash = password_hash($_POST["user_password"], PASSWORD_BCRYPT);
        if ($passwordHash === false) {
            $arr["success"] = false;
            $arr["message"] = "Something went wrong pleast try again.";
        } else {
            $arr = [];
            $avatar = '';

            $insertQuery = "INSERT INTO `users`(`user_name`, `user_fullName`, `user_OrgName`, `user_phone`, `user_email`, `user_password`, `user_location`, `user_hwid`, `user_ip`, `user_avatar`, `user_dateCreated`, `user_dateLastAccess`)VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , ?)";
            $stmtInsert = $con->prepare($insertQuery);
            $stmtInsert->bind_param("ssssssssssss", $username, $fullName, $orgName, $phone, $email, $passwordHash, $location, $hwid, $ip, $avatar, $formattedTime, $formattedTime);

            if ($stmtInsert->execute()) {
                $userId = mysqli_insert_id($con);
                $arr["success"] = true;
                $arr["message"] = "Registered successfully.";
                $arr['user_id'] = $userId;
            } else {
                $arr["success"] = false;
                $arr["message"] = "Error Occuried Try Again Later.";
            }

            $stmtInsert->close();
        }
    } else {
        $arr["success"] = false;
        $arr["message"] = "Some Inputs Are Missing.";
    }
} else {
    $arr["success"] = false;
    $arr["message"] = "Invalid Request.";
}

$con->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($arr, JSON_UNESCAPED_UNICODE);

?>