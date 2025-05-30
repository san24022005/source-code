<?php
session_start();
$conn = new mysqli("localhost", "root", "123456", "qlbh");
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$makh = $_SESSION['username'];

// Truy vấn giỏ hàng
$stmt = $conn->prepare("
    SELECT g.masp, g.size, g.soluong, s.tensp, s.gia, s.url
    FROM giohang g
    JOIN sanpham s ON g.masp = s.masp
    WHERE g.makh = ?
");
$stmt->bind_param("s", $makh);
$stmt->execute();
$result = $stmt->get_result();
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
    <h2>Giỏ hàng của bạn</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Hình ảnh</th>
            <th>Tên SP</th>
            <th>Size</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng</th>
        </tr>
        <?php
        $tong = 0;
        while ($item = $result->fetch_assoc()):
            $subtotal = $item['gia'] * $item['soluong'];
            $tong += $subtotal;
        ?>
        <tr>
            <td><img src="<?= htmlspecialchars($item['url']) ?>" width="80"></td>
            <td><?= htmlspecialchars($item['tensp']) ?></td>
            <td><?= htmlspecialchars($item['size']) ?></td>
            <td><?= number_format($item['gia'], 0, ',', '.') ?> VNĐ</td>
            <td><?= $item['soluong'] ?></td>
            <td><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</td>
        </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="5" align="right"><strong>Tổng cộng:</strong></td>
            <td><strong><?= number_format($tong, 0, ',', '.') ?> VNĐ</strong></td>
        </tr>
    </table>
</body>
</html>
