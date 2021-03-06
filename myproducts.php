<?php
include 'config.php';
session_start();
if(!isset($_SESSION['loggedin'])){
 header('location:login.php');
 exit;
}
$username=$_SESSION['username'];
if($_SERVER['REQUEST_METHOD']=='POST'){
    $pname=$_POST['title'];
    $pdesc=$_POST['desc'];

    $time=$_POST['time'];
    
    $info=pathinfo($_FILES['file']['name']);
    $ext=$info['extension'];
    $fileName=$pname.".".$ext;
    $file_type=$_FILES['file']['type'];
    $file_size=$_FILES['file']['size'];
    $file_tmp_loc=$_FILES['file']['tmp_name'];
    $file_store="uploads/".$fileName;
   
    move_uploaded_file($file_tmp_loc,$file_store);


    $sql="INSERT INTO `products` ( `product_name`, `product_description`, `created`, `username`,`ext`,`time`) VALUES ( '$pname', '$pdesc', current_timestamp(), '$username','$ext','$time')";
    $result=mysqli_query($conn,$sql);
     
    echo '<script>toaster.success("Your product has been included in Auction successfully")</script>';
  
    
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

    <title>Hello, world!</title>
  </head>
 
 <?php include 'header.php' ?>

 <div class="container">
     <h2>Add a new product by this form</h2>
<form action="" method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" name="title">
  </div>
  <input type="file" class="btn btn-success" name="file" id="">
  <div class="mb-3">
    <label for="title" class="form-label">Description</label>
    <textarea name="desc" id="" cols="30" rows="10" class="form-control"></textarea>
  </div>
  <div class="mb-3">
    <label for="title" class="form-label">Till what date do you want bidding? Please enter like YYYY-MM-DD HH:MM:SS </label>
    <input type="text" class="form-control" name="time" id="">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

<?php
$sql1="SELECT * FROM `products` WHERE username='$username'";
$result1=mysqli_query($conn,$sql1);
echo '<div class="container my-2"><div class="row ">';
while($rows=mysqli_fetch_assoc($result1)){
  $id=$rows['product_id'];
  $sql2="Select * from bid WHERE product_id='$id' order by `bid`.`bid_amount` DESC";
  $result2=mysqli_query($conn,$sql2);
  $rows2=mysqli_fetch_assoc($result2);
  $hbid=$rows2['bid_amount'];
echo'<div class="col-md-4 my-2"><div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title text-center">'.$rows['product_name'].'</h5>';
    if($hbid==null){
      echo '<h5 class="card-title text-center">Highest Bid:No biddings yet</h5>';
     }else{
     echo '<h5 class="card-title text-center">Highest Bid:'.$hbid.'</h5>';
     }
   echo'<img src="uploads/'.$rows['product_name'].'.'.$rows['ext'].'" width="200px" height ="100px">
    <p class="card-text">'.substr($rows['product_description'],0,20).'....</p>
    <a href="displayproduct.php?product_id='.$rows['product_id'].'" class="btn btn-primary" >Go to Product</a> 
  </div>
  </div></div>';
}
echo '</div></div>';
?>

