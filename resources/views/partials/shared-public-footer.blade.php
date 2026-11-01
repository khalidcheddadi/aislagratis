<footer class="brand-footer">
    <div class="brand-footer-ticker" role="region" aria-label="Información sobre nuestros servicios">
        <div class="brand-footer-ticker-track" aria-hidden="true">
            @foreach (['Aislamiento de cubiertas', 'Programa CAE · RD 36/2023', 'Estudio técnico gratuito', 'Cobertura en el norte de España'] as $item)
                <span><i></i>{{ $item }}</span>
            @endforeach
            @foreach (['Aislamiento de cubiertas', 'Programa CAE · RD 36/2023', 'Estudio técnico gratuito', 'Cobertura en el norte de España'] as $item)
                <span><i></i>{{ $item }}</span>
            @endforeach
        </div>
    </div>

    <div class="brand-footer-main">
        <div class="brand-footer-grid">
            <section class="brand-footer-intro" aria-label="Información de aislagratis">
                <a class="brand-footer-logo" href="{{ route('home') }}" aria-label="aislagratis, inicio">
                    <img src="{{ asset('icons/icon-192.png') }}?v={{ filemtime(public_path('icons/icon-192.png')) }}" alt="" aria-hidden="true" width="38" height="38">
                    <span>islagratis<span class="brand-footer-trademark">™</span><small>Programa CAE · RD 36/2023</small></span>
                </a>
                <p>Aislamiento térmico de cubiertas para viviendas. Estudio técnico gratuito, acompañamiento y orientación sobre el programa CAE.</p>
                <div class="brand-footer-social" aria-label="Canales de contacto">
                    <a href="https://wa.me/{{ config('aislaplus.phone_whatsapp') }}" target="_blank" rel="noopener noreferrer" aria-label="Contactar por WhatsApp"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', config('aislaplus.phone')) }}" aria-label="Llamar"><i class="fa-solid fa-phone" aria-hidden="true"></i></a>
                    <a href="mailto:{{ config('aislaplus.email') }}" aria-label="Enviar correo"><i class="fa-solid fa-envelope" aria-hidden="true"></i></a>
                </div>
                <span class="brand-footer-status"><i></i> Atención personalizada</span>
            </section>

            <nav class="brand-footer-links" aria-label="Explorar">
                <h2>Explorar</h2>
                <a href="{{ route('home') }}">Inicio</a>
                <a href="{{ route('about') }}">Sobre nosotros</a>
                <a href="{{ route('services.index') }}">Servicios</a>
                <a href="{{ route('coverage') }}">Cobertura</a>
                <a href="{{ route('faq') }}">Preguntas frecuentes</a>
            </nav>

            <nav class="brand-footer-links" aria-label="Información y recursos">
                <h2>Información</h2>
                <a href="{{ route('home') }}#cae">Programa CAE</a>
                <a href="{{ route('home') }}#requisitos">Requisitos</a>
                <a href="{{ route('legal.privacy') }}">Privacidad</a>
                <a href="{{ route('legal.terms') }}">Términos y condiciones</a>
                <a href="{{ route('legal.cookies') }}">Política de cookies</a>
            </nav>

            <section class="brand-footer-contact">
                <span class="brand-footer-eyebrow">¿Hablamos?</span>
                <h2>Mejora el confort de tu hogar.</h2>
                <p>Cuéntanos sobre tu vivienda y solicita un primer estudio sin compromiso.</p>
                <a class="brand-footer-cta" href="{{ route('leads.create') }}">Solicitar estudio <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                <a class="brand-footer-contact-detail" href="tel:{{ preg_replace('/[^0-9+]/', '', config('aislaplus.phone')) }}">{{ config('aislaplus.phone') }}</a>
                <a class="brand-footer-contact-detail" href="mailto:{{ config('aislaplus.email') }}">{{ config('aislaplus.email') }}</a>
            </section>
        </div>
    </div>

    <div class="brand-footer-bottom">
        <span>© {{ date('Y') }} aislagratis™ · Todos los derechos reservados</span>
        <div>
            <a href="{{ route('legal.privacy') }}">Privacidad</a>
            <a href="{{ route('legal.terms') }}">Términos</a>
            <a href="{{ route('legal.cookies') }}">Cookies</a>
        </div>
        <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">Volver arriba <i class="fa-solid fa-arrow-up" aria-hidden="true"></i></button>
    </div>

    <div class="brand-footer-watermark" aria-hidden="true">
        <span><img src="{{ asset('icons/icon-192.png') }}" alt="">ISLAGRATIS™</span>
    </div>
</footer>
