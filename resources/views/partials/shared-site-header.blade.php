<div class="shared-site-header">
    <header class="home-nav-header" id="mainHeader">
        <div class="home-nav-shell">
            <nav class="home-nav-primary" aria-label="Navegación principal">
                <details class="home-nav-dropdown">
                    <summary>
                        Empresa
                        <svg viewBox="0 0 20 20" aria-hidden="true"><path d="m5 7.5 5 5 5-5" /></svg>
                    </summary>
                    <div class="home-nav-mega">
                        <div class="home-nav-column">
                            <span class="home-nav-label">Páginas</span>
                            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a>
                            <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">Servicios</a>
                            <a href="{{ route('coverage') }}" class="{{ request()->routeIs('coverage') ? 'active' : '' }}">Áreas de cobertura</a>
                            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Sobre nosotros</a>
                            <a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">Preguntas frecuentes</a>
                        </div>
                        <div class="home-nav-column">
                            <span class="home-nav-label">Información y cuenta</span>
                            <a href="{{ route('legal.privacy') }}" class="{{ request()->routeIs('legal.privacy') ? 'active' : '' }}">Política de privacidad</a>
                            <a href="{{ route('legal.terms') }}" class="{{ request()->routeIs('legal.terms') ? 'active' : '' }}">Términos y condiciones</a>
                            <a href="{{ route('legal.cookies') }}" class="{{ request()->routeIs('legal.cookies') ? 'active' : '' }}">Política de cookies</a>
                            @auth
                                <a href="{{ auth()->user()->dashboardRoute() }}">Mi panel</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">Cerrar sesión</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Iniciar sesión</a>
                                <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Registrarse</a>
                            @endauth
                        </div>
                        <div class="home-nav-promo">
                            <img src="{{ asset('images/aislamiento-cubierta-instalado-640.webp') }}" alt="Aislamiento térmico instalado bajo la cubierta de una vivienda" loading="lazy" decoding="async">
                            <div class="home-nav-promo-shade"></div>
                            <div class="home-nav-promo-content">
                                <span>Evaluación gratuita · Sin compromiso</span>
                                <strong>¿Tu vivienda puede beneficiarse de los CAE?</strong>
                                <a href="{{ route('leads.create') }}">Solicitar estudio <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </details>
                <a href="{{ route('services.index') }}" class="home-nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">Servicios</a>
                <a href="{{ route('coverage') }}" class="home-nav-link {{ request()->routeIs('coverage') ? 'active' : '' }}">Cobertura</a>
            </nav>

            <a href="{{ route('home') }}" class="home-nav-brand" aria-label="aislagratis, inicio">
                <img class="home-nav-brand-icon" src="{{ asset('icons/icon-192.png') }}?v={{ filemtime(public_path('icons/icon-192.png')) }}" alt="" aria-hidden="true" width="28" height="28">
                islagratis<span>™</span>
            </a>

            <div class="home-nav-actions">
                <a href="{{ route('about') }}" class="home-nav-secondary {{ request()->routeIs('about') ? 'active' : '' }}">Sobre nosotros</a>
                <a href="{{ route('leads.create') }}" class="home-nav-cta">Solicitar estudio</a>
                <button id="mobileMenuBtn" class="home-nav-toggle" type="button" aria-label="Abrir menú" aria-expanded="false" aria-controls="mobileMenu">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16" /></svg>
                </button>
            </div>
        </div>

        <nav id="mobileMenu" class="home-mobile-menu hidden" aria-label="Navegación móvil">
            <div class="home-mobile-column">
                <span class="home-nav-label">Explorar</span>
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a>
                <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">Servicios</a>
                <a href="{{ route('coverage') }}" class="{{ request()->routeIs('coverage') ? 'active' : '' }}">Áreas de cobertura</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Sobre nosotros</a>
                <a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">Preguntas frecuentes</a>
                <a href="{{ route('leads.create') }}" class="home-mobile-cta">Solicitar estudio</a>
            </div>
            <div class="home-mobile-column">
                <span class="home-nav-label">Información legal</span>
                <a href="{{ route('legal.privacy') }}" class="{{ request()->routeIs('legal.privacy') ? 'active' : '' }}">Política de privacidad</a>
                <a href="{{ route('legal.terms') }}" class="{{ request()->routeIs('legal.terms') ? 'active' : '' }}">Términos y condiciones</a>
                <a href="{{ route('legal.cookies') }}" class="{{ request()->routeIs('legal.cookies') ? 'active' : '' }}">Política de cookies</a>
            </div>
            <div class="home-mobile-column">
                <span class="home-nav-label">Cuenta</span>
                @auth
                    <a href="{{ auth()->user()->dashboardRoute() }}">Mi panel</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Registrarse</a>
                @endauth
            </div>
            <div class="home-nav-promo home-mobile-promo">
                <img src="{{ asset('images/aislamiento-cubierta-instalado-640.webp') }}" alt="Aislamiento térmico instalado bajo la cubierta de una vivienda" loading="lazy" decoding="async">
                <div class="home-nav-promo-shade"></div>
                <div class="home-nav-promo-content">
                    <span>Evaluación gratuita · Sin compromiso</span>
                    <strong>¿Tu vivienda puede beneficiarse de los CAE?</strong>
                    <a href="{{ route('leads.create') }}">Solicitar estudio <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </nav>
    </header>
</div>
