<?php
include 'config.php';
$username = $_SESSION['username'];
$productid = $_POST['productid'];
$rating = $_POST['rating'];

$query = "SELECT COUNT(*) AS cntpost FROM `rating table` WHERE product_id='$productid' and username='$username'";
$result = mysqli_query($conn,$query);

$fetchdata = mysqli_fetch_array($result);
$count = $fetchdata['cntpost'];
if($count == 0){
    $insertquery = "INSERT INTO `rating table` ( `product_id`, `currentime`, `stars`, `username`) VALUES ( '$productid', current_timestamp(), '$rating', '$username')";
    mysqli_query($conn,$insertquery);
   }else {
    $updatequery = "UPDATE `rating table` SET `stars` = '$rating' WHERE `rating table`.`username` = '$username' AND `rating table`.`product_id` = '$productid'";
    mysqli_query($conn,$updatequery);
   }
   
   $query = "SELECT ROUND(AVG(stars),1) as averageRating FROM `rating table` WHERE product_id=".$productid;
$result = mysqli_query($con,$query);
$fetchAverage = mysqli_fetch_array($result);
$averageRating = $fetchAverage['averageRating'];

$return_arr = array("averageRating"=>$averageRating);

echo json_encode($return_arr);

?>

