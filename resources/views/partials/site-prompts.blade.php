<aside class="site-install-prompt" id="installPrompt" aria-label="Instalar aislagratis" aria-live="polite">
    <img src="{{ asset('icons/icon-192.png') }}" alt="" width="44" height="44">
    <div class="site-install-copy">
        <strong>aislagratis en tu dispositivo</strong>
        <span>Accede cómodamente desde tu pantalla de inicio.</span>
    </div>
    <button class="site-install-action" id="installBtn" type="button">Instalar</button>
    <button class="site-install-close" id="closePrompt" type="button" aria-label="Cerrar aviso de instalación">&times;</button>
</aside>

<div class="site-cookie-banner" id="cookieConsentBanner" data-consent-url="{{ route('cookie.consent') }}" role="dialog" aria-modal="false" aria-labelledby="cookieConsentTitle" aria-describedby="cookieConsentDesc cookieConsentStatus">
    <div class="site-cookie-copy">
        <strong id="cookieConsentTitle"><span aria-hidden="true">🍪</span> Usamos cookies</strong>
        <p id="cookieConsentDesc">Utilizamos cookies técnicas necesarias y almacenamiento local para recordar tu elección. Consulta nuestra <a href="{{ route('legal.cookies') }}">Política de cookies</a>.</p>
        <p id="cookieConsentStatus" class="site-cookie-error" role="status" hidden></p>
    </div>
    <div class="site-cookie-actions">
        <button class="site-cookie-reject" id="rejectCookiesBtn" type="button">Rechazar</button>
        <button class="site-cookie-accept" id="acceptCookiesBtn" type="button">Aceptar</button>
    </div>
</div>
