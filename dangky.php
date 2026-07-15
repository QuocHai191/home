<?php
include("lib/connect.php");
$thongbao = "";

if(isset($_POST['btnDangKy'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];

    if(empty($username) || empty($password)){
        $thongbao = "Vui lòng nhập đầy đủ Tài khoản và Mật khẩu!";
    } else {

        $check = "SELECT * FROM taikhoan WHERE username='$username'";
        $result_check = mysqli_query($conn, $check);

        if(mysqli_num_rows($result_check) > 0){
            $thongbao = "Tài khoản này đã có người sử dụng!";
        } else {

            $sql = "INSERT INTO taikhoan(username,password,fullname,quyen)
                    VALUES('$username','$password','$fullname',0)";

            if(mysqli_query($conn,$sql)){
                $thongbao = "Đăng ký thành công! <a href='index.php'>Đăng nhập ngay</a>";
            }else{
                $thongbao = "Lỗi đăng ký: ".mysqli_error($conn);
            }

        }

    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Đăng ký tài khoản</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>

body{

background:linear-gradient(135deg,#1e3a8a,#2563eb);

font-family:'Segoe UI',sans-serif;

min-height:100vh;

display:flex;

justify-content:center;

align-items:center;

}

.register-card{

width:450px;

background:#fff;

border-radius:20px;

overflow:hidden;

box-shadow:0 20px 40px rgba(0,0,0,.25);

}

.header{

background:linear-gradient(90deg,#1e40af,#2563eb);

color:#fff;

padding:35px;

text-align:center;

}

.header i{

font-size:60px;

margin-bottom:10px;

}

.header h2{

font-weight:bold;

margin-bottom:8px;

}

.form-area{

padding:30px;

}

.form-control{

height:48px;

border-radius:12px;

}

.btn-register{

background:#2563eb;

border:none;

height:50px;

border-radius:12px;

font-weight:bold;

font-size:17px;

color:#fff;

transition:.3s;

}

.btn-register:hover{

background:#1d4ed8;

transform:translateY(-2px);

}

.footer{

text-align:center;

padding:20px;

border-top:1px solid #eee;

}

</style>

</head>

<body>

<div class="register-card">

<div class="header">

<i class="bx bx-mobile-alt"></i>

<h2>TECH STORE</h2>

<p>Đăng ký tài khoản mới</p>

</div>

<div class="form-area">

<?php
if($thongbao!=""){
?>

<div class="alert alert-info text-center">

<?php echo $thongbao; ?>

</div>

<?php
}
?>

<form action="dangky.php" method="POST">

<div class="mb-3">

<label class="form-label">

<i class="bx bx-user"></i>

Tên đăng nhập

</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label class="form-label">

<i class="bx bx-lock-alt"></i>

Mật khẩu

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<div class="mb-4">

<label class="form-label">

<i class="bx bx-id-card"></i>

Họ và tên

</label>

<input
type="text"
name="fullname"
class="form-control">

</div>

<button
class="btn btn-register w-100"
name="btnDangKy">

<i class="bx bx-user-plus"></i>

ĐĂNG KÝ

</button>

</form>

</div>

<div class="footer">

Đã có tài khoản?

<a href="index.php">

Đăng nhập

</a>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>