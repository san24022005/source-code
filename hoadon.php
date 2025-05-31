<?php
session_start();
$conn = new mysqli("localhost", "root", "123456", "qlbh");
$conn->set_charset("utf8mb4");

if (!isset($_SESSION['username'])) {
    die("Bạn chưa đăng nhập.");
}
$makh = $_SESSION['username'];

$username = $conn->real_escape_string($_SESSION['username']);

$sql_kh = "SELECT kh.makh, hoten, thongtin_lienhe, ngaysinh, sodt 
            FROM khachhang kh 
            JOIN thongtin_lienhe tt ON kh.makh = tt.makh 
            WHERE kh.makh = '$username'";
$result_kh = $conn->query($sql_kh);
$kh = $result_kh->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['masp'], $_GET['size'], $_GET['soluong'])) {
    $masp = $_GET['masp'];
    $size = $_GET['size'];
    $soluong = intval($_GET['soluong']);

    $stmt = $conn->prepare("
        SELECT tensp, gia, url FROM sanpham WHERE masp = ?
    ");
    $stmt->bind_param("s", $masp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $row['masp'] = $masp;
        $row['size'] = $size;
        $row['soluong'] = $soluong;
        $row['subtotal'] = $row['gia'] * $soluong;
        $tong = $row['subtotal'];
        $items = [$row];
    } else {
        die("Sản phẩm không tồn tại.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chon'])) {
    $chon = $_POST['chon'];
    $tong = 0;
    $items = [];

    foreach ($chon as $value) {
        list($masp, $size) = explode('|', $value);

        $stmt = $conn->prepare("
            SELECT s.tensp, s.gia, s.url, g.soluong
            FROM giohang g
            JOIN sanpham s ON g.masp = s.masp
            WHERE g.makh = ? AND g.masp = ? AND g.size = ?
        ");
        $stmt->bind_param("sss", $makh, $masp, $size);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $row['masp'] = $masp;
            $row['size'] = $size;
            $row['subtotal'] = $row['gia'] * $row['soluong'];
            $tong += $row['subtotal'];
            $items[] = $row;
        }
    }
}  elseif (!isset($items)) {
    die("Không có sản phẩm nào được chọn.");
}

function generateSoHD($conn) {
    $sql = "SELECT soHD FROM hoadon ORDER BY soHD DESC LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastSoHD = $row['soHD'];
        $num = (int)substr($lastSoHD, 2); // bỏ 'HD' và lấy số
        $newNum = $num + 1;
    } else {
        $newNum = 1;
    }
    
    return 'HD' . str_pad($newNum, 3, '0', STR_PAD_LEFT); // HD001, HD002, ...
}

// Tạo số hóa đơn mới
$soHD = generateSoHD($conn);
$makh = $kh['makh'];
$manv = 'NV01'; // cố định như yêu cầu
$trigia = 0;
$trangthai = 'Hủy';
$ngayHD = date('Y-m-d');

// Kiểm tra xem hóa đơn đã tồn tại cho session này chưa để tránh trùng
$sql_insertHD = "INSERT INTO hoadon (soHD, ngayHD, makh, manv, trigia, trangthai)
                VALUES ('$soHD', '$ngayHD', '$makh', '$manv', '$trigia', '$trangthai')";

if (!$conn->query($sql_insertHD)) {
    echo "<p class='error'>Lỗi tạo hóa đơn: " . $conn->error . "</p>";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn thanh toán</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/css/table.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
    }

    table {
        border-collapse: collapse;
        width: 90%;
        margin: 0 auto;
        background-color: #fff;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    th {
        background-color: #4CAF50;
        color: white;
        padding: 12px;
        font-size: 16px;
    }

    td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    img {
        width: 60px;
        height: auto;
        border-radius: 4px;
    }

    strong {
        color: #e53935;
        font-size: 18px;
    }

    .btn-dathang {
        display: block;
        margin: 30px auto;
        padding: 12px 24px;
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-dathang:hover {
        background-color: #45a049;
    }
</style>

</head>
<body>
    <div id="hoadon">
    <h2>Hóa đơn thanh toán</h2>
    <table>
        <tr>
            <th>Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Size</th>
            <th>Giá</th>
            <th>Số lượng</th>
            <th>Thành tiền</th>
        </tr>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><img src="<?= htmlspecialchars($item['url']) ?>"></td>
            <td><?= htmlspecialchars($item['tensp']) ?></td>
            <td><?= htmlspecialchars($item['size']) ?></td>
            <td><?= number_format($item['gia'], 0, ',', '.') ?> VNĐ</td>
            <td><?= $item['soluong'] ?></td>
            <td><?= number_format($item['subtotal'], 0, ',', '.') ?> VNĐ</td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="5"><strong>Tổng cộng:</strong></td>
            <td><strong><?= number_format($tong, 0, ',', '.') ?> VNĐ</strong></td>
        </tr>
    </table>
    <div style="width: 90%; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h3>Thông tin khách hàng</h3>
    <p><strong>Họ tên:</strong> <?= htmlspecialchars($kh['hoten']) ?></p>
    <p><strong>Ngày sinh:</strong> <?= htmlspecialchars($kh['ngaysinh']) ?></p>
    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($kh['sodt']) ?></p>
    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($kh['thongtin_lienhe']) ?></p>
</div>
<form action="thanhtoan.php" method="post" style="text-align: center; margin-top: 30px;">
    <?php foreach ($items as $item): ?>
        <input type="hidden" name="masp[]" value="<?= htmlspecialchars($item['masp']) ?>">
        <input type="hidden" name="size[]" value="<?= htmlspecialchars($item['size']) ?>">
        <input type="hidden" name="soluong[]" value="<?= htmlspecialchars($item['soluong']) ?>">
        <input type="hidden" name="gia[]" value="<?= htmlspecialchars($item['gia']) ?>">
    <?php endforeach; ?>
    <input type="hidden" name="soHD" value="<?= $soHD ?>">
    <input type="hidden" name="tongtien" value="<?= $tong ?>">
    <button type="submit" class="btn-dathang">Thanh toán</button>
</form>

</div>
</body>
</html>
