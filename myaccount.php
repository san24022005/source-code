<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'KH001';
}

require 'connect.php';

$username = $_SESSION['username'];

// Lấy thông tin hiện tại
$sql = "SELECT kh.hoten, kh.ngaysinh, tl.sodt, tl.email, tl.sonha, tl.caphuyen, tl.capxa, tl.captinh
        FROM khachhang kh
        LEFT JOIN thongtin_lienhe tl ON kh.makh = tl.makh
        WHERE kh.makh = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Thông tin khách hàng</title>
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/table.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php
    require 'site.php';
    load_top();
    load_backbtn();
    ?>
        <div class="myacc-container">
            <h2>Thông tin khách hàng</h2>
            <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            <hr>

            <div class="form-row">
                <label>Tên đăng nhập</label>
                <input type="text" value="<?= htmlspecialchars($username) ?>" readonly />
            </div>

            <div class="form-row">
                <label>Họ tên</label>
                <input type="text" name="hoten" value="<?= htmlspecialchars($user['hoten']) ?>" readonly />
            </div>

            <div class="form-row">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly />
            </div>

            <div class="form-row">
                <label>Số điện thoại</label>
                <input type="text" name="sodt" value="<?= htmlspecialchars($user['sodt']) ?>" readonly />
            </div>

            <div class="form-row">
                <label>Ngày sinh</label>
                <input type="date" name="ngaysinh" value="<?= htmlspecialchars($user['ngaysinh']) ?>" readonly />
            </div>

            <div class="address">
                <label><strong>Địa chỉ</strong></label>
                <input type="text" placeholder="Số nhà, tên đường" name="sonha" value="<?= htmlspecialchars($user['sonha']) ?>" readonly />
                <input type="text" placeholder="Phường / Xã" name="xa" value="<?= htmlspecialchars($user['capxa']) ?>" readonly />
                <input type="text" placeholder="Quận / Huyện" name="huyen" value="<?= htmlspecialchars($user['caphuyen']) ?>" readonly />
                <input type="text" placeholder="Tỉnh / Thành phố" name="tinh" value="<?= htmlspecialchars($user['captinh']) ?>" readonly />
            </div>

            <div class="form-actions">
                <button class="btn-myacc-edit js-edit-address" type="button">Chỉnh sửa</button>
                <a href="reset-password.php" class="btn-myacc-pass">Đổi mật khẩu</a>
            </div>
        </div>
    <?php load_footer(); ?>
    <div class="modal-address" style="display: none;">
        <?php 
            load_modal_address();
        ?>
    </div>

    <script src="./accsets/js/modal-address.js"></script>
</body>
</html>