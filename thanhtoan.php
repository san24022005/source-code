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
    <style>
        .thanhtoan-section {
            display: none;
        }
        .thanhtoan-section.active {
            display: block;
        }
        .payment-method {
            margin: 20px 0;
        }
        .payment-method label {
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <div class="thanhtoan-container">
        <div class="thanhtoan_left-container">
            <h2>Thông tin đơn hàng</h2>
            <p><strong>Giá trị đơn hàng:</strong> <?= number_format($tongtien, 0, ',', '.') ?> VNĐ</p>
            <p><strong>Mã hóa đơn:</strong> <?= htmlspecialchars($soHD) ?></p>
            <p><strong>Nội dung:</strong> Thanh toán hóa đơn <?= htmlspecialchars($soHD) ?></p>

            <div class="payment-method">
                <h3>Chọn hình thức thanh toán:</h3>
                <label><input type="radio" name="payment" value="qr" checked> Chuyển khoản qua QR</label>
                <label><input type="radio" name="payment" value="cash"> Thanh toán tiền mặt</label>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="thanhtoan_right-container thanhtoan-section active" id="qr-section">
            <h2>Quét mã QR để thanh toán</h2>
            <img src="https://img.vietqr.io/image/BIDV-8830616514-qr_only.png?amount=<?= intval($tongtien) ?>&addInfo=Thanh toán hóa đơn <?= urlencode($soHD) ?>" alt="QR Thanh toán">
            <p><em>Dùng app ngân hàng để quét mã và thanh toán.</em></p>
            <button onclick="thanhToan()">Tôi đã hoàn tất thanh toán trên app</button>
        </div>

<!-- ... phần trên giữ nguyên ... -->

<!-- Tiền mặt Section -->
<div class="thanhtoan_right-container thanhtoan-section" id="cash-section">
    <h2>Thanh toán tiền mặt</h2>
    <p>Vui lòng đưa tiền cho nhân viên thu ngân để hoàn tất đơn hàng.</p>
    <button onclick="xacNhanTienMat()">Xác nhận tiền mặt</button>
</div>

<script>
    const radios = document.querySelectorAll('input[name="payment"]');
    const qrSection = document.getElementById('qr-section');
    const cashSection = document.getElementById('cash-section');

    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.value === 'qr') {
                qrSection.classList.add('active');
                cashSection.classList.remove('active');
            } else {
                cashSection.classList.add('active');
                qrSection.classList.remove('active');
            }
        });
    });

    function thanhToan() {
        const xacNhan = confirm('Cảm ơn bạn đã thanh toán. Chúng tôi sẽ kiểm tra lại đơn hàng và giao hàng sớm nhất.');
        if (xacNhan) {
            window.location.href = 'clear_cart.php';
        }
    }

    function xacNhanTienMat() {
        const xacNhan = confirm('Xác nhận bạn đã nhận đủ tiền mặt từ khách hàng?');
        if (xacNhan) {
            window.location.href = 'clear_cart.php';
        }
    }
</script>
</body>
</html>
