@extends('layouts.public')

@section('title', 'Ciudades con cobertura | aislagratis')
@section('meta_description', 'Descubre las 54 ciudades donde aislagratis ofrece aislamiento térmico y estudio CAE gratuito.')

@push('page-styles')
    <style>
        .coverage-page {
            --coverage-ink: #0A161E;
            --coverage-muted: #94A3B8;
            --coverage-accent: #2DD4BF;
            color: var(--coverage-ink);
            background: #0A161E;
            font-family: "Plus Jakarta Sans", "Montserrat", sans-serif;
        }

        body.brand-experience:not(.brand-home) main > .coverage-hero {
            color: #F8FAFC;
            background:
                radial-gradient(ellipse at 9% 8%, rgba(45, 212, 191, 0.14), transparent 34%),
                radial-gradient(ellipse at 94% 85%, rgba(15, 118, 110, 0.2), transparent 36%),
                #0A161E !important;
        }

        body.brand-experience:not(.brand-home) main > .coverage-directory,
        body.brand-experience:not(.brand-home) main > .coverage-cta {
            background:
                radial-gradient(ellipse at 88% 0%, rgba(45, 212, 191, 0.055), transparent 27%),
                #0A161E !important;
        }

        body.brand-experience:not(.brand-home) main .coverage-directory h2 {
            color: #F8FAFC !important;
        }

        body.brand-experience:not(.brand-home) main .coverage-hero-description,
        body.brand-experience:not(.brand-home) main .coverage-visual-caption p,
        body.brand-experience:not(.brand-home) main .coverage-cta p {
            color: rgba(232, 240, 233, 0.72) !important;
        }

        body.brand-experience:not(.brand-home) main .coverage-directory-intro {
            color: #94A3B8 !important;
        }

        body.brand-experience:not(.brand-home) main .coverage-primary-link {
            color: #0A161E !important;
        }

        body.brand-experience:not(.brand-home) main .coverage-search input {
            border: 0 !important;
            border-radius: 0 !important;
            outline: 0 !important;
            color: #F8FAFC !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        body.brand-experience:not(.brand-home) main .coverage-search input::placeholder {
            color: #94A3B8 !important;
        }

        .coverage-hero {
            position: relative;
            overflow: hidden;
            color: #F8FAFC;
            background:
                radial-gradient(ellipse at 9% 8%, rgba(45, 212, 191, 0.14), transparent 34%),
                radial-gradient(ellipse at 94% 85%, rgba(15, 118, 110, 0.2), transparent 36%),
                #0A161E;
        }

        .coverage-hero::before {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(45, 212, 191, 0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(45, 212, 191, 0.035) 1px, transparent 1px);
            background-size: 64px 64px;
            content: "";
            mask-image: linear-gradient(110deg, #000 0%, transparent 76%);
            pointer-events: none;
        }

        .coverage-hero-inner,
        .coverage-directory-inner,
        .coverage-cta-inner {
            position: relative;
            width: min(1200px, calc(100% - 48px));
            margin-inline: auto;
        }

        .coverage-hero-inner {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(360px, 0.88fr);
            align-items: center;
            gap: clamp(42px, 7vw, 100px);
            padding-block: clamp(62px, 8vw, 108px);
        }

        .coverage-hero-copy { max-width: 610px; }

        .coverage-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 27px;
            color: var(--coverage-accent);
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.17em;
            text-transform: uppercase;
        }

        .coverage-eyebrow-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--coverage-accent);
            box-shadow: 0 0 18px rgba(45, 212, 191, 0.75);
        }

        .coverage-hero h1 {
            max-width: 650px;
            margin: 0;
            color: #F8FAFC;
            font-family: "Plus Jakarta Sans", "Montserrat", sans-serif;
            font-size: clamp(3.1rem, 6.4vw, 6rem);
            font-weight: 600;
            letter-spacing: -0.075em;
            line-height: 0.99;
        }

        .coverage-hero h1 span {
            color: var(--coverage-accent);
            font-weight: 500;
        }

        .coverage-hero-description {
            max-width: 510px;
            margin: 25px 0 0;
            color: rgba(232, 240, 233, 0.72);
            font-size: clamp(0.94rem, 1.35vw, 1.08rem);
            line-height: 1.85;
        }

        .coverage-hero-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px 22px;
            margin-top: 32px;
        }

        .coverage-primary-link {
            display: inline-flex;
            min-height: 52px;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 0 21px;
            border: 1px solid var(--coverage-accent);
            border-radius: 999px;
            color: #0A161E;
            background: var(--coverage-accent);
            font-size: 0.84rem;
            font-weight: 800;
            text-decoration: none;
            transition: transform 180ms ease, box-shadow 180ms ease, background 180ms ease;
        }

        .coverage-primary-link:hover {
            transform: translateY(-2px);
            background: #5EEAD4;
            box-shadow: 0 12px 32px rgba(45, 212, 191, 0.2);
        }

        .coverage-primary-link svg { width: 17px; height: 17px; }

        .coverage-availability {
            color: rgba(232, 240, 233, 0.67);
            font-size: 0.76rem;
        }

        .coverage-availability strong {
            display: block;
            margin-bottom: 3px;
            color: #F8FAFC;
            font-size: 0.81rem;
        }

        .coverage-hero-visual {
            position: relative;
            min-height: 430px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 30px;
            background: #14232E;
            box-shadow: 0 35px 100px rgba(0, 0, 0, 0.36);
            isolation: isolate;
        }

        .coverage-hero-visual::after {
            position: absolute;
            z-index: -1;
            inset: 0;
            background: linear-gradient(180deg, rgba(5, 15, 10, 0.05) 26%, rgba(5, 15, 10, 0.82) 100%);
            content: "";
        }

        .coverage-hero-visual img {
            position: absolute;
            z-index: -2;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 54%;
        }

        .coverage-visual-label {
            position: absolute;
            top: 20px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 13px;
            border: 1px solid rgba(255, 255, 255, 0.24);
            border-radius: 999px;
            color: #F8FAFC;
            background: rgba(10, 22, 30, 0.72);
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            backdrop-filter: blur(14px);
        }

        .coverage-visual-label svg { width: 14px; height: 14px; color: var(--coverage-accent); }

        .coverage-visual-caption {
            position: absolute;
            right: 24px;
            bottom: 24px;
            left: 24px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
        }

        .coverage-visual-caption p {
            max-width: 260px;
            margin: 0;
            color: rgba(248, 250, 252, 0.76);
            font-size: 0.76rem;
            line-height: 1.65;
        }

        .coverage-visual-caption strong {
            display: block;
            margin-bottom: 5px;
            color: white;
            font-size: clamp(1.05rem, 2vw, 1.35rem);
            font-weight: 600;
            letter-spacing: -0.035em;
        }

        .coverage-visual-count {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 11px 14px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 17px;
            color: var(--coverage-accent);
            background: rgba(10, 22, 30, 0.72);
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: -0.07em;
            line-height: 1;
            backdrop-filter: blur(14px);
        }

        .coverage-visual-count span {
            display: inline-block;
            color: rgba(248, 250, 252, 0.72);
            font-size: 0.55rem;
            font-weight: 700;
            letter-spacing: 0.13em;
            text-transform: uppercase;
        }

        .coverage-directory {
            padding-block: clamp(64px, 8vw, 104px) clamp(72px, 9vw, 116px);
            background:
                radial-gradient(ellipse at 88% 0%, rgba(45, 212, 191, 0.055), transparent 27%),
                #0A161E;
        }

        .coverage-directory-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 28px;
            margin-bottom: 32px;
        }

        .coverage-section-kicker {
            display: block;
            margin-bottom: 12px;
            color: var(--coverage-accent);
            font-size: 0.66rem;
            font-weight: 800;
            letter-spacing: 0.17em;
            text-transform: uppercase;
        }

        .coverage-directory h2 {
            margin: 0;
            color: #F8FAFC;
            font-size: clamp(2rem, 4vw, 3.35rem);
            font-weight: 600;
            letter-spacing: -0.065em;
            line-height: 1.08;
        }

        .coverage-directory-intro {
            max-width: 410px;
            margin: 12px 0 0;
            color: var(--coverage-muted);
            font-size: 0.91rem;
            line-height: 1.75;
        }

        .coverage-search {
            display: flex;
            width: min(100%, 360px);
            min-height: 54px;
            flex: 0 0 auto;
            align-items: center;
            gap: 12px;
            padding: 0 17px;
            border: 1px solid rgba(226, 239, 242, 0.12);
            border-radius: 16px;
            background: rgba(20, 35, 46, 0.86);
            box-shadow: 0 8px 26px rgba(0, 0, 0, 0.18);
            transition: border-color 180ms ease, box-shadow 180ms ease;
        }

        .coverage-search:focus-within {
            border-color: var(--coverage-accent);
            box-shadow: 0 0 0 4px rgba(45, 212, 191, 0.12);
        }

        .coverage-search svg { width: 19px; height: 19px; flex: 0 0 auto; color: var(--coverage-accent); }

        .coverage-search input {
            width: 100%;
            min-width: 0;
            padding: 0;
            border: 0;
            outline: 0;
            color: #F8FAFC;
            background: transparent;
            font: 500 0.83rem "Plus Jakarta Sans", "Montserrat", sans-serif;
        }

        .coverage-search input::placeholder { color: #94A3B8; }

        .coverage-directory-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin: 26px 0 14px;
            color: #94A3B8;
            font-size: 0.75rem;
        }

        .coverage-directory-meta strong { color: #F8FAFC; font-weight: 800; }

        .coverage-city-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 11px;
        }

        .coverage-city-card {
            display: flex;
            min-height: 70px;
            align-items: center;
            gap: 13px;
            padding: 12px 14px;
            border: 1px solid rgba(226, 239, 242, 0.09);
            border-radius: 16px;
            background: rgba(20, 35, 46, 0.86);
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.12);
            transition: transform 180ms ease, border-color 180ms ease, box-shadow 180ms ease;
        }

        .coverage-city-card[hidden] { display: none; }

        .coverage-city-card:hover {
            transform: translateY(-3px);
            border-color: rgba(45, 212, 191, 0.42);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.24);
        }

        .coverage-city-marker {
            display: grid;
            width: 36px;
            height: 36px;
            flex: 0 0 auto;
            place-items: center;
            border: 1px solid rgba(45, 212, 191, 0.2);
            border-radius: 12px;
            color: var(--coverage-accent);
            background: rgba(45, 212, 191, 0.09);
        }

        .coverage-city-marker svg { width: 16px; height: 16px; }

        .coverage-city-name {
            color: #F1F5F9;
            font-size: 0.79rem;
            font-weight: 700;
            line-height: 1.45;
        }

        .coverage-empty {
            display: none;
            margin: 18px 0 0;
            padding: 22px;
            border: 1px dashed rgba(226, 239, 242, 0.2);
            border-radius: 16px;
            color: #94A3B8;
            background: rgba(20, 35, 46, 0.65);
            text-align: center;
        }

        .coverage-empty.is-visible { display: block; }

        .coverage-cta {
            padding: 0 24px clamp(64px, 8vw, 100px);
            background: #0A161E;
        }

        .coverage-cta-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            overflow: hidden;
            padding: clamp(28px, 5vw, 54px);
            border: 1px solid rgba(45, 212, 191, 0.16);
            border-radius: 28px;
            color: #f6f8f5;
            background:
                radial-gradient(ellipse at 95% 0%, rgba(45, 212, 191, 0.12), transparent 38%),
                #14232E;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.22);
        }

        .coverage-cta-copy { max-width: 630px; }

        .coverage-cta h2 {
            margin: 0;
            color: #F8FAFC;
            font-size: clamp(1.55rem, 3.3vw, 2.45rem);
            font-weight: 600;
            letter-spacing: -0.055em;
            line-height: 1.14;
        }

        .coverage-cta p {
            margin: 11px 0 0;
            color: rgba(232, 240, 233, 0.68);
            font-size: 0.85rem;
            line-height: 1.7;
        }

        @media (max-width: 900px) {
            .coverage-hero-inner { grid-template-columns: minmax(0, 1fr) minmax(280px, 0.8fr); gap: 34px; }
            .coverage-hero-visual { min-height: 370px; }
            .coverage-city-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }

        @media (max-width: 680px) {
            .coverage-hero-inner,
            .coverage-directory-inner { width: min(100% - 36px, 520px); }
            .coverage-hero-inner { grid-template-columns: 1fr; gap: 35px; padding-block: 48px 56px; }
            .coverage-hero h1 { font-size: clamp(3rem, 14vw, 5rem); }
            .coverage-hero-description { margin-top: 19px; font-size: 0.9rem; }
            .coverage-hero-actions { margin-top: 25px; }
            .coverage-hero-visual { min-height: 360px; border-radius: 23px; }
            .coverage-directory { padding-block: 58px 68px; }
            .coverage-directory-heading { align-items: stretch; flex-direction: column; gap: 21px; margin-bottom: 25px; }
            .coverage-search { width: 100%; }
            .coverage-city-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
            .coverage-city-card { min-height: 64px; gap: 9px; padding: 9px; border-radius: 13px; }
            .coverage-city-marker { width: 31px; height: 31px; border-radius: 10px; }
            .coverage-city-name { font-size: 0.7rem; }
            .coverage-cta { padding-inline: 18px; }
            .coverage-cta-inner { align-items: flex-start; flex-direction: column; gap: 22px; border-radius: 22px; }
        }

        @media (max-width: 380px) {
            .coverage-hero-inner,
            .coverage-directory-inner { width: min(100% - 28px, 520px); }
            .coverage-city-grid { grid-template-columns: 1fr; }
            .coverage-visual-caption { right: 17px; bottom: 17px; left: 17px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .coverage-primary-link,
            .coverage-city-card { transition: none; }
        }
    </style>
@endpush

@section('content')
    <main class="coverage-page">
        <section class="coverage-hero" aria-labelledby="coverage-title">
            <div class="coverage-hero-inner">
                <div class="coverage-hero-copy">
                    <span class="coverage-eyebrow"><span class="coverage-eyebrow-dot" aria-hidden="true"></span> AISLAGRATIS · RED DE COBERTURA</span>
                    <h1 id="coverage-title">Tu ciudad.<br><span>Un hogar mejor.</span></h1>
                    <p class="coverage-hero-description">
                        Llevamos el aislamiento térmico y la gestión del programa CAE a ciudades de toda España.
                        Consulta nuestra red y descubre si podemos ayudarte.
                    </p>
                    <div class="coverage-hero-actions">
                        <a class="coverage-primary-link" href="{{ route('leads.create') }}">
                            Comprueba tu vivienda
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                        <span class="coverage-availability"><strong>Estudio gratuito</strong>Sin compromiso</span>
                    </div>
                </div>

                <figure class="coverage-hero-visual">
                    <img src="{{ asset('images/aislamiento-cubierta-instalado.jpg') }}" alt="Aislamiento térmico instalado bajo la cubierta de una vivienda" fetchpriority="high">
                    <span class="coverage-visual-label">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        PRESENCIA TÉCNICA EN ESPAÑA
                    </span>
                    <figcaption class="coverage-visual-caption">
                        <p><strong>Aislamiento real, cerca de ti.</strong>Soluciones profesionales para mejorar el confort de tu hogar.</p>
                        <span class="coverage-visual-count">{{ $cities->count() }}<span>ciudades</span></span>
                    </figcaption>
                </figure>
            </div>
        </section>

        <section class="coverage-directory" aria-labelledby="coverage-cities-title">
            <div class="coverage-directory-inner">
                <div class="coverage-directory-heading">
                    <div>
                        <span class="coverage-section-kicker">Nuestra red, localidad a localidad</span>
                        <h2 id="coverage-cities-title">Encuentra tu ciudad</h2>
                        <p class="coverage-directory-intro">Estamos ampliando el acceso a hogares mejor aislados. Busca tu localidad en nuestra red.</p>
                    </div>
                    <label class="coverage-search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/></svg>
                        <input id="coverage-city-search" type="search" placeholder="Buscar una ciudad..." autocomplete="off" aria-label="Buscar una ciudad">
                    </label>
                </div>

                <div class="coverage-directory-meta">
                    <span id="coverage-results" aria-live="polite">Mostrando <strong>{{ $cities->count() }}</strong> ciudades</span>
                    <span>España <span aria-hidden="true">·</span> <strong>{{ $cities->count() }} destinos</strong></span>
                </div>

                <ul class="coverage-city-grid" id="coverage-city-list">
                    @foreach ($cities as $city)
                        <li class="coverage-city-card" data-city="{{ $city['name'] }}">
                            <span class="coverage-city-marker" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                            </span>
                            <span class="coverage-city-name">{{ $city['name'] }}</span>
                        </li>
                    @endforeach
                </ul>
                <p class="coverage-empty" id="coverage-empty" role="status">No encontramos esa ciudad en la lista. Consúltanos y comprobaremos la disponibilidad en tu zona.</p>
            </div>
        </section>

        <section class="coverage-cta" aria-labelledby="coverage-cta-title">
            <div class="coverage-cta-inner">
                <div class="coverage-cta-copy">
                    <span class="coverage-section-kicker">El primer paso es sencillo</span>
                    <h2 id="coverage-cta-title">¿No ves tu ciudad? También podemos ayudarte.</h2>
                    <p>Cuéntanos dónde está tu vivienda y nuestro equipo confirmará la disponibilidad, sin compromiso.</p>
                </div>
                <a class="coverage-primary-link" href="{{ route('leads.create') }}">
                    Solicitar estudio gratuito
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        (() => {
            const search = document.getElementById('coverage-city-search');
            const cityCards = [...document.querySelectorAll('#coverage-city-list [data-city]')];
            const resultCount = document.getElementById('coverage-results');
            const emptyState = document.getElementById('coverage-empty');

            if (!search || !resultCount || !emptyState) return;

            const normalize = value => value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLocaleLowerCase('es');

            search.addEventListener('input', () => {
                const query = normalize(search.value.trim());
                let visibleCount = 0;

                cityCards.forEach(card => {
                    const isVisible = normalize(card.dataset.city || '').includes(query);
                    card.hidden = !isVisible;
                    if (isVisible) visibleCount++;
                });

                resultCount.innerHTML = `Mostrando <strong>${visibleCount}</strong> ${visibleCount === 1 ? 'ciudad' : 'ciudades'}`;
                emptyState.classList.toggle('is-visible', visibleCount === 0);
            });
        })();
    </script>
@endpush
