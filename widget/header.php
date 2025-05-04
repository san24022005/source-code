<div id="header">
    <div class="logo">
        <a href="index.php"></a>
    </div>

    <ul class="nav">
        <li>
            <a href="">
                Áo
                <i class="down-icon ti-angle-down"></i>
            </a>

            <ul class="sub-nav">
                <li><a href="">Áo polo dài tay</a></li>
                <li><a href="">Áo thun dài tay</a></li>
                <li><a href="">Áo khoác</a></li>
                <li><a href="">Áo sơ mi</a></li>
                <li><a href="">Áo Tshirt</a></li>
            </ul>
        </li>

        <li>
            <a href="">
                Quần
                <i class="down-icon ti-angle-down"></i>
            </a>

            <ul class="sub-nav">
                <li><a href="">Quần âu</a></li>
                <li><a href="">Quần short</a></li>
                <li><a href="">Quần jean</a></li>
            </ul>
        </li>

        <li><a href="">Đồ bộ</a></li>

        <li><a href="">Đồng phục</a></li>

        <li><a href="">Tây phục</a></li>
    </ul>

    <ul class="nav-icon">
        <li>
            <a href="">
                <i class="search-icon ti-search"></i>
            </a>
        </li>

        <li class="menu">
            <a href="">
                <i class="menu-icon ti-menu"></i>

                <ul class="sub-menu">
                    <li><a href="">
                        <i class="sub-menu-icon ti-user"></i>
                        My account
                        <?php
                            if (isset($_SESSION["username"])) {
                                echo "({$_SESSION['username']})";
                            } else {
                                echo "Đăng nhập";
                            }
                        ?>
                    </a></li>
                    <li><a href="">
                        <i class="sub-menu-icon ti-shopping-cart"></i>
                        Giỏ hàng
                    </a></li>

                    <li><a href="">
                        <i class="sub-menu-icon ti-package"></i>
                        Đơn hàng của tôi
                    </a></li>

                    <li><a href="">
                        <i class="sub-menu-icon ti-book"></i>
                        Điều khoản dịch vụ
                    </a></li>

                    <li><a href="">
                        <i class="sub-menu-icon ti-help"></i>
                        Hỗ trợ khách hàng
                    </a></li>

                    <li><a href="">
                        <i class="sub-menu-icon ti-info"></i>
                        Giới thiệu về BT SHOP
                    </a></li>

                    <li><a href="">
                        <i class="sub-menu-icon ti-shift-right"></i>
                        Đăng xuất
                    </a></li>
                </ul>
            </a>
        </li>
    </ul>
</div>
