<?php
    require '../site.php';
    load_top();
?>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kết nối CSDL
    $conn = mysqli_connect("localhost", "root", "123456", "QLBH");

    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }

    // Kiểm tra tên đăng nhập và mật khẩu
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && $password === $user['password']) {
        // Đăng nhập thành công
        $_SESSION['username'] = $user['username'];
        $_SESSION['firstname'] = $user['ten'];
        $_SESSION['lastname'] = $user['ho'];
    
        header('Location: ../index.php');
        exit;
    } else {
        echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu!'); window.history.back();</script>";
    }
    
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="vi">    
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập BT SHOP</title>
    <link rel="stylesheet" href="../accsets/css/login.css">
    <link rel="stylesheet" href="../accsets/css/base.css">
    <link rel="stylesheet" href="../accsets/css/grid.css">
    <link rel="stylesheet" href="../accsets/fonts/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../accsets/css/main.css">
</head>

<body>
    <div class="login-container">
        <div class="left-panel">
            <img src= "../accsets/images/logo.png" alt="BT Shop Logo" class="logo">
            <h2>BT SHOP</h2>
            <p>Vua của các quý ông</p>
        </div>
        <div class ="right-panel">
            <div class="back-home">
                <i class="back-icon ti-angle-left"></i>
                <a href="../index.php">Trang chủ</a>
            </div>
            <h2>ĐĂNG NHẬP</h2>

            <form action ="login.php" method="POST">
                <input type="text" name="username" placeholder="Email/Số điện thoại/Tên dăng nhập" required>
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <button type="submit">ĐĂNG NHẬP</button>
            </form>

            <div class="options">
                <a href = "#"> Quên mật khẩu </a>
                <a href = "#"> Đăng nhập bằng số điện thoại SMS</a>
            </div>

            <div class="login-with">
                <button class="social facebook">
                    <i class="face-icon ti-facebook"></i>
                    Facebook
                </button>
                <button class="social google">
                    <i class="gg-icon ti-google"></i>
                    Google
                </button>
            </div>

            <p class="reg">Bạn mới biết đến BT shop? <a href="register.php"> Đăng ký</a></p>
        </div>
    </div>
</body>
</html>
<?php
    load_footer();
?>