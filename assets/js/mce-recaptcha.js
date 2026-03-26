// assets/js/mce-recaptcha.js
// Render explícito de reCAPTCHA v2 con soporte de cambio de idioma en caliente (mce-lang-changed)
(() => {
    const getLang = () => window.mceCurrentLang || localStorage.getItem('siteLang') || 'es';

    const renderAll = () => {
        if (!window.grecaptcha) return;
        document.querySelectorAll('.g-recaptcha[data-sitekey]').forEach(el => {
            if (el.dataset.recaptchaId) return;
            const id = grecaptcha.render(el, { sitekey: el.dataset.sitekey });
            el.dataset.recaptchaId = id;
        });
        document.querySelectorAll('.recaptcha-old').forEach(old => old.remove());
    };

    const loadRecaptcha = (lang) => {
        const existing = document.querySelector('script[data-mce-recaptcha]');
        if (existing && existing.dataset.lang === lang) {
            renderAll();
            return;
        }
        if (existing) existing.remove();
        delete window.grecaptcha;
        delete window.___grecaptcha_cfg;
        const s = document.createElement('script');
        s.src = `https://www.google.com/recaptcha/api.js?onload=mceRenderRecaptcha&render=explicit&hl=${lang}`;
        s.async = true;
        s.defer = true;
        s.dataset.mceRecaptcha = '1';
        s.dataset.lang = lang;
        document.head.appendChild(s);
        window.mceRenderRecaptcha = renderAll;
    };

    const rehydratePlaceholders = () => {
        const fresh = [];
        document.querySelectorAll('.g-recaptcha[data-sitekey]').forEach(el => {
            if (!el.dataset.recaptchaId) return;
            const clone = document.createElement('div');
            clone.className = el.className;
            clone.dataset.sitekey = el.dataset.sitekey;
            el.insertAdjacentElement('afterend', clone);
            el.classList.add('recaptcha-old');
            fresh.push(clone);
        });
        return fresh;
    };

    const formsWithCaptcha = () =>
        Array.from(document.querySelectorAll('form')).filter(f => f.querySelector('.g-recaptcha'));

    const attachSubmitBlocker = () => {
        formsWithCaptcha().forEach((form) => {
            if (form.dataset.mceRecaptchaBound) return;
            form.dataset.mceRecaptchaBound = '1';
            form.addEventListener('submit', (event) => {
                if (typeof window.grecaptcha === 'undefined') {
                    event.preventDefault();
                    alert('reCAPTCHA aun no termina de cargar. Intenta nuevamente en unos segundos.');
                    return;
                }
                const widgetId = form.querySelector('.g-recaptcha')?.dataset.recaptchaId;
                const response = widgetId !== undefined ? grecaptcha.getResponse(Number(widgetId)) : '';
                if (!response) {
                    event.preventDefault();
                    alert('Completa la verificación reCAPTCHA antes de enviar.');
                }
            });
        });
    };

    // init
    loadRecaptcha(getLang());
    attachSubmitBlocker();

    window.addEventListener('mce-lang-changed', (e) => {
        rehydratePlaceholders();
        loadRecaptcha(e.detail?.lang || 'es');
        attachSubmitBlocker();
    });
})();
