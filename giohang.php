<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location:index.php");
    exit();
}

include("./lib/connect.php");

if (!isset($_SESSION['giohang'])) {
    $_SESSION['giohang'] = [];
}

// Xóa sản phẩm
if(isset($_GET['xoa'])){
    $id = (int)$_GET['xoa'];

    if(isset($_SESSION['giohang'][$id])){
        unset($_SESSION['giohang'][$id]);
    }

    header("Location: giohang.php");
    exit();
}

// Cập nhật số lượng
if(isset($_POST['capnhat'])){

    foreach($_POST['soluong'] as $id=>$sl){

        $id=(int)$id;
        $sl=(int)$sl;

        if($sl<=0){
            unset($_SESSION['giohang'][$id]);
        }else{
            $_SESSION['giohang'][$id]=$sl;
        }

    }

    header("Location: giohang.php");
    exit();
}

// Đặt hàng
if(isset($_POST['dathang'])){

    if(!empty($_SESSION['giohang'])){

        $username=$_SESSION['login_user'];

        mysqli_query($conn,"
        INSERT INTO hoadon(username,ngaylap)
        VALUES('$username',NOW())
        ");

        $mahd=mysqli_insert_id($conn);

        foreach($_SESSION['giohang'] as $id=>$sl){

            $rs=mysqli_query($conn,"SELECT * FROM sanpham WHERE id='$id'");

            if(mysqli_num_rows($rs)==0){
                continue;
            }

            $sp=mysqli_fetch_assoc($rs);

            $gia=$sp['gia'];

            mysqli_query($conn,"
            INSERT INTO chitiethoadon(mahd,idsp,soluong,gia)
            VALUES('$mahd','$id','$sl','$gia')
            ");

            mysqli_query($conn,"
            UPDATE sanpham
            SET soluong=soluong-$sl
            WHERE id='$id'
            ");

        }

        unset($_SESSION['giohang']);

        echo "<script>
        alert('Đặt hàng thành công!');
        location='tranguser.php';
        </script>";
        exit();
    }
}
?>

<!doctype html>
<html lang="vi">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Giỏ hàng</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f7;
    font-family:'Segoe UI',sans-serif;
}

.sidebar{
    background:#1f2937;
    min-height:100vh;
    color:#fff;
}

.sidebar h3{
    font-weight:bold;
}

.sidebar .nav-link{
    color:#d1d5db;
    padding:12px 18px;
    border-radius:10px;
    transition:.3s;
}

.sidebar .nav-link:hover{
    background:#2563eb;
    color:#fff;
}

.header{
    background:#fff;
    border-radius:15px;
    padding:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    margin-bottom:25px;
}

.card-table{
    background:#fff;
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.table td,
.table th{
    vertical-align:middle;
}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<!-- Sidebar -->

<div class="col-lg-2 sidebar p-3">

<h3>
<i class="bx bx-mobile"></i>
TECH STORE
</h3>

<p>
Xin chào
<b><?=$_SESSION['login_user']?></b>
</p>

<hr>

<ul class="nav flex-column">

<li class="nav-item mb-2">
<a href="tranguser.php" class="nav-link">
<i class="bx bx-home"></i>
Trang chủ
</a>
</li>

<li class="nav-item mb-2">
<a href="giohang.php" class="nav-link active bg-primary text-white">
<i class="bx bx-cart"></i>
Giỏ hàng
</a>
</li>
<li class="nav-item mb-2">
    <a href="donhang.php" class="nav-link">
        <i class="bx bx-package"></i>
        Đơn hàng
    </a>
</li>

<li class="nav-item mt-3">
<a href="logout.php" class="nav-link bg-white text-danger">
<i class="bx bx-log-out"></i>
Đăng xuất
</a>
</li>

</ul>

</div>

<!-- Content -->

<div class="col-lg-10 p-4">

<div class="header">

<h2>
<i class="bx bx-cart"></i>
GIỎ HÀNG CỦA BẠN
</h2>

<p class="text-muted">
Danh sách sản phẩm đã thêm vào giỏ hàng
</p>

</div>

<div class="card-table p-4">

<form method="post">

<table class="table table-hover">

<thead class="table-dark">

<tr>

<th>Tên sản phẩm</th>

<th>Đơn giá</th>

<th width="120">Số lượng</th>

<th>Thành tiền</th>

<th width="100">Xóa</th>

</tr>

</thead>

<tbody>

<?php

$tong=0;

if(!empty($_SESSION['giohang'])){

foreach($_SESSION['giohang'] as $id=>$sl){

$rs=mysqli_query($conn,"SELECT * FROM sanpham WHERE id='$id'");

if(mysqli_num_rows($rs)==0){
    continue;
}

$sp=mysqli_fetch_assoc($rs);

$tt=$sp['gia']*$sl;

$tong+=$tt;

?>

<tr>

<td><?=$sp['tensp']?></td>

<td><?=number_format($sp['gia'],0,",",".")?> đ</td>

<td>

<input
type="number"
class="form-control"
name="soluong[<?=$id?>]"
value="<?=$sl?>"
min="1">

</td>

<td><?=number_format($tt,0,",",".")?> đ</td>

<td>

<a
href="giohang.php?xoa=<?=$id?>"
class="btn btn-danger btn-sm">

<i class="bx bx-trash"></i>

</a>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="5" class="text-center">

Không có sản phẩm trong giỏ hàng

</td>

</tr>

<?php

}

?>

<tr>

<th colspan="3" class="text-end">

TỔNG TIỀN

</th>

<th>

<?=number_format($tong,0,",",".")?> đ

</th>

<th></th>

</tr>

</tbody>

</table>

<div class="text-end">

<button
type="submit"
name="capnhat"
class="btn btn-primary">

<i class="bx bx-refresh"></i>

Cập nhật

</button>

<button
type="submit"
name="dathang"
class="btn btn-success">

<i class="bx bx-credit-card"></i>

Đặt hàng

</button>

<a
href="tranguser.php"
class="btn btn-secondary">

Tiếp tục mua

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</body>
</html>