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
         $arr['listings']=[];

         $searchQuery = "SELECT * FROM `listings`  WHERE `listing_status` != 'deleted' AND  `listing_userId` = '$userId' ORDER BY `listing_id` DESC  LIMIT 100";
         $stmt = $con->prepare($searchQuery);
         $stmt->execute();
         $result = $stmt->get_result();
 
       
 
       
 
         if ($result) {
           
           while ($listing = $result->fetch_assoc()) {
             
             $authorQuery = "SELECT * FROM `users`  WHERE `user_id` = ? ";
             $atmt = $con->prepare($authorQuery);
             $atmt->bind_param("i",  $listing['listing_userId']); 
             $atmt->execute();
             $authorResult = $atmt->get_result()->fetch_assoc(); 
             $listing['author_info']=$authorResult;
             $listingId=$listing['listing_id'];
             $listing['files']=[];
             $filesQuery = "SELECT * FROM `files`  WHERE `file_referenceType` = 'listing' AND `file_referenceId` = '$listingId' ";
             $ftmt = $con->prepare($filesQuery);
             $ftmt->execute();
             $filesResult = $ftmt->get_result();
     
             while ($file= $filesResult->fetch_assoc()) {
 
          
             $listing['files'][]=$file;
             }
           
             $arr['listings'][]=$listing;
           } 
             
         
        
       
                
         
         }
           $arr['insights']=[];

         $searchQuery = "SELECT
     t1.*,
     CASE WHEN t2.like_id IS NOT NULL THEN 'true' ELSE 'false' END AS is_liked 
 FROM
     insights t1 
 LEFT JOIN
     likes t2 ON t2.like_referenceType ='insight' AND t1.insight_id = t2.like_referenceId AND t2.like_userId ='$userId' AND t1.insight_status !='deleted'  WHERE t1.insight_userId ='$userId' ORDER BY t1.insight_id DESC LIMIT 100";
         $stmt = $con->prepare($searchQuery);
         $stmt->execute();
         $result = $stmt->get_result();
 
 
         if ($result) {
           while ($insight = $result->fetch_assoc()) {
 
           
             $authorQuery = "SELECT * FROM `users`  WHERE `user_id` = ? ";
             $atmt = $con->prepare($authorQuery);
             $atmt->bind_param("i",  $insight['insight_userId']); 
             $atmt->execute();
             $authorResult = $atmt->get_result()->fetch_assoc(); 
             $insight['author_info']=$authorResult;
             $insightId=$insight['insight_id'];
             $insight['files']=[];
             $filesQuery = "SELECT * FROM `files`  WHERE `file_referenceType` = 'insight' AND `file_referenceId` = '$insightId' ";
             $ftmt = $con->prepare($filesQuery);
             $ftmt->execute();
             $filesResult = $ftmt->get_result();
     
             while ($file= $filesResult->fetch_assoc()) {
 
          
             $insight['files'][]=$file;
             }
           
             $arr['insights'][]=$insight;
           } 
             
         
        
       
                
         
         } 
         $arr["success"] = true;
         $arr["message"] = "Fetching Profile."; 
      
        
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