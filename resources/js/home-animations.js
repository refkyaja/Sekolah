function initHomepageNavbar() {
    const navbar = document.getElementById('homepage-navbar');
    if (!navbar) {
        return;
    }

    const updateState = () => {
        navbar.classList.toggle('is-scrolled', window.scrollY > 24);
    };

    updateState();
    window.addEventListener('scroll', updateState, { passive: true });
}

function initHomepageAnimations() {
    const animatedItems = Array.from(document.querySelectorAll('[data-home-animate], [data-kurikulum-animate]'));
    const staggerGroups = Array.from(document.querySelectorAll('[data-home-stagger], [data-kurikulum-stagger]'));
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (reduceMotion) {
        animatedItems.forEach((item) => item.classList.add('is-visible'));
        staggerGroups.forEach((group) => {
            Array.from(group.children).forEach((child) => child.classList.add('is-visible'));
        });
        return;
    }

    staggerGroups.forEach((group) => {
        Array.from(group.children).forEach((child, index) => {
            if (!(child instanceof HTMLElement)) {
                return;
            }

            child.style.setProperty('--animate-delay', `${index * 110}ms`);
        });
    });

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        {
            threshold: 0.16,
            rootMargin: '0px 0px -10% 0px',
        },
    );

    animatedItems.forEach((item) => observer.observe(item));
    staggerGroups.forEach((group) => {
        Array.from(group.children).forEach((child) => {
            if (child instanceof HTMLElement) {
                observer.observe(child);
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initHomepageNavbar();
    initHomepageAnimations();
});
