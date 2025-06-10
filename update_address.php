<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['username'])) {
    echo "error: not_logged_in";
    exit;
}

$makh = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoten = $conn->real_escape_string($_POST['hoten']);
    $email = $conn->real_escape_string($_POST['email']);
    $sodt = $conn->real_escape_string($_POST['sodt']);
    $ngaysinh = $conn->real_escape_string($_POST['ngaysinh']);
    $sonha = $conn->real_escape_string($_POST['sonha']);
    $capxa = $conn->real_escape_string($_POST['capxa']);
    $caphuyen = $conn->real_escape_string($_POST['caphuyen']);
    $captinh = $conn->real_escape_string($_POST['captinh']);

    $conn->query("UPDATE khachhang SET hoten='$hoten', ngaysinh='$ngaysinh' WHERE makh='$makh'");
    $conn->query("UPDATE thongtin_lienhe SET email='$email', sodt='$sodt', sonha='$sonha', capxa='$capxa', caphuyen='$caphuyen', captinh='$captinh' WHERE makh='$makh'");

    $_SESSION['name'] = $hoten;
    echo "success";
    exit;
}
echo "error: invalid_request";
exit;
?>