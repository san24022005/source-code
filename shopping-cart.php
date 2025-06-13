<?php 
session_start();

require 'connect.php';

if (!isset($_SESSION['username'])) {
    die("Bạn chưa đăng nhập.");
}

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/css/table.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
    <title>Giỏ hàng của bạn</title>
</head>
<body>
    <?php
    require 'site.php';
    load_top();
    load_backbtn();
    ?>
    <div id="cart">
        <h2>Giỏ hàng của bạn</h2>

        <form method="post" action="hoadon.php">
            <div class="cart-container">
                <div class="cart-item cart-header">
                <div>Chọn</div>
                <div>Hình ảnh</div>
                <div>Thông tin</div>
                <div>Xóa</div>
            </div>

            <?php
            $tong = 0;
            if ($result->num_rows === 0) {
                echo "<div style='padding: 20px;'>Giỏ hàng trống.</div>";
            } else {
                while ($item = $result->fetch_assoc()):
                    $subtotal = $item['gia'] * $item['soluong'];
                    $tong += $subtotal;
            ?>

            <div class="cart-item">
                <div class="check">
                    <input type="checkbox" name="chon[]" value="<?= $item['masp'] . '|' . $item['size'] ?>">
                </div>

                <div>
                    <img src="<?= htmlspecialchars($item['url']) ?>" alt="Hình sản phẩm">
                </div>

                <div class="info">
                    <div class="tensp"><?= htmlspecialchars($item['tensp']) ?></div>
                    <div>
                        Size: <?= htmlspecialchars($item['size']) ?> x 
                        SL: <?= $item['soluong'] ?>
                    </div>

                    <div>Đơn giá: <?= number_format($item['gia'], 0, ',', '.') ?> VNĐ</div>
                    <div class="tongtien">Tổng: <?= number_format($subtotal, 0, ',', '.') ?> VNĐ</div>
                </div>

                <div class="btn-remove">
                    <a href="remove-cart.php?masp=<?= $item['masp'] ?>&size=<?= $item['size'] ?>&soluong=<?= $item['soluong'] ?>">Xóa</a>
                </div>
            </div>

                <?php endwhile; ?>
            
            <div class="cart-total">Tổng cộng: <?= number_format($tong, 0, ',', '.') ?> VNĐ</div>

            <?php } ?>
            
            </div>
        <br>
        <button type="submit" name="thanhtoan" class="btn-thanhtoan" onclick="return confirm('Xác nhận thanh toán các sản phẩm đã chọn?');">Đặt hàng</button>
        </form>
    </div>
    <?php load_footer();?>
    
    <script scr="./accsets/js/cart.js"></script>
</body>
</html>