<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Chuyển hướng nếu người dùng chưa đăng nhập
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>BT Shop</title>
        <link rel="stylesheet" href="./accsets/css/main.css">
        <link rel="stylesheet" href="./accsets/css/base.css">
        <link rel="stylesheet" href="./accsets/css/grid.css">
        <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
    </head>
    <body>
        <?php
            require 'site.php';
            load_top();
            load_header();
            load_slider();
        ?>
        <div id="products">

        </div>
        
        <?php
            load_footer();
        ?>
    </body>
</html>