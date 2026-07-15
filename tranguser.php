<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['quyen'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['quyen'] == 1) {
    header("Location: homepage.php");
    exit();
}

include("./lib/connect.php");
// Lấy thông tin người dùng
$username = $_SESSION['login_user'];

$sqlUser = "SELECT fullname FROM taikhoan WHERE username='$username'";
$resultUser = mysqli_query($conn, $sqlUser);

if ($resultUser && mysqli_num_rows($resultUser) > 0) {
    $rowUser = mysqli_fetch_assoc($resultUser);
    $fullname = $rowUser['fullname'];
} else {
    $fullname = $username;
}
$demgio = 0;

if(isset($_SESSION['giohang'])){
    $demgio = array_sum($_SESSION['giohang']);
}
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>TECH STORE - Trang người dùng</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f7;
    font-family:'Segoe UI',sans-serif;
}

/* Sidebar */

.sidebar-box{
    background:#1f2937;
    min-height:100vh;
    color:#fff;
}

.sidebar-box h4{
    color:#fff;
    font-weight:bold;
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

/* Header */

.header-box{
    background:#fff;
    border-radius:15px;
    padding:25px 30px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    margin-bottom:30px;
}

.page-title{
    font-size:30px;
    font-weight:bold;
}

.page-subtitle{
    color:#666;
}

/* Product */

.product-card{
    border:none;
    border-radius:18px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 4px 15px rgba(0,0,0,.08);
    transition:.3s;
    position:relative;
}

.product-card:hover{
    transform:translateY(-8px);
    box-shadow:0 10px 30px rgba(0,0,0,.18);
}

.sale-tag{
    position:absolute;
    top:12px;
    left:12px;
    background:#d70018;
    color:#fff;
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:bold;
}

.img-container{
    height:240px;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.product-img{
    max-width:90%;
    max-height:190px;
}

.product-name{
    height:48px;
    font-weight:600;
    overflow:hidden;
}

.price{
    color:#d70018;
    font-size:24px;
    font-weight:bold;
}

.old-price{
    text-decoration:line-through;
    color:#888;
}

.stock{
    display:inline-block;
    background:#eefaf1;
    color:#0f9d58;
    padding:5px 12px;
    border-radius:30px;
    font-size:13px;
}

.rating{
    color:#ffc107;
}

.btn-view{
    background:#2563eb;
    color:#fff;
}

.btn-view:hover{
    background:#1d4ed8;
    color:#fff;
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
<p>
Xin chào
<b><?php echo htmlspecialchars($fullname); ?></b>
</p>

<ul class="nav flex-column">

<!-- Trang chủ -->
<li class="nav-item mb-2">
    <a href="tranguser.php" class="nav-link">
        <i class="bx bx-home"></i>
        Trang chủ
    </a>
</li>

<!-- Giỏ hàng -->
<li class="nav-item mb-2">
    <a href="giohang.php" class="nav-link d-flex justify-content-between align-items-center">
        <span>
            <i class="bx bx-cart"></i>
            Giỏ hàng
        </span>

        <span class="badge bg-danger">
            <?php echo $demgio; ?>
        </span>
    </a>
</li>

<!-- Đơn hàng -->
<li class="nav-item mb-2">
    <a href="donhang.php" class="nav-link">
        <i class="bx bx-receipt"></i>
        Đơn hàng
    </a>
</li>

<hr>

<!-- Đăng xuất -->
<li class="nav-item mt-3">
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

<h3 class="page-title">
CỬA HÀNG ĐIỆN THOẠI TECH STORE
</h3>

<p class="page-subtitle">
Chào mừng bạn đến với cửa hàng điện thoại.
</p>

</div>

<div class="row">

<?php

$sql="SELECT * FROM sanpham";
$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

$hinhanh=!empty($row['hinhanh']) && file_exists("img/".$row['hinhanh'])
? "img/".$row['hinhanh']
: "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400";

?>

<div class="col-xl-3 col-lg-4 col-md-6 mb-4">

<div class="card product-card h-100">

<span class="sale-tag">
HOT
</span>

<div class="img-container">

<img src="<?php echo $hinhanh; ?>" class="product-img">

</div>

<div class="card-body">

<div class="product-name mb-2">

<?php echo $row['tensp']; ?>

</div>

<div class="rating mb-2">
★★★★★
</div>

<div class="price">

<?php echo number_format($row['gia'],0,",","."); ?> ₫

</div>

<div class="old-price mb-3">

<?php echo number_format($row['gia']*1.1,0,",","."); ?> ₫

</div>

<div class="stock mb-3">

Còn <?php echo $row['soluong']; ?> sản phẩm

</div>

<a href="themgiohang.php?id=<?php echo $row['id'];?>"
class="btn btn-success w-100">

<i class="bx bx-cart-add"></i>

Thêm giỏ hàng
</a>

</div>

</div>

</div>

<?php

}

}else{

echo '

<div class="col-12">

<div class="alert alert-warning text-center">

Chưa có sản phẩm.

</div>

</div>

';

}

?>

</div>

</div>

</div>

</div>

</body>
</html>