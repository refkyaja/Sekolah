document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('guru-scroll');
    const cards = document.querySelectorAll('.guru-card');

    if (!container || cards.length === 0) return;

    const gap = 32;
    const cardWidth = cards[0].offsetWidth + gap;
    let index = 0;

    setInterval(() => {
        index = (index + 1) % cards.length;

        container.scrollTo({
            left: cardWidth * index,
            behavior: 'smooth'
        });
    }, 3000);
});
