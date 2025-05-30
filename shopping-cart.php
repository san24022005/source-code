<?php
session_start();
$conn = new mysqli("localhost", "root", "123456", "qlbh");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

require 'connect.php';

if (!isset($_SESSION['username'])) {
    die("Bạn chưa đăng nhập.");
}

$makh = $_SESSION['username'];

// Xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['masp'], $_POST['size'], $_POST['soluong'])) {
        $masp = $_POST['masp'];
        $size = $_POST['size'];
        $soluong = (int)$_POST['soluong'];
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        $key = $masp . "_" . $size;
        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['soluong'] += $soluong;
        } else {
            $_SESSION['cart'][$key] = ['masp' => $masp, 'size' => $size, 'soluong' => $soluong];
        }
        echo "success";
        exit();
    }

    // Cập nhật số lượng
    if (isset($_POST['capnhat']) && isset($_POST['soluong'])) {
        foreach ($_POST['soluong'] as $masp => $sizes) {
            foreach ($sizes as $size => $soluong) {
                $stmt = $conn->prepare("UPDATE giohang SET soluong = ? WHERE makh = ? AND masp = ? AND size = ?");
                $stmt->bind_param("isss", $soluong, $makh, $masp, $size);
                $stmt->execute();
            }
        }
    }

    // Xóa sản phẩm
    if (isset($_POST['xoa'])) {
        $masp = $_POST['masp'];
        $size = $_POST['size'];
        $stmt = $conn->prepare("DELETE FROM giohang WHERE makh = ? AND masp = ? AND size = ?");
        $stmt->bind_param("sss", $makh, $masp, $size);
        $stmt->execute();
    }

    // Thanh toán
    if (isset($_POST['thanhtoan']) && isset($_POST['chon'])) {
        $sanphams = $_POST['chon'];
        echo "<h3>Thanh toán thành công các sản phẩm sau:</h3><ul>";
        foreach ($sanphams as $sp) {
            list($masp, $size) = explode('|', $sp);
            echo "<li>Mã sản phẩm: $masp, Size: $size</li>";
            $stmt = $conn->prepare("DELETE FROM giohang WHERE makh = ? AND masp = ? AND size = ?");
            $stmt->bind_param("sss", $makh, $masp, $size);
            $stmt->execute();
        }
        echo "</ul><a href='giohang.php'>Quay lại giỏ hàng</a>";
        exit();
    }
}

// Lấy giỏ hàng từ CSDL
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
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        .btn { padding: 5px 10px; background-color: #3399ff; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
<h2>Giỏ hàng của bạn</h2>
<form method="post">
<table>
    <tr>
        <th>Chọn</th>
        <th>Hình ảnh</th>
        <th>Tên SP</th>
        <th>Size</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Tổng</th>
        <th>Xoá</th>
    </tr>
    <?php
    $tong = 0;
    if ($result->num_rows === 0) {
        echo "<tr><td colspan='8'>Giỏ hàng trống.</td></tr>";
    } else {
        while ($item = $result->fetch_assoc()):
            $subtotal = $item['gia'] * $item['soluong'];
            $tong += $subtotal;
    ?>
    <tr>
        <td><input type="checkbox" name="chon[]" value="<?= $item['masp'] . '|' . $item['size'] ?>"></td>
        <td><img src="<?= htmlspecialchars($item['url']) ?>" width="80"></td>
        <td><?= htmlspecialchars($item['tensp']) ?></td>
        <td><?= htmlspecialchars($item['size']) ?></td>
        <td><?= number_format($item['gia'], 0, ',', '.') ?> VNĐ</td>
        <td><input type="number" name="soluong[<?= $item['masp'] ?>][<?= $item['size'] ?>]" value="<?= $item['soluong'] ?>" min="1" style="width: 60px;"></td>
        <td><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</td>
        <td>
            <button type="submit" name="xoa" class="btn" onclick="return confirm('Xoá sản phẩm này?');">
                <input type="hidden" name="masp" value="<?= $item['masp'] ?>">
                <input type="hidden" name="size" value="<?= $item['size'] ?>">
                Xoá
            </button>
        </td>
    </tr>
    <?php endwhile; ?>
    <tr>
        <td colspan="6" align="right"><strong>Tổng cộng:</strong></td>
        <td colspan="2"><strong><?= number_format($tong, 0, ',', '.') ?> VNĐ</strong></td>
    </tr>
    <?php } ?>
</table>
<br>
<button type="submit" name="capnhat" class="btn">Cập nhật giỏ hàng</button>
<button type="submit" name="thanhtoan" class="btn" onclick="return confirm('Xác nhận thanh toán các sản phẩm đã chọn?');">Thanh toán</button>
</form>
</body>
</html>
