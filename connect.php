<?php
$host = 'localhost';      
$dbname = 'QLBH';     
$username = 'root';       
$password = '123456';

// Tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4'); // Thiết lập UTF-8 để tránh lỗi tiếng Việt
?>
