<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Slider</title>
    <style>
        .slider {
            position: relative;
            width: 100%;
            max-width: 800px;
            margin: auto;
            overflow: hidden;
        }

        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slides img {
            width: 100%;
            border: none;
        }

        .navigation {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .navigation button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }

        .navigation button:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
    </style>
</head>
<body>
    <div class="slider">
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

        function updateSlider() {
            const offset = -currentIndex * 100;
            slides.style.transform = `translateX(${offset}%)`;
        }
    </script>
</body>
</html>