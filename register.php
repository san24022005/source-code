<?php
    require 'site.php';
    load_top();
?>
<?php
session_start();

// Kết nối đến MySQL
$conn = mysqli_connect("localhost", "root", "123456", "QLBH");

if (!$conn) {
    die("Không thể kết nối CSDL: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận dữ liệu từ form
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm = $_POST['nhaplaimatkhau'];

    // Kiểm tra mật khẩu có khớp không
    if ($password !== $confirm) {
        echo "<script>alert('Mật khẩu không khớp!'); window.history.back();</script>";
        exit();
    }

    // Kiểm tra tên đăng nhập đã tồn tại chưa
    $sql_check = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql_check);
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Tên đăng nhập đã tồn tại.'); window.history.back();</script>";
        exit();
    }

    // Thêm người dùng vào CSDL
    $sql_insert = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($conn, $sql_insert)) {
        $_SESSION['username'] = $username;
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;

        echo "<script>alert('Đăng ký thành công!'); window.location='index.php';</script>";
    } else {
        echo "Lỗi khi đăng ký: " . mysqli_error($conn);
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

            <form action="register.php" method="post">
                <input type="text" name="firstname" placeholder="Tên" required>
                <input type="text" name="lastname" placeholder="Họ" required>
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
