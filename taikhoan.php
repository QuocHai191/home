<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit();
}

include("./lib/connect.php");
?>

<!doctype html>
<html lang="vi">

<head>

<meta charset="utf-8">

<title>Quản lý tài khoản</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

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

.sidebar-box h4{
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
    padding:20px 30px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    margin-bottom:30px;
}

.page-title{
    font-size:30px;
    font-weight:bold;
}

.table-card{
    background:#fff;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.table thead{
    background:#2563eb;
    color:#fff;
}

.btn-add{
    background:#d70018;
    color:#fff;
    border:none;
}

.btn-add:hover{
    background:#b50015;
    color:#fff;
}

</style>

</head>

<body>

<div class="container-fluid">

<div class="row">

<!-- SIDEBAR -->

<div class="col-xl-2 col-lg-3 col-md-4 sidebar-box p-3">

<div class="mb-4">

<h4>

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

<!-- CONTENT -->

<div class="col-xl-10 col-lg-9 col-md-8 p-4">

<div class="header-box d-flex justify-content-between align-items-center">

<div>

<h2 class="page-title">

QUẢN LÝ TÀI KHOẢN

</h2>

<p class="text-muted">

Danh sách tài khoản trong hệ thống

</p>

</div>

<a href="dangky.php" class="btn btn-add">

<i class="bx bx-user-plus"></i>

Thêm tài khoản

</a>

</div>

<div class="table-card">

<table class="table table-hover align-middle mb-0">

<thead>

<tr>


<th>Tài khoản</th>

<th>Họ tên</th>

<th>Quyền</th>

<th width="170">Thao tác</th>

</tr>

</thead>

<tbody>

<?php

$sql = "SELECT * FROM taikhoan ORDER BY username ASC";

$result=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($result))
{

?>

<tr>


<td><?php echo $row['username']; ?></td>

<td><?php echo $row['fullname']; ?></td>

<td>

<?php

if($row['quyen']==1)
{

echo '<span class="badge bg-danger">Admin</span>';

}
else
{

echo '<span class="badge bg-success">User</span>';

}

?>

</td>

<td>

<a href="edit_taikhoan.php?username=<?php echo urlencode($row['username']); ?>"" class="btn btn-sm btn-outline-primary">

<i class="bx bx-edit"></i>

</a>

<a href="delete_taikhoan.php?username=<?php echo urlencode($row['username']); ?>"

onclick="return confirm('Bạn có chắc muốn xóa tài khoản này?')"

class="btn btn-sm btn-outline-danger">

<i class="bx bx-trash"></i>

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