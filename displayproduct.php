<?php
include 'config.php';
session_start();
if(!isset($_SESSION['loggedin'])){
 header('location:login.php');
 exit;
}
$username=$_SESSION['username'];
$productid=$_GET['product_id'];
     if(isset($_POST['post1'])){
         $bid=$_POST['bidding'];
         $sql1="INSERT INTO `bid` ( `product_id`, `username`, `currentime`,`bid_amount`) VALUES ('$productid', '$username', current_timestamp(),'$bid')";
         $result1=mysqli_query($conn,$sql1);
         echo '<script>alert("You have successfully given a bid for this product")</script>';
     }else if(isset($_POST['update'])){
         header('location:update.php?product_id='.$productid);
         echo '<script>alert("You have successfully updated your product")</script>';
     }
     else if(isset($_POST['delete'])){
      $sql2=" DELETE FROM `products` WHERE `products`.`product_id` = $productid";
      $result2=mysqli_query($conn,$sql2);
      header('location:myproducts.php?username='.$username);
      echo '<script>alert("You have successfully deleted your product")</script>';
     }
     else if(isset($_POST['comment'])){
         $desc=$_POST['desc'];
         $sql3="INSERT INTO `comments` ( `product_id`, `username`, `currentime`, `comment`) VALUES ( '$productid', '$username', current_timestamp(), '$desc');";
         $result3=mysqli_query($conn,$sql3);
         echo '<script>alert("Your comment has been successfully accepted")</script>';
     }

  

$sql5="Select * from comments where product_id='$productid'";
$result5=mysqli_query($conn,$sql5);
while($rows=mysqli_fetch_assoc($result5)){
   $id=$rows['id'];
   if(isset($_POST[$id.'up'])){
       header('location:update1.php?comment_id='.$id.'&product_id='.$productid);
       echo '<script>alert("You have successfully updated your comment")</script>';
   }
   else if(isset($_POST[$id.'dl'])){
       $sql6="DELETE FROM `comments` WHERE `comments`.`id` = $id";
       $result6=mysqli_query($conn,$sql6);
       echo '<script>alert("You have successfully deleted your comment")</script>';
   }
}
     
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">

<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<link href='assets/jquery-bar-rating/dist/themes/fontawesome-stars.css' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="assets/jquery-bar-rating/dist/jquery.barrating.min.js" type="text/javascript"></script>
    <title>Hello, world!</title>
  </head>
  <script>
    $(function() {
 $('.rating').barrating({
  theme: 'fontawesome-stars',
  onSelect: function(value, text, event) {
    
    alert("You have successfully given rating to this product");
 
   var el = this;
   var el_id = el.$elem.data('id');

   
   if (typeof(event) !== 'undefined') {
 
     var split_id = el_id.split("_");
     var productid = split_id[1]; 

    
     $.ajax({
       url: 'rating_ajax.php',
       type: 'post',
       data: {productid:productid,rating:value},
       dataType: 'json',
       success: function(data){
        
         var average = data['averageRating'];
         $('#avgrating_'+productid).text(average);
       }
     });
   }
  }
 });
});
    </script>

  <body>
 <?php include 'header.php' ?>

 <?php 
 $sql="Select * from products where product_id='$productid'";
 $result=mysqli_query($conn,$sql);
 $rows=mysqli_fetch_assoc($result);
$admin_username=$rows['username'];
$sql2="Select * from bid WHERE product_id='$productid' order by `bid`.`bid_amount` DESC";
$result2=mysqli_query($conn,$sql2);
$rows2=mysqli_fetch_assoc($result2);
$hbid=$rows2['bid_amount'];


 echo '<div class="container">';
$productid=$_GET['product_id'];
$sql7="Select * from `rating table` where product_id='$productid' and username='$username'";
$result7=mysqli_query($conn,$sql7);
$fetchRating = mysqli_fetch_array($result7);
  $rating = $fetchRating['stars'];
  $query = "SELECT ROUND(AVG(stars),1) as averageRating FROM `rating table` WHERE product_id='$productid'";
  $avgresult = mysqli_query($conn,$query);
  $fetchAverage = mysqli_fetch_array($avgresult);
  $averageRating = $fetchAverage['averageRating'];
  if($averageRating <= 0){
    $averageRating = "No rating yet.";
   }
   
echo '<div class="jumbotron">
<h1 class="display-4 text-center">'.$rows['product_name'].'</h1>';
if($hbid==null){
    echo '<h5 class="card-title text-center">Highest Bid:No biddings yet</h5>';
   }else{
   echo '<h5 class="card-title text-center">Highest Bid:'.$hbid.'</h5>';
   }

echo '<img src="uploads/'.$rows['product_name'].'.'.$rows['ext'].'" width="1200px" height ="400px" style="position:absolute,left:0px">
<p class="lead mt-4"><strong>Description :</strong>'.$rows['product_description'].'</p>

<select class="rating" id="rating_ '.$productid.'" data-id="rating_'. $productid.' " style="display:none">

    <option value="1" >1</option>
    <option value="2" >2</option>
    <option value="3" >3</option>
    <option value="4" >4</option>
    <option value="5" >5</option>
   </select>
 
   </div>
   <div style="clear: both;"></div>
   Average Rating : <span id="avgrating_'. $productid.'">'. $averageRating.'</span>

<hr class="my-4"> 

</div></div>
<script> 
$(document).ready(function(){
    $("#rating_'.$productid .'").barrating("set",'.$rating.');
   })
</script>';
?>




<?php date_default_timezone_set("Asia/Calcutta");
echo'<div class="container"><form action="" method="post">';
   $time=strtotime($rows['time']);
     if($time>time()){
    echo' <label for="post1" class="form-label text-center">Enter Bidding for this product</label>
    <input type="text" class="form-control" name="bidding" id="">';
    if($time-time()>7200){
        
        echo '<h3 style="color:green">Ending time of bid : '.date("y-m-d H:i:s",$time).' </h3>';
    }else{
        echo '<h3 style="color:red">Ending time of bid '.date("y-m-d H:i:s",$time).'. If you want to bid then do it asap </h3>';
    }
    echo' <button type="submit" class="btn btn-primary mt-4 mx-4" name="post1" >Add Bidding</button>';
     
     }else{
       
         echo '<h2>The bid for this product has been closed</h2>';
     }
     if($rows['username']==$username){
      echo '<button type="submit" class="btn btn-primary mt-4 mx-4" name="update">Update Product</button>';
      echo '<button type="submit" class="btn btn-primary mt-4 mx-4" name="delete">Delete Product</button>';
     }
echo '</form></div>';


$sql2="Select * from bid WHERE product_id='$productid' order by `bid`.`bid_amount` DESC";
$result2=mysqli_query($conn,$sql2);
if($username==$admin_username){
    echo '<h2 class="text-center mt-4">Bidding participants</h2>';
while($row=mysqli_fetch_assoc($result2)){
    echo '
     <div style="border:2px solid black; margin:10px">
    <h4>Bidded by '.$row['username'].'</h4>
    <h4>Bidding amount: '.$row['bid_amount'].'</h4></div>';
}
}

echo '<h3 class="text-center">Add an comment from here</h3><div class="container"><form action="" method="post">
<div class="mb-3 ">
<label for="title" class="form-label">Type a comment</label>
<textarea name="desc" id="" cols="30" rows="3" class="form-control"></textarea>
</div>
<button type="submit" class="btn btn-primary" name="comment">Submit</button>
    
</form> </div>';

$sql4="Select * from comments where product_id='$productid'";
$result4=mysqli_query($conn,$sql4);

    echo '<h2 class="text-center mt-4">Past Comments</h2>';
while($row=mysqli_fetch_assoc($result4)){
    echo '
     <div style="border:2px solid black; margin:10px">
    <h4>Commented by '.$row['username'].'</h4>
    <p> '.$row['comment'].'</p></div>';

       if($username==$row['username']){
           echo '<form action="" method="post">  
           <button type="submit" class="btn btn-primary" name="'.$row['id'].'up">Update</button>
           <button type="submit" class="btn btn-primary" name="'.$row['id'].'dl">Delete</button>
           </form>';
       }
   
}
?>

</body>



</html>
