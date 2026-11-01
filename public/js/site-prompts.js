(function () {
    const consentKey = 'cookies_consent';
    const visitorTokenKey = 'visitor_token';
    const consentExpiryDays = 365;
    const banner = document.getElementById('cookieConsentBanner');
    const acceptButton = document.getElementById('acceptCookiesBtn');
    const rejectButton = document.getElementById('rejectCookiesBtn');
    const consentStatus = document.getElementById('cookieConsentStatus');
    const installPrompt = document.getElementById('installPrompt');
    const installButton = document.getElementById('installBtn');
    const closeInstallButton = document.getElementById('closePrompt');
    let deferredInstallPrompt = null;

    function updateInstallPromptOffset() {
        if (banner && document.body.classList.contains('cookie-consent-visible')) {
            const offset = banner.getBoundingClientRect().height + 34;
            document.documentElement.style.setProperty('--cookie-banner-offset', `${offset}px`);
        }
    }

    function displayConsentBanner(visible) {
        if (!banner) return;
        banner.style.display = visible ? 'flex' : 'none';
        document.body.classList.toggle('cookie-consent-visible', visible);
        if (visible) updateInstallPromptOffset();
    }

    function getConsent() {
        const stored = localStorage.getItem(consentKey);
        if (!stored) return null;

        try {
            const consent = JSON.parse(stored);
            if (
                consent
                && ['accepted', 'rejected'].includes(consent.value)
                && consent.expiry
                && new Date(consent.expiry) > new Date()
            ) {
                return {
                    value: consent.value,
                    expiry: consent.expiry,
                    serverSynced: consent.serverSynced === true,
                };
            }
        } catch (error) {
            console.warn('No se pudo leer el consentimiento almacenado.', error);
        }

        localStorage.removeItem(consentKey);
        return null;
    }

    function createVisitorToken() {
        if (window.crypto && typeof window.crypto.randomUUID === 'function') {
            return window.crypto.randomUUID();
        }

        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, character => {
            const random = Math.random() * 16 | 0;
            const value = character === 'x' ? random : (random & 0x3 | 0x8);
            return value.toString(16);
        });
    }

    async function sendConsent(value) {
        let visitorToken = localStorage.getItem(visitorTokenKey);
        if (!visitorToken) {
            visitorToken = createVisitorToken();
            localStorage.setItem(visitorTokenKey, visitorToken);
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        const consentUrl = banner?.dataset.consentUrl;
        if (!csrfToken || !consentUrl) {
            throw new Error('No se pudo guardar el consentimiento: faltan datos de seguridad.');
        }

        const formData = new FormData();
        formData.append('consent', value);
        formData.append('visitor_token', visitorToken);

        const response = await fetch(consentUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                Accept: 'application/json',
            },
            body: formData,
        });
        if (!response.ok) throw new Error(`No se pudo guardar el consentimiento (${response.status}).`);

        const result = await response.json();
        if (result.success !== true) throw new Error('El servidor no confirmó el consentimiento.');
    }

    function storeConsent(value, expiry) {
        localStorage.setItem(consentKey, JSON.stringify({
            value,
            expiry,
            serverSynced: true,
        }));
    }

    async function saveConsent(value) {
        acceptButton.disabled = true;
        rejectButton.disabled = true;
        if (consentStatus) {
            consentStatus.textContent = 'Guardando tu elección…';
            consentStatus.hidden = false;
        }

        try {
            await sendConsent(value);
            const expiry = new Date();
            expiry.setDate(expiry.getDate() + consentExpiryDays);
            storeConsent(value, expiry.toISOString());
            if (consentStatus) consentStatus.hidden = true;
            displayConsentBanner(false);
        } catch (error) {
            console.error('Error al guardar el consentimiento en el servidor:', error);
            if (consentStatus) {
                consentStatus.textContent = 'No se pudo guardar tu elección. Comprueba tu conexión e inténtalo de nuevo.';
                consentStatus.hidden = false;
            }
        } finally {
            acceptButton.disabled = false;
            rejectButton.disabled = false;
        }
    }

    async function synchronizeStoredConsent(consent) {
        if (consent.serverSynced) return;

        try {
            await sendConsent(consent.value);
            storeConsent(consent.value, consent.expiry);
        } catch (error) {
            console.error('No se pudo sincronizar el consentimiento guardado:', error);
        }
    }

    if (banner) {
        const consent = getConsent();
        displayConsentBanner(consent === null);
        if (consent) synchronizeStoredConsent(consent);

        acceptButton?.addEventListener('click', async () => {
            await saveConsent('accepted');
        });

        rejectButton?.addEventListener('click', async () => {
            await saveConsent('rejected');
        });

        window.addEventListener('resize', updateInstallPromptOffset);
    }

    window.addEventListener('beforeinstallprompt', event => {
        event.preventDefault();
        deferredInstallPrompt = event;
        if (installPrompt) installPrompt.style.display = 'flex';
        updateInstallPromptOffset();
    });

    installButton?.addEventListener('click', async () => {
        if (!deferredInstallPrompt) return;

        deferredInstallPrompt.prompt();
        await deferredInstallPrompt.userChoice;
        deferredInstallPrompt = null;
        if (installPrompt) installPrompt.style.display = 'none';
    });

    closeInstallButton?.addEventListener('click', () => {
        if (installPrompt) installPrompt.style.display = 'none';
    });

    window.addEventListener('appinstalled', () => {
        if (installPrompt) installPrompt.style.display = 'none';
        deferredInstallPrompt = null;
    });

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js').catch(error => {
                console.error('Service Worker registration failed:', error);
            });
        });
    }
})();
