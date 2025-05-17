<?php
require('connect.php');

if (isset($_GET['masp']) && isset($_GET['size'])) {
    $masp = $conn->real_escape_string($_GET['masp']);
    $size = $conn->real_escape_string($_GET['size']);

    $sql = "SELECT soluong FROM size_sanpham WHERE masp = '$masp' AND size = '$size'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['soluong'];
    } else {
        echo "0";
    }
}
?>

