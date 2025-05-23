document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modal-mua-ngay");
    const modalImg = document.getElementById("modal-img");
    const modalTensp = document.getElementById("modal-tensp");
    const modalGia = document.getElementById("modal-gia");
    const modalSize = document.getElementById("modal-size");
    const modalQty = document.getElementById("modal-qty");
    const btnXacNhan = document.getElementById("btn-xacnhan");
    const maxNote = document.getElementById("modal-max-note");

    let currentMasp = ""; // ✅ Biến toàn cục lưu mã sản phẩm

    // Gán sự kiện cho nút "Mua ngay"
    document.querySelectorAll(".js-mua-ngay").forEach(btn => {
        btn.addEventListener("click", function () {
            // Lấy thông tin sản phẩm từ button
            currentMasp = this.getAttribute("data-masp");
            const img = this.getAttribute("data-img");
            const tensp = this.getAttribute("data-tensp");
            const gia = this.getAttribute("data-gia");

            // Gán vào modal
            modalImg.src = img;
            modalTensp.textContent = tensp;
            modalGia.textContent = `Giá: ${parseFloat(gia).toLocaleString()} VNĐ`;
            modalQty.value = 1;
            maxNote.textContent = "";

            // Gọi Ajax lấy size từ PHP (tuỳ bạn triển khai)
            fetch(`get_size.php?masp=${currentMasp}`)
                .then(res => res.json())
                .then(data => {
                    modalSize.innerHTML = "";
                    data.forEach(sizeData => {
                        const option = document.createElement("option");
                        option.value = sizeData.size;
                        option.textContent = `${sizeData.size} (${sizeData.soluong} cái)`;
                        option.setAttribute("data-max", sizeData.soluong);
                        modalSize.appendChild(option);
                    });
                });

            // Hiện modal
            modal.style.display = "block";
        });
    });

    // Cập nhật thông báo tối đa khi chọn size
    modalSize.addEventListener("change", function () {
        const selected = modalSize.options[modalSize.selectedIndex];
        const max = selected.getAttribute("data-max");
        maxNote.textContent = `Tối đa: ${max} cái`;
        modalQty.max = max;
    });

    // Sự kiện nút xác nhận mua
    btnXacNhan.addEventListener("click", function () {
        const size = modalSize.value;
        const soluong = modalQty.value;

        if (!currentMasp || !size || soluong < 1) {
            alert("Vui lòng chọn size và số lượng hợp lệ.");
            return;
        }

        const query = `masp=${encodeURIComponent(currentMasp)}&size=${encodeURIComponent(size)}&soluong=${encodeURIComponent(soluong)}`;
        window.location.href = "shopping.php?" + query;
    });

    // Đóng modal
    document.querySelector(".ti-close").addEventListener("click", function () {
        modal.style.display = "none";
    });
});
