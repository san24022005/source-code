<?php
    require 'site.php';
    load_top();
?>
<?php
session_start();

// Kết nối đến MySQL
require 'connect.php';

if (!$conn) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận dữ liệu từ form
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['nhaplaimatkhau'];

    // Kiểm tra mật khẩu có khớp không
    if ($password !== $confirm) {
        echo "<script>alert('Mật khẩu không khớp!'); window.history.back();</script>";
        exit();
    }

    // Kiểm tra tên đăng nhập đã tồn tại chưa
    $sql_check = "SELECT * FROM taikhoan WHERE username = '$username'";
    $result = mysqli_query($conn, $sql_check);
    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }
    if (mysqli_num_rows($result) > 0) {

        echo "<script>alert('Tên đăng nhập đã tồn tại.'); window.history.back();</script>";
        exit();
    }

    // Thêm người dùng vào CSDL
    $sql_insert_khachhang = "INSERT INTO khachhang (makh, doanhso, hoten) VALUES ('$username', 0, '$name')";
    $sql_insert_taikhoan = "INSERT INTO taikhoan (username, password, vaitro) VALUES ('$username', '$password', 'user')";
    $sql_insert_thongtin = "INSERT INTO thongtin_lienhe (makh) VALUES ('$username')";

    if (!mysqli_query($conn, $sql_insert_khachhang)) {
        echo "Lỗi khi thêm vào bảng khachhang: " . mysqli_error($conn);
        exit();
    }

    if (!mysqli_query($conn, $sql_insert_taikhoan)) {
        echo "Lỗi khi thêm vào bảng taikhoan: " . mysqli_error($conn);
        exit();
    }

    if (!mysqli_query($conn, $sql_insert_thongtin)) {
        echo "Lỗi khi thêm vào bảng thongtin: " . mysqli_error($conn);
        exit();
    } else {
        $_SESSION['username'] = $username;
        $_SESSION['name'] = $name;
        echo "<script>alert('Đăng ký thành công!'); window.location='index.php';</script>";
    }
    // Đóng kết nối sau khi hoàn thành
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BT Shop</title>
    <link rel="stylesheet" href="accsets/css/login.css">
    <link rel="stylesheet" href="accsets/css/base.css">
    <link rel="stylesheet" href="accsets/fonts/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="accsets/css/main.css">
</head>
<body>
    <div class="register">
        <div class="left-panel">
            <img src="accsets/images/logo.png" alt="Logo" class="logo">
            <h2>Chào mừng khách hàng đến với BT SHOP</h2>
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

            <form action="register.php" method="post">
                <input type="text" name="name" placeholder="Họ và Tên" required>
                <input type="text" name="username" placeholder="Tên đăng nhập" required>
                <input type="password" name="password" placeholder="Mật khẩu" required>
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
