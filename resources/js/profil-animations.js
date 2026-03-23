// Animations for profile page
document.addEventListener('DOMContentLoaded', function() {
    // Navbar scroll effect
    const navbar = document.getElementById('homepage-navbar');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    // Handle navbar on scroll
    function handleScroll() {
        if (window.scrollY > 50) {
            navbar.classList.add('is-scrolled');
        } else {
            navbar.classList.remove('is-scrolled');
        }
        
        // Trigger element animations
        const animatedElements = document.querySelectorAll('[data-home-animate], [data-home-stagger] > *');
        animatedElements.forEach(element => {
            const rect = element.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            
            if (rect.top <= windowHeight - 100) {
                element.classList.add('is-visible');
            }
        });
        
        // Handle stagger container children
        const staggerContainers = document.querySelectorAll('[data-home-stagger]');
        staggerContainers.forEach(container => {
            const children = container.children;
            const containerRect = container.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            
            if (containerRect.top <= windowHeight - 100) {
                Array.from(children).forEach((child, index) => {
                    child.style.setProperty('--stagger-index', index);
                    child.classList.add('is-visible');
                });
            }
        });
        
        // Add this inside handleScroll function after existing code
        
        // Handle stagger items with delay
        const staggerItems = document.querySelectorAll('[data-home-stagger] .stagger-item');
        staggerItems.forEach((item, index) => {
            const rect = item.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            
            if (rect.top <= windowHeight - 100) {
                item.style.transitionDelay = `${150 + (index * 50)}ms`;
                item.classList.add('is-visible');
            }
        });
    }
    
    // Initial check
    handleScroll();
    
    // Add scroll listener
    window.addEventListener('scroll', handleScroll);
    
    // Mobile menu toggle
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
        });
    }
});
