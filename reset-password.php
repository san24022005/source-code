<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>
        alert('Bạn chưa đăng nhập!');
        window.location.href = 'login.php';
    </script>";
    exit;
}

require 'connect.php'; // File kết nối CSDL

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldPassword = $_POST['old-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    // Kiểm tra mật khẩu xác nhận
    if ($newPassword !== $confirmPassword) {
        echo "Mật khẩu xác nhận không trùng khớp.";
        exit();
    }

    // Kiểm tra mật khẩu cũ
    $sql = "SELECT * FROM taikhoan WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $oldPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Cập nhật mật khẩu mới
        $update = "UPDATE taikhoan SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($update);
        $stmt->bind_param("ss", $newPassword, $username);
        $stmt->execute();
        echo "<script>
                alert('Đã đổi mật khẩu thành công');
                window.location.href = 'logout.php';
              </script>";
              exit;
    } else {
        echo "<script>
                alert('Không đúng mật khẩu');
                window.location.href = 'reset-password.php';
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/css/login.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
</head>
<body>
    <?php 
    require 'site.php';
    load_top();
    load_backbtn();
    ?>
    <div id="reset-pass">
        <div class="form-container">
            <h2>ĐẶT LẠI MẬT KHẨU</h2>
            <form action="#" method="post">
                <label for="old-password">Mật khẩu cũ</label>
                <input type="password" id="old-password" name="old-password" placeholder="Nhập mật khẩu cũ" required>

                <label for="new-password">Mật khẩu mới</label>
                <input type="password" id="new-password" name="new-password" placeholder="Nhập mật khẩu mới" required>

                <label for="confirm-password">Xác nhận mật khẩu mới</label>
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Xác nhận lại mật khẩu mới" required>

                <button type="submit">Đổi mật khẩu</button>
            </form>
        </div>
    </div>
    <?php load_footer(); ?>
</body>
</html>
