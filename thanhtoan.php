<?php
session_start();
require('connect.php');

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Truy cập không hợp lệ.");
}

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    die("Bạn chưa đăng nhập.");
}

// Kiểm tra dữ liệu gửi về
if (!isset($_POST['masp'], $_POST['size'], $_POST['quantity'])) {
    die("Thiếu dữ liệu sản phẩm.");
}

$masp = $conn->real_escape_string($_POST['masp']);
$size = $conn->real_escape_string($_POST['size']);
$soluong = (float)$_POST['quantity'];
$soHD = $conn->real_escape_string($_POST['soHD'] ?? '');

// Lấy giá bán từ sản phẩm
$sql_gia = "SELECT gia FROM sanpham WHERE masp = '$masp'";
$result_gia = $conn->query($sql_gia);
if (!$result_gia || $result_gia->num_rows === 0) {
    die("Không tìm thấy sản phẩm.");
}
$giaban = (float)$result_gia->fetch_assoc()['gia'];

// Thêm vào chitiethoadon
$sql_insert = "INSERT INTO chitiethoadon (soHD, masp, size, soluong, giaban) 
               VALUES ('$soHD', '$masp', '$size', $soluong, $giaban)";

if ($conn->query($sql_insert)) {
    // Cập nhật trạng thái hóa đơn từ 'Hủy' → 'Đang xử lý'
    $conn->query("UPDATE hoadon SET trangthai = 'Đã đặt hàng' WHERE soHD = '$soHD'");
    echo "<script>
    alert('Đã đặt hàng thành công!');
        window.location.href = 'index.php';
        </script>";
exit();

} else {
    echo "<p class='error'>Lỗi khi thêm chi tiết hóa đơn: " . $conn->error . "</p>";
}
?>
