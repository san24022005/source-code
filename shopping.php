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
        
        <a href="index.php">
            <div class="home-page">
                <i class="ti-angle-left"></i>
                Quay về trang chủ
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
                        while ($row_size = $result_size->fetch_assoc()) {
                            $size = htmlspecialchars($row_size['size']);
                            echo "<label class='size-option'>";
                            echo "<input type='radio' name='size' value='$size' onchange='fetchSoluong(\"$size\")'> $size";
                            echo "</label>";
                        }
                    } else {
                        echo "<p>Không có size cho sản phẩm này.</p>";
                    }

                    echo "<p><strong>Chọn số lượng:</strong></p>";
                    echo "<div id='soluong-container'>";
                    echo "<input type='number' name='quantity' min='1' max='1' value='1' style='width: 50px;'>";
                    echo "</div>";
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
                        <p><span id="dongia" data-dongia="<?php echo $row['gia']; ?>"><?php echo number_format($row['gia']); ?></span> VNĐ</p>
                        <p><strong>Miễn phí</strong></p>
                        <p>0đ</p>
                        <p><span id="thanhtien"><?php echo number_format($row['gia']); ?></span> VNĐ</p>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div class="modal-footer">
                            <input type="hidden" name="masp" value="<?php echo htmlspecialchars($row['masp']); ?>">
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
<script>
function fetchSoluong(size) {
    const masp = "<?php echo $masp; ?>";
    fetch(`get_soluong.php?masp=${masp}&size=${size}`)
        .then(response => response.text())
        .then(data => {
            const soluong = parseInt(data);
            const container = document.getElementById('soluong-container');
            if (!isNaN(soluong) && soluong > 0) {
                container.innerHTML = `
                    <input type='number' name='quantity' id='quantity' min='1' max='${soluong}' value='1' style='width: 50px;' onchange='capNhatTien()'>
                `;
                capNhatTien(); // Gọi ngay lần đầu
            } else {
                container.innerHTML = `<p style='color: red;'>Không còn hàng trong size này.</p>`;
            }
        });
}

function capNhatTien() {
    const dongia = parseInt(document.getElementById("dongia").dataset.dongia);
    const soluongInput = document.getElementById("quantity");
    const soluong = soluongInput ? parseInt(soluongInput.value) : 1;

    const thanhtien = dongia * soluong;
    document.getElementById("thanhtien").textContent = thanhtien.toLocaleString("vi-VN");
}
</script>

</body>
</html>
