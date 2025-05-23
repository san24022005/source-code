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
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin hóa đơn</title>
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/css/grid.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
</head>
<body>
<?php 
require 'site.php';
load_top();
?>
<div class="modal-buy">
    <div class="modal-container">
        <a href="index.php">
            <div class="home-page">
                <i class="ti-angle-left"></i> Quay về trang chủ
            </div>
        </a>
        <div class="modal-header">
            <h2>Thông tin hóa đơn</h2>  
        </div>
        <div class="modal-body">
        <form method="POST" action="thanhtoan.php">
        <table>
            <tr>
                <td class="modal-label label-product">
                    <?php
                    $sql = "SELECT masp, tensp, gia, url FROM sanpham WHERE masp = '$masp'";
                    $result = $conn->query($sql);

                    if (!$result || $result->num_rows === 0) {
                        die("<p>Không tìm thấy sản phẩm.</p>");
                    }

                    $row = $result->fetch_assoc();
                    echo "<img src='{$row['url']}' width='100%'/>";
                    echo "<h3>{$row['tensp']}</h3>";
                    echo "<p><strong>Giá: " . number_format($row['gia']) . " VNĐ</strong></p>";
                    echo "<p><strong>Size đã chọn:</strong> " . htmlspecialchars($size) . "</p>";
                    echo "<p><strong>Số lượng:</strong> $soluong</p>";
                    ?>
                </td>

                <td class="modal-label label-khachhang">
                    <div style="text-align: right;"><a href="#">Chỉnh sửa</a></div>
                    <?php 
                    if (!isset($_SESSION['username'])) {
                        echo "<p class='error'>Bạn chưa đăng nhập. Vui lòng <a href='login.php'>đăng nhập</a> để tiếp tục.</p>";
                        exit();
                    }

                    $username = $conn->real_escape_string($_SESSION['username']);
                    $sql_kh = "SELECT kh.makh, hoten, thongtin_lienhe, ngaysinh, sodt 
                               FROM khachhang kh 
                               JOIN thongtin_lienhe tt ON kh.makh = tt.makh 
                               WHERE kh.makh = '$username'";
                    $result_kh = $conn->query($sql_kh);

                    if (!$result_kh || $result_kh->num_rows === 0) {
                        echo "<p>Không tìm thấy thông tin khách hàng.</p>";
                    } else {
                        $kh = $result_kh->fetch_assoc();
                        echo "<h3>Thông tin giao hàng</h3>";
                        echo "<p><strong>Họ tên:</strong> {$kh['hoten']}</p>";
                        echo "<p><strong>Địa chỉ:</strong> {$kh['thongtin_lienhe']}</p>";
                        echo "<p><strong>Số điện thoại:</strong> {$kh['sodt']}</p>";
                        echo "<p><strong>Ngày sinh:</strong> {$kh['ngaysinh']}</p>";
                    }
                    ?>
                </td>
            </tr>

            <tr class="modal-thanhtoan">
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
                <td colspan="2">
                    <div class="modal-footer">
                        <input type="hidden" name="masp" value="<?php echo htmlspecialchars($masp); ?>">
                        <input type="hidden" name="size" value="<?php echo htmlspecialchars($size); ?>">
                        <input type="hidden" name="quantity" value="<?php echo $soluong; ?>">
                        <button type="submit" class="btn btn-buy">Xác nhận mua</button>
                    </div>
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
