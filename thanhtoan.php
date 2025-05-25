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
$username = $conn->real_escape_string($_SESSION['username']);

// Lấy mã khách hàng từ session username
$sql_kh = "SELECT makh FROM khachhang WHERE makh = '$username'";
$result_kh = $conn->query($sql_kh);
if (!$result_kh || $result_kh->num_rows === 0) {
    die("Không tìm thấy khách hàng.");
}
$makh = $result_kh->fetch_assoc()['makh'];

// Lấy hóa đơn gần nhất với trạng thái 'Hủy'
$sql_hd = "SELECT soHD FROM hoadon 
           WHERE makh = '$makh' AND trangthai = 'Hủy' 
           ORDER BY ngayHD DESC LIMIT 1";
$result_hd = $conn->query($sql_hd);
if (!$result_hd || $result_hd->num_rows === 0) {
    die("Không tìm thấy hóa đơn để thêm chi tiết.");
}
$soHD = $result_hd->fetch_assoc()['soHD'];

// Lấy giá bán từ sản phẩm
$sql_gia = "SELECT gia FROM sanpham WHERE masp = '$masp'";
$result_gia = $conn->query($sql_gia);
if (!$result_gia || $result_gia->num_rows === 0) {
    die("Không tìm thấy sản phẩm.");
}
$gia = (float)$result_gia->fetch_assoc()['gia'];

// Thêm vào chitiethoadon
$sql_insert = "INSERT INTO chitiethoadon (soHD, masp, size, soluong, giaban) 
               VALUES ('$soHD', '$masp', '$size', $soluong, $gia)";

if ($conn->query($sql_insert)) {
    // Cập nhật trạng thái hóa đơn từ 'Hủy' → 'Đang xử lý'
    $conn->query("UPDATE hoadon SET trangthai = 'Đã đặt hàng' WHERE soHD = '$soHD'");
    echo "<script>
    alert('Đã đặt hàng thành công!');
        window.location.href = 'index.php';
        </script>";
exit();

} else {
    echo "<p class='error'>❌ Lỗi khi thêm chi tiết hóa đơn: " . $conn->error . "</p>";
}
?>
