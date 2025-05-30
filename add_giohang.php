<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['username'])) {
    die("Bạn cần đăng nhập để thêm vào giỏ hàng.");
}

$makh = $_SESSION['username'];
$masp = $_GET['masp'] ?? '';
$size = $_GET['size'] ?? '';
$soluong = intval($_GET['soluong'] ?? 1);

if ($masp == '' || $size == '') {
    die("Thiếu thông tin sản phẩm.");
}

// Kiểm tra xem đã có sản phẩm này trong giỏ chưa
$stmt = $conn->prepare("SELECT soluong FROM giohang WHERE makh = ? AND masp = ? AND size = ?");
$stmt->bind_param("sss", $makh, $masp, $size);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Nếu có, cập nhật số lượng
    $new_qty = $row['soluong'] + $soluong;
    $update = $conn->prepare("UPDATE giohang SET soluong = ? WHERE makh = ? AND masp = ? AND size = ?");
    $update->bind_param("isss", $new_qty, $makh, $masp, $size);
    $update->execute();
} else {
    // Nếu chưa có, thêm mới
    $insert = $conn->prepare("INSERT INTO giohang (makh, masp, size, soluong) VALUES (?, ?, ?, ?)");
    $insert->bind_param("sssi", $makh, $masp, $size, $soluong);
    $insert->execute();
}

header("Location: shopping-cart.php");
exit;
?>
