<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location:index.php");
    exit();
}

include("./lib/connect.php");

if (!isset($_GET['id'])) {
    header("Location:tranguser.php");
    exit();
}

$id = (int)$_GET['id'];

// Kiểm tra sản phẩm có tồn tại không
$sql = "SELECT * FROM sanpham WHERE id='$id'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==0){
    header("Location:tranguser.php");
    exit();
}

// Nếu chưa có giỏ hàng
if(!isset($_SESSION['giohang'])){
    $_SESSION['giohang']=array();
}

// Nếu sản phẩm đã có thì tăng số lượng
if(isset($_SESSION['giohang'][$id])){

    $_SESSION['giohang'][$id]++;

}else{

    $_SESSION['giohang'][$id]=1;

}

header("Location:giohang.php");
exit();
?>