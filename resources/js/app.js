import './bootstrap';
import './guru-scroll';

// Import Font Awesome
import '@fortawesome/fontawesome-free/css/all.css';

// Animasi saat scroll
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            e.preventDefault();
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Intersection Observer untuk animasi saat scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
            }
        });
    }, observerOptions);

    // Amati elemen dengan kelas animate-on-scroll
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });

    // Counter animation untuk statistik
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            
            const inc = target / speed;
            
            if (count < target) {
                counter.innerText = Math.ceil(count + inc);
                setTimeout(updateCount, 10);
            } else {
                counter.innerText = target;
            }
        };
        
        const startCounter = () => {
            if (counter.getBoundingClientRect().top < window.innerHeight) {
                updateCount();
                observer.unobserve(counter);
            }
        };
        
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    startCounter();
                }
            });
        }, { threshold: 0.5 });
        
        counterObserver.observe(counter);
    });

    // Mobile menu toggle
    const mobileMenuButton = document.querySelector('[data-collapse-toggle="mobile-menu"]');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('block');
        });
    }

    // Sticky navigation
    const nav = document.querySelector('nav');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            nav.classList.add('shadow-lg', 'bg-white/90', 'backdrop-blur');
        } else {
            nav.classList.remove('shadow-lg', 'bg-white/90', 'backdrop-blur');
        }
    });
});

// Alpine sudah dibawa oleh Livewire. Jangan start instance kedua di sini,
// karena akan bentrok dengan komponen yang memakai entangle().
