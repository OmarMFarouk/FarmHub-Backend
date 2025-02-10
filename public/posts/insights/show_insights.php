<?php

include "../../../dbconnection.php";
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
        $arr = [];
        $arr['insights']=[];

        $searchQuery = "SELECT
    t1.*,
    CASE WHEN t2.like_id IS NOT NULL THEN 'true' ELSE 'false' END AS is_liked
FROM
    insights t1
LEFT JOIN
    likes t2 ON t2.like_referenceType ='insight' AND t1.insight_id = t2.like_referenceId AND t2.like_userId ='1' AND t1.insight_status !='deleted'  ORDER BY t1.insight_id DESC LIMIT 100";
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
            
        
         $arr["success"] = true;
         $arr["message"] = "Fetching Insights."; 
      
      
               
        
        } else {
            $arr["success"] = false;
            $arr["message"] = "DATABASE ERROR.";
        }

        $stmt->close();
    
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