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
        echo "<div class='product' style='border:1px solid #ccc; padding:10px; margin:10px; width:200px; float:left; text-align:center'>";
        echo "<img src='{$row['url']}' width='150' height='150'/>";
        echo "<h3>{$row['tensp']}</h3>";
        echo "<p><strong>Giá: " . number_format($row['gia']) . " VNĐ</strong></p>";

        // Các nút chức năng
        echo "<button class='btn' onclick=\"alert('Mua ngay: {$row['tensp']}')\">Mua ngay</button>";
        echo "<button class='btn' onclick=\"alert('Đã thêm vào giỏ: {$row['tensp']}')\">Thêm vào giỏ</button> ";
        echo "<a href='chitiet.php?masp={$row['masp']}'><button class='btn'>Xem chi tiết</button></a>";

        echo "</div>";
    }
} else {
    echo "Không có sản phẩm nào.";
}
?>
</div>
