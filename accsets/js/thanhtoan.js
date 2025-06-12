function thanhToan() {
    const xacNhan = confirm('Cảm ơn bạn đã thanh toán. Chúng tôi sẽ kiểm tra lại đơn hàng và giao hàng sớm nhất.');
    if (xacNhan) {
        window.location.href = 'clear_cart.php';
    } 
}