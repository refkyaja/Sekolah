// Animations for kurikulum page
document.addEventListener('DOMContentLoaded', function() {
    console.log('🎬 Kurikulum animations loaded!');
    
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
        const animatedElements = document.querySelectorAll('[data-kurikulum-animate]');
        console.log(`🎯 Found ${animatedElements.length} animated elements`);
        animatedElements.forEach((element, index) => {
            const rect = element.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            
            if (rect.top <= windowHeight - 100) {
                console.log(`✅ Making element ${index} visible:`, element);
                element.classList.add('is-visible');
            }
        });
        
        // Handle stagger container children
        const staggerContainers = document.querySelectorAll('[data-kurikulum-stagger]');
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
        
        // Handle holistic items with specific delays
        const holisticItems = document.querySelectorAll('.holistic-item');
        holisticItems.forEach((item, index) => {
            const rect = item.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            
            if (rect.top <= windowHeight - 100) {
                item.style.transitionDelay = `${1100 + (index * 50)}ms`;
                item.classList.add('is-visible');
            }
        });
        
        // Handle PAUD items with specific delays
        const paudItems = document.querySelectorAll('.paud-item');
        paudItems.forEach((item, index) => {
            const rect = item.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            
            if (rect.top <= windowHeight - 100) {
                item.style.transitionDelay = `${1500 + (index * 50)}ms`;
                item.classList.add('is-visible');
            }
        });
        
        // Handle Why Choose Us cards
        const whyCards = document.querySelectorAll('.why-card');
        whyCards.forEach((card, index) => {
            const rect = card.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            
            if (rect.top <= windowHeight - 100) {
                card.style.transitionDelay = `${2200 + (index * 50)}ms`;
                card.classList.add('is-visible');
            }
        });
    }
    
    // Initial check
    handleScroll();
    
    // Add scroll listener with throttle for better performance
    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(function() {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    });
    
    // Mobile menu toggle
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
        });
    }
    
    // Add smooth reveal for elements on page load
    setTimeout(() => {
        handleScroll();
    }, 100);
});