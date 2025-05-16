
const buyBtns = document.querySelector('.js-mua-ngay')

function showModalBuy() {
    modal.classList.add('show');
}

for (const buyBtn of buyBtns) {
    buyBtn.addEventListener('click', showModalBuy() );
}

