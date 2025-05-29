<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "123456", "QLBH");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý tìm kiếm nếu có từ khóa
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>BT Shop</title>
    <style>
        body { font-family: Arial; padding: 20px; margin: 0; }
        .header { 
            background-color: #007bff; 
            color: white; 
            padding: 10px 20px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            position: sticky; 
            top: 0; 
            z-index: 1000; 
        }
        .header h1 { margin: 0; font-size: 24px; }
        .header input[type="text"] { 
            width: 200px; 
            padding: 8px; 
            border: none; 
            border-radius: 4px; 
        }
        .header button { 
            padding: 8px 12px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
        }
        .nav { 
            display: flex; 
            gap: 20px; 
        }
        .nav a { 
            color: white; 
            text-decoration: none; 
            font-size: 16px; 
            font-weight: bold; 
        }
        #cart-header { 
            font-size: 18px; 
            cursor: pointer; 
            margin-left: 10px; 
        }
        #results { 
            margin-top: 20px; 
        }
        .product { 
            border: 1px solid #ccc; 
            padding: 15px; 
            margin: 10px 0; 
            border-radius: 5px; 
            display: inline-block; 
            width: 200px; 
            text-align: center; 
            vertical-align: top; 
            margin-right: 20px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
        }
        .product img { 
            width: 100%; 
            height: auto; 
        }
        .product h3 { 
            margin: 10px 0; 
            font-size: 16px; 
        }
        .product p { 
            margin: 5px 0; 
            font-size: 14px; 
        }
        .product button { 
            padding: 8px; 
            margin: 5px 0; 
            width: 100%; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 14px; 
        }
        .cart-button { 
            background-color: #007bff; 
            color: white; 
        }
        .buy-now { 
            background-color: #007bff; 
            color: white; 
        }
        .section-title { 
            font-size: 20px; 
            font-weight: bold; 
            margin: 20px 0; 
        }
    </style>
</head>
<body>

<div class="header">
    <h1>BT SHOP</h1>
    <div class="nav">
        <a href="#">ÁO</a>
        <a href="#">QUẦN</a>
        <a href="#">ĐỒ BỘ</a>
        <a href="#">ĐỒNG PHỤC</a>
        <a href="#">MẶT KÍNH</a>
    </div>
    <div>
        <form id="search-form" style="display: inline;">
            <input type="text" id="search-input" name="keyword" placeholder="Nhập từ khóa..." value="<?php echo htmlspecialchars($keyword); ?>">
            <button type="submit">🔍</button>
        </form>
        <span id="cart-header">🛒</span>
    </div>
</div>

<div id="results">
    <?php
    if ($keyword !== '') {
        // Chuẩn bị truy vấn an toàn
        $stmt = $conn->prepare("
            SELECT * FROM sanpham
            WHERE 
                tensp LIKE CONCAT('%', ?, '%') 
                OR masp LIKE CONCAT('%', ?, '%')
                OR danhmuc LIKE CONCAT('%', ?, '%')
                OR kieu LIKE CONCAT('%', ?, '%')
                OR nuocsx LIKE CONCAT('%', ?, '%')
        ");
        $stmt->bind_param("sssss", $keyword, $keyword, $keyword, $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();

        // Hiển thị kết quả
        if ($result->num_rows > 0) {
            echo "<div class='section-title'>Kết quả tìm kiếm</div>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<img src='placeholder.jpg' alt='Product Image'>"; // Thay bằng URL ảnh thực tế nếu có
                echo "<h3>" . htmlspecialchars($row['tensp']) . "</h3>";
                echo "<p><strong>Giá:</strong> " . number_format($row['gia'], 0, ',', '.') . " VND</p>";
                echo "<button class='cart-button'>🛒 Xem chi tiết</button>";
                echo "<button class='buy-now'>Mua ngay</button>";
                echo "</div>";
            }
        } else {
            echo "<p>Không tìm thấy sản phẩm nào phù hợp.</p>";
        }

        $stmt->close();
    } else {
        // Mặc định hiển thị một số sản phẩm nếu không có từ khóa
        $result = $conn->query("SELECT * FROM sanpham LIMIT 4");
        if ($result->num_rows > 0) {
            echo "<div class='section-title'>Áo Polo</div>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<img src='placeholder.jpg' alt='Product Image'>"; // Thay bằng URL ảnh thực tế nếu có
                echo "<h3>" . htmlspecialchars($row['tensp']) . "</h3>";
                echo "<p><strong>Giá:</strong> " . number_format($row['gia'], 0, ',', '.') . " VND</p>";
                echo "<button class='cart-button'>🛒 Xem chi tiết</button>";
                echo "<button class='buy-now'>Mua ngay</button>";
                echo "</div>";
            }
        }

        // Thêm một danh mục khác (Áo sơ mi)
        $result_shirts = $conn->query("SELECT * FROM sanpham LIMIT 4 OFFSET 4");
        if ($result_shirts->num_rows > 0) {
            echo "<div class='section-title'>Áo sơ mi</div>";
            while ($row = $result_shirts->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<img src='placeholder.jpg' alt='Product Image'>"; // Thay bằng URL ảnh thực tế nếu có
                echo "<h3>" . htmlspecialchars($row['tensp']) . "</h3>";
                echo "<p><strong>Giá:</strong> " . number_format($row['gia'], 0, ',', '.') . " VND</p>";
                echo "<button class='cart-button'>🛒 Xem chi tiết</button>";
                echo "<button class='buy-now'>Mua ngay</button>";
                echo "</div>";
            }
        }
    }
    ?>
</div>

<script>
    // Ngăn reload trang và cuộn xuống khi submit form tìm kiếm
    document.getElementById('search-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Ngăn reload trang
        const keyword = document.getElementById('search-input').value;
        if (keyword) {
            // Thực hiện tìm kiếm và cuộn xuống
            document.getElementById('results').scrollIntoView({ behavior: 'smooth' });
            // Có thể thêm logic AJAX để tải dữ liệu mới nếu cần
        }
    });

    // Tự động cuộn xuống danh sách sản phẩm khi nhấp vào ô tìm kiếm
    document.getElementById('search-input').addEventListener('click', function() {
        document.getElementById('results').scrollIntoView({ behavior: 'smooth' });
    });

    // Chuyển đến giỏ hàng trên header khi nhấp vào nút giỏ hàng
    document.querySelectorAll('.cart-button').forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('cart-header').scrollIntoView({ behavior: 'smooth' });
            // Bạn có thể thêm logic để cập nhật giỏ hàng tại đây (ví dụ: gọi API)
        });
    });
</script>

<?php
$conn->close();
?>

</body>
</html>