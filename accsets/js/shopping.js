document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("modal-mua-ngay");
    const closeBtn = modal.querySelector(".close");
    const muaNgayButtons = document.querySelectorAll(".js-mua-ngay");

    const modalTensp = document.getElementById("modal-tensp");
    const modalGia = document.getElementById("modal-gia");
    const modalImg = document.getElementById("modal-img");
    const modalSize = document.getElementById("modal-size");
    const modalQty = document.getElementById("modal-qty");
    const modalNote = document.getElementById("modal-max-note");

    let currentSizes = {}; // lưu {size: soluong}

    muaNgayButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const masp = btn.getAttribute("data-masp");
            const tensp = btn.getAttribute("data-tensp");
            const gia = btn.getAttribute("data-gia");
            const img = btn.getAttribute("data-img");

            // Cập nhật thông tin
            modalTensp.textContent = tensp;
            modalGia.textContent = "Giá: " + gia + " VNĐ";
            modalImg.src = img;

            modal.dataset.masp = masp; // GÁN MÃ SẢN PHẨM CHO MODAL

            // Gọi Ajax để lấy size
            fetch("get_sizes.php?masp=" + masp)
                .then(res => res.json())
                .then(data => {
                    modalSize.innerHTML = "";
                    currentSizes = {};
                    data.forEach(item => {
                        const opt = document.createElement("option");
                        opt.value = item.size;
                        opt.textContent = `${item.size} (Tối đa: ${item.soluong})`;
                        modalSize.appendChild(opt);
                        currentSizes[item.size] = parseFloat(item.soluong);
                    });
                    modalQty.value = 1;
                    updateQtyLimit();
                    modal.style.display = "flex";
                });
        });
    });

    modalSize.addEventListener("change", updateQtyLimit);
    modalQty.addEventListener("input", updateQtyLimit);

    function updateQtyLimit() {
        const selectedSize = modalSize.value;
        const maxQty = currentSizes[selectedSize] || 1;
        const qtyInput = parseInt(modalQty.value);
        modalQty.max = maxQty;
        if (qtyInput > maxQty) {
            modalNote.textContent = `Chỉ còn tối đa ${maxQty} sản phẩm cho size này`;
            modalQty.value = maxQty;
        } else {
            modalNote.textContent = "";
        }
    }

    closeBtn.addEventListener("click", () => modal.style.display = "none");
    window.addEventListener("click", (e) => {
        if (e.target === modal) modal.style.display = "none";
    });

    document.getElementById("btn-xacnhan").addEventListener("click", function () {
    const masp = modal.dataset.masp;
    const size = modalSize.value;
    const soluong = modalQty.value;

    if (!masp) {
        alert("Lỗi: Mã sản phẩm không hợp lệ.");
        return;
    }

    const url = `shopping.php?masp=${encodeURIComponent(masp)}&size=${encodeURIComponent(size)}&soluong=${encodeURIComponent(soluong)}`;
    window.location.href = url; // ✅ Chuyển hướng trực tiếp
});

});
