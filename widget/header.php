<div id="header">
    
        <a href="index.php">
            <img src="accsets/images/logo.png" alt="Logo" class="logo">
        </a>
    

    <ul class="nav">
        <li>
            <a href="index.php#ao">
                Áo
                <i class="down-icon ti-angle-down"></i>
            </a>

            <ul class="sub-nav">
                <li><a href="index.php#aopolodaitay">Áo polo dài tay</a></li>
                <li><a href="index.php#aothundaitay">Áo thun dài tay</a></li>
                <li><a href="index.php#aokhoac">Áo khoác</a></li>
                <li><a href="index.php#aosomi">Áo sơ mi</a></li>
                <li><a href="index.php#aotshirt">Áo Tshirt</a></li>
            </ul>
        </li>

        <li>
            <a href="index.php#quan">
                Quần
                <i class="down-icon ti-angle-down"></i>
            </a>

            <ul class="sub-nav">
                <li><a href="index.php#quanau">Quần âu</a></li>
                <li><a href="index.php#quanshort">Quần short</a></li>
                <li><a href="index.php#quanjeans">Quần jean</a></li>
            </ul>
        </li>

        <li><a href="index.php#dobo">Đồ bộ</a></li>

        <li><a href="index.php#dongphuc">Đồng phục</a></li>

        <li><a href="index.php#matkinh">Mắt kính</a></li>
    </ul>

    <ul class="nav-right">
        <li class="search-box">
    <form action="search.php" method="GET">
        <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm..." />
        <button type="submit"><i class="ti-search"></i></button>
    </form>
</li>


        <li><a href="shopping-cart.php">
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
                    <li><a href="orders.php">
                        <i class="sub-setting-icon ti-package"></i>
                        Đơn hàng của tôi
                    </a></li>

                    <li><a href="dieukhoandichvu.php">
                        <i class="sub-setting-icon ti-book"></i>
                        Điều khoản dịch vụ
                    </a></li>

                    <li><a href="hotrokhachhang.php">
                        <i class="sub-setting-icon ti-help"></i>
                        Hỗ trợ khách hàng
                    </a></li>

                    <li><a href="introduce.php">
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
