<?php
include 'config.php';
session_start();
if(!isset($_SESSION['loggedin'])){
 header('location:login.php');
 exit;
}
$username=$_SESSION['username'];
$id=$_GET['comment_id'];
$productid=$_GET['product_id'];
 if($_SERVER['REQUEST_METHOD']=='POST'){
    $desc=$_POST['desc'];
     $sql="UPDATE comments SET comment= '$desc' WHERE `comments`.`id` = $id";
     $result=mysqli_query($conn,$sql);
     header('location:displayproduct.php?product_id='.$productid);
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
     <textarea name="desc" class="form-control mt-5" id="" cols="30" rows="3"></textarea>
    <button class="btn btn-primary">Submit</button>
 </form>