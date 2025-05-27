<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$makh = $_SESSION['username'];

// Kết nối CSDL
$conn = new mysqli("localhost", "root", "123456", "qlbh");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn đơn hàng và sản phẩm
$sql = "
    SELECT hd.soHD, hd.ngayHD, sp.tensp, sp.url, cthd.size, cthd.soluong,
           cthd.giaban, sp.masp
    FROM hoadon hd
    JOIN chitiethoadon cthd ON hd.soHD = cthd.soHD
    JOIN sanpham sp ON cthd.masp = sp.masp
    WHERE hd.makh = ?
    ORDER BY hd.ngayHD DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $makh);
$stmt->execute();
$result = $stmt->get_result();

// Gom đơn hàng
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[$row['soHD']]['ngayHD'] = $row['ngayHD'];
    $orders[$row['soHD']]['items'][] = $row;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng của tôi</title>
    <link rel="stylesheet" href="accsets/css/base.css">
    <link rel="stylesheet" href="accsets/css/table.css">
    <link rel="stylesheet" href="accsets/css/main.css">
    <link rel="stylesheet" href="accsets/fonts/themify-icons/themify-icons.css">
    <style>
        .orders-container {
            margin: 50px auto;
            border-radius: 10px;
            padding: 20px;
        }
        .order-card {
            background: #fff;
            border: 1px solid #e5e5e5;
            padding: 15px;
            border-radius: 10px;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        .item {
            display: flex;
            gap: 15px;
            margin: 10px 0;
        }
        .item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .info {
            flex: 1;
        }
        .price {
            text-align: right;
            color: #d0011b;
            font-weight: bold;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 10px;
            margin-top: 10px;
        }

        .btn {
            width: 120px;
        }

        .btn:hover {
            background: #d8351d;
        }

        .status {
            color: green;
        }
    </style>
</head>
<body>
    <?php 
    require 'site.php'; 
    load_top();
    load_backbtn(); 
    ?>
    <div class="orders-container">
    <h2>Đơn hàng của tôi</h2>

    <?php if (empty($orders)): ?>
        <p>Bạn chưa có sản phẩm nào được mua.</p>
    <?php else: ?>
        <?php foreach ($orders as $soHD => $order): ?>
            <div class="order-card">
                <div class="order-header">
                    <span>Đơn hàng #<?= $soHD ?> | Ngày: <?= $order['ngayHD'] ?></span>
                    <span class="status">Hoàn thành</span>
                </div>

                <?php $tong = 0; ?>
                <?php foreach ($order['items'] as $item): ?>
                    <div class="item">
                        <img src="<?= $item['url'] ?>" alt="<?= $item['tensp'] ?>">
                        <div class="info">
                            <div><?= $item['tensp'] ?></div>
                            <div>Phân loại: Size <?= $item['size'] ?> x <?= $item['soluong'] ?></div>
                        </div>
                        <div class="price"><?= number_format($item['giaban'], 0, ',', '.') ?>₫</div>
                    </div>
                    <?php $tong += $item['giaban'] * $item['soluong']; ?>
                <?php endforeach; ?>

                <div class="footer">
                    <span>Thành tiền: <strong><?= number_format($tong, 0, ',', '.') ?>₫</strong></span>
                    <form method="GET" action="muagain.php">
                        <input type="hidden" name="masp" value="<?= $item['masp'] ?>">
                        <button class="btn" type="submit">Mua Lại</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>

</body>
</html>
<?php
$stmt->close();
$conn->close();
load_footer();
?>
