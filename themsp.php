<?php
session_start();
// Khóa bảo vệ: Chưa đăng nhập thì không cho vào trang này
if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit();
}
// Gọi đúng file kết nối nằm trong thư mục lib
include("./lib/connect.php"); 

$thongbao = "";

// Xử lý khi người dùng bấm nút "LƯU SẢN PHẨM"
if (isset($_POST['btnThem'])) {
    $tensp = mysqli_real_escape_string($conn, $_POST['tensp']);
    $gia = $_POST['gia'];
    $soluong = $_POST['soluong'];
    $hinhanh = $_POST['hinhanh']; // Nhập tên file ảnh (Ví dụ: iphone15.jpg)

    if (empty($tensp) || empty($gia) || empty($soluong)) {
        $thongbao = '<div class="alert alert-danger text-center">Vui lòng điền đầy đủ thông tin bắt buộc!</div>';
    } else {
        // Câu lệnh SQL thêm dữ liệu vào bảng sanpham
        $sql = "INSERT INTO sanpham (tensp, gia, soluong, hinhanh) VALUES ('$tensp', '$gia', '$soluong', '$hinhanh')";
        
        if (mysqli_query($conn, $sql)) {
            // Thêm thành công -> Tự động chuyển hướng về trang chủ sau 1 giây
            $thongbao = '<div class="alert alert-success text-center">Thêm điện thoại thành công! Đang quay lại trang chủ...</div>';
            header("refresh:1; url=homepage.php");
        } else {
            $thongbao = '<div class="alert alert-danger text-center">Lỗi hệ thống: ' . mysqli_error($conn) . '</div>';
        }
    }
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <title>Thêm Điện Thoại Mới</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    padding:20px 30px;
    margin-bottom:30px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.page-title{
    font-size:30px;
    font-weight:700;
}

.page-subtitle{
    color:#777;
}

.product-card{
    border:none;
    border-radius:18px;
    box-shadow:0 6px 20px rgba(0,0,0,.08);
}

.form-control{
    height:48px;
    border-radius:10px;
}

.form-control:focus{
    border-color:#2563eb;
    box-shadow:0 0 0 .2rem rgba(37,99,235,.15);
}

</style>
</head>
<body>

<div class="container-fluid">
<div class="row">

    <!-- Sidebar -->
    <div class="col-xl-2 col-lg-3 col-md-4 sidebar-box p-3 min-vh-100">

        <div class="p-2 mb-4">
            <h4 class="text-white">
                <i class="bx bx-mobile-alt"></i>
                TECH STORE
            </h4>
        </div>

        <hr>

        <?php include("sidebarmenu.php"); ?>

    </div>


    <!-- Nội dung -->
    <div class="col-xl-10 col-lg-9 col-md-8 p-4">

        <div class="header-box d-flex justify-content-between align-items-center">

            <div>

                <h3 class="page-title">
                    THÊM ĐIỆN THOẠI MỚI
                </h3>

                <p class="page-subtitle">
                    Thêm sản phẩm mới vào hệ thống
                </p>

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

                        <?php echo $thongbao; ?>

                        <form action="themsp.php" method="POST">

                            <div class="mb-3">

                                <label class="form-label fw-bold">
                                    Tên điện thoại
                                </label>

                                <input
                                type="text"
                                class="form-control"
                                name="tensp"
                                placeholder="Ví dụ: iPhone 15 Pro Max"
                                required>

                            </div>


                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">
                                        Giá bán
                                    </label>

                                    <input
                                    type="number"
                                    class="form-control"
                                    name="gia"
                                    required>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label fw-bold">
                                        Số lượng
                                    </label>

                                    <input
                                    type="number"
                                    class="form-control"
                                    name="soluong"
                                    required>

                                </div>

                            </div>


                            <div class="mb-4">

                                <label class="form-label fw-bold">
                                    Tên file hình ảnh
                                </label>

                                <input
                                type="text"
                                class="form-control"
                                name="hinhanh"
                                placeholder="iphone15.jpg">

                                <small class="text-muted">
                                    Để ảnh trong thư mục
                                    <b>img/</b>
                                </small>

                            </div>


                            <div class="text-end">

                                <button
                                type="submit"
                                name="btnThem"
                                class="btn btn-success px-4">

                                    <i class="bx bx-save"></i>

                                    Lưu sản phẩm

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>