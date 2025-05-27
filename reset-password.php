<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BT SHOP - Đặt lại mật khẩu</title>
  <link rel ="stylesheet" href="reset-password.css">
</head>
<body>

  <div class="left">
    <img src="../accsets/images/logo.png" width="80" alt="BT Shop Logo">
    <h1>BT SHOP</h1>
    <p>Vua của các quý ông</p>
  </div>

  <div class="right">
    <div class="form-container">
      <div class="header"><a href="index.html" style="color: purple; text-decoration: none;">← Trang chủ</a></div>
      <h2>ĐẶT LẠI MẬT KHẨU</h2>
      <form action="#" method="post">
        <label for="old-password">Mật khẩu cũ</label>
        <input type="password" id="old-password" name="old-password" placeholder="Nhập mật khẩu cũ" required>

        <label for="new-password">Mật khẩu mới</label>
        <input type="password" id="new-password" name="new-password" placeholder="Nhập mật khẩu mới" required>

        <label for="confirm-password">Xác nhận mật khẩu mới</label>
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Xác nhận lại mật khẩu mới" required>

        <button type="submit">Xác nhận</button>
      </form>
      <div class="link">
        <a href="login.html">← Quay lại đăng nhập</a>
      </div>
    </div>
  </div>

</body>
</html>
