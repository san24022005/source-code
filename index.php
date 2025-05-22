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
<!-- Modal hiển thị sản phẩm -->
<div id="modal-mua-ngay" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2 id="modal-tensp"></h2>
    <img id="modal-img" src="" width="150" height="150" alt="Sản phẩm">
    <p id="modal-gia"></p>

    <label for="modal-size">Chọn size:</label>
    <select id="modal-size"></select>

    <label for="modal-qty">Số lượng:</label>
    <input type="number" id="modal-qty" min="1" value="1" />

    <p id="modal-max-note" style="color:red;"></p>

    <button id="btn-xacnhan" class="btn">Xác nhận mua</button>
  </div>
</div>


<style>
.modal {
  position: fixed;
  z-index: 1000;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.5);
  display: flex; align-items: center; justify-content: center;
}

.modal-content {
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  width: 300px;
  position: relative;
  text-align: center;
}

.close {
  position: absolute;
  top: 10px; right: 15px;
  font-size: 24px;
  cursor: pointer;
}

#modal-img {
  margin: 10px 0;
}
</style>

<script src="accsets/js/shopping.js"></script>
   
    </body>
</html>

