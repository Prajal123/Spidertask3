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
     }else if(isset($_POST['update'])){
         header('location:update.php?product_id='.$productid);
     }
     else if(isset($_POST['delete'])){
      $sql2=" DELETE FROM `products` WHERE `products`.`product_id` = $productid";
      $result2=mysqli_query($conn,$sql2);
      header('location:myproducts.php?username='.$username);
     }
     else if(isset($_POST['comment'])){
         $desc=$_POST['desc'];
         $sql3="INSERT INTO `comments` ( `product_id`, `username`, `currentime`, `comment`) VALUES ( '$productid', '$username', current_timestamp(), '$desc');";
         $result3=mysqli_query($conn,$sql3);
     }

  

$sql5="Select * from comments where product_id='$productid'";
$result5=mysqli_query($conn,$sql5);
while($rows=mysqli_fetch_assoc($result5)){
   $id=$rows['id'];
   if(isset($_POST[$id.'up'])){
       header('location:update1.php?comment_id='.$id.'&product_id='.$productid);
   }
   else if(isset($_POST[$id.'dl'])){
       $sql6="DELETE FROM `comments` WHERE `comments`.`id` = $id";
       $result6=mysqli_query($conn,$sql6);
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

    <title>Hello, world!</title>
  </head>
 
  <body>
 <?php include 'header.php' ?>

 <?php 
 $sql="Select * from products where product_id='$productid'";
 $result=mysqli_query($conn,$sql);
 $rows=mysqli_fetch_assoc($result);
$admin_username=$rows['username'];
 echo '<div class="container">
 <div class="jumbotron">
  <h1 class="display-4 text-center">'.$rows['product_name'].'</h1>
  <p class="lead">'.$rows['product_description'].'</p>
  <hr class="my-4"> 
</div>
</div>';

echo'<div class="container"><form action="" method="post">';
     if(set_time_limit(10)){
    echo' <label for="post1" class="form-label text-center">Enter Bidding for this product</label>
    <input type="text" class="form-control" name="bidding" id="">
     <button type="submit" class="btn btn-primary mt-4 mx-4" name="post1" >Add Bidding</button>';
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
