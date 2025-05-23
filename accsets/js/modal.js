document.getElementById("btn-xacnhan").addEventListener("click", function () {
    const masp = modal.dataset.masp;
    const size = modalSize.value;
    const soluong = modalQty.value;

    if (!masp) {
        alert("Lỗi: Mã sản phẩm không hợp lệ.");
        return;
    }

    const url = `shopping.php?masp=${encodeURIComponent(masp)}&size=${encodeURIComponent(size)}&soluong=${encodeURIComponent(soluong)}`;
    document.getElementById("xacnhan-link").href = url;
});
