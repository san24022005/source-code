<div id="header">
    
        <a href="index.php">
            <img src="accsets/images/logo.png" alt="Logo" class="logo">
        </a>
    

    <ul class="nav">
        <li>
            <a href="#ao">
                Áo
                <i class="down-icon ti-angle-down"></i>
            </a>

            <ul class="sub-nav">
                <li><a href="#polodaitay">Áo polo dài tay</a></li>
                <li><a href="#aothundaitay">Áo thun dài tay</a></li>
                <li><a href="#aokhoac">Áo khoác</a></li>
                <li><a href="#aosomi">Áo sơ mi</a></li>
                <li><a href="#aotshirt">Áo Tshirt</a></li>
            </ul>
        </li>

        <li>
            <a href="#quan">
                Quần
                <i class="down-icon ti-angle-down"></i>
            </a>

            <ul class="sub-nav">
                <li><a href="#quanau">Quần âu</a></li>
                <li><a href="#quanshort">Quần short</a></li>
                <li><a href="#quanjean">Quần jean</a></li>
            </ul>
        </li>

        <li><a href="#dobo">Đồ bộ</a></li>

        <li><a href="#dongphuc">Đồng phục</a></li>

        <li><a href="#tayphuc">Tây phục</a></li>
    </ul>

    <ul class="nav-right">
        <li>
            <a href="">
                <i class="nav-icon search-icon ti-search"></i>
            </a>
        </li>

        <li><a href="">
            <i class="nav-icon shopping-cart-icon ti-shopping-cart"></i>
        </a></li>

        <li class="setting">
            <a href="">
                <i class="nav-icon setting-icon ti-settings"></i>

                <ul class="sub-setting">
                    <li><a href="myaccount.php">
                        <i class="sub-setting-icon ti-user"></i>
                        My account
                        <?php
                            if (isset($_SESSION["name"])) {
                                echo "({$_SESSION['name']})";
                            } else {
                                echo "Đăng nhập";
                            }
                        ?>
                    </a></li>
                    <li><a href="">
                        <i class="sub-setting-icon ti-package"></i>
                        Đơn hàng của tôi
                    </a></li>

                    <li><a href="">
                        <i class="sub-setting-icon ti-book"></i>
                        Điều khoản dịch vụ
                    </a></li>

                    <li><a href="">
                        <i class="sub-setting-icon ti-help"></i>
                        Hỗ trợ khách hàng
                    </a></li>

                    <li><a href="">
                        <i class="sub-setting-icon ti-info"></i>
                        Giới thiệu về BT SHOP
                    </a></li>

                    <li><a href="./logout.php">
                        <i class="sub-setting-icon ti-shift-right"></i>
                        Đăng xuất
                    </a></li>
                </ul>
            </a>
        </li>
    </ul>
</div>
