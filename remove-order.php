<?php
// Kết nối CSDL
require 'connect.php';

if (isset($_GET['soHD'])) {
    $soHD = $_GET['soHD'];

    // Bắt đầu transaction để đảm bảo tính toàn vẹn
    mysqli_begin_transaction($conn);

    try {
        // Xóa chi tiết hóa đơn trước
        $sql_cthd = "DELETE FROM chitiethoadon WHERE soHD = ?";
        $stmt_cthd = mysqli_prepare($conn, $sql_cthd);
        mysqli_stmt_bind_param($stmt_cthd, 's', $soHD);
        mysqli_stmt_execute($stmt_cthd);

        // Xóa hóa đơn
        $sql_hd = "DELETE FROM hoadon WHERE soHD = ?";
        $stmt_hd = mysqli_prepare($conn, $sql_hd);
        mysqli_stmt_bind_param($stmt_hd, 's', $soHD);
        mysqli_stmt_execute($stmt_hd);

        // Commit nếu không có lỗi
        mysqli_commit($conn);

        // Chuyển hướng hoặc thông báo thành công
        header("Location: orders.php");
        exit;
    } catch (Exception $e) {
        // Rollback nếu có lỗi
        mysqli_rollback($conn);
        echo "Lỗi khi xóa đơn hàng: " . $e->getMessage();
    }
} else {
    echo "Không có mã hóa đơn.";
}
?>
