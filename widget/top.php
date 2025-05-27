<div id="top">
    <ul id="top-nav">
        <div class="left-top">
            <li>
                <div class="mobile-btn">
                    <i class="top-icon ti-mobile"></i>
                </div>
            </li>
            <li>
                <div class="email-btn">
                    <i class="top-icon ti-email"></i>
                    <a href="mailto:cskh@khavico.com">cskh@khavico.com</a>
                </div>
            </li>
            <li>
                <div class="contact-btn">
                    <i class="top-icon ti-location-pin"></i>
                    <a href="">Liên hệ</a>
                </div>
            </li>
        </div>

        <div class="right-top">
            <li>
            <div class="login-btn">
                <i class="top-icon ti-shift-right"></i>
                <a href="<?php echo isset($_SESSION['name']) ? 'myaccount.php' : 'login.php'; ?>">
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
                    <i class="top-icon ti-user"></i>
                    <a href="register.php">Đăng ký</a>
                </div>
            </li>
        </div>        
    </ul>
</div>
