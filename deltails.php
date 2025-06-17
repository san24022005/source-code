<?php
session_start();
require 'connect.php';

$masp = isset($_GET['masp']) ? $_GET['masp'] : '';

$sql = "SELECT * FROM sanpham WHERE masp = '$masp'";
$result = $conn->query($sql);
$prd = $result->fetch_assoc();

$sql_sizes = "SELECT * FROM size_sanpham WHERE masp = '$masp'";
$sizes = $conn->query($sql_sizes);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CTSP - <?= $prd['masp'] ?></title>
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/css/table.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
</head>
<body>
    <?php
    require 'site.php';
    load_top();
    load_backbtn();
    ?>

    <?php if ($prd): ?>
        <div class="delprd-container">
            <div class="delprd-image">
                <img src="<?= $prd['url'] ?>" alt="<?= $prd['tensp'] ?>">
            </div>
            <div class="delprd-chitiet">
                <h2><?= $prd['tensp'] ?> </h2>
                <h2> Mã sản phẩm: <?= $prd['masp'] ?></h2>
                <div class="delprd-meta">
                    Thương hiệu: <?= $prd['brand'] ?? 'LStyle' ?> | Loại: <?= $prd['danhmuc'] ?> | Xuất xứ: <?= $prd['nuocsx'] ?? 'Việt Nam' ?>
                </div>
                <div class="delprd-price"><?= number_format($prd['gia'], 0, ',', '.') ?>₫</div>

                <!-- Khuyến mãi -->
                <div class="promotion">
                    <p><span>Giảm 10%</span> - <a href="#">Xem hướng dẫn</a></p>
                    <p>Áp dụng miễn phí giao hàng toàn quốc cho đơn hàng từ 500K. <a href="#">Xem chi tiết</a></p>
                </div>

                <div class="size-options">
                    <p><strong>Kích thước (size):</strong></p>
                    <?php while($row = $sizes->fetch_assoc()): ?>
                        <span><?= $row['size'] ?></span>
                    <?php endwhile; ?>
                </div>

                <div class="mota">
                    <h2>Mô tả sản phẩm</h2>
                    <p><?= nl2br($prd['mota']) ?></p>
                </div>

                <!-- Nút hành động -->
                <div class="actions">
                    <button type="button" class="btn js-gio-hang"
                        data-masp="<?= $prd['masp']; ?>"
                        data-img="<?= $prd['url']; ?>"
                        data-tensp="<?= htmlspecialchars($prd['tensp']); ?>"
                        data-gia="<?= $prd['gia']; ?>">
                        Thêm vào giỏ hàng
                    </button>

                    <button type="button" class="btn js-mua-ngay"
                        data-masp="<?= $prd['masp']; ?>"
                        data-img="<?= $prd['url']; ?>"
                        data-tensp="<?= htmlspecialchars($prd['tensp']); ?>"
                        data-gia="<?= $prd['gia']; ?>">
                        Mua ngay
                    </button>
                </div>
            </div>
        </div>
    <?php else: ?>
        <p style="text-align: center; font-size: 18px; color: #d63031;">Không tìm thấy sản phẩm.</p>
    <?php endif; ?>
    <?php load_footer(); ?>
    <div id="modal-mua-ngay" class="modal" style="display:none;" data-masp="">
        <?php
            load_modal();
        ?>
    </div>
    <script src="./accsets/js/modal.js"></script>
</body>
</html>