document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const leftBtn = document.querySelector('.nav.left');
    const rightBtn = document.querySelector('.nav.right');
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
            dots[i].classList.toggle('active', i === index);
        });
        currentSlide = index;
    }

    rightBtn.addEventListener('click', () => {
        let next = (currentSlide + 1) % slides.length;
        showSlide(next);
    });

    leftBtn.addEventListener('click', () => {
        let prev = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(prev);
    });

    dots.forEach(dot => {
        dot.addEventListener('click', () => {
            showSlide(parseInt(dot.dataset.index));
        });
    });

    // Optional: Auto-slide every 6 seconds
    setInterval(() => {
        let next = (currentSlide + 1) % slides.length;
        showSlide(next);
    }, 6000);
});
