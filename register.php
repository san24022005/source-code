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
        <div class="left-register">
            <img src="./accsets/images/logo.png" alt="BT Shop Logo" class="logo">
            <h2>BT SHOP</h2>
            <p>Vua của các quý ông</p>
        </div>
        <div class="right-register">
                <h2>TẠO TÀI KHOẢN</h2>

                <button class="social-btn google">Đăng nhập Google</button>
                <button class="social-btn facebook">Đăng nhập Facebook</button>

                <form action="dangky.php" method="post">
                    <input class="form-input" type="text" name="ten" placeholder="Tên" required>
                    <input class="form-input" type="text" name="ho" placeholder="Họ" required>
                    <input class="form-input" type="email" name="email" placeholder="Email" required>
                    <input class="form-input" type="password" name="matkhau" placeholder="Mật khẩu" required>
	                <input class="form-input" type="password" name="nhaplaimatkhau" placeholder="Nhập lại mật khẩu" required>
                    <button type="submit" class="btn-submit">ĐĂNG KÝ</button>
                </form>

                <div class="back-link">
                    <a href="#">Trở về</a>
                </div>
        </div>
    </div>  
</body>
</html>
<?php
    load_footer();
?>
