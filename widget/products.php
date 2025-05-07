<div id="products">
<?php
$host = "localhost";
$user = "root";
$pass = "123456";
$dbname = "QLBH";  // thay bằng tên CSDL của bạn

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
<?php
$sql = "SELECT sp.masp, tensp, gia, url, size, soluong, giaban
        FROM sanpham sp
        JOIN size_sanpham sz ON sp.masp = sz.masp
        ORDER BY sp.masp, size";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

?>
<?php
$current_masp = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($current_masp != $row['masp']) {
            if ($current_masp != '') echo "</ul></div>"; // kết thúc sản phẩm trước đó
            $current_masp = $row['masp'];
            echo "<div class='product'>";
            echo "<img src='{$row['url']}' width='150' />";
            echo "<h3>{$row['tensp']}</h3>";
            echo "<p>Giá gốc: " . number_format($row['gia']) . " VNĐ</p>";
            echo "<ul><strong>Size và Giá bán:</strong>";
        }
        echo "<li>Size {$row['size']} - SL: {$row['soluong']} - Giá bán: " . number_format($row['giaban']) . " VNĐ</li>";
    }
    echo "</ul></div>"; // kết thúc sản phẩm cuối
} else {
    echo "Không có sản phẩm nào.";
}
?>

</div>