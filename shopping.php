<?php
session_start();
require('connect.php');

if (!$conn) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

if (!isset($_GET['masp'], $_GET['size'], $_GET['soluong'])) {
    die("Thiếu thông tin sản phẩm.");
}

$masp = $conn->real_escape_string($_GET['masp']);
$size = $conn->real_escape_string($_GET['size']);
$soluong = (int)$_GET['soluong'];
$username = $conn->real_escape_string($_SESSION['username']);

$sql = "SELECT masp, tensp, gia, url, mota, kieu FROM sanpham WHERE masp = '$masp'";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
die("<p>Không tìm thấy sản phẩm.</p>");
}

$row = $result->fetch_assoc();

$sql_kh = "SELECT kh.makh, hoten, thongtin_lienhe, ngaysinh, sodt 
            FROM khachhang kh 
            JOIN thongtin_lienhe tt ON kh.makh = tt.makh 
            WHERE kh.makh = '$username'";
$result_kh = $conn->query($sql_kh);
$kh = $result_kh->fetch_assoc();
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
$trigia = $row['gia'] * $soluong;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin hóa đơn</title>
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/css/table.css">
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
</head>
<body>
<?php 
require 'site.php';
load_top();
load_backbtn();
?>
<div class="label-shopping">
    <div class="label-shopping-container">
        <div class="shopping-header">
            <h2>Thông tin hóa đơn</h2>  
        </div>
        <div class="shopping-body">
        <form method="POST" action="thanhtoan.php">
        <table class="label-shopping-table">
            <tr>
                <td rowspan="6" class="label-image">
                    <?php
                    
                    echo "<img src='{$row['url']}' width='100%'/>";?>
                </td>

                <td rowspan="6" class="label-ngancach"></td>
            </tr>
               
            <tr>
                <td colspan="2" class="label-thongtinsp"><?php
                    echo "<h3>{$row['tensp']}</h3>";
                    echo "<p><strong>Loại:</strong> " . htmlspecialchars($row['kieu']) . "</p>";
                    echo "<p><strong>Đơn giá: " . number_format($row['gia']) . " VNĐ</strong></p>";
                    echo "<p><strong>Size đã chọn:</strong> " . htmlspecialchars($size) . "</p>";
                    echo "<p><strong>Số lượng:</strong> $soluong</p>";
                    ?>
                </td>
            </tr>
            <tr >
                <td class="label-khachhang" colspan="2">
                    <?php 
                    if (!isset($_SESSION['username'])) {
                        echo "<p class='error'>Bạn chưa đăng nhập. Vui lòng <a href='login.php'>đăng nhập</a> để tiếp tục.</p>";
                        exit();
                    }

                    if (!$result_kh || $result_kh->num_rows === 0) {
                        echo "<p>Không tìm thấy thông tin khách hàng.</p>";
                    } else {
                        echo "<h3>Thông tin giao hàng</h3>";
                        echo "<p><strong>Họ tên:</strong> {$kh['hoten']}</p>";
                        echo "<p><strong>Địa chỉ:</strong> {$kh['thongtin_lienhe']}</p>";
                        echo "<p><strong>Số điện thoại:</strong> {$kh['sodt']}</p>";
                        echo "<p><strong>Ngày sinh:</strong> {$kh['ngaysinh']}</p>";
                    }
                    ?>
                    <div class="btn-thaydoi"><a href="myaccount.php">Thay đổi</a></div>
                </td>
            </tr>

            <tr class="label-thanhtoan">
                <td colspan="2"><h3>Chi tiết thanh toán</h3></td>
            </tr>

            <tr>
                <td class="tieude-gia">
                    <p>Đơn giá:</p>
                    <p>Phí vận chuyển:</p>
                    <p>Giảm giá:</p>
                    <p>Thành tiền:</p>
                </td>
                <td class="gia">
                    <?php 
                    $tongtien = $row['gia'] * $soluong;
                    ?>
                    <p><?php echo number_format($row['gia']); ?> VNĐ</p>
                    <p><strong>Miễn phí</strong></p>
                    <p>0 VNĐ</p>
                    <p><strong><?php echo number_format($tongtien); ?> VNĐ</strong></p>
                </td>
            </tr>

            <tr>
                <td colspan="3" class="label-btn">
                    <div>
                        <input type="hidden" name="masp" value="<?php echo htmlspecialchars($masp); ?>">
                        <input type="hidden" name="size" value="<?php echo htmlspecialchars($size); ?>">
                        <input type="hidden" name="quantity" value="<?php echo $soluong; ?>">
                        <input type="hidden" name="soHD" value="<?php echo $soHD; ?>">
                        <button type="submit" class="btn btn-buy">Đặt hàng</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="label-mota">
                    <h3>MÔ TẢ SẢN PHẨM</h3>
                    <p><?php echo htmlspecialchars($row['mota']); ?></p>
                </td>
            </tr>
        </table>
        </form>
        </div>
    </div>   
</div>
<?php load_footer(); ?>
</body>
</html>
