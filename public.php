<?php
include 'config.php';
session_start();
if(!isset($_SESSION['loggedin'])){
 header('location:login.php');
 exit;
}
$username=$_SESSION['username'];
 if($_SERVER['REQUEST_METHOD']=='POST'){
     header('location:myproducts.php?username='.$username);
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


<body>
<div class="container">
    <h2>Welcome to Auction-Products</h2>
</div>
<form action="" method="post">
<button class="btn btn-primary">My Products</button>
</form>

<?php
$sql1="SELECT * FROM `products`";
$result1=mysqli_query($conn,$sql1);
echo '<div class="container"><div class="row" >';
while($rows=mysqli_fetch_assoc($result1)){
  $id=$rows['product_id'];
  $sql2="Select * from bid WHERE product_id='$id' order by `bid`.`bid_amount` DESC";
  $result2=mysqli_query($conn,$sql2);
  $rows2=mysqli_fetch_assoc($result2);
  $hbid=$rows2['bid_amount'];
echo'<div class="col-md-4 my-2"><div class="card " style="width: 18rem;">
  <img src="..." class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title text-center">'.$rows['product_name'].'</h5>
    <h5 class="card-title text-center">Highest Bid:'.$hbid.'</h5>
    <p class="card-text">'.substr($rows['product_description'],0,20).'....</p>
    <a href="displayproduct.php?product_id='.$rows['product_id'].'" class="btn btn-primary" >Go to Product</a> 
  </div>
  </div></div>';
}
echo '</div></div>';
?>
  </body>
</html>