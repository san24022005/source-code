
<?php
$conn = new mysqli("localhost", "root", "123456", "qlbh");
$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
<?php
include "connect.php";

$masp = isset($_GET['masp']) ? $_GET['masp'] : '';

$sql = "SELECT * FROM sanpham WHERE masp = '$masp'";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

$sql_sizes = "SELECT * FROM size_sanpham WHERE masp = '$masp'";
$sizes = $conn->query($sql_sizes);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm - <?= $product['tensp'] ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/themify-icons@1.0.1/css/themify-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f5f5;
            padding: 40px;
            color: #333;
        }

        .product-container {
            display: flex;
            gap: 40px;
            background: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-image {
            width: 50%;
            position: relative;
        }

        .product-image img {
            width: 100%;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .product-image img:hover {
            transform: scale(1.05);
        }

        .product-details {
            width: 50%;
            padding: 20px 0;
        }

        .product-details h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #222;
        }

        .product-meta {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .product-price {
            font-size: 26px;
            color: #d63031; /* Màu đỏ đậm hơn */
            font-weight: bold;
            margin-bottom: 15px;
        }

        .promotion {
            margin-bottom: 20px;
            font-size: 14px;
        }

        .promotion span {
            color: #d63031;
            font-weight: 500;
        }

        .promotion a {
            color: #d63031;
            text-decoration: underline;
            margin-left: 5px;
        }

        .color-options, .size-options, .quantity-selector {
            margin: 20px 0;
        }

        .color-options span, .size-options span {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .color-options span:hover, .size-options span:hover {
            border-color: #d63031;
            background: #f8f8f8;
        }

        .color-options span.active, .size-options span.active {
            border-color: #d63031;
            background: #ffe6e6;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-selector button {
            background: #ddd;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .quantity-selector button:hover {
            background: #ccc;
        }

        .quantity-selector input {
            width: 50px;
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .actions button, .actions i {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            font-weight: 500;
            text-align: center;
        }

        .actions button {
            background: #d63031; /* Nút Mua ngay màu đỏ */
            color: white;
            flex: 1;
        }

        .actions button:hover {
            background: #b12729; /* Đậm hơn khi hover */
        }

        .actions i {
            background: #28a745; /* Nút Thêm vào giỏ màu xanh */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
        }

        .actions i:hover {
            background: #218838; /* Xanh đậm hơn khi hover */
        }

        .social-icons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        .social-icons a {
            color: #666;
            font-size: 20px;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #d63031;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-container {
                flex-direction: column;
                padding: 20px;
            }

            .product-image, .product-details {
                width: 100%;
            }

            .product-details h2 {
                font-size: 24px;
            }

            .product-price {
                font-size: 20px;
            }

            .actions button, .actions i {
                padding: 10px 20px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<?php if ($product): ?>
    <div class="product-container">
        <div class="product-image">
            <img src="<?= $product['url'] ?>" alt="<?= $product['tensp'] ?>">
        </div>
        <div class="product-details">
            <h2><?= $product['tensp'] ?> - <?= $product['masp'] ?></h2>
            <div class="product-meta">
                Thương hiệu: <?= $product['brand'] ?? 'W&W' ?> | Loại: <?= $product['danhmuc'] ?> | Mã SP: <?= $product['masp'] ?>
            </div>
            <div class="product-price"><?= number_format($product['gia'], 0, ',', '.') ?>₫</div>

            <!-- Khuyến mãi -->
            <div class="promotion">
                <p><span>Giảm 10%</span> - <a href="#">Xem hướng dẫn</a></p>
                <p>Áp dụng miễn phí giao hàng toàn quốc cho đơn hàng từ 500K. <a href="#">Xem chi tiết</a></p>
            </div>

            <!-- Lựa chọn màu sắc -->
            <div class="color-options">
                <p><strong>Màu sắc:</strong></p>
                <span class="active">Đen</span>
                <span>Xanh đen</span>
            </div>

            <!-- Lựa chọn kích thước -->
            <div class="size-options">
                <p><strong>Kích thước:</strong></p>
                <?php while($row = $sizes->fetch_assoc()): ?>
                    <span><?= $row['size'] ?> (SL: <?= $row['soluong'] ?>)</span>
                <?php endwhile; ?>
            </div>

            <!-- Chọn số lượng -->
            <div class="quantity-selector">
                <p><strong>Số lượng:</strong></p>
                <button onclick="updateQuantity(-1)">-</button>
                <input type="number" id="quantity" value="1" min="1" readonly>
                <button onclick="updateQuantity(1)">+</button>
            </div>

            <!-- Nút hành động -->
            <div class="actions">
                <i class="ti-shopping-cart" onclick="addToCart()" title="Thêm vào giỏ hàng">THÊM VÀO GIỎ</i>
                <button onclick="buyNow()">MUA NGAY</button>
            </div>

            <!-- Biểu tượng mạng xã hội -->
            <div class="social-icons">
                <a href="#" class="ti-facebook"></a>
                <a href="#" class="ti-email"></a>
                <a href="#" class="ti-comment-alt"></a> <!-- Biểu tượng thay thế cho Zalo -->
            </div>
        </div>
    </div>
<?php else: ?>
    <p style="text-align: center; font-size: 18px; color: #d63031;">Không tìm thấy sản phẩm.</p>
<?php endif; ?>

<script>
    function updateQuantity(change) {
        const quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        quantity = Math.max(1, quantity + change);
        quantityInput.value = quantity;
    }

    function addToCart() {
        const quantity = document.getElementById('quantity').value;
        const selectedColor = document.querySelector('.color-options .active').textContent;
        alert(`Đã thêm ${quantity} sản phẩm màu ${selectedColor} vào giỏ hàng!`);
    }

    function buyNow() {
        const quantity = document.getElementById('quantity').value;
        const selectedColor = document.querySelector('.color-options .active').textContent;
        alert(`Đặt mua ngay ${quantity} sản phẩm màu ${selectedColor}!`);
    }
</script>

</body>
</html>
