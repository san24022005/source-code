<?php
session_start();

$conn = new mysqli("localhost", "root", "123456", "qlbh");
$conn->set_charset("utf8mb4");

if (!isset($_SESSION['username'])) {
    die("Bạn chưa đăng nhập.");
}
$makh = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['capnhat'])) {
    $hoten = $conn->real_escape_string($_POST['hoten']);
    $email = $conn->real_escape_string($_POST['email']);
    $sodt = $conn->real_escape_string($_POST['sodt']);
    $ngaysinh = $conn->real_escape_string($_POST['ngaysinh']);
    $sonha = $conn->real_escape_string($_POST['sonha']);
    $capxa = $conn->real_escape_string($_POST['capxa']);
    $caphuyen = $conn->real_escape_string($_POST['caphuyen']);
    $captinh = $conn->real_escape_string($_POST['captinh']);

    $sql_update_kh = "UPDATE khachhang SET hoten='$hoten', ngaysinh='$ngaysinh' WHERE makh='$makh'";
    $conn->query($sql_update_kh);

    $sql_update_lienhe = "UPDATE thongtin_lienhe SET email='$email', sodt='$sodt', sonha='$sonha', capxa='$capxa', caphuyen='$caphuyen', captinh='$captinh' WHERE makh='$makh'";
    $conn->query($sql_update_lienhe);
    
    $_SESSION['name'] = $_POST['hoten'];
    // Không xóa session cart_temp
    echo "<script>window.history.back();</script>";
    exit;
} else {
    die("Yêu cầu không hợp lệ.");
}
