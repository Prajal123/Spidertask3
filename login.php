<?php
include 'config.php';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $username=$_POST['username'];
    $password=$_POST['password'];
   $sql="Select * from user where email='$username'";
   $result=mysqli_query($conn,$sql);
   $login=true;
   if(mysqli_num_rows($result)==1){

    while($row=mysqli_fetch_assoc($result)){

      if(password_verify($password,$row['password'])){
        $login=false;
      }
    }
  }
    if(!$login){
    session_start();
    $_SESSION['username']=$username;
    $_SESSION['password']=$password;
    $_SESSION['loggedin']=true;

    header("location:public.php");
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

<div class="container">
    <h2>Please login here</h2>
</div>
<body>

 <div class="container">
<form action="" method="post">
  <div class="mb-3">
    <label for="Username" class="form-label">Username</label>
    <input type="email" class="form-control" name="username">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
  </body>
</html>