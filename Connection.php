<?php
$Server="localhost";
$Username="root";
$Password="manager";
$Connection=mysqli_connect($Server,$Username,$Password);
if($Connection){
    // echo "Welcome To PHP With MYSQL";
}else{
    die(mysqli_error($Connection));
}
?>