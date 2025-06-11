const modal = document.querySelector(".modal-address");
const modalContent = document.querySelector(".modal-address-content");
const editBtn = document.querySelector(".js-edit-address");
const closeBtn = document.querySelector('.modal-address-content .close');

    // Mở modal
if (editBtn) {
    editBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        modal.style.display = "block";
    });
}

    // Đóng modal khi click vào nút close
if (closeBtn) {
    closeBtn.addEventListener("click", function () {
         modal.style.display = "none";
    });
}

    // Đóng modal khi click ra ngoài modal-content (xử lý nổi bọt)
window.addEventListener("click", function (e) {
    if (e.target === modal) {
        modal.style.display = "none";
    }
});

    // Ngăn sự kiện nổi bọt khi click bên trong nội dung modal
if (modalContent) {
    modalContent.addEventListener("click", function (e) {
        e.stopPropagation();
    });
}

document.querySelector('#modalAddress form').addEventListener('submit', function(e) {
    e.preventDefault(); // Không reload trang
    const form = this;
    const formData = new FormData(form);

    fetch('update_address.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "success") {
            alert("Cập nhật thành công!");
            // Tùy bạn: có thể ẩn modal và cập nhật phần hiển thị thông tin
            document.getElementById('modalAddress').style.display = "none";
            location.reload(); // Hoặc chỉ cập nhật phần địa chỉ bằng JS nếu muốn
        } else {
            alert("Có lỗi xảy ra: " + data);
        }
    });
});