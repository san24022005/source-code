document.getElementById("btn-xacnhan").addEventListener("click", function () {
    const masp = document.querySelector(".js-mua-ngay[data-masp]").getAttribute("data-masp");
    const size = modalSize.value;
    const soluong = modalQty.value;

    // Tạo query string
    const query = `masp=${encodeURIComponent(masp)}&size=${encodeURIComponent(size)}&soluong=${encodeURIComponent(soluong)}`;

    // Ví dụ chuyển hướng tới file mua.php với query
    window.location.href = "shopping.php?" + query;

    // Nếu muốn gửi bằng fetch/post cũng được, nhưng bạn nói là muốn query string
});
