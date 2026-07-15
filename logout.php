<?php
session_start();
// Xóa bỏ toàn bộ phiên đăng nhập
session_destroy();
// Quay trở lại màn hình đăng nhập chính
header("Location: index.php");
exit();
?>