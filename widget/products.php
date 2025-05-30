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

// Lấy danh mục sản phẩm khác nhau
$sql_danhmuc = "SELECT DISTINCT danhmuc FROM sanpham ORDER BY danhmuc";
$result_danhmuc = $conn->query($sql_danhmuc);

if ($result_danhmuc->num_rows > 0) {
    while ($row_dm = $result_danhmuc->fetch_assoc()) {
        $danhmuc = $row_dm['danhmuc'];
        $id_danhmuc = vn_to_str($danhmuc);

        echo "<div id='$id_danhmuc' class='danhmuc'>";
        echo "<h1>$danhmuc</h1>";

        // Lấy các kiểu theo danh mục
        $stmt_kieu = $conn->prepare("SELECT DISTINCT kieu FROM sanpham WHERE danhmuc = ? ORDER BY kieu");
        $stmt_kieu->bind_param("s", $danhmuc);
        $stmt_kieu->execute();
        $result_kieu = $stmt_kieu->get_result();

        if ($result_kieu->num_rows > 0) {
            while ($row_kieu = $result_kieu->fetch_assoc()) {
                $kieu = $row_kieu['kieu'];
                $id_kieu = vn_to_str($kieu);

                echo "<div id='$id_kieu' class='kieu'>";
                echo "<h2>$kieu</h2>";

                // Lấy sản phẩm theo danh mục và kiểu
                $stmt_sp = $conn->prepare("SELECT masp, tensp, gia, url FROM sanpham WHERE danhmuc = ? AND kieu = ? ORDER BY masp");
                $stmt_sp->bind_param("ss", $danhmuc, $kieu);
                $stmt_sp->execute();
                $result_sp = $stmt_sp->get_result();

                while ($row = $result_sp->fetch_assoc()) {
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
                    echo "</tr><tr>";
                    echo "<td colspan='2' class='btn-muangay'>";
                    echo "<button type='button' class='btn js-mua-ngay' 
                            data-masp='{$row['masp']}' 
                            data-img='{$row['url']}'
                            data-tensp='{$row['tensp']}'
                            data-gia='{$row['gia']}'>Mua ngay
                        </button>
                        </td>";

                    echo "</table>";
                    echo "</div>";
                }

                echo "</div>"; // đóng kieu
            }
        }

        echo "</div>"; // đóng danhmuc
    }
} else {
    echo "Không có danh mục sản phẩm nào.";
}

$conn->close();
?>
</div>

<?php
function vn_to_str($str) {
    $unicode = [
        'a'=>'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
        'd'=>'đ',
        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'i'=>'í|ì|ỉ|ĩ|ị',
        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'D'=>'Đ',
        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    ];
    foreach($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    return strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $str));
}
?>
