<?php
session_start();

$makh=$_SESSION['username'];
?>
<div class="myaccount">
    <div class="myaccount-container">
        <div class="myaccount-header">
            <h2>Thông tin tài khoản</h2>===============
            <p>Chào mừng bạn đến với BT Shop</p>
        </div>
        <div class="myaccount-content">
            <div class="myaccount-info">
                <h3>Thông tin cá nhân</h3>
                <p>Tên đăng nhập: <?php echo $_SESSION['username']; ?></p>
                <!-- <p>Email: <?php echo $_SESSION['email']; ?></p>
                <p>Số điện thoại: <?php echo $_SESSION['phone']; ?></p> -->
            </div>
            <div class="myaccount-actions">
                <a href="../login/logout.php" class="logout-btn">Đăng xuất</a>
                <a href="../login/edit_profile.php" class="edit-btn">Chỉnh sửa thông tin</a>
</div>