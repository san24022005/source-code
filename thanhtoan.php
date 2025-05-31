<?php
session_start();
$conn = new mysqli("localhost", "root", "123456", "qlbh");
$conn->set_charset("utf8mb4");

if (!isset($_POST['soHD'], $_POST['masp'], $_POST['size'], $_POST['soluong'], $_POST['gia'], $_POST['tongtien'])) {
    die("Thiếu dữ liệu để thanh toán.");
}

$soHD = $_POST['soHD'];
$tongtien = floatval($_POST['tongtien']);
$masps = $_POST['masp'];
$sizes = $_POST['size'];
$soluongs = $_POST['soluong'];
$gias = $_POST['gia'];

// Cập nhật lại trạng thái hóa đơn và trị giá
$sql_update_hd = "UPDATE hoadon SET trangthai='Đã thanh toán', trigia=? WHERE soHD=?";
$stmt = $conn->prepare($sql_update_hd);
$stmt->bind_param("ds", $tongtien, $soHD);
$stmt->execute();

// Thêm vào bảng chi tiết hóa đơn
$stmt_ct = $conn->prepare("INSERT INTO chitiethoadon (soHD, masp, size, soluong, giaban) VALUES (?, ?, ?, ?, ?)");

for ($i = 0; $i < count($masps); $i++) {
    $m = $conn->real_escape_string($masps[$i]);
    $s = $conn->real_escape_string($sizes[$i]);
    $sl = floatval($soluongs[$i]);
    $g = floatval($gias[$i]);
    $stmt_ct->bind_param("sssdd", $soHD, $m, $s, $sl, $g);
    $stmt_ct->execute();
}

echo "<h2 style='text-align:center;color:green;'>Thanh toán thành công! Mã hóa đơn: $soHD</h2>";
?>
