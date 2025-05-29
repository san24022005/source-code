<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['username'])) {
    die("Bạn chưa đăng nhập.");
}

$makh = $_SESSION['username'];

// Truy vấn giỏ hàng
$stmt = $conn->prepare("
    SELECT g.masp, g.size, g.soluong, s.tensp, s.gia, s.url
    FROM giohang g
    JOIN sanpham s ON g.masp = s.masp
    WHERE g.makh = ?
");
$stmt->bind_param("s", $makh);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng của bạn</title>
</head>
<body>
    <h2>Giỏ hàng của bạn</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Hình ảnh</th>
            <th>Tên SP</th>
            <th>Size</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng</th>
        </tr>
        <?php
        $tong = 0;
        while ($item = $result->fetch_assoc()):
            $subtotal = $item['gia'] * $item['soluong'];
            $tong += $subtotal;
        ?>
        <tr>
            <td><img src="<?= htmlspecialchars($item['url']) ?>" width="80"></td>
            <td><?= htmlspecialchars($item['tensp']) ?></td>
            <td><?= htmlspecialchars($item['size']) ?></td>
            <td><?= number_format($item['gia'], 0, ',', '.') ?> VNĐ</td>
            <td><?= $item['soluong'] ?></td>
            <td><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</td>
        </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="5" align="right"><strong>Tổng cộng:</strong></td>
            <td><strong><?= number_format($tong, 0, ',', '.') ?> VNĐ</strong></td>
        </tr>
    </table>
</body>
</html>
