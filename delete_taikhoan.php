<?php
session_start();

if(!isset($_SESSION['login_user'])){
    header("Location:index.php");
    exit();
}

include("./lib/connect.php");

$username=$_GET['username'];

mysqli_query($conn,"DELETE FROM taikhoan WHERE username='$username'");

header("Location:taikhoan.php");
exit();
?>