<?php
$soHD = $_GET['soHD'] ?? null;
$tongtien = floatval($_GET['total'] ?? 0);

if (!$soHD || $tongtien <= 0) {
    die("Thiếu thông tin hóa đơn hoặc số tiền không hợp lệ.");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
</head>
<body>
    <div class="thanhtoan-container">
        <div class="thanhtoan_left-container">
            <h2>Thông tin đơn hàng</h2>
            <p><strong>Giá trị đơn hàng:</strong> <?= number_format($tongtien, 0, ',', '.') ?> VNĐ</p>
            <p><strong>Mã hóa đơn:</strong> <?= htmlspecialchars($soHD) ?></p>
            <p><strong>Nội dung:</strong> Thanh toán hóa đơn <?= htmlspecialchars($soHD) ?></p>
        </div>
        <div class="thanhtoan_right-container">
            <h2>Quét mã QR để thanh toán</h2>
            <img src="https://img.vietqr.io/image/BIDV-8830616514-qr_only.png?amount=<?= intval($tongtien) ?>&addInfo=Thanh toán hóa đơn <?= urlencode($soHD) ?>" alt="QR Thanh toán">
            <p><em>Dùng app ngân hàng để quét mã và thanh toán.</em></p>
            <button onclick="thanhToan()">Tôi đã hoàn tất thanh toán trên app</button>
        </div>
    </div>

    <script src="./accsets/js/thanhtoan.js"></script>
</body>
</html>