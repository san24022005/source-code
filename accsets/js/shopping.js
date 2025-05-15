
const buyBtns = document.querySelector('.js-mua-ngay')

function showModalBuy() {
    modal.classList.add('show');
}

for (const buyBtn of buyBtns) {
    buyBtn.addEventListener('click', showModalBuy() );
}


document.querySelector('.modal-buy .close').addEventListener('click', function () {
    document.querySelector('.modal-buy').classList.remove('show'); // Xóa class .show
});

// Lắng nghe sự kiện khi người dùng ấn vào nút đóng
document.querySelector('.modal-buy .btn-close').addEventListener('click', function () {
    document.querySelector('.modal-buy').classList.remove('show'); // Xóa class .show
});