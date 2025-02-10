<?php
include ("../../dbconnection.php");
include ("../../dbcheck.php");
$con = dbconnection();

if ( isset($_POST["id"])){
    $id = $_POST["id"];
} else
    return;


    $arr = [];
  $name=$_FILES["file"]["name"];
  move_uploaded_file($_FILES["file"]["tmp_name"], "../images/client_$id");
        //Move the file to the uploads folder


        //Get the File Location
        $filelocation = "http://localhost/gym/admin/images/client_$id";

        //Get the File Size
        $size = ($_FILES["file"]["size"]/1024).' kB';

        //Save to your Database
     $updateQuery = "UPDATE `clients` SET `image`= '$filelocation' WHERE id = '$id' ";
     $exeInsert =  mysqli_query($con, $updateQuery);
      
      
    if($insertQuery){
        $arr["success"] = true;
    $arr["message"] = "Client Photo Added";
    
    }else {
           $arr["success"] = false;
    $arr["message"] = "Error";
    }
    print (json_encode($arr));


?>