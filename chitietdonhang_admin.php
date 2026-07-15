<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location:index.php");
    exit();
}

include("./lib/connect.php");

if ($_SESSION['quyen'] != 1) {
    header("Location:tranguser.php");
    exit();
}

if (!isset($_GET['mahd'])) {
    header("Location:quanlydonhang.php");
    exit();
}

$mahd = (int)$_GET['mahd'];

// Lấy thông tin hóa đơn
$sqlHD = "SELECT * FROM hoadon WHERE mahd='$mahd'";
$rsHD = mysqli_query($conn,$sqlHD);

if(mysqli_num_rows($rsHD)==0){
    header("Location:quanlydonhang.php");
    exit();
}

$hoadon = mysqli_fetch_assoc($rsHD);
?>

<!doctype html>
<html lang="vi">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Chi tiết đơn hàng</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f7;
    font-family:'Segoe UI',sans-serif;
}

.sidebar-box{
    background:#1f2937;
    min-height:100vh;
    color:#fff;
}

.sidebar-box .nav-link{
    color:#d1d5db;
    padding:12px 18px;
    border-radius:10px;
    transition:.3s;
    font-size:16px;
}

.sidebar-box .nav-link:hover{
    background:#2563eb;
    color:#fff;
    padding-left:28px;
}

.header-box{
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
    padding:25px;
}

.table td,
.table th{
    vertical-align:middle;
}

.info-box{
    background:#f8f9fa;
    border-radius:10px;
    padding:15px;
    margin-bottom:20px;
}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<!-- Sidebar -->

<div class="col-xl-2 col-lg-3 col-md-4 sidebar-box p-3">

<h4 class="mb-3">
<i class="bx bx-mobile-alt"></i>
TECH STORE
</h4>

<p>
Xin chào
<b><?php echo $_SESSION['login_user']; ?></b>
</p>

<hr>

<?php include("sidebarmenu.php"); ?>

</div>

<!-- Nội dung -->

<div class="col-xl-10 col-lg-9 col-md-8 p-4">

<div class="header-box d-flex justify-content-between align-items-center">

<div>

<h3>
<i class="bx bx-package"></i>
CHI TIẾT ĐƠN HÀNG <?php echo $mahd; ?>
</h3>

<p class="text-muted mb-0">
Thông tin chi tiết đơn hàng
</p>

</div>

<a href="quanlydonhang.php" class="btn btn-secondary">
<i class="bx bx-arrow-back"></i>
Quay lại
</a>

</div>

<div class="card-table">

<div class="info-box">

<div class="row">

<div class="col-md-4">
<strong>Mã đơn:</strong>
#<?php echo $hoadon['mahd']; ?>
</div>

<div class="col-md-4">
<strong>Khách hàng:</strong>
<?php echo $hoadon['username']; ?>
</div>

<div class="col-md-4">
<strong>Ngày đặt:</strong>
<?php echo $hoadon['ngaylap']; ?>
</div>

</div>

</div>

<table class="table table-hover">

<thead class="table-dark">

<tr>

<th>STT</th>

<th>Tên sản phẩm</th>

<th>Đơn giá</th>

<th>Số lượng</th>

<th>Thành tiền</th>

</tr>

</thead>

<tbody>

<?php

$stt=1;
$tong=0;

$sql="
SELECT sanpham.tensp,
       chitiethoadon.gia,
       chitiethoadon.soluong

FROM chitiethoadon

INNER JOIN sanpham

ON sanpham.id = chitiethoadon.idsp

WHERE mahd='$mahd'
";

$rs=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($rs)){

$thanhtien=$row['gia']*$row['soluong'];

$tong+=$thanhtien;

?>

<tr>

<td><?php echo $stt++; ?></td>

<td><?php echo $row['tensp']; ?></td>

<td><?php echo number_format($row['gia'],0,",","."); ?> đ</td>

<td><?php echo $row['soluong']; ?></td>

<td><?php echo number_format($thanhtien,0,",","."); ?> đ</td>

</tr>

<?php } ?>

<tr class="table-warning">

<th colspan="4" class="text-end">

TỔNG THANH TOÁN

</th>

<th>

<?php echo number_format($tong,0,",","."); ?> đ

</th>

</tr>

</tbody>

</table>

</div>

</div>

</div>

</div>

</body>

</html>