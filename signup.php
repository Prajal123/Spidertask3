<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <title>Hello, world!</title>
  </head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <body>
    

<?php  include 'header.php'?>
<?php
 include 'config.php';
 if($_SERVER["REQUEST_METHOD"]=='POST'){
     $username=$_POST['username'];
     $password=$_POST['password'];
     $cpassword=$_POST['cpassword'];
     $sql="SELECT * FROM `user` WHERE email='$username'";
     $result=mysqli_query($conn,$sql);
     $num=mysqli_num_rows($result);
     if($num>0){
      echo '<script>toastr.warning("Username already exist please enter a different username")</script>';
     }else{
         if($cpassword==$password){
           $hash=password_hash($password,PASSWORD_DEFAULT);
           $sql1=" INSERT INTO `user` ( `email`, `password`, `time`) VALUES ( '$username', '$hash', current_timestamp()) ";
           $result1=mysqli_query($conn,$sql1);
           header('location:profile.php');
         }else{
            echo '<script>toastr.warning("Confirm password did not match with password")</script>';
         }
     }
 }
?>

<div class="container">
<h2 class="h2">Please Signup here</h2>

<form action="" method="post">
  <div class="mb-3">
    <label for="Username" class="form-label">Username</label>
    <input type="email" class="form-control" name="username">
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" name="password" class="form-control">
  </div>
  <div class="mb-3">
    <label for="cpassword" class="form-label">Confirm Password</label>
    <input type="password" name="cpassword" class="form-control">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</body>
</html>