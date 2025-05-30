let currentIndex = 0;

function moveSlide(step) {
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;

    currentIndex = (currentIndex + step + totalSlides) % totalSlides;
    const slider = document.querySelector('.slider');
    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
}

// Tự động chuyển slide mỗi 3 giây
setInterval(() => {
    moveSlide(1); // Di chuyển tới slide tiếp theo
}, 3000);
