<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit();
}

include("./lib/connect.php");

if (!isset($_GET['username'])) {
    header("Location: taikhoan.php");
    exit();
}

$username = mysqli_real_escape_string($conn, $_GET['username']);

$sql = "SELECT * FROM taikhoan WHERE username='$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header("Location: taikhoan.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

$thongbao = "";

if (isset($_POST['btnSua'])) {

    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $quyen = (int)$_POST['quyen'];

    $update = "UPDATE taikhoan SET
                password='$password',
                fullname='$fullname',
                quyen='$quyen'
                WHERE username='$username'";

    if (mysqli_query($conn, $update)) {
        header("Location: taikhoan.php");
        exit();
    } else {
        $thongbao = '<div class="alert alert-danger">Lỗi: '.mysqli_error($conn).'</div>';
    }
}
?>

<!doctype html>
<html lang="vi">

<head>

<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Sửa tài khoản</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f7;
    font-family:'Segoe UI',sans-serif;
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

.form-control,
.form-select{
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

<div class="header-box d-flex justify-content-between align-items-center">

<div>

<h3>SỬA TÀI KHOẢN</h3>

<p>Cập nhật thông tin tài khoản</p>

</div>

<a href="taikhoan.php" class="btn btn-outline-primary">

<i class="bx bx-arrow-back"></i>

Quay lại

</a>

</div>

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card product-card">

<div class="card-body p-4">

<?php echo $thongbao; ?>

<form method="POST">

<div class="mb-3">

<label class="fw-bold">

Tên đăng nhập

</label>

<input
type="text"
class="form-control"
value="<?php echo $row['username']; ?>"
disabled>

</div>

<div class="mb-3">

<label class="fw-bold">

Mật khẩu

</label>

<input
type="text"
name="password"
class="form-control"
value="<?php echo $row['password']; ?>"
required>

</div>

<div class="mb-3">

<label class="fw-bold">

Họ và tên

</label>

<input
type="text"
name="fullname"
class="form-control"
value="<?php echo $row['fullname']; ?>"
required>

</div>

<div class="mb-4">

<label class="fw-bold">

Quyền

</label>

<select name="quyen" class="form-select">

<option value="1" <?php if($row['quyen']==1) echo "selected"; ?>>

Admin

</option>

<option value="0" <?php if($row['quyen']==0) echo "selected"; ?>>

User

</option>

</select>

</div>

<div class="text-end">

<button
type="submit"
name="btnSua"
class="btn btn-save">

<i class="bx bx-save"></i>

Cập nhật tài khoản

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