<?php
session_start();
include('connect.php');

// Kiểm tra masp hợp lệ
if (!isset($_GET['masp']) || empty($_GET['masp'])) {
    die("Mã sản phẩm không hợp lệ.");
}

$masp = $conn->real_escape_string($_GET['masp']); // Chống SQL injection

// Truy vấn sản phẩm
$sql = "SELECT masp, tensp, gia, url FROM sanpham WHERE masp = '$masp'";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
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
            <div class="modal-label lable-product">
                <?php
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<div class='product'>";
                    echo "<img src='{$row['url']}' width='150' height='150'/>";
                    echo "<h3>{$row['tensp']}</h3>";
                    echo "<p><strong>Giá: " . number_format($row['gia']) . " VNĐ</strong></p>";
                    echo "</div>";
                } else {
                    echo "<p>Không tìm thấy sản phẩm.</p>";
                }
                ?>
            </div>

            <div class="modal-label lable-khachhang">
                <?php 
                // Kiểm tra đăng nhập
                if (!isset($_SESSION['username'])) {
                    echo "<p class='error'>Bạn chưa đăng nhập. Vui lòng <a href='login.php'>đăng nhập</a> để tiếp tục.</p>";
                    exit();
                }

                $username = $conn->real_escape_string($_SESSION['username']); // Lấy mã khách hàng từ session

                // Truy vấn thông tin khách hàng
                $sql_kh = "SELECT * FROM taikhoan WHERE username = '$username'";
                $result_kh = $conn->query($sql_kh);

                if (!$result_kh) {
                    die("Query failed: " . $conn->error);
                }

                if ($result_kh->num_rows > 0) {
                    $kh = $result_kh->fetch_assoc();
                    echo "<h3>Thông tin khách hàng</h3>";
                    echo "<p><strong>Họ tên:</strong> {$kh['hoten']}</p>";
                    echo "<p><strong>Địa chỉ:</strong> {$kh['diachi']}</p>";
                    echo "<p><strong>Số điện thoại:</strong> {$kh['sodt']}</p>";
                    echo "<p><strong>Ngày sinh</strong> {$kh['ngaysinh']}</p>";
                } else {
                    echo "<p>Không tìm thấy thông tin khách hàng.</p>";
                }
                ?>
            </div>
        </div>
    </div> 
</div>
