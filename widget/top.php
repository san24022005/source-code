<div id="top">
    <ul id="top-nav">
        <div class="left-top">
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
        </div>

        <div class="right-top">
            <li>
            <div class="login-btn">
                <a href="<?php echo isset($_SESSION['name']) ? 'myaccount.php' : 'login.php'; ?>">
                    <i class="top-icon ti-shift-right"></i>
                    <?php
                        if (isset($_SESSION["name"])) {
                            echo $_SESSION["name"];
                        } else {
                            echo "Đăng nhập";
                        }
                    ?>
                </a>
            </div>
            </li>

            <li>
                <div class="register-btn">
                    <a href="<?php echo isset($_SESSION['name']) ? 'logout.php' : 'register.php'; ?>">
                        <i class="top-icon ti-user"></i>
                        <?php
                        if (isset($_SESSION["name"])) {
                            echo "Đăng xuất";
                        } else {
                            echo "Đăng kí";
                        }
                        ?>
                    </a>
                </div>
            </li>
        </div>        
    </ul>
</div>
