const slides = document.getElementById('slides');
const images = slides.querySelectorAll('img');
const totalImages = images.length;
let currentIndex = 0;

document.getElementById('next').addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % totalImages;
    updateSlider();
});

document.getElementById('prev').addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + totalImages) % totalImages;
    updateSlider();
});

// Tự động chạy mỗi 3 giây
setInterval(() => {
    currentIndex = (currentIndex + 1) % totalImages;
    updateSlider();
}, 3000);


function updateSlider() {
    const offset = -currentIndex * 100;
    slides.style.transform = `translateX(${offset}%)`;
}