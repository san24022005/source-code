<?php
// Kết nối 
$host = 'localhost';      
$dbname = 'QLBH';     
$username = 'root';       
$password = '123456';

// Tạo kết nối
$conn = new mysqli($host, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

mysqli_set_charset($conn, "utf8"); // Thiết lập UTF-8 để tránh lỗi tiếng Việt

if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'KH001';
}
$makh = $_SESSION['username'];

// Lấy thông tin hiện tại
$sql = "SELECT kh.hoten, kh.ngaysinh, tl.email, tl.sodt, tl.sonha, tl.capxa, tl.caphuyen, tl.captinh 
        FROM khachhang kh
        JOIN thongtin_lienhe tl ON kh.makh = tl.makh
        WHERE kh.makh = '$makh'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!-- Modal chỉnh sửa thông tin -->
 
<div class="modal-address-content" id="modalAddress">
  <form method="POST" action="update_address.php">
    <h2>Cập nhật thông tin</h2>
    <div class="close">
        <i class="close-icon ti-close"></i>
    </div>

    <div class="form-row">
        <label>Họ tên:</label>
        <input type="text" name="hoten" value="<?= $row['hoten'] ?>" required>
    </div>

    <div class="form-row">
        <label>Email:</label>
        <input type="email" name="email" value="<?= $row['email'] ?>" required>
    </div>

    <div class="form-row">
        <label>Số điện thoại:</label>
        <input type="text" name="sodt" value="<?= $row['sodt'] ?>" required>
    </div>

    <div class="form-row">
        <label>Ngày sinh:</label>
        <input type="date" name="ngaysinh" value="<?= $row['ngaysinh'] ?>" required>
    </div>

    <div class="form-row">
        <label>Số nhà:</label>
        <input type="text" name="sonha" value="<?= $row['sonha'] ?>" required>
    </div>

    <div class="form-row">
        <label>Cấp xã:</label>
        <input type="text" name="capxa" value="<?= $row['capxa'] ?>" required>
    </div>

    <div class="form-row">
        <label>Cấp huyện:</label>
        <input type="text" name="caphuyen" value="<?= $row['caphuyen'] ?>" required>
    </div>

    <div class="form-row">
        <label>Cấp tỉnh:</label>
        <input type="text" name="captinh" value="<?= $row['captinh'] ?>" required>
    </div>

    <input type="hidden" name="form_type" value="update_address">
    <button type="submit" name="capnhat">Cập nhật</button>
  </form>
</div>