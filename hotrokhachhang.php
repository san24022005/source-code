<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ - Hỗ trợ khách hàng</title>
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
    <style>
    
  </style>
</head>
<body>
    <?php 
    require 'site.php';
    load_top();
    load_backbtn();
    ?>

    <div class="contact-section">
        <!-- LEFT COLUMN -->
        <div class="contact-left">
            <h2>Liên hệ - Hỗ trợ </h2>
            <div class="contact-block">
                <img src="./accsets/images/phone-icon.png" alt="Phone">
                <div>
                    <strong>Phòng Kinh doanh</strong><br>
                    <a href="mailto:hotrobtshop@gmail.com.vn">hotrobtshop@gmmail.com.vn </a><br>
                    +84 81 422 5862 (Mr. Vương)<br>
                    +84 78 566 7053 (Mr. Hiếu)
                </div>
            </div>

            <div class="contact-block">
                <img src="./accsets/images/info-icon.png" alt="Info">
                <div>
                    <strong>Yêu Cầu Chung</strong><br>
                    +84 28 3997 8000<br>
                    Line. 1800 2222 (tuyển dụng)<br>
                    Line. 1900 3355 (liên hệ chung)
                </div>
            </div>

            <div class="contact-block">
                <img src="./accsets/images/location-icon.png" alt="Location">
                <div>
                    <strong>Tòa nhà opera house BT shop </strong><br>
                    08 An Dương Vương,Phường Nguyễn Văn Cừ, TP Quy Nhơn, tỉnh Bình Định ,<br>
                    Quy Nhơn, Bình Định <a href="https://www.google.com/maps/place/Tr%C6%B0%E1%BB%9Dng+%C4%90%E1%BA%A1i+H%E1%BB%8Dc+Quy+Nh%C6%A1n/@13.7584719,109.2144763,17z/data=!4m15!1m8!3m7!1s0x316f6cec00478855:0x3027a73de7997b85!2zTmjDoCBBMywgMTcwIEFuIETGsMahbmcgVsawxqFuZywgTmd1eeG7hW4gVsSDbiBD4burLCBRdXkgTmjGoW4sIELDrG5oIMSQ4buLbmgsIFZp4buHdCBOYW0!3b1!8m2!3d13.7584719!4d109.2170566!16s%2Fg%2F1w3w0jyv!3m5!1s0x316f6cebf252c49f:0xa83caa291737172f!8m2!3d13.7589597!4d109.2178573!16s%2Fg%2F120ylnmc?entry=ttu&g_ep=EgoyMDI1MDUyOC4wIKXMDSoASAFQAw%3D%3DGI">(Bản đồ)</a>
                </div>
            </div>
        </div>

        <div class="contact-right">
            <h2>Hỗ trợ khách hàng</h2>
            <form class="contact-form">
                <label for="name">Họ và tên *</label>
                <input type="text" id="name" placeholder="Nhập họ và tên">
                <div class="input-row hotro__responsive">
                    <div class="input-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" placeholder="example@mail.com">
                    </div>

                    <div class="input-group">
                        <label for="phone">Số điện thoại</label>
                        <div class="phone-input">
                            <select>
                                <option>(+84)</option>
                                <option>(+1)</option>
                                <option>(+61)</option>
                            </select>
                            <input type="text" placeholder="0123 456 7890">
                        </div>
                    </div>
                </div>

                <label for="company">Shop *</label>
                <input type="text" id="company" placeholder="BT shop">
                <label for="message">Nội dung *</label>
                <textarea id="message" placeholder="Nhập nội dung"></textarea>
                <button type="submit">Gửi →</button>
            </form>
        </div>
    </div>
</body>
</html>
