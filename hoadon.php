<?php
session_start();
$conn = new mysqli("localhost", "root", "123456", "qlbh");
$conn->set_charset("utf8mb4");

if (!isset($_SESSION['username'])) {
    die("Bạn chưa đăng nhập.");
}
$makh = $_SESSION['username'];

// Xử lý nhận dữ liệu sản phẩm từ GET hoặc POST (lần đầu vào)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['masp'], $_GET['size'], $_GET['soluong'])) {
    $_SESSION['cart_temp'] = [
        'type' => 'muanay',
        'masp' => $_GET['masp'],
        'size' => $_GET['size'],
        'soluong' => intval($_GET['soluong']),
    ];
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['chon'])) {
    $_SESSION['cart_temp'] = [
        'type' => 'giohang',
        'chon' => $_POST['chon'],
    ];
    header("Location: hoadon.php"); // chuyển hướng tránh gửi lại POST
    exit();
}

// Nếu session cart_temp chưa tồn tại thì báo lỗi
if (!isset($_SESSION['cart_temp'])) {
    die("Không có sản phẩm nào được chọn.");
}

// Lấy sản phẩm dựa trên session cart_temp
$items = [];
$tong = 0;
$trangthai = '';

if ($_SESSION['cart_temp']['type'] === 'muanay') {
    $masp = $_SESSION['cart_temp']['masp'];
    $size = $_SESSION['cart_temp']['size'];
    $soluong = $_SESSION['cart_temp']['soluong'];
    $trangthai = 'Mua ngay (Hủy)';

    $stmt = $conn->prepare("SELECT tensp, gia, url FROM sanpham WHERE masp = ?");
    $stmt->bind_param("s", $masp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $row['masp'] = $masp;
        $row['size'] = $size;
        $row['soluong'] = $soluong;
        $row['subtotal'] = $row['gia'] * $soluong;
        $tong = $row['subtotal'];
        $items[] = $row;
    } else {
        die("Sản phẩm không tồn tại.");
    }
} elseif ($_SESSION['cart_temp']['type'] === 'giohang') {
    $chon = $_SESSION['cart_temp']['chon'];
    $trangthai = 'Mua bằng giỏ hàng (Hủy)';
    $tong = 0;

    foreach ($chon as $value) {
        list($masp, $size) = explode('|', $value);

        $stmt = $conn->prepare("SELECT s.tensp, s.gia, s.url, g.soluong
                                FROM giohang g
                                JOIN sanpham s ON g.masp = s.masp
                                WHERE g.makh = ? AND g.masp = ? AND g.size = ?");
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
}

// Lấy thông tin khách hàng
$sql_kh = "SELECT kh.makh, kh.hoten, kh.ngaysinh, tl.sodt, tl.email, tl.sonha, tl.capxa, tl.caphuyen, tl.captinh
           FROM khachhang kh
           JOIN thongtin_lienhe tl ON kh.makh = tl.makh
           WHERE kh.makh = '$makh'";
$result_kh = $conn->query($sql_kh);
if (!$result_kh || $result_kh->num_rows == 0) {
    die("Không tìm thấy thông tin khách hàng.");
}
$kh = $result_kh->fetch_assoc();

// Kiểm tra thông tin giao hàng bắt buộc
$can_update_info = false;
$required_fields = ['hoten', 'sodt', 'sonha', 'capxa', 'caphuyen', 'captinh'];

foreach ($required_fields as $field) {
    if (empty(trim($kh[$field] ?? ''))) {
        $can_update_info = true;
        break;
    }
}

// Hàm tạo số hóa đơn mới
function generateSoHD($conn) {
    $sql = "SELECT soHD FROM hoadon ORDER BY soHD DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastSoHD = $row['soHD'];
        $num = (int)substr($lastSoHD, 2);
        $newNum = $num + 1;
    } else {
        $newNum = 1;
    }

    return 'HD' . str_pad($newNum, 3, '0', STR_PAD_LEFT);
}

$soHD = generateSoHD($conn);
$manv = 'NV01';
$ngayHD = date('Y-m-d');
$trigia = $tong;

// Tạo hóa đơn mới trong CSDL
$sql_insertHD = "INSERT INTO hoadon (soHD, ngayHD, makh, manv, trigia, trangthai) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insertHD);
$stmt->bind_param("ssssds", $soHD, $ngayHD, $makh, $manv, $trigia, $trangthai);
if (!$stmt->execute()) {
    echo "<p class='error'>Lỗi tạo hóa đơn: " . $conn->error . "</p>";
}
$stmt->close();

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Hóa đơn thanh toán</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="./accsets/css/main.css" />
    <link rel="stylesheet" href="./accsets/css/base.css" />
    <link rel="stylesheet" href="./accsets/css/table.css" />
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css" />
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
                        <img src="<?= htmlspecialchars($item['url']) ?>" alt="Ảnh sản phẩm" />
                        <div class="info">
                            <div class="tensp"><strong><?= htmlspecialchars($item['tensp']) ?></strong></div>
                            <div class="size">Size: <?= htmlspecialchars($item['size']) ?> x SL: <?= $item['soluong'] ?></div>
                            <div class="dongia">Đơn giá: <?= number_format($item['gia'], 0, ',', '.') ?> VNĐ</div>
                            <div class="thanhtien">Thành tiền: <strong style="color:#e53935"><?= number_format($item['subtotal'], 0, ',', '.') ?> VNĐ</strong></div>
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
                <p><strong>Email:</strong> <?= htmlspecialchars($kh['email']) ?></p>
                <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($kh['sonha'] . ', ' . $kh['capxa'] . ', ' . $kh['caphuyen'] . ', ' . $kh['captinh']) ?></p>
                <button class="btn-edit-address js-edit-address">Cập nhật</button>
            </div>

            <?php if ($can_update_info): ?>
    <p style="color: red; font-weight: bold;">
        Vui lòng cập nhật đầy đủ thông tin giao hàng trước khi thanh toán.
    </p>
<?php else: ?>
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
<?php endif; ?>

        </div>
    </div>

    <!-- Modal chỉnh sửa địa chỉ -->
    <div class="modal-address" style="display:none;">
        <?php load_modal_address(); ?>
    </div>

    <script src="./accsets/js/modal-address.js"></script>
</body>
</html>
