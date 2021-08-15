<?php
$servername="localhost";
$username="root";
$password="";
$database="auction";

$conn=mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    echo "Something went wrong";
}

?>
