<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location:index.php");
    exit();
}

include("./lib/connect.php");

if($_SESSION['quyen']!=1){
    header("Location:tranguser.php");
    exit();
}
?>

<!doctype html>
<html lang="vi">

<head>

<meta charset="utf-8">

<title>Quản lý đơn hàng</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>

body{
background:#f5f5f7;
font-family:'Segoe UI';
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
}

.sidebar-box .nav-link:hover{
background:#2563eb;
color:#fff;
}

.header-box{
background:#fff;
padding:25px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
margin-bottom:25px;
}

.card-table{
background:#fff;
padding:20px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,.08);
}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<div class="col-lg-2 sidebar-box p-3">

<h4>
<i class="bx bx-mobile"></i>
TECH STORE
</h4>

<p>
Xin chào
<b><?=$_SESSION['login_user']?></b>
</p>

<hr>

<?php include("sidebarmenu.php"); ?>

</div>

<div class="col-lg-10 p-4">

<div class="header-box">

<h2>
<i class="bx bx-package"></i>
QUẢN LÝ ĐƠN HÀNG
</h2>

<p>Danh sách đơn hàng của khách hàng</p>

</div>

<div class="card-table">

<table class="table table-hover">

<thead class="table-dark">

<tr>

<th>Mã HĐ</th>

<th>Khách hàng</th>

<th>Ngày đặt</th>

<th>Tổng tiền</th>

<th>Chi tiết</th>

</tr>

</thead>

<tbody>

<?php

$sql = "
SELECT
    hoadon.*,
    taikhoan.fullname
FROM hoadon
INNER JOIN taikhoan
ON hoadon.username = taikhoan.username
ORDER BY hoadon.mahd DESC
";

$rs=mysqli_query($conn,$sql);

while($hd=mysqli_fetch_assoc($rs)){

$tong=0;

$ct=mysqli_query($conn,"
SELECT *
FROM chitiethoadon
WHERE mahd='".$hd['mahd']."'
");

while($r=mysqli_fetch_assoc($ct)){

$tong += $r['gia']*$r['soluong'];

}

?>

<tr>

<td>#<?=$hd['mahd']?></td>

<td><?=$hd['fullname']?></td>

<td><?=$hd['ngaylap']?></td>

<td><?=number_format($tong,0,",",".")?> đ</td>

<td>

<a
href="chitietdonhang_admin.php?mahd=<?=$hd['mahd']?>"
class="btn btn-primary btn-sm">

<i class="bx bx-show"></i>

Xem

</a>

</td>

</tr>

<?php
}
?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</body>
</html>