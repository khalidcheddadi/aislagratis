<header class="custom-header">
    <div class="logo">
        <img class="brand-logo-image" src="{{ asset('icons/icon-192.png') }}?v={{ filemtime(public_path('icons/icon-192.png')) }}" alt="" aria-hidden="true" width="40" height="40">
        <div class="logo-text">
            <span class="bold-text">aislagratis</span>
        </div>
    </div>

    <nav>
        <ul class="nav-desktop">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a></li>
            <li><a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">Servicios</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">Sobre nosotros</a></li>
            <li><a href="{{ route('leads.create') }}" class="{{ request()->routeIs('leads.create') ? 'active' : '' }}">Solicitar estudio</a></li>
            @auth
                @php $currentUser = auth()->user(); @endphp
                <li style="list-style:none; position: relative;">
                    <a href="#" id="userDropdownToggle" style="display:flex; align-items:center; gap:6px;">
                        <i class="fa-solid fa-user"></i> {{ $currentUser->first_name }} <i class="fa-solid fa-chevron-down" style="font-size:0.6rem;"></i>
                    </a>
                    <div class="user-dropdown" style="display:none; position:absolute; top:100%; right:0; background:var(--white); border-radius:12px; box-shadow:var(--shadow-md); min-width:180px; padding:8px 0; z-index:200;">
                        <a href="{{ $currentUser->dashboardRoute() }}" style="display:block; padding:10px 18px; font-size:0.8rem; font-weight:600; color:var(--black);">Mi panel</a>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" style="display:block; width:100%; text-align:left; padding:10px 18px; font-size:0.8rem; font-weight:600; color:var(--black); border-top:1px solid var(--border-light); background:none; border-left:none; border-right:none; border-bottom:none; cursor:pointer; font-family:'Montserrat', sans-serif;">Cerrar sesión</button>
                        </form>
                    </div>
                </li>
            @else
                <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                <li><a href="{{ route('register') }}">Registrarse</a></li>
            @endauth
        </ul>
    </nav>

    <div class="contact-info">
        <span class="call-text">Llama ahora</span>
        <a class="phone-number" href="tel:{{ preg_replace('/[^0-9+]/', '', config('aislaplus.phone')) }}">
            {{ config('aislaplus.phone') }}
        </a>
    </div>

    <button class="mobile-toggle" id="mobileToggle" aria-label="Abrir menú" aria-controls="mobileNav" aria-expanded="false">
        <i class="fa-solid fa-bars"></i>
    </button>
</header>

<button class="mobile-nav-backdrop" id="mobileNavBackdrop" type="button" aria-label="Cerrar menú"></button>
<aside class="mobile-nav" id="mobileNav" aria-hidden="true" aria-label="Menú de navegación">
    <div class="mobile-nav-header">
        <a class="mobile-nav-brand" href="{{ route('home') }}">
            <img class="brand-logo-image" src="{{ asset('icons/icon-192.png') }}?v={{ filemtime(public_path('icons/icon-192.png')) }}" alt="" aria-hidden="true" width="34" height="34">
            <span>aislagratis</span>
        </a>
        <button class="mobile-nav-close" id="mobileNavClose" type="button" aria-label="Cerrar menú">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <nav class="mobile-nav-links" aria-label="Navegación principal">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Inicio</a>
        <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}"><i class="fa-solid fa-screwdriver-wrench"></i> Servicios</a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}"><i class="fa-solid fa-circle-info"></i> Sobre nosotros</a>
        <a href="{{ route('leads.create') }}" class="{{ request()->routeIs('leads.create') ? 'active' : '' }}"><i class="fa-solid fa-clipboard-check"></i> Solicitar estudio</a>
    </nav>
    <div class="mobile-nav-account">
        @auth
            <a href="{{ auth()->user()->dashboardRoute() }}"><i class="fa-solid fa-user"></i> Mi panel</a>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar sesión</button>
        </form>
        @else
            <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}"><i class="fa-solid fa-arrow-right-to-bracket"></i> Iniciar sesión</a>
            <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}"><i class="fa-solid fa-user-plus"></i> Registrarse</a>
        @endauth
    </div>
    <a class="mobile-nav-phone" href="tel:{{ preg_replace('/[^0-9+]/', '', config('aislaplus.phone')) }}">
        <span>Llama ahora</span>
        <strong>{{ config('aislaplus.phone') }}</strong>
    </a>
</aside>
