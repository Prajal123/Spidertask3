<?php
include 'config.php';
session_start();
if(!isset($_SESSION['loggedin'])){
 header('location:login.php');
 exit;
}
$username=$_SESSION['username'];
$productid=$_GET['product_id'];
$sql="Select * from products where product_id='$productid'";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_assoc($result);
if($_SERVER['REQUEST_METHOD']=='POST'){
    if($rows['username']==$username){
    $title=$_POST['title'];
    $desc=$_POST['desc'];
    $sql1="UPDATE `products` SET `product_description` = '$desc',`product_name`='$title' WHERE `products`.`product_id` = $productid";
    $result1=mysqli_query($conn,$sql1);
    header('location:displayproduct.php?product_id='.$productid);
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
 
 <?php include 'header.php' ?>

 <form action="" method="post">
 <div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control" name="title">
  </div>
  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <br>
    <textarea name="desc" id="" cols="30" rows="10" class="form-control"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
 </form>

