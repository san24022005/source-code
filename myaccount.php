<?php
session_start();

// 🔒 Nếu chưa đăng nhập thì chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['username'])) {
    // Giả lập: bạn có thể sửa dòng này sau để test
    $_SESSION['username'] = 'KH001'; // ví dụ: tên đăng nhập
    // header("Location: login.php");
    // exit();
}

// Biến lưu username đăng nhập
$username = $_SESSION['username'];

// 🔌 Kết nối CSDL
$conn = new mysqli("localhost", "root", "123456", "qlbh");
$conn->set_charset("utf8mb4");

// 🔍 Lấy thông tin khách hàng
$sql = "SELECT kh.hoten, kh.ngaysinh, tl.sodt, tl.email, tl.sonha, tl.caphuyen, tl.capxa, tl.captinh
        FROM khachhang kh
        LEFT JOIN thongtin_lienhe tl ON kh.makh = tl.makh
        WHERE kh.makh = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thông tin đăng nhập</title>
  <link rel ="stylesheet" href="myaccount.css">
</head>
<body>
<div class="container">
  <h2>Thông tin đăng nhập</h2>
  <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
  <hr>
  <div class="form-row">
    <label>Tên đăng nhập</label>
    <input type="text" value="<?= htmlspecialchars($username) ?>" disabled>
  </div>

  <div class="form-row">
    <label>Họ tên</label>
    <input type="text" value="<?= htmlspecialchars($user['hoten']) ?>" disabled>
  </div>

  <div class="form-row">
    <label>Email</label>
    <input type="email" value="<?= htmlspecialchars($user['email']) ?>" disabled>
  </div>

  <div class="form-row">
    <label>Số điện thoại</label>
    <input type="text" value="<?= htmlspecialchars($user['sodt']) ?>" disabled>
  </div>

  <div class="form-row">
    <label>Giới tính</label>
    <input type="radio" name="gender" checked disabled> Nam
    <input type="radio" name="gender" disabled> Nữ
    <input type="radio" name="gender" disabled> Khác
  </div>

  <div class="form-row">
    <label>Ngày sinh</label>
    <input type="date" value="<?= $user['ngaysinh'] ?>" disabled>
  </div>

  <div class="form-row">
    <label>Địa chỉ</label>
    <input type="text" value="<?= htmlspecialchars($user['sonha'] . ', ' . $user['capxa'] . ', ' . $user['caphuyen'] . ', ' . $user['captinh']) ?>" disabled>
  </div>

  <div class="form-actions">
    <button class="btn">Lưu</button>
   <button class="btn-edit" onclick="enableEdit()">Chỉnh sửa</button>

  </div>
  <script>
function enableEdit() {
    const inputs = document.querySelectorAll("input, select");
    inputs.forEach(el => {
        el.removeAttribute("readonly");
        el.removeAttribute("disabled");
    });

    alert("Bạn có thể chỉnh sửa thông tin bây giờ!");
}
</script>

</div>
</body>
</html>
