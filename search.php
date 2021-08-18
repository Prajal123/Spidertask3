<?php
include 'config.php';
session_start();
if(!isset($_SESSION['loggedin'])){
 header('location:login.php');
 exit;
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

<div class="container">
    <h2>Search Results for <?php echo $_GET['search']?></h2>
</div>

<?php
$query=$_GET['search'];
  $sql="Select * from products where match (product_name,product_description) against ('$query')";
  $result=mysqli_query($conn,$sql);
  echo '<div class="container"><div class="row" >';
  $noresults=true;
  while($rows=mysqli_fetch_assoc($result)){
    $id=$rows['product_id'];
  $noresults=false;
  $sql2="Select * from bid WHERE product_id='$id' order by `bid`.`bid_amount` DESC";
  $result2=mysqli_query($conn,$sql2);
  $rows2=mysqli_fetch_assoc($result2);
  $hbid=$rows2['bid_amount'];
  echo'<div class="col-md-4 my-2"><div class="card " style="width: 18rem;">

   <div class="card-body"><h5 class="card-title text-center">'.$rows['product_name'].'</h5>';
   if($hbid==null){
    echo '<h5 class="card-title text-center">Highest Bid:No biddings yet</h5>';
   }else{
   echo '<h5 class="card-title text-center">Highest Bid:'.$hbid.'</h5>';
   }
    echo' <img src="uploads/'.$rows['product_name'].'.'.$rows['ext'].'" width="200px" height ="100px">
      <p class="card-text">'.substr($rows['product_description'],0,20).'....</p>
      <a href="displayproduct.php?product_id='.$rows['product_id'].'" class="btn btn-primary" >Go to Product</a> 
    </div>
    </div></div>';
  }
  echo '</div></div>';
  if($noresults){
    echo '<div class="jumbotron">
  <div class="container">
    <h1 class="display-4">No results found</h1>
    <p class="lead">Suggestions:
    <ul>
    <li>Make sure that all words are spelled correctly.</li>
    <li>Try different keywords.</li>
    <li>Try more general keywords.</li>
    </ul>
    </p>
  </div>
</div>';
  }


?>


  </body>
</html>