<?php
session_start();
// Nếu tài khoản đã đăng nhập rồi thì tự động chuyển thẳng vào trang chủ homepage.php
if (isset($_SESSION['login_user'])) {
    header("Location: homepage.php");
    exit();
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <title>Đăng nhập - Hệ thống quản lý điện thoại</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>

<style>
body{
    background:linear-gradient(135deg,#1e3a8a,#2563eb);
    min-height:100vh;
    font-family:'Segoe UI',sans-serif;
}

.login-box{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 20px 50px rgba(0,0,0,.25);
}

.login-header{
    background:linear-gradient(90deg,#1e3a8a,#2563eb);
    padding:35px;
    text-align:center;
    color:#fff;
}

.login-header i{
    font-size:65px;
    margin-bottom:10px;
}

.login-header h2{
    font-weight:700;
    margin-bottom:5px;
}

.login-header p{
    opacity:.9;
}

.form-control{
    height:50px;
    border-radius:12px;
}

.form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 .15rem rgba(37,99,235,.25);
}

.btn-login{
    background:linear-gradient(90deg,#2563eb,#1d4ed8);
    color:#fff;
    border:none;
    height:50px;
    border-radius:12px;
    font-size:17px;
    font-weight:600;
    transition:.3s;
}

.btn-login:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(37,99,235,.3);
}

.logo{
    font-size:40px;
    margin-bottom:10px;
}

.footer-text{
    color:#fff;
}

.footer-text a{
    color:#fff;
    font-weight:bold;
    text-decoration:none;
}
</style>

<div class="container">

<div class="row justify-content-center align-items-center" style="min-height:100vh;">

<div class="col-lg-5">

<div class="login-box">

<div class="login-header">

<div class="logo">
<i class="bx bx-mobile-alt"></i>
</div>

<h2>TECH STORE</h2>

<p>Hệ thống quản lý cửa hàng điện thoại</p>

</div>

<div class="p-4">

<?php
if (isset($_SESSION['loi_dangnhap'])) {
echo '<div class="alert alert-danger text-center">'.$_SESSION['loi_dangnhap'].'</div>';
unset($_SESSION['loi_dangnhap']);
}
?>

<form action="login.php" method="POST">

<div class="mb-3">

<label class="form-label fw-bold">
<i class="bx bx-user"></i>
Tài khoản
</label>

<input
type="text"
class="form-control"
name="taikhoan"
placeholder="Nhập tài khoản"
required>

</div>

<div class="mb-4">

<label class="form-label fw-bold">
<i class="bx bx-lock-alt"></i>
Mật khẩu
</label>

<input
type="password"
class="form-control"
name="matkhau"
placeholder="Nhập mật khẩu"
required>

</div>

<button
type="submit"
name="submit"
class="btn btn-login w-100">

<i class="bx bx-log-in-circle"></i>

ĐĂNG NHẬP

</button>

</form>

<hr>

<div class="text-center">

Chưa có tài khoản?

<a href="dangky.php">

Đăng ký ngay

</a>

</div>

</div>

</div>

<div class="text-center mt-4 footer-text">

© 2026 TECH STORE

</div>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</body>
</html>