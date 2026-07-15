<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit();
}

include("./lib/connect.php");

if(!isset($_GET['id'])){
    header("Location: homepage.php");
    exit();
}

$id = (int)$_GET['id'];

$sql = "SELECT * FROM sanpham WHERE id='$id'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)==0){
    header("Location: homepage.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

$thongbao="";

if(isset($_POST['btnSua'])){

    $tensp=mysqli_real_escape_string($conn,$_POST['tensp']);
    $gia=$_POST['gia'];
    $soluong=$_POST['soluong'];
    $hinhanh=$_POST['hinhanh'];

    $update="UPDATE sanpham SET

    tensp='$tensp',
    gia='$gia',
    soluong='$soluong',
    hinhanh='$hinhanh'

    WHERE id='$id'";

    if(mysqli_query($conn,$update)){

        header("Location: homepage.php");
        exit();

    }else{

        $thongbao='<div class="alert alert-danger">Lỗi: '.mysqli_error($conn).'</div>';

    }

}
?>

<!doctype html>
<html lang="vi">

<head>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Sửa sản phẩm</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>

body{
background:#f5f5f7;
font-family:Segoe UI;
}

.sidebar-box{
background:#1f2937;
color:#fff;
min-height:100vh;
}

.sidebar-box .nav-link{
color:#d1d5db;
padding:12px 18px;
border-radius:10px;
transition:.3s;
}

.sidebar-box .nav-link:hover{
background:#2563eb;
color:#fff;
padding-left:28px;
}

.header-box{
background:#fff;
border-radius:15px;
padding:20px;
margin-bottom:30px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.product-card{
border:none;
border-radius:18px;
box-shadow:0 5px 18px rgba(0,0,0,.08);
}

.form-control{
height:48px;
border-radius:10px;
}

.btn-save{
background:#d70018;
color:#fff;
border:none;
}

.btn-save:hover{
background:#b00015;
color:#fff;
}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<div class="col-xl-2 col-lg-3 col-md-4 sidebar-box p-3">

<div class="mb-4">

<h4 class="text-white">

<i class="bx bx-mobile-alt"></i>

TECH STORE

</h4>

<p>

Xin chào

<b><?php echo $_SESSION['login_user']; ?></b>

</p>

</div>

<hr>

<?php include("sidebarmenu.php"); ?>

</div>

<div class="col-xl-10 col-lg-9 col-md-8 p-4">

<div class="header-box d-flex justify-content-between">

<div>

<h3>SỬA SẢN PHẨM</h3>

<p>Cập nhật thông tin điện thoại</p>

</div>

<a href="homepage.php" class="btn btn-outline-primary">

<i class="bx bx-arrow-back"></i>

Quay lại

</a>

</div>

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card product-card">

<div class="card-body p-4">

<?php echo $thongbao;?>

<form method="POST">

<div class="mb-3">

<label class="fw-bold">

Tên điện thoại

</label>

<input
type="text"
name="tensp"
class="form-control"
value="<?php echo $row['tensp'];?>"
required>

</div>

<div class="row">

<div class="col-md-6 mb-3">

<label class="fw-bold">

Giá bán

</label>

<input
type="number"
name="gia"
class="form-control"
value="<?php echo $row['gia'];?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold">

Số lượng

</label>

<input
type="number"
name="soluong"
class="form-control"
value="<?php echo $row['soluong'];?>"
required>

</div>

</div>

<div class="mb-4">

<label class="fw-bold">

Tên file ảnh

</label>

<input
type="text"
name="hinhanh"
class="form-control"
value="<?php echo $row['hinhanh'];?>">

</div>

<div class="text-end">

<button
type="submit"
name="btnSua"
class="btn btn-save">

<i class="bx bx-save"></i>

Cập nhật

</button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</body>

</html>