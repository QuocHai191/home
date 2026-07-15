<?php
session_start(); // Khởi động phiên làm việc để lưu trạng thái đăng nhập

// ĐỔI ĐƯỜNG DẪN: Gọi file kết nối nằm trong thư mục lib cho giống các file khác của bạn
include("./lib/connect.php"); 

if (isset($_POST['submit'])) { // Nếu người dùng bấm nút đăng nhập

    $taikhoan = mysqli_real_escape_string($conn, $_POST['taikhoan']);
    $matkhau = $_POST['matkhau'];

    // 1. Kiểm tra xem người dùng có bỏ trống ô nào không
    if (empty($taikhoan) || empty($matkhau)) {
        $_SESSION['loi_dangnhap'] = "Chưa nhập đủ thông tin tài khoản hoặc mật khẩu!";
        header("Location: index.php");
        exit();
    } else {
        // 2. Truy vấn kiểm tra tài khoản trong bảng taikhoan
        $sql = "SELECT * FROM taikhoan WHERE username = '$taikhoan'";
        $query = mysqli_query($conn, $sql);

        if ($query && mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);
            
            // 3. So sánh mật khẩu thô
            if ($matkhau == $row['password']) {
                
               // Đăng nhập thành công
$_SESSION['login_user'] = $taikhoan;
$_SESSION['quyen'] = $row['quyen']; // Lưu quyền vào Session

// Phân quyền
if ($row['quyen'] == 1) {
    // Admin
    header("Location: homepage.php");
} else {
    // User
    header("Location: tranguser.php");
}
exit();

            } else {
                $_SESSION['loi_dangnhap'] = "Mật khẩu nhập vào không chính xác!";
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['loi_dangnhap'] = "Tài khoản này không tồn tại trên hệ thống!";
            header("Location: index.php");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>