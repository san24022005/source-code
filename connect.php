<?php
$host = 'localhost';      // Địa chỉ máy chủ CSDL
$dbname = 'QLBH';     // Tên cơ sở dữ liệu
$username = 'root';       // Tên đăng nhập
$password = '123456';           // Mật khẩu (để trống nếu dùng XAMPP mặc định)

// Tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

mysqli_set_charset($conn, "utf8"); // Thiết lập UTF-8 để tránh lỗi tiếng Việt
?>
