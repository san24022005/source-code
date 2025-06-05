<?php
require('connect.php');

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
?>