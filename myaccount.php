<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'KH001';
}

$username = $_SESSION['username'];

$conn = new mysqli("localhost", "root", "123456", "qlbh");
$conn->set_charset("utf8mb4");

// ✅ Xử lý khi bấm "Lưu"
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hoten = $_POST['hoten'];
    $email = $_POST['email'];
    $sodt = $_POST['sodt'];
    $ngaysinh = $_POST['ngaysinh'];
    $diachi = $_POST['diachi'];

    // Phân tích địa chỉ (giả định đúng định dạng: nhà, xã, huyện, tỉnh)
    $parts = explode(',', $diachi);
    $sonha = trim($parts[0]);
    $capxa = trim($parts[1]);
    $caphuyen = trim($parts[2]);
    $captinh = trim($parts[3]);

    // Cập nhật CSDL
    $stmt1 = $conn->prepare("UPDATE khachhang SET hoten=?, ngaysinh=? WHERE makh=?");
    $stmt1->bind_param("sss", $hoten, $ngaysinh, $username);
    $stmt1->execute();

    $stmt2 = $conn->prepare("UPDATE thongtin_lienhe SET email=?, sodt=?, sonha=?, capxa=?, caphuyen=?, captinh=? WHERE makh=?");
    $stmt2->bind_param("sssssss", $email, $sodt, $sonha, $capxa, $caphuyen, $captinh, $username);
    $stmt2->execute();

    echo "<script>alert('Cập nhật thành công!');</script>";
}

// Lấy thông tin hiện tại
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
  <link rel="stylesheet" href="myaccount.css">
</head>
<body>
<form method="POST">
<div class="container">
  <h2>Thông tin đăng nhập</h2>
  <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
  <hr>

  <div class="form-row">
    <label>Tên đăng nhập</label>
    <input type="text" value="<?= htmlspecialchars($username) ?>" readonly>
  </div>

  <div class="form-row">
    <label>Họ tên</label>
    <input type="text" name="hoten" value="<?= htmlspecialchars($user['hoten']) ?>" readonly>
  </div>

  <div class="form-row">
    <label>Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
  </div>

  <div class="form-row">
    <label>Số điện thoại</label>
    <input type="text" name="sodt" value="<?= htmlspecialchars($user['sodt']) ?>" readonly>
  </div>

  <div class="form-row">
    <label>Giới tính</label>
    <input type="radio" name="gender" checked disabled> Nam
    <input type="radio" name="gender" disabled> Nữ
    <input type="radio" name="gender" disabled> Khác
  </div>

  <div class="form-row">
    <label>Ngày sinh</label>
    <input type="date" name="ngaysinh" value="<?= $user['ngaysinh'] ?>" readonly>
  </div>

  <div class="form-row">
    <label>Địa chỉ</label>
    <input type="text" name="diachi" value="<?= htmlspecialchars($user['sonha'] . ', ' . $user['capxa'] . ', ' . $user['caphuyen'] . ', ' . $user['captinh']) ?>" readonly>
  </div>

  <div class="form-actions">
    <button class="btn" type="submit">Lưu</button>
    <button class="btn-edit" type="button" onclick="enableEdit()">Chỉnh sửa</button>
  </div>
</div>
</form>

<script>
function enableEdit() {
    const inputs = document.querySelectorAll("input:not([type=radio])");
    inputs.forEach(el => {
        el.removeAttribute("readonly");
        el.removeAttribute("disabled");
    });
    alert("Bạn có thể chỉnh sửa thông tin bây giờ!");
}
</script>
</body>
</html>
