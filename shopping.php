<?php
session_start();
require('connect.php');

if (!$conn) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

if (!isset($_GET['masp']) || empty($_GET['masp'])) {
    die("Mã sản phẩm không hợp lệ.");

}
$masp = $conn->real_escape_string($_GET['masp']);
?>
<!DOCTYPE html>
<html lang="en">
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
        <div class="close-btn">
            <i class="ti-close"></i>
        </div>
       
        <div class="modal-header">
            <h2>Thông tin hóa đơn</h2>  
        </div>
        <div class="modal-body">
        <table>
            <tr>
                <td class="modal-label label-product">
              
                    <?php
                    $sql = "SELECT masp, tensp, gia, url FROM sanpham WHERE masp = '$masp'";
                    $result = $conn->query($sql);

                    if (!$result) {
                        die("Query failed: " . $conn->error);
                    }

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        echo "<img src='{$row['url']}' width='100%'/>";
                        echo "<h3>{$row['tensp']}</h3>";
                        echo "<p><strong>Giá: " . number_format($row['gia']) . " VNĐ</strong></p>";
                    } else {
                        echo "<p>Không tìm thấy sản phẩm.</p>";
                    }
                    
                    echo "<p><strong>Chọn size:</strong></p>";

                    $sql_size = "SELECT size FROM size_sanpham WHERE masp = '$masp'";
                    $result_size = $conn->query($sql_size);

                    if ($result_size && $result_size->num_rows > 0) {
                    echo "<form>";
                    while ($row_size = $result_size->fetch_assoc()) {
                        $size = htmlspecialchars($row_size['size']);
                        echo "<label class='size-option'>";
                        echo "<input type='radio' name='size' value='$size' > $size";
                        echo "</label>";
                    }
                    echo "<br>";
                   
                    $sql_soluong = "SELECT soluong FROM size_sanpham WHERE masp = '$masp'";
                    $result_soluong = $conn->query($sql_soluong);

                    echo "<p><strong>Chọn số lượng:</strong></p>";

                    if ($result_soluong && $result_soluong->num_rows > 0) {
                        $row_sl = $result_soluong->fetch_assoc();
                        $soluong_max = $row_sl['soluong'];

                        echo "<input type='number' name='quantity' min='1' max='{$soluong_max}' value='1' style='width: 50px;'>";
                    } else {
                        echo "<p style='color: red;'>Không có thông tin số lượng.</p>";
                    }


                    echo "</form>";
                    } else {
                        echo "<p>Không có size cho sản phẩm này.</p>";
                    }
               ?>
                </td>

                <td class="modal-label label-khachhang">
                    <div style="text-align: right;"><a href="">Chỉnh sửa</a></div>
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

                    if (!$result_kh) {
                        die("Query failed: " . $conn->error);
                    }

                    if ($result_kh->num_rows > 0) {
                        $kh = $result_kh->fetch_assoc();
                        echo "<h3>Thông tin giao hàng</h3>";
                        echo "<p><strong>Họ tên:</strong> {$kh['hoten']}</p>";
                        echo "<p><strong>Địa chỉ:</strong> {$kh['thongtin_lienhe']}</p>";
                        echo "<p><strong>Số điện thoại:</strong> {$kh['sodt']}</p>";
                        echo "<p><strong>Ngày sinh:</strong> {$kh['ngaysinh']}</p>";
                    } else {
                        echo "<p>Không tìm thấy thông tin khách hàng.</p>";
                    }
                    ?>
                </tr>

                <tr>
                    <td class="tieude-gia">
                        <p>Tổng tiền hàng: </p>
                        <p>Phí vận chuyển:</p>
                        <p>Giảm giá:</p>
                        <p>Thành tiền:</p>
                    </td>
                    <td class="gia">
                        <p><?php echo number_format($row['gia']); ?> VNĐ</p>
                        <p><strong>Miễn phí</strong></p>
                        <p>0đ</p>
                        <p><?php echo number_format($row['gia']); ?> VNĐ</p>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div class="modal-footer">
                            <form method="POST" action="thanhtoan.php">
                                <input type="hidden" name="masp" value="<?php echo htmlspecialchars($row['masp']); ?>">
                                <button type="submit" class="btn btn-buy">Xác nhận mua</button>
                            </form>
                        </div>
                    </td>
                </tr>
       
            
        </table>
        </div>
    </div>   
</div>
<?php
    load_footer();
?>
</body>
</html>

