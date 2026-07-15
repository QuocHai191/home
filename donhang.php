<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location:index.php");
    exit();
}

include("./lib/connect.php");

$demgio = 0;
if(isset($_SESSION['giohang'])){
    $demgio = array_sum($_SESSION['giohang']);
}

$username = $_SESSION['login_user'];
?>

<!doctype html>
<html lang="vi">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Đơn hàng của tôi</title>

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
    margin-bottom:30px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.card{
    border:none;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.table th{
    background:#1f2937;
    color:#fff;
}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<!-- Sidebar -->

<div class="col-xl-2 col-lg-3 col-md-4 sidebar-box p-3">

<h4>
<i class="bx bx-mobile-alt"></i>
TECH STORE
</h4>

<p>
Xin chào
<b><?php echo $_SESSION['login_user']; ?></b>
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
<a href="giohang.php" class="nav-link d-flex justify-content-between">

<span>
<i class="bx bx-cart"></i>
Giỏ hàng
</span>

<span class="badge bg-danger">
<?php echo $demgio; ?>
</span>

</a>
</li>

<li class="nav-item mb-2">
<a href="donhang.php" class="nav-link bg-primary text-white">
<i class="bx bx-receipt"></i>
Đơn hàng
</a>
</li>

<hr>

<li class="nav-item">
<a href="logout.php" class="nav-link text-danger bg-white">
<i class="bx bx-log-out"></i>
Đăng xuất
</a>
</li>

</ul>

</div>

<!-- Content -->

<div class="col-xl-10 col-lg-9 col-md-8 p-4">

<div class="header-box">

<h3>
<i class="bx bx-receipt"></i>
ĐƠN HÀNG CỦA TÔI
</h3>

<p class="text-muted">
Lịch sử các đơn hàng đã đặt
</p>

</div>

<?php

$sql = "
SELECT
hd.mahd,
hd.ngaylap,
sp.tensp,
ct.soluong,
ct.gia
FROM hoadon hd
INNER JOIN chitiethoadon ct ON hd.mahd=ct.mahd
INNER JOIN sanpham sp ON ct.idsp=sp.id
WHERE hd.username='$username'
ORDER BY hd.mahd DESC
";

$result = mysqli_query($conn,$sql);

?>

<div class="card">

<div class="card-body">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>Mã HĐ</th>

<th>Ngày đặt</th>

<th>Sản phẩm</th>

<th>Số lượng</th>

<th>Đơn giá</th>

<th>Thành tiền</th>

<th>Trạng thái</th>

</tr>

</thead>

<tbody>

<?php

$tong = 0;

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

$thanhtien = $row['soluong'] * $row['gia'];

$tong += $thanhtien;

?>

<tr>

<td>

#<?php echo $row['mahd']; ?>

</td>

<td>

<?php echo date("d/m/Y H:i",strtotime($row['ngaylap'])); ?>

</td>

<td>

<?php echo $row['tensp']; ?>

</td>

<td>

<?php echo $row['soluong']; ?>

</td>

<td>

<?php echo number_format($row['gia'],0,",","."); ?> đ

</td>

<td>

<?php echo number_format($thanhtien,0,",","."); ?> đ

</td>

<td>

<span class="badge bg-success">

Đã đặt

</span>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="7" class="text-center">

Bạn chưa có đơn hàng nào.

</td>

</tr>

<?php

}

?>

</tbody>

<tfoot>

<tr>

<th colspan="5" class="text-end">

Tổng tiền đã mua

</th>

<th>

<?php echo number_format($tong,0,",","."); ?> đ

</th>

<th></th>

</tr>

</tfoot>

</table>

<div class="text-end">

<a href="tranguser.php" class="btn btn-primary">

<i class="bx bx-shopping-bag"></i>

Tiếp tục mua sắm

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</body>

</html>