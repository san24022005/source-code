<?php
session_start();
require 'connect.php';

if (!isset($_POST['soHD'], $_POST['masp'], $_POST['size'], $_POST['soluong'], $_POST['gia'], $_POST['tongtien'])) {
    die("Thiếu dữ liệu để thanh toán.");
}

$soHD = $_POST['soHD'];
$tongtien = floatval($_POST['tongtien']);
$masps = $_POST['masp'];
$sizes = $_POST['size'];
$soluongs = $_POST['soluong'];
$gias = $_POST['gia'];
$makh = $_SESSION['username'] ?? null;

if (!$makh) die("Không xác định khách hàng.");

// Kiểm tra trạng thái hóa đơn ban đầu
$sql_check = "SELECT trangthai FROM hoadon WHERE soHD = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $soHD);
$stmt_check->execute();
$result = $stmt_check->get_result();
$hd = $result->fetch_assoc();

$isFromGioHang = ($hd && $hd['trangthai'] === 'Mua bằng giỏ hàng (Hủy)');

// Thêm chi tiết hóa đơn và xử lý giỏ hàng nếu cần
$stmt_ct = $conn->prepare("INSERT INTO chitiethoadon (soHD, masp, size, soluong, giaban) VALUES (?, ?, ?, ?, ?)");
$stmt_del = $conn->prepare("DELETE FROM giohang WHERE makh=? AND masp=? AND size=? AND soluong=?");

for ($i = 0; $i < count($masps); $i++) {
    $m = $conn->real_escape_string($masps[$i]);
    $s = $conn->real_escape_string($sizes[$i]);
    $sl = floatval($soluongs[$i]);
    $g = floatval($gias[$i]);

    $stmt_ct->bind_param("sssdd", $soHD, $m, $s, $sl, $g);
    $stmt_ct->execute();

    // Nếu đơn hàng là từ giỏ hàng, thì xóa sản phẩm tương ứng khỏi giỏ
    if ($isFromGioHang) {
        $stmt_del->bind_param("sssd", $makh, $m, $s, $sl);
        $stmt_del->execute();
    }
}

$sql_update_hd = "UPDATE hoadon SET trangthai='Đã đặt hàng', trigia=? WHERE soHD=?";
$stmt = $conn->prepare($sql_update_hd);
$stmt->bind_param("ds", $tongtien, $soHD);
$stmt->execute();

header("Location: thanhtoan.php?soHD=" . urlencode($soHD) . "&total=" . urlencode($tongtien));
exit;
?>