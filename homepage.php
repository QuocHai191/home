<?php
session_start();
// Khóa bảo vệ: Nếu chưa đăng nhập thì đẩy về trang chủ index.php
if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit();
}
include("./lib/connect.php");
if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['quyen'] != 1) {
    header("Location: tranguser.php");
    exit();
}
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <title>Quản Lý Điện Thoại - Cửa Hàng Chuyên Nghiệp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    <style>
     body{
    background:#f5f5f7;
    font-family:'Segoe UI',sans-serif;
}

/* SIDEBAR */

.sidebar-box{
    background:#1f2937;
    color:#fff;
    min-height:100vh;
}

.sidebar-box h4{
    color:#fff!important;
    font-weight:bold;
}

.sidebar-box a{
    color:#fff;
}

/* HEADER */

.header-box{
    background:#fff;
    border-radius:15px;
    padding:20px 30px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    margin-bottom:30px;
}

.page-title{
    font-size:30px;
    font-weight:700;
}

.page-subtitle{
    color:#777;
}

/* CARD */

.product-card{
    border:none;
    border-radius:18px;
    overflow:hidden;
    transition:.35s;
    background:#fff;
    box-shadow:0 4px 15px rgba(0,0,0,.08);
}

.product-card:hover{
    transform:translateY(-8px);
    box-shadow:0 12px 35px rgba(0,0,0,.18);
}

.img-container{
    background:#fff;
    height:240px;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.product-img{
    max-width:90%;
    max-height:190px;
    transition:.3s;
}

.product-card:hover .product-img{
    transform:scale(1.08);
}

/* TÊN */

.product-name{
    height:50px;
    overflow:hidden;
    font-weight:600;
    font-size:17px;
    color:#222;
}

/* GIÁ */

.price{
    color:#d70018;
    font-size:24px;
    font-weight:bold;
}

.old-price{
    color:#888;
    text-decoration:line-through;
    font-size:14px;
}

/* KHO */

.stock{
    background:#eefaf1;
    color:#0f9d58;
    padding:6px 12px;
    border-radius:30px;
    font-size:13px;
    display:inline-block;
}

/* BUTTON */

.btn-success{
    background:#d70018;
    border:none;
}

.btn-success:hover{
    background:#b80015;
}

.btn-outline-primary{
    border:2px solid #0066ff;
}

.btn-outline-primary:hover{
    background:#0066ff;
}

.btn-outline-danger{
    border:2px solid #d70018;
}

.btn-outline-danger:hover{
    background:#d70018;
}

.rating{
    color:#ffc107;
}

.sale-tag{
    position:absolute;
    top:12px;
    left:12px;
    background:#d70018;
    color:#fff;
    padding:5px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:bold;
}

.product-card{
    position:relative;
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

    font-weight:500;
}

.sidebar-box .nav-link:hover{

    background:#2563eb;

    color:#fff;

    padding-left:28px;
}

.sidebar-box .nav-link i{

    width:22px;
}

.sidebar-box h4{

    color:#fff!important;
}

.sidebar-box hr{

    border-color:rgba(255,255,255,.15);
}
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            
            <div class="col-xl-2 col-lg-3 col-md-4 sidebar-box p-3 min-vh-100">
                <div class="p-2 mb-4">
                    <h4 class="text-primary font-weight-bold mb-1"><i class="bx bx-mobile-alt"></i> TECH STORE</h4>
                    <span class="text-muted small">Xin chào: <strong class="text-dark"><?php echo $_SESSION['login_user']; ?></strong></span>
                </div>
                <hr>
                <?php include("sidebarmenu.php"); ?>
            </div>

            <div class="col-xl-10 col-lg-9 col-md-8 p-4">
                
                <div class="header-box d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="page-title">CỬA HÀNG ĐIỆN THOẠI TECH STORE</h3>
						<p class="page-subtitle">Chính hãng • Giá tốt • Bảo hành toàn quốc</p>
                    </div>
                    <a href="themsp.php" class="btn btn-success btn-rounded waves-effect waves-light shadow-sm">
                        <i class="bx bx-plus-circle me-1"></i> Thêm sản phẩm mới
                    </a>
                </div>

                <div class="row">
                    <?php
                    $sql = "SELECT * FROM sanpham";
                    $ketqua = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($ketqua) > 0) {
                        while ($row = mysqli_fetch_array($ketqua)) {
                            // Nếu không có ảnh, hệ thống tự lấy link ảnh demo ngẫu nhiên cực đẹp của Unsplash
                            $hinhanh = !empty($row['hinhanh']) && file_exists("img/".$row['hinhanh']) 
                                       ? "img/".$row['hinhanh'] 
                                       : "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&auto=format&fit=crop&q=60";
                            ?>
                            <div class="col-xl-3 col-lg-4 col-sm-6 mb-4">
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
            <?php echo number_format($row['gia']/0.9,0,",","."); ?> ₫
        </div>

        <div class="stock mb-3">
            Còn <?php echo $row['soluong']; ?> sản phẩm
        </div>

        <div class="row">

            <div class="col-6">

                <a href="edit.php?id=<?php echo $row['id']; ?>"
                   class="btn btn-outline-primary w-100">

                    <i class="bx bx-edit"></i>

                    Sửa

                </a>

            </div>

            <div class="col-6">

                <a href="delete.php?id=<?php echo $row['id']; ?>"
                   onclick="return confirm('Bạn chắc chắn muốn xóa?')"
                   class="btn btn-outline-danger w-100">

                    <i class="bx bx-trash"></i>

                    Xóa

                </a>

            </div>

        </div>

    </div>

</div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div class="col-12"><div class="alert alert-warning text-center">Hiện tại chưa có điện thoại nào trong kho.</div></div>';
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>