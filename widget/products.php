<div id="products">
<?php
$host = "localhost";
$user = "root";
$pass = "123456";  
$dbname = "QLBH";

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$sql = "SELECT sp.masp, tensp, gia, url 
        FROM sanpham sp
        ORDER BY sp.masp";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='product'>";
        echo "<a href='details.php?masp={$row['masp']}'><img src='{$row['url']}' width='150' height='150'/></a>";
        echo "<h3>{$row['tensp']}</h3>";
        echo "<p><strong>Giá: " . number_format($row['gia']) . " VNĐ</strong></p>";

        // Các nút chức năng
        echo "<table>";
        echo "<tr>";
        echo "<td><button type='button' class='btn btn-giohang' onclick=\"alert('Đã thêm vào giỏ: {$row['tensp']}')\"><i class='ti-shopping-cart'></i></button></td>";
        echo "<td><a href='details.php?masp={$row['masp']}' class='btn'><button type='button' class='btn'>Xem chi tiết</button></a></td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td colspan='2'><a href='shopping.php?masp={$row['masp']}' class='btn btn-buy js-mua-ngay' onclick=\"alert('Mua ngay: {$row['tensp']}')\">
                <button type='button' class='btn'>Mua ngay</button></a></td>";
        echo "</tr>";
        echo "</table>";

        echo "</div>";
    }
} else {
    echo "Không có sản phẩm nào.";
}
?>
</div>


