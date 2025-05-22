<?php
$host = "localhost";
$user = "root";
$pass = "123456";
$dbname = "QLBH";

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8");

$masp = $_GET['masp'];

$sql = "SELECT size, soluong FROM size_sanpham WHERE masp = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $masp);
$stmt->execute();
$result = $stmt->get_result();

$sizes = [];
while ($row = $result->fetch_assoc()) {
    $sizes[] = $row;
}
echo json_encode($sizes);
