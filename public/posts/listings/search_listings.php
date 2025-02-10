<?php
include "../../../dbconnection.php";
$con = dbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (
          isset($_POST["search_keyword"]) && !empty($_POST["search_keyword"])
            ) {
                
            $keyWord = mysqli_real_escape_string($con, $_POST["search_keyword"]);
        $arr = [];
        $arr['listings']=[];

        $searchQuery = "SELECT * FROM `listings`  WHERE `listing_status` != 'deleted' AND  `listing_title` LIKE '%$keyWord%' ORDER BY `listing_id` DESC  LIMIT 100";
        $stmt = $con->prepare($searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();

       

      

        if ($result) {
          
          while ($listing = $result->fetch_assoc()) {
            $listingId= $listing['listing_id'];
            $authorQuery = "SELECT * FROM `users`  WHERE `user_id` = ? ";
            $atmt = $con->prepare($authorQuery);
            $atmt->bind_param("i",  $listing['listing_userId']); 
            $atmt->execute();
            $authorResult = $atmt->get_result()->fetch_assoc(); 
            $listing['author_info']=$authorResult;

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
            
        
         $arr["success"] = true;
         $arr["message"] = "Fetching listings."; 
      
               
        
        } else {
            $arr["success"] = false;
            $arr["message"] = "DATABASE ERROR.";
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