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
    $trangthai = 'Mua ngay (Hủy)';

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
    $trangthai = 'Mua bằng giỏ hàng (Hủy)';

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
</head>
<body>
    <?php
    require 'site.php';
    load_top();
    load_backbtn();
    ?>
    <div id="hoadon-container">
    <h2>Hóa đơn thanh toán</h2>
    <div class="hoadon-body">
    <div class="label-sanpham">
        <?php foreach ($items as $item): ?>
        <div class="item-sp">
            <img src="<?= htmlspecialchars($item['url']) ?>" alt="Ảnh sản phẩm">
            <div class="info">
                <div class="tensp"><strong><?= htmlspecialchars($item['tensp']) ?></strong></div>
                <div class="size">Size: <?= htmlspecialchars($item['size']) ?> x SL: <?= $item['soluong'] ?></div>
                <div class="dongia">Đơn giá: <?= number_format($item['gia'], 0, ',', '.') ?> VNĐ</div>
                <div class="thanhtien">Thành tiền: <strong style="color: #e53935"><?= number_format($item['subtotal'], 0, ',', '.') ?> VNĐ</strong></div>
            </div>
        </div>
        <?php endforeach; ?>

        <div style="text-align: right; font-size: 18px; margin-top: 20px;">
            <strong>Tổng cộng: <?= number_format($tong, 0, ',', '.') ?> VNĐ</strong>
        </div>
    </div>

    <div class="label-thongtin">
        <h2>Thông tin giao hàng</h2>
        <p><strong>Họ tên:</strong> <?= htmlspecialchars($kh['hoten']) ?></p>
        <p><strong>Ngày sinh:</strong> <?= htmlspecialchars($kh['ngaysinh']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($kh['sodt']) ?></p>
        <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($kh['thongtin_lienhe']) ?></p>
        <a href="myaccount.php" class="thaydoi">Thay đổi thông tin</a>
    </div>

    <form action="add_order.php" method="post">
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
</div>

</body>
</html>
