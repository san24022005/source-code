const modal = document.getElementById("modal-mua-ngay");
const closeBtn = modal.querySelector(".close");
const muaNgayButtons = document.querySelectorAll(".js-mua-ngay");

const btnThanhToan = document.getElementById("btn-xacnhan").parentElement;
const btnGioHang = document.getElementById("btn-giohang").parentElement;

const gioHangButtons = document.querySelectorAll(".js-gio-hang");

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
        modalGia.textContent = "Giá: " + Number(gia).toLocaleString('vi-VN') + " VNĐ";
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
                opt.textContent = `${item.size}`;
                modalSize.appendChild(opt);
                currentSizes[item.size] = parseFloat(item.soluong);
            });
            modalQty.value = 1;
            updateQtyLimit();
            modal.style.display = "flex";
        });
        btnThanhToan.style.display = "block";
        btnGioHang.style.display = "none";
    });
});

gioHangButtons.forEach(btn => {
    btn.addEventListener("click", () => {
        const masp = btn.getAttribute("data-masp");
        const tensp = btn.getAttribute("data-tensp");
        const gia = btn.getAttribute("data-gia");
        const img = btn.getAttribute("data-img");

        // Cập nhật thông tin
        modalTensp.textContent = tensp;
        modalGia.textContent = "Giá: " + Number(gia).toLocaleString('vi-VN') + " VNĐ";
        modalImg.src = img;

        modal.dataset.masp = masp;

        fetch("get_sizes.php?masp=" + masp)
        .then(res => res.json())
        .then(data => {
            modalSize.innerHTML = "";
            currentSizes = {};
            data.forEach(item => {
                const opt = document.createElement("option");
                opt.value = item.size;
                opt.textContent = `${item.size}`;
                modalSize.appendChild(opt);
                currentSizes[item.size] = parseFloat(item.soluong);
            });
            modalQty.value = 1;
            updateQtyLimit();

            // Hiển thị nút giỏ hàng, ẩn nút thanh toán
            btnThanhToan.style.display = "none";
            btnGioHang.style.display = "block";

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

    const url = `hoadon.php?masp=${encodeURIComponent(masp)}&size=${encodeURIComponent(size)}&soluong=${encodeURIComponent(soluong)}`;
    window.location.href = url; 
});

document.getElementById("btn-giohang").addEventListener("click", function () {
    const masp = modal.dataset.masp;
    const size = modalSize.value;
    const soluong = modalQty.value;

    if (!masp) {
        alert("Lỗi: Mã sản phẩm không hợp lệ.");
        return;
    }

    const url = `add_giohang.php?masp=${encodeURIComponent(masp)}&size=${encodeURIComponent(size)}&soluong=${encodeURIComponent(soluong)}`;
    window.location.href = url; 
});

const btnIncrease = document.getElementById('btn-increase');
const btnDecrease = document.getElementById('btn-decrease');
const inputQty = document.getElementById('modal-qty');

btnIncrease.addEventListener('click', function () {
    let current = parseInt(inputQty.value) || 1;
    inputQty.value = current + 1;
});

btnDecrease.addEventListener('click', function () {
    let current = parseInt(inputQty.value) || 1;
    if (current > 1) {
        inputQty.value = current - 1;
    }
});