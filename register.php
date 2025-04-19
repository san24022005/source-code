<?php
    require 'site.php';
    load_top();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BT Shop</title>
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/css/grid.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="./accsets/css/login.css">
</head>
<body>
    <div class="register">
        <div class="left-panel">
            <img src="./accsets/images/logo.png" alt="BT Shop Logo" class="logo">
            <h2>BT SHOP</h2>
            <p>Vua của các quý ông</p>
        </div>
        <div class="right-panel">
            <div class="back-home">
                <i class="back-icon ti-angle-left"></i>
                <a href="index.php">Trang chủ</a>
            </div>
            <h2>TẠO TÀI KHOẢN</h2>

            <button class="social-btn google">
                <i class="gg-icon ti-google"></i>
                Google
            </button>
            <button class="social-btn facebook">
                <i class="face-icon ti-facebook"></i>
                Facebook
            </button>

            <form action="dangky.php" method="post">
                <input type="text" name="ten" placeholder="Tên" required>
                <input type="text" name="ho" placeholder="Họ" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="matkhau" placeholder="Mật khẩu" required>
	            <input type="password" name="nhaplaimatkhau" placeholder="Nhập lại mật khẩu" required>
                <button type="submit" class="btn-submit">ĐĂNG KÝ</button>
            </form>
        </div>
    </div>  
</body>
</html>
<?php
    load_footer();
?>
