<?php
session_start();
$conn = new mysqli("localhost", "root", "123456", "qlbh");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý thêm vào giỏ hàng nếu có POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['masp'], $_POST['size'], $_POST['soluong'])) {
    $masp = $_POST['masp'];
    $size = $_POST['size'];
    $soluong = (int)$_POST['soluong'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $key = $masp . "_" . $size;
    if (isset($_SESSION['cart'][$key])) {
        $_SESSION['cart'][$key]['soluong'] += $soluong;
    } else {
        $_SESSION['cart'][$key] = [
            'masp' => $masp,
            'size' => $size,
            'soluong' => $soluong
        ];
    }
    echo "success";
    exit();
}

// Lấy sản phẩm
$sql = "SELECT * FROM sanpham";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sản phẩm</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-giohang').forEach(button => {
            button.addEventListener('click', function () {
                const masp = this.getAttribute('data-masp');
                const size = this.getAttribute('data-size');
                const soluong = this.getAttribute('data-soluong');

                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `masp=${masp}&size=${size}&soluong=${soluong}`
                })
                .then(response => response.text())
                .then(data => {
                    alert('Đã thêm vào giỏ hàng!');
                })
                .catch(error => {
                    alert('Lỗi thêm sản phẩm');
                });
            });
        });
    });
    </script>
    <style>
        .product-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px;
            width: 200px;
            display: inline-block;
            vertical-align: top;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        }
        .btn {
            background-color: #3399ff;
            color: white;
            border: none;
            padding: 8px 12px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<h2>Sản phẩm</h2>
<div class="product-list">
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product-card'>";
        echo "<img src='{$row['url']}' alt='{$row['tensp']}' width='180'>";
        echo "<h3>{$row['tensp']}</h3>";
        echo "<p>Giá: " . number_format($row['gia'], 0, ',', '.') . " VND</p>";
        echo "<button class='btn btn-giohang' data-masp='{$row['masp']}' data-size='M' data-soluong='1'><i class='fas fa-cart-plus'></i> Thêm vào giỏ</button>";
        echo "<a href='deltails.php?masp={$row['masp']}'><button class='btn'>Xem chi tiết</button></a>";
        echo "<button class='btn'>Mua ngay</button>";
        echo "</div>";
    }
} else {
    echo "<p>Không có sản phẩm nào.</p>";
}
?>
</div>
</body>
</html>
