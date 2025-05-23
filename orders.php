<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$makh = $_SESSION['username'];

// Kết nối CSDL
$host = "localhost";
$user = "root";
$pass = "123456";
$dbname = "qlbh"; // 🔁 Thay bằng tên CSDL thực tế của bạn

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn đơn hàng của khách hàng
$sql = "
    SELECT 
        hd.soHD,
        hd.ngayHD,
        sp.tensp,
        sp.url,
        cthd.size,
        cthd.soluong,
        cthd.giaban,
        sp.masp
    FROM hoadon hd
    JOIN chitiethoadon cthd ON hd.soHD = cthd.soHD
    JOIN sanpham sp ON cthd.masp = sp.masp
    WHERE hd.makh = ?
    ORDER BY hd.ngayHD DESC, hd.soHD DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $makh);
$stmt->execute();
$result = $stmt->get_result();

// Hiển thị HTML
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng của tôi</title>
    <style>
        .donhang { border: 1px solid #ccc; padding: 10px; margin: 15px 0; border-radius: 10px; }
        .sanpham { display: flex; gap: 15px; margin-bottom: 10px; }
        .sanpham img { width: 100px; height: auto; object-fit: cover; border-radius: 8px; }
        button { padding: 5px 10px; background: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h2>Đơn hàng của tôi</h2>

    <?php
    $current_soHD = null;
    while ($row = $result->fetch_assoc()) {
        if ($row['soHD'] != $current_soHD) {
            if ($current_soHD !== null) {
                echo "</div>"; // Kết thúc div đơn hàng trước
            }
            $current_soHD = $row['soHD'];
            echo "<div class='donhang'>";
            echo "<h3>Đơn hàng #{$row['soHD']} - Ngày đặt: {$row['ngayHD']}</h3>";
        }

        echo "<div class='sanpham'>";
        echo "<img src='{$row['url']}' alt='{$row['tensp']}'>";
        echo "<div>";
        echo "<strong>Tên sản phẩm:</strong> {$row['tensp']}<br>";
        echo "<strong>Size:</strong> {$row['size']}<br>";
        echo "<strong>Số lượng:</strong> {$row['soluong']}<br>";
        echo "<strong>Giá:</strong> " . number_format($row['giaban'], 0, ',', '.') . " VNĐ<br>";
        echo "<a href='muagain.php?masp={$row['masp']}'><button>Mua lại</button></a>";
        echo "</div>";
        echo "</div>";
    }

    if ($current_soHD !== null) {
        echo "</div>"; // Đóng thẻ div cuối cùng nếu có dữ liệu
    } else {
        echo "<p>Bạn chưa có đơn hàng nào.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
</body>
</html>