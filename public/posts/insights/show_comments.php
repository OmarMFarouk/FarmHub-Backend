<?php

include "../../../dbconnection.php";
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (
    isset($_POST["insight_id"]) && !empty($_POST["insight_id"]) &&
    isset($_POST["user_id"]) && !empty($_POST["user_id"])
    ) {
        
    $insightId = mysqli_real_escape_string($con, $_POST["insight_id"]);
    $userId = mysqli_real_escape_string($con, $_POST["user_id"]);
        $arr = [];
        $arr['insight_comments']=[];

        $searchQuery = "SELECT
    t1.*,
    CASE WHEN t2.like_id IS NOT NULL THEN 'true' ELSE 'false' END AS is_liked
FROM
    insights_comments t1
LEFT JOIN
    likes t2 ON t2.like_referenceType ='comment' AND t1.comment_id = t2.like_referenceId AND t2.like_userId ='$userId' AND t1.comment_status !='deleted'  ORDER BY t1.comment_id DESC";
        $stmt = $con->prepare($searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();

      

        if ($result) {
          while ($comment = $result->fetch_assoc()) {

            $authorQuery = "SELECT * FROM `users`  WHERE `user_id` = ? ";
            $atmt = $con->prepare($authorQuery);
            $atmt->bind_param("i",  $comment['comment_userId']); 
            $atmt->execute();
            $authorResult = $atmt->get_result()->fetch_assoc(); 
            $comment['author_info']=$authorResult;


          
            $arr['insight_comments'][]=$comment;
          } 
            
        
         $arr["success"] = true;
         $arr["message"] = "Fetching Insight Comments."; 
      
        } else {
          $arr["success"] = false;
          $arr["message"] = "Something Went Wrong, Try Again Later.";
      } 
        
        } else {
            $arr["success"] = false;
            $arr["message"] = "DATABASE ERROR.";
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