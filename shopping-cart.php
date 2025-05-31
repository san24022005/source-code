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

// Lấy dữ liệu giỏ hàng
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/css/table.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
    <style>
        #cart {
            width: 900px;
            margin: 44px auto;
        }

    .cart-container {
        width: 100%;
        display: flex;
        flex-direction: column;
    }

    .cart-container .cart-item {
        height: 150px;
        display: grid;
        grid-template-columns: 4% 15% 30% 8% 12% 13% 12% 6%;
        align-items: center;
        padding: 10px;
        border: 1px solid #ccc;
        text-align: center;
    }

    .cart-container .cart-header {
        font-weight: bold;
        background-color: #f0f0f0;
        height: 50px;
    }

    .cart-container .cart-item img {
        width: 80px;
    }

    .cart-container .cart-total {
        text-align: right;
        font-weight: bold;
        margin-top: 10px;
    }

    .cart-container input {
        text-align: center;
        width: 30px;
    }
    </style>
</head>
<body>
    <div id="cart">
    <h2>Giỏ hàng của bạn</h2>
    <form method="post" action="hoadon.php">
        <div class="cart-container">
    <div class="cart-item cart-header">
        <div>Chọn</div>
        <div>Hình ảnh</div>
        <div>Tên SP</div>
        <div>Size</div>
        <div>Đơn giá</div>
        <div>Số lượng</div>
        <div>Tổng</div>
        <div>Xóa</div>
    </div>

    <?php
    $tong = 0;
    if ($result->num_rows === 0) {
        echo "<div>Giỏ hàng trống.</div>";
    } else {
        while ($item = $result->fetch_assoc()):
            $subtotal = $item['gia'] * $item['soluong'];
            $tong += $subtotal;
    ?>
    <div class="cart-item">
        <div><input type="checkbox" name="chon[]" value="<?= $item['masp'] . '|' . $item['size'] ?>"></div>
        <div><img src="<?= htmlspecialchars($item['url']) ?>" alt="Hình sản phẩm"></div>
        <div><?= htmlspecialchars($item['tensp']) ?></div>
        <div><?= htmlspecialchars($item['size']) ?></div>
        <div><?= number_format($item['gia'], 0, ',', '.') ?> VNĐ</div>
        <div>
            <input type="number" name="soluong[<?= $item['masp'] ?>][<?= $item['size'] ?>]" value="<?= $item['soluong'] ?>" min="1">
        </div>
        <div><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</div>
        <div class="btn-remove">
            <a href="remove-cart.php?masp=<?= $item['masp'] ?>">Xóa</a>
        </div>
    </div>
    <?php endwhile; ?>
    <div class="cart-total">Tổng cộng: <?= number_format($tong, 0, ',', '.') ?> VNĐ</div>
    <?php } ?>
    </div>
        <br>
        <button type="submit" name="thanhtoan" class="btn-thanhtoan" onclick="return confirm('Xác nhận thanh toán các sản phẩm đã chọn?');">Thanh toán</button>
    </form>
    </div>
</body>
</html>
