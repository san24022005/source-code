<?php
// Bắt đầu phiên làm việc
session_start();

// Xóa toàn bộ biến session
$_SESSION = [];

// Hủy session hiện tại
session_destroy();

// Chuyển hướng người dùng đến trang đăng nhập
header("Location: login.php");
exit();
?>
