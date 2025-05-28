document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll(".btn-them-gio");

    buttons.forEach(button => {
        button.addEventListener("click", function () {
            const masp = button.getAttribute("data-masp");
            const tensp = button.getAttribute("data-tensp");
            const gia = button.getAttribute("data-gia");
            const img = button.getAttribute("data-img");

            // 👉 Gửi dữ liệu qua Ajax để thêm vào giỏ hàng (ví dụ gửi về PHP)
            fetch("add_to_cart.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `masp=${masp}&tensp=${encodeURIComponent(tensp)}&gia=${gia}&img=${encodeURIComponent(img)}`
            })
            .then(res => res.text())
            .then(data => {
                alert("Đã thêm vào giỏ hàng!");
                console.log(data); // Xem phản hồi từ server nếu cần
            })
            .catch(err => console.error("Lỗi:", err));
        });
    });
});

