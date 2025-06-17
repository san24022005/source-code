<div id="top">
    <div class="left-top">
        <ul>
        <li>
            <div class="mobile-btn">
                <a href="tel:0946171903"><i class="top-icon ti-mobile"></i></a>
            </div>
        </li>
        <li>
            <div class="email-btn">
                <a href="mailto:cskh@btshop.com">
                    <i class="top-icon ti-email"></i>
                    cskh@btshop.com
                </a>
            </div>
        </li>
        <li>
            <div class="contact-btn">
                <a href="hotrokhachhang.php">
                    <i class="top-icon ti-location-pin"></i>
                    Liên hệ
                </a>
            </div>
        </li>
        </ul>
    </div>
    
    <div class="right-top">
        <ul>
        <li>
            <div class="login-btn">
                <a href="<?php echo isset($_SESSION['name']) ? 'myaccount.php' : 'login.php'; ?>">
                    <i class="top-icon ti-shift-right"></i>
                    <?php echo isset($_SESSION["name"]) ? $_SESSION["name"] : "Đăng nhập"; ?>
                </a>
            </div>
        </li>
        <li>
            <div class="register-btn">
                <a href="<?php echo isset($_SESSION['name']) ? 'logout.php' : 'register.php'; ?>">
                    <i class="top-icon ti-user"></i>
                    <?php echo isset($_SESSION["name"]) ? "Đăng xuất" : "Đăng kí"; ?>
                </a>
            </div>
        </li>
        </ul>
    </div>
</div>
