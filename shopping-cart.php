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
// Xử lý cập nhật, xoá, thanh toán
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cập nhật số lượng
    if (isset($_POST['capnhat']) && isset($_POST['soluong'])) {
        foreach ($_POST['soluong'] as $masp => $sizes) {
            foreach ($sizes as $size => $soluong) {
                $stmt = $conn->prepare("UPDATE giohang SET soluong = ? WHERE makh = ? AND masp = ? AND size = ?");
                $stmt->bind_param("isss", $soluong, $makh, $masp, $size);
                $stmt->execute();
            }
        }
    }

    // Xoá sản phẩm
    if (isset($_POST['xoa'])) {
        $masp = $_POST['masp'];
        $size = $_POST['size'];
        $stmt = $conn->prepare("DELETE FROM giohang WHERE makh = ? AND masp = ? AND size = ?");
        $stmt->bind_param("sss", $makh, $masp, $size);
        $stmt->execute();
    }

    // Thanh toán
    if (isset($_POST['thanhtoan']) && isset($_POST['chon'])) {
        $sanphams = $_POST['chon'];
        echo "<h3>Thanh toán thành công các sản phẩm sau:</h3><ul>";
        foreach ($sanphams as $sp) {
            list($masp, $size) = explode('|', $sp);
            echo "<li>Mã sản phẩm: $masp, Size: $size</li>";
            $stmt = $conn->prepare("DELETE FROM giohang WHERE makh = ? AND masp = ? AND size = ?");
            $stmt->bind_param("sss", $makh, $masp, $size);
            $stmt->execute();
        }
        echo "</ul><a href='giohang.php'>Quay lại giỏ hàng</a>";
        exit();
    }
}

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
=======
    <h2>Giỏ hàng của bạn</h2>
    <form method="post">
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Chọn</th>
            <th>Hình ảnh</th>
            <th>Tên SP</th>
            <th>Size</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Tổng</th>
            <th>Xoá</th>
        </tr>

        <?php
        if ($result->num_rows === 0) {
            echo "<tr><td colspan='8'>Giỏ hàng trống.</td></tr>";
        } else {
            $tong = 0;
            while ($item = $result->fetch_assoc()):
                $subtotal = $item['gia'] * $item['soluong'];
                $tong += $subtotal;
        ?>
        <tr>
            <td><input type="checkbox" name="chon[]" value="<?= $item['masp'] . '|' . $item['size'] ?>"></td>
            <td><img src="<?= htmlspecialchars($item['url']) ?>" width="80"></td>
            <td><?= htmlspecialchars($item['tensp']) ?></td>
            <td><?= htmlspecialchars($item['size']) ?></td>
            <td><?= number_format($item['gia'], 0, ',', '.') ?> VNĐ</td>
            <td><input type="number" name="soluong[<?= $item['masp'] ?>][<?= $item['size'] ?>]" value="<?= $item['soluong'] ?>" min="1" style="width: 60px;"></td>
            <td><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</td>
            <td>
                <form method="post" style="display:inline;" onsubmit="return confirm('Xoá sản phẩm này?');">
                    <input type="hidden" name="masp" value="<?= htmlspecialchars($item['masp']) ?>">
                    <input type="hidden" name="size" value="<?= htmlspecialchars($item['size']) ?>">
                    <button type="submit" name="xoa">Xoá</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
        <tr>
            <td colspan="6" align="right"><strong>Tổng cộng:</strong></td>
            <td colspan="2"><strong><?= number_format($tong, 0, ',', '.') ?> VNĐ</strong></td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <button type="submit" name="capnhat">Cập nhật giỏ hàng</button>
    <button type="submit" name="thanhtoan" onclick="return confirm('Xác nhận thanh toán các sản phẩm đã chọn?');">Thanh toán</button>
    </form>
</body>
</html>
