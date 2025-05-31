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

    $sonha = isset($_POST['sonha']) ? trim($_POST['sonha']) : '';
    $capxa = isset($_POST['xa']) ? trim($_POST['xa']) : '';
    $caphuyen = isset($_POST['huyen']) ? trim($_POST['huyen']) : '';
    $captinh = isset($_POST['tinh']) ? trim($_POST['tinh']) : '';

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
    <meta charset="UTF-8" />
    <title>Thông tin khách hàng</title>
    <link rel="stylesheet" href="accsets/css/base.css">
    <link rel="stylesheet" href="accsets/css/main.css">
    <link rel="stylesheet" href="accsets/fonts/themify-icons/themify-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <?php
  require 'site.php';
  load_top();
  load_backbtn();
  ?>
  <form method="POST" autocomplete="off">
      <div class="myacc-container">
          <h2>Thông tin đăng nhập</h2>
          <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
          <hr>

          <div class="form-row">
              <label>Tên đăng nhập</label>
              <input type="text" value="<?= htmlspecialchars($username) ?>" readonly />
          </div>

          <div class="form-row">
              <label>Họ tên</label>
              <input type="text" name="hoten" value="<?= htmlspecialchars($user['hoten']) ?>" readonly />
          </div>

          <div class="form-row">
              <label>Email</label>
              <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly />
          </div>

          <div class="form-row">
              <label>Số điện thoại</label>
              <input type="text" name="sodt" value="<?= htmlspecialchars($user['sodt']) ?>" readonly />
          </div>

          <div class="form-row">
              <label>Ngày sinh</label>
              <input type="date" name="ngaysinh" value="<?= htmlspecialchars($user['ngaysinh']) ?>" readonly />
          </div>

          <div class="address">
              <label><strong>Địa chỉ</strong></label>
              <input type="text" placeholder="Số nhà, tên đường" name="sonha" value="<?= htmlspecialchars($user['sonha']) ?>" readonly />
              <input type="text" placeholder="Phường / Xã" name="xa" value="<?= htmlspecialchars($user['capxa']) ?>" readonly />
              <input type="text" placeholder="Quận / Huyện" name="huyen" value="<?= htmlspecialchars($user['caphuyen']) ?>" readonly />
              <input type="text" placeholder="Tỉnh / Thành phố" name="tinh" value="<?= htmlspecialchars($user['captinh']) ?>" readonly />
          </div>

          <div class="form-actions">
              <button class="btn-myacc" type="submit">Lưu</button>
              <button class="btn-myacc-edit" type="button" onclick="enableEdit()">Chỉnh sửa</button>
              <a href="reset-password.php" class="btn-myacc-pass">Đổi mật khẩu</a>
          </div>
      </div>
</form>

<script>
    function enableEdit() {
        const inputs = document.querySelectorAll("input:not([type=radio])");
        inputs.forEach(el => {
        el.removeAttribute("readonly");
        el.removeAttribute("disabled");
        el.style.backgroundColor = "#fff";
        el.style.cursor = "text";
    });
    alert("Bạn có thể chỉnh sửa thông tin bây giờ!");
  }
</script>
<?php load_footer(); ?>
</body>
</html>
