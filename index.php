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
    <link rel="stylesheet" href="./accsets/css/table.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
</head>
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
        
    <div id="modal-mua-ngay" class="modal" style="display:none;" data-masp="">
        <?php
        load_modal();
        ?>
    </div>

    <script src="./accsets/js/slider.js"></script>
    <script src="./accsets/js/header.js"></script>
    <script src="./accsets/js/modal.js"></script>
</body>
</html>

