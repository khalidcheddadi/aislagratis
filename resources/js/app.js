import './bootstrap';
import AOS from 'aos';


AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
    offset: 80,
});


const mobileToggle = document.getElementById('mobileToggle');
const mobileNav = document.getElementById('mobileNav');
if (mobileToggle && mobileNav) {
    mobileToggle.addEventListener('click', () => {
        mobileNav.classList.toggle('show');
    });
}


const userDropdownToggle = document.getElementById('userDropdownToggle');
if (userDropdownToggle) {
    const userDropdown = userDropdownToggle.nextElementSibling;
    userDropdownToggle.addEventListener('click', (e) => {
        e.preventDefault();
        userDropdown.style.display = userDropdown.style.display === 'none' ? 'block' : 'none';
    });
    document.addEventListener('click', (e) => {
        if (!userDropdownToggle.contains(e.target) && !userDropdown.contains(e.target)) {
            userDropdown.style.display = 'none';
        }
    });
}


const tickerTrack = document.getElementById('tickerTrack');
if (tickerTrack) {
    tickerTrack.innerHTML += tickerTrack.innerHTML;
}


if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
            .catch(error => console.error('Service Worker registration failed:', error));
    });
}


let deferredPrompt;
const installPrompt = document.getElementById('installPrompt');
const installBtn = document.getElementById('installBtn');
const closePrompt = document.getElementById('closePrompt');

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    if (installPrompt) installPrompt.style.display = 'flex';
});

if (installBtn) {
    installBtn.addEventListener('click', async () => {
        if (!deferredPrompt) return;
        deferredPrompt.prompt();
        await deferredPrompt.userChoice;
        deferredPrompt = null;
        installPrompt.style.display = 'none';
    });
}

if (closePrompt) {
    closePrompt.addEventListener('click', () => {
        installPrompt.style.display = 'none';
    });
}

window.addEventListener('appinstalled', () => {
    if (installPrompt) installPrompt.style.display = 'none';
    deferredPrompt = null;
});


(function() {
    const COOKIE_CONSENT_KEY = 'cookies_consent';
    const VISITOR_TOKEN_KEY = 'visitor_token';
    const COOKIE_CONSENT_EXPIRY_DAYS = 365;
    const banner = document.getElementById('cookieConsentBanner');
    const acceptBtn = document.getElementById('acceptCookiesBtn');
    const rejectBtn = document.getElementById('rejectCookiesBtn');

    if (!banner) return;

    function generateVisitorToken() {
        if (window.crypto && crypto.randomUUID) return crypto.randomUUID();
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            const r = Math.random() * 16 | 0;
            const v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    function getVisitorToken() {
        let token = localStorage.getItem(VISITOR_TOKEN_KEY);
        if (!token) {
            token = generateVisitorToken();
            localStorage.setItem(VISITOR_TOKEN_KEY, token);
        }
        return token;
    }

    function getConsent() {
        const stored = localStorage.getItem(COOKIE_CONSENT_KEY);
        if (!stored) return null;
        try {
            const parsed = JSON.parse(stored);
            if (parsed && parsed.expiry && new Date(parsed.expiry) > new Date()) {
                return parsed.value;
            }
            localStorage.removeItem(COOKIE_CONSENT_KEY);
            return null;
        } catch (e) {
            localStorage.removeItem(COOKIE_CONSENT_KEY);
            return null;
        }
    }

    function setConsentLocal(value) {
        const expiryDate = new Date();
        expiryDate.setDate(expiryDate.getDate() + COOKIE_CONSENT_EXPIRY_DAYS);
        localStorage.setItem(COOKIE_CONSENT_KEY, JSON.stringify({
            value: value,
            expiry: expiryDate.toISOString()
        }));
    }

    function saveConsentToServer(value) {
        const visitorToken = getVisitorToken();
        const formData = new FormData();
        formData.append('consent', value);
        formData.append('visitor_token', visitorToken);

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) return;

        fetch('/cookie-consent', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken },
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Cookie consent could not be saved.');
            return response.json();
        })
        .catch(error => console.error('Error saving consent:', error));
    }

    const consent = getConsent();
    if (consent === null) banner.style.display = 'block';

    acceptBtn?.addEventListener('click', () => {
        setConsentLocal('accepted');
        saveConsentToServer('accepted');
        banner.style.display = 'none';
    });

    rejectBtn?.addEventListener('click', () => {
        setConsentLocal('rejected');
        saveConsentToServer('rejected');
        banner.style.display = 'none';
    });
})();


document.querySelectorAll('.faq-hero-question, .faq-question').forEach(btn => {
    btn.addEventListener('click', function() {
        const parent = this.parentElement;
        const selector = parent.classList.contains('faq-hero-item') ? '.faq-hero-item' : '.faq-item';
        const isActive = parent.classList.contains('active');
        document.querySelectorAll(selector).forEach(item => item.classList.remove('active'));
        if (!isActive) parent.classList.add('active');
    });
});
