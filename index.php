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
        <link rel="stylesheet" href="./accsets/css/main.css">
        <link rel="stylesheet" href="./accsets/css/base.css">
        <link rel="stylesheet" href="./accsets/css/grid.css">
        <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
    </head>
    <body>
        <div class="main">
        <?php
            require 'site.php';
            load_top();
            load_header();
            load_products();
            load_footer();
        ?>
        </div>
    </body>

</html>

<script>
    const buyBtns = document.querySelector('.js-mua-ngay')

    function showModalBuy() {
        modal.classList.add('show');
    }

    for (const buyBtn of buyBtns) {
        buyBtn.addEventListener('click', showModalBuy() );
    }
    const closeBtn = document.querySelector('.close-btn');
    const modal = document.querySelector('.modal');

    closeBtn.addEventListener('click', function() {
        modal.classList.remove('.show');
    });
</script>