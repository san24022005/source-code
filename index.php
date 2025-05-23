<?php
session_start();


if (!isset($_SESSION['username'])) {
    echo "<script>
        alert('Bạn chưa đăng nhập!');
        window.location.href = 'login.php';
    </script>";
    exit;
}
?>
<!DOCTYPE html> 
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>BT Shop</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./accsets/css/main.css">
        <link rel="stylesheet" href="./accsets/css/base.css">
        <link rel="stylesheet" href="./accsets/css/grid.css">
        <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
    </head>
    <style>
    html, body {
        scroll-behavior: smooth;
    }
    </style>
    <body>
        <div class="main">
        <?php
            require 'site.php';
            load_top();
            load_header();
            load_slider();
            load_products();
            load_footer();
        ?>
        </div>
        <!-- Modal hiển thị sản phẩm -->
        
        <div id="modal-mua-ngay" class="modal" style="display:none;">
            <table class="modal-content" cellspacing="0" cellpadding="8">
            <tr>
                <td colspan="2"><i class="ti-close close"></i></td>
            </tr>
            <tr>
                <!-- Cột 1: Ảnh -->
                <td rowspan="8" style="width: 250px">
                    <img id="modal-img" src="" alt="Sản phẩm" style="width: 100%;">
                </td>
                <td rowspan="8" class="ngancach"></td>

                <!-- Cột 2: Tên sản phẩm -->
                <td class="modal-tesp"><h2 id="modal-tensp"></h2></td>
            </tr>
            <tr>
                <td class="modal-gia"><p id="modal-gia"></p></td>
            </tr>
            <tr>
                <td class="modal-size">
                    <label for="modal-size">Chọn size:</label>
                    <select id="modal-size"></select>
                </td>
            </tr>
            <tr>
                <td class="modal-soluong">
                    <label for="modal-qty">Số lượng:</label>
                    <input type="number" id="modal-qty" min="1" value="1"/>
                </td>
            </tr>
            <tr>
                <td class="note"><p id="modal-max-note"></p></td>
            </tr>
            <tr>
                <td class="btn-xacnhan-mua">
                    <button id="btn-xacnhan" class="btn">Xác nhận mua</button>
                </td>
            </tr>
            </table>
        </div>

        <script src="accsets/js/shopping.js"></script>
    </body>
</html>

