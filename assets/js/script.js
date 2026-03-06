// assets/js/script.js

// Loader para la pagina (fallback por si load se retrasa)
const hideLoader = () => {
    const loader = document.getElementById('loader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.style.display = 'none';
        }, 500);
    }
};

window.addEventListener('load', hideLoader);
document.addEventListener('DOMContentLoaded', () => setTimeout(hideLoader, 1500));

document.querySelectorAll('[data-auto-dismiss]').forEach(alert => {
    const timeout = Number(alert.dataset.autoDismiss) || 5000;
    const queryFlag = alert.dataset.queryFlag;

    if (queryFlag && window.history.replaceState) {
        const url = new URL(window.location.href);
        url.searchParams.delete(queryFlag);
        const cleanUrl = `${url.pathname}${url.search}${url.hash}`;
        window.history.replaceState({}, document.title, cleanUrl);
    }

    setTimeout(() => {
        alert.classList.add('opacity-0');

        setTimeout(() => {
            alert.remove();
        }, 500);
    }, timeout);
});

// Smooth scroll para enlaces internos
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Mostrar/ocultar boton "volver arriba"
window.addEventListener('scroll', function() {
    const scrollPosition = window.scrollY;
    const backToTop = document.getElementById('back-to-top');
    
    if (backToTop) {
        if (scrollPosition > 500) {
            backToTop.classList.remove('hidden');
        } else {
            backToTop.classList.add('hidden');
        }
    }
});

// Animaciones mas suaves al hacer scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in-up');
            entry.target.classList.remove('opacity-0');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll('.animate-on-scroll').forEach(el => {
    el.classList.add('opacity-0');
    observer.observe(el);
});
