<?php
session_start();

require 'connect.php';

if (!isset($_SESSION['username'])) {
    die("Bạn chưa đăng nhập.");
}

$makh = $_SESSION['username'];
$masp = $_GET['masp'] ?? '';
$size = $_GET['size'] ?? '';
$soluong = $_GET['soluong'] ?? '';

if ($masp === '' || $size === '' || $soluong === '') {
    die("Thiếu thông tin để xóa sản phẩm.");
}

// Xóa sản phẩm khỏi giỏ hàng
$sql = "DELETE FROM giohang WHERE makh = ? AND masp = ? AND size = ? AND soluong = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssd", $makh, $masp, $size, $soluong);

if ($stmt->execute()) {
    header("Location: shopping-cart.php"); // Chuyển hướng về trang giỏ hàng
    exit;
} else {
    echo "Lỗi khi xóa sản phẩm: " . $stmt->error;
}
?>
