<?php
session_start();

require 'connect.php';

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

if ($keyword == null) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BT Shop</title>
    <link rel="stylesheet" href="./accsets/css/main.css">
    <link rel="stylesheet" href="./accsets/css/base.css">
    <link rel="stylesheet" href="./accsets/css/table.css">
    <link rel="stylesheet" href="./accsets/fonts/themify-icons/themify-icons.css">
</head>
<style>
    #header .nav {
        display: none;
    }

    #header .logo {
        display: block;
    }
</style>
<body>
    <div class="main">
        <?php
        require 'site.php';
        load_top();
        load_header();
        echo "<div id='search-containner'>";
        echo "<h2>Kết quả tìm kiếm cho từ khóa: <em>$keyword</em></h2>";
        echo "<div id='search-products'>";

        if ($keyword !== '') {
            // Tìm kiếm theo tên sản phẩm có chứa từ khóa
            $sql = "SELECT masp, tensp, gia, url FROM sanpham WHERE tensp LIKE ?";
            $stmt = $conn->prepare($sql);
            $like_keyword = "%" . $keyword . "%";
            $stmt->bind_param("s", $like_keyword);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<table><tr>";
                    echo "<td colspan='2' class='img'><a href='deltails.php?masp={$row['masp']}'><img src='{$row['url']}' width='150px' height='150px'/></a></td></tr>";
                    echo "<tr><td colspan='2' class='name-prd'><h3>{$row['tensp']}</h3></td></tr>";
                    echo "<tr><td colspan='2' class='price-prd'><p><strong>Giá: " . number_format($row['gia']) . " VNĐ</strong></p></td></tr>";
                    echo "<tr>
                            <td class='btn-giohang'>
                                <button type='button' class='btn js-gio-hang'
                                data-masp='{$row['masp']}' 
                                data-img='{$row['url']}'
                                data-tensp='{$row['tensp']}'
                                data-gia='{$row['gia']}'>
                                    <i class='shopping-cart-icon ti-shopping-cart'></i>
                                </button>
                            </td>";
                    echo "<td class='btn-details'><a href='deltails.php?masp={$row['masp']}'><button type='button' class='btn'>Xem chi tiết</button></a></td>";
                    echo "</tr><tr><td colspan='2' class='btn-muangay'>";
                    echo "<button type='button' class='btn js-mua-ngay' 
                            data-masp='{$row['masp']}' 
                            data-img='{$row['url']}'
                            data-tensp='{$row['tensp']}'
                            data-gia='{$row['gia']}'>Mua ngay</button></td></tr>";
                    echo "</table></div>";
                }
            } else {
                echo "<p>Không tìm thấy sản phẩm nào phù hợp.</p>";
            }

            $stmt->close();
        } else {
            echo "<p>Vui lòng nhập từ khóa tìm kiếm.</p>";
        }

        echo "</div>";
        echo "</div>";

        $conn->close();

        load_footer();
        ?>
    </div>
    <div id="modal-mua-ngay" class="modal" style="display:none;" data-masp="">
        <?php
        load_modal();
        ?>
    </div>

    <script src="./accsets/js/modal.js"></script>
</body>
</html>
