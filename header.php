<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Auction</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php
        if(!$_SESSION['loggedin']){
        echo'<li class="nav-item">
          <a class="nav-link active" style="position:absolute;left:100px;bottom:8px" href="signup.php">Signup</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link active" style="position:absolute;left:200px;bottom:8px" href="login.php">Login</a>
        </li></ul>';
        }else{

            echo'
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="logout.php">Logout</a>
        </li>
        <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="public.php">Home</a>
      </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="profile.php">'.$_SESSION['username'].'</a>
        </li>
      </ul>';
        }
      ?>
      <form class="d-flex" action="search.php" method="get" >
        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-success"  type="submit">Search</button>
      </form>
   
  </div>
</nav>