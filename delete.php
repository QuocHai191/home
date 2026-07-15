<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit();
}

include("./lib/connect.php");

if(isset($_GET['id'])){

    $id = (int)$_GET['id'];

    $sql = "DELETE FROM sanpham WHERE id='$id'";

    if(mysqli_query($conn,$sql)){
        header("Location: homepage.php");
        exit();
    }else{
        echo "Lỗi: ".mysqli_error($conn);
    }

}else{

    header("Location: homepage.php");
    exit();

}
?>