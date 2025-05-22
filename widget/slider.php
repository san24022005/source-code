
    <div id="slider">
        <div class="slides" id="slides">
            <img src="accsets/images/slider/slider1.png" alt="Image 1">
            <img src="accsets/images/slider/slider2.png" alt="Image 2">
            <img src="accsets/images/slider/slider3.png" alt="Image 3">
            <img src="accsets/images/slider/slider4.png" alt="Image 4">
        </div>
        <div class="navigation">
            <button id="prev">❮</button>
            <button id="next">❯</button>
        </div>
    </div>

    <script>
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
    </script>
