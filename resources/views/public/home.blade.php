@extends('layouts.public')

@section('title', 'Aislamiento de áticos con lana mineral - aislagratis')
@section('meta_description', 'Aislamiento insuflado de áticos y bajo cubierta con lana mineral. Estudio técnico gratuito y orientación sobre elegibilidad para el programa CAE, sujeto a evaluación y disponibilidad.')

@push('styles')
<style>
    .faq-hero-section {
        padding: 80px 0;
        background: #f8faf8;
        position: relative;
        overflow: hidden;
    }

    .faq-hero-section::before {
        content: '';
        position: absolute;
        top: -150px;
        right: -150px;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(27,94,32,0.06) 0%, transparent 70%);
        pointer-events: none;
    }

    .faq-hero-section::after {
        content: '';
        position: absolute;
        bottom: -100px;
        left: -100px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(27,94,32,0.04) 0%, transparent 70%);
        pointer-events: none;
    }

    .faq-hero-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
        display: flex;
        gap: 60px;
        align-items: flex-start;
        position: relative;
        z-index: 1;
    }

    .faq-hero-left { flex: 0 0 320px; position: sticky; top: 120px; }

    .faq-hero-sub {
        font-size: 1rem;
        font-weight: 600;
        color: #1B5E20;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 8px;
        display: block;
    }

    .faq-hero-title {
        font-size: 2.8rem;
        font-weight: 900;
        color: #1a1a1a;
        line-height: 1.1;
        margin-bottom: 20px;
    }

    .faq-hero-title span { color: #1B5E20; }

    .faq-hero-description {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .faq-hero-contact-card {
        background: #fff;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        border: 1px solid #e8eee8;
    }

    .faq-hero-contact-card h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .faq-hero-contact-card p {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 15px;
    }

    .faq-hero-contact-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        background: #1B5E20;
        color: #fff;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .faq-hero-contact-btn:hover {
        background: #2e7d32;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(27,94,32,0.3);
        color: #fff;
    }

    .faq-hero-right { flex: 1; min-width: 0; }

    .faq-hero-list { display: flex; flex-direction: column; gap: 14px; }

    .faq-hero-item {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        border: 1.5px solid #e8eee8;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    .faq-hero-item:hover { border-color: #c8dcc8; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }

    .faq-hero-item.active {
        border-color: #1B5E20;
        box-shadow: 0 8px 30px rgba(27,94,32,0.12);
    }

    .faq-hero-question {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        background: none;
        border: none;
        cursor: pointer;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: #1a1a1a;
        text-align: left;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .faq-hero-question:hover { color: #1B5E20; }

    .faq-hero-question .faq-number {
        flex-shrink: 0;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #f0f5f0;
        color: #1B5E20;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 800;
        transition: all 0.3s ease;
    }

    .faq-hero-item.active .faq-hero-question .faq-number { background: #1B5E20; color: #fff; }

    .faq-hero-question .faq-text { flex: 1; }

    .faq-hero-question .faq-icon {
        flex-shrink: 0;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        color: #999;
    }

    .faq-hero-item.active .faq-hero-question .faq-icon {
        background: #1B5E20;
        color: #fff;
        transform: rotate(180deg);
    }

    .faq-hero-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), padding 0.3s ease;
        padding: 0 24px;
    }

    .faq-hero-answer-inner {
        padding-bottom: 20px;
        font-size: 0.9rem;
        color: #666;
        line-height: 1.8;
        border-top: 1px solid #f0f0f0;
        padding-top: 15px;
    }

    .faq-hero-item.active .faq-hero-answer { max-height: 500px; }

    .cae-feature-section {
        padding: 76px 20px;
        background:
            radial-gradient(ellipse at 8% 12%, rgba(244, 162, 34, 0.15), transparent 34%),
            linear-gradient(135deg, #f4f8f3 0%, #fff 52%, #edf5ed 100%);
    }

    .cae-feature-link {
        display: block;
        max-width: 1200px;
        margin: 0 auto;
        color: inherit;
        text-decoration: none;
        border-radius: 30px;
        outline-offset: 6px;
    }

    .cae-feature-card {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: clamp(28px, 5vw, 58px);
        border: 1px solid rgba(255, 255, 255, 0.55);
        border-radius: 30px;
        color: #fff;
        background:
            radial-gradient(circle at 88% 8%, rgba(244, 162, 34, 0.28), transparent 25%),
            linear-gradient(125deg, #142b1c 0%, #1b5e20 58%, #287538 100%);
        box-shadow: 0 24px 70px rgba(20, 55, 29, 0.2);
        transition: transform 250ms ease, box-shadow 250ms ease;
    }

    .cae-feature-card::before,
    .cae-feature-card::after {
        position: absolute;
        z-index: -1;
        content: "";
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        pointer-events: none;
    }

    .cae-feature-card::before {
        top: -150px;
        right: -85px;
        width: 390px;
        height: 390px;
    }

    .cae-feature-card::after {
        top: -105px;
        right: -40px;
        width: 300px;
        height: 300px;
    }

    .cae-feature-link:hover .cae-feature-card {
        transform: translateY(-5px);
        box-shadow: 0 32px 82px rgba(20, 55, 29, 0.28);
    }

    .cae-feature-link:focus-visible {
        outline: 3px solid #f4a222;
    }

    .cae-feature-topline {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 28px;
    }

    .cae-feature-badge,
    .cae-feature-official {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .cae-feature-badge {
        padding: 10px 15px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 999px;
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
    }

    .cae-feature-badge i { color: #ffc45d; }
    .cae-feature-official { color: rgba(255, 255, 255, 0.78); }

    .cae-feature-heading {
        max-width: 840px;
        margin: 0 0 18px;
        color: #fff;
        font-size: clamp(2rem, 4.8vw, 3.6rem);
        font-weight: 900;
        line-height: 1.08;
        letter-spacing: -0.04em;
    }

    .cae-feature-heading span { color: #ffc45d; }

    .cae-feature-intro {
        max-width: 820px;
        margin: 0 0 32px;
        color: rgba(255, 255, 255, 0.82);
        font-size: clamp(0.98rem, 1.5vw, 1.12rem);
        line-height: 1.8;
    }

    .cae-feature-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 28px;
    }

    .cae-feature-point {
        min-height: 126px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(8px);
    }

    .cae-feature-point i {
        display: inline-grid;
        width: 38px;
        height: 38px;
        margin-bottom: 12px;
        place-items: center;
        border-radius: 12px;
        color: #18351e;
        background: #ffc45d;
    }

    .cae-feature-point h3 {
        margin: 0 0 6px;
        color: #fff;
        font-size: 1rem;
        font-weight: 800;
    }

    .cae-feature-point p {
        margin: 0;
        color: rgba(255, 255, 255, 0.76);
        font-size: 0.88rem;
        line-height: 1.65;
    }

    .cae-feature-bottom {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        padding-top: 22px;
        border-top: 1px solid rgba(255, 255, 255, 0.18);
    }

    .cae-feature-note {
        max-width: 700px;
        margin: 0;
        color: rgba(255, 255, 255, 0.72);
        font-size: 0.8rem;
        line-height: 1.65;
    }

    .cae-feature-cta {
        display: inline-flex;
        flex: 0 0 auto;
        align-items: center;
        gap: 11px;
        padding: 14px 19px;
        border-radius: 999px;
        color: #18351e;
        background: #ffc45d;
        font-size: 0.9rem;
        font-weight: 900;
        transition: background 200ms ease, gap 200ms ease;
    }

    .cae-feature-link:hover .cae-feature-cta {
        gap: 16px;
        background: #ffd27f;
    }

    @media (max-width: 992px) {
        .faq-hero-container { flex-direction: column; gap: 40px; }
        .faq-hero-left { flex: 1; position: static; }
        .faq-hero-title { font-size: 2.2rem; }
        .cae-feature-grid { grid-template-columns: 1fr; }
        .cae-feature-point { min-height: 0; }
    }

    @media (max-width: 600px) {
        .faq-hero-section { padding: 50px 0; }
        .faq-hero-title { font-size: 1.8rem; }
        .faq-hero-question { padding: 16px 18px; font-size: 0.85rem; }
        .faq-hero-answer { padding: 0 18px; }
        .cae-feature-section { padding: 48px 15px; }
        .cae-feature-card { border-radius: 22px; }
        .cae-feature-topline { align-items: flex-start; flex-direction: column; }
        .cae-feature-bottom { align-items: stretch; flex-direction: column; }
        .cae-feature-cta { justify-content: center; }
    }
</style>
@endpush

@section('content')

    <div class="hero-container" id="home-hero" style="--hero-image: url('{{ asset('images/image12-960.webp') }}');">
        @include('partials.public-header')
        <span class="hero-smoke-effect" aria-hidden="true"></span>

        <main class="hero-main">
            <div class="left-content">
                <div class="typography-group">
                    <span class="sub-title">Aislamiento térmico · Viviendas unifamiliares</span>
                    <h1 class="main-title">Confort<br>desde tu<br>ático.</h1>
                </div>
                <p class="hero-description">
                    Aislamiento insuflado con lana mineral para áticos y bajo cubierta,
                    valorado vivienda por vivienda.
                </p>
                <a href="{{ route('leads.create') }}" class="cta-button">
                    Solicitar estudio técnico
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
                <div class="bottom-promo">
                    <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                    <p>Estudio inicial gratuito<br>Actuación sujeta a evaluación técnica</p>
                </div>
            </div>

            <div class="right-content">
                <div class="image-wrapper">
                    <picture>
                        <source
                            type="image/webp"
                            srcset="{{ asset('images/image12-320.webp') }} 320w, {{ asset('images/image12-640.webp') }} 640w, {{ asset('images/image12-960.webp') }} 960w"
                            sizes="(max-width: 480px) 84vw, (max-width: 768px) 76vw, (max-width: 1100px) 42vw, 38vw">
                        <img src="{{ asset('images/image12.jpg') }}" alt="Aislamiento de lana mineral insuflado en el suelo de un ático" class="main-image" width="1200" height="1600" fetchpriority="high" decoding="async">
                    </picture>
                </div>
            </div>

            <aside class="hero-services" aria-label="Servicios de aislamiento">
                <span class="hero-services-label">Nuestras actuaciones</span>
                <a href="{{ route('services.index') }}" class="hero-service-card hero-service-card-featured">
                    <span class="hero-service-arrow" aria-hidden="true"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                    <strong>Aislamiento con lana mineral</strong>
                    <small>Para áticos y bajo cubierta</small>
                </a>
                <a href="{{ route('services.index') }}" class="hero-service-card">
                    <span class="hero-service-arrow" aria-hidden="true"><i class="fa-solid fa-arrow-up-right-from-square"></i></span>
                    <strong>Insuflado mecánico</strong>
                    <small>Solución definida tras el estudio</small>
                </a>
                <p class="hero-service-note">
                    La posible tramitación CAE depende de los requisitos y de la validación del expediente.
                </p>
            </aside>
        </main>

        <div class="hero-bottom">
            <span><i class="fa-solid fa-house-circle-check" aria-hidden="true"></i> Atención personalizada para tu vivienda</span>
            <a href="{{ route('services.index') }}">Conoce nuestros servicios <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>

    @include('partials.ticker-bar')

    <main class="home-content" aria-label="Información sobre nuestros servicios">
        <section class="cae-feature-section home-cae-section" aria-labelledby="home-cae-title">
            <div class="home-section-shell">
                <div class="home-cae-layout">
                    <div class="home-cae-copy" data-aos="fade-up">
                        <div class="home-eyebrow"><span></span> Programa de Certificados de Ahorro Energético</div>
                        <h2 id="home-cae-title">Una casa más confortable.<br><span>Menos energía que se pierde.</span></h2>
                        <p>El sistema de Certificados de Ahorro Energético (CAE) impulsa actuaciones que reducen el consumo de energía y está regulado en España por el Real Decreto 36/2023. En aislagratis te acompañamos desde el estudio inicial hasta la instalación de aislamiento en áticos y bajo cubierta, siempre sujeta a la evaluación técnica de cada vivienda.</p>
                        <a class="home-text-link" href="https://www.miteco.gob.es/es/energia/eficiencia/cae.html#accordion-6c9ad09474-item-30e76c36b0" target="_blank" rel="noopener noreferrer">
                            Información oficial en MITECO <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="home-cae-process" data-aos="fade-left" data-aos-delay="100">
                        <div class="home-process-heading">
                            <span>01 — 03</span>
                            <strong>Un proceso claro, paso a paso</strong>
                        </div>
                        <article class="home-process-step">
                            <span>01</span><i class="fa-solid fa-magnifying-glass-chart" aria-hidden="true"></i>
                            <div><h3>Estudio técnico</h3><p>Revisamos las características de tu vivienda y las mejoras que podrían ser adecuadas.</p></div>
                        </article>
                        <article class="home-process-step">
                            <span>02</span><i class="fa-solid fa-house-circle-check" aria-hidden="true"></i>
                            <div><h3>Aislamiento de cubierta</h3><p>Estudiamos el acceso, la cubierta y la solución de aislamiento adecuada para cada ático.</p></div>
                        </article>
                        <article class="home-process-step">
                            <span>03</span><i class="fa-solid fa-file-circle-check" aria-hidden="true"></i>
                            <div><h3>Gestión acompañada</h3><p>Te orientamos con la documentación y los pasos de validación del expediente CAE.</p></div>
                        </article>
                        <p class="home-disclaimer">La elegibilidad, la financiación aplicable y la disponibilidad dependen de la evaluación técnica, los requisitos vigentes y los fondos o cupos disponibles. Consulta las condiciones oficiales en MITECO.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="services-hero-section home-services-section" id="servicios" aria-labelledby="home-services-title">
            <div class="home-section-shell">
                <div class="home-section-heading" data-aos="fade-up">
                    <div><span class="home-eyebrow"><span></span> Lo que hacemos</span><h2 id="home-services-title">Soluciones para<br>vivir mejor.</h2></div>
                    <p>Una intervención adecuada empieza por entender cada cubierta. Valoramos el espacio y definimos contigo los siguientes pasos.</p>
                </div>

                @php
                    $serviceCards = [
                        [
                            'name' => 'Lana mineral en cubierta',
                            'description' => 'Aislamiento térmico y acústico del desván con lana mineral, incluida lana de roca cuando el estudio técnico la determine.',
                            'icon_class' => 'fa-house-chimney',
                            'image' => 6,
                        ],
                        [
                            'name' => 'Insuflado mecánico',
                            'description' => 'Aplicación mecánica del aislante en zonas accesibles del bajo cubierta, con material y espesor definidos para cada inmueble.',
                            'icon_class' => 'fa-gears',
                            'image' => 7,
                        ],
                        [
                            'name' => 'Gestión del expediente CAE',
                            'description' => 'Acompañamiento técnico y documental durante la evaluación, ejecución y validación, si la actuación cumple los requisitos.',
                            'icon_class' => 'fa-file-circle-check',
                            'image' => 3,
                        ],
                    ];
                @endphp
                <div class="services-blob-grid home-services-grid">
                    @foreach($serviceCards as $index => $service)
                        <article class="service-blob-card home-service-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <div class="service-blob-image home-service-image">
                                <picture>
                                    <source
                                        type="image/webp"
                                        srcset="{{ asset('images/image'.$service['image'].'-320.webp') }} 320w, {{ asset('images/image'.$service['image'].'-640.webp') }} 640w"
                                        sizes="(max-width: 560px) 88vw, (max-width: 900px) 45vw, 33vw">
                                    <img src="{{ asset('images/image'.$service['image'].'.jpg') }}" alt="{{ $service['name'] }}: {{ $service['description'] }}" loading="lazy" decoding="async" width="640" height="420">
                                </picture>
                                <span class="home-service-number">0{{ $index + 1 }}</span>
                                <span class="service-icon-overlay"><i class="fa-solid {{ $service['icon_class'] }}" aria-hidden="true"></i></span>
                            </div>
                            <div class="home-service-copy">
                                <h3>{{ $service['name'] }}</h3>
                                <p class="service-desc">{{ $service['description'] }}</p>
                                <a href="{{ route('leads.create') }}" class="service-link">Solicitar valoración <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="about-section home-about-section" id="nosotros" aria-labelledby="home-about-title">
            <div class="home-section-shell home-about-layout">
                <div class="about-image home-about-image" data-aos="fade-right">
                    <picture>
                        <source type="image/webp" srcset="{{ asset('images/image11-320.webp') }} 320w, {{ asset('images/image11-640.webp') }} 640w" sizes="(max-width: 760px) 88vw, 48vw">
                        <img src="{{ asset('images/image11.jpg') }}" alt="Aislamiento insuflado instalado bajo la cubierta de un ático" class="blob-img" loading="lazy" decoding="async" width="900" height="1600">
                    </picture>
                    <div class="home-image-caption"><i class="fa-solid fa-house-circle-check" aria-hidden="true"></i><span>Una solución pensada<br>para cada vivienda</span></div>
                </div>
                <div class="about-content home-about-copy" data-aos="fade-left">
                    <span class="home-eyebrow"><span></span> Aislamiento Rbay · aislagratis</span>
                    <h2 id="home-about-title">Especialistas en áticos. Cercanos en cada paso.</h2>
                    <p>En Aislamiento Rbay, a través de aislagratis, nos centramos en el aislamiento de áticos y bajo cubiertas de viviendas unifamiliares. Estudiamos cada espacio para valorar la aplicación de lana mineral o lana de roca mediante insuflado mecánico y te orientamos sobre el expediente de Certificados de Ahorro Energético (CAE).</p>
                    <div class="stats-grid home-about-facts">
                        <div class="stat-item"><span>01</span><h3>Estudio</h3><p>Revisión técnica de la vivienda</p></div>
                        <div class="stat-item"><span>02</span><h3>Cubierta</h3><p>Atención al desván y bajo cubierta</p></div>
                        <div class="stat-item"><span>03</span><h3>CAE</h3><p>Gestión sujeta a elegibilidad</p></div>
                    </div>
                    <a href="{{ route('leads.create') }}" class="home-text-link">Cuéntanos tu caso <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </section>

        <section class="metrics-hero-section home-requirements-section" id="metricas" aria-labelledby="home-requirements-title">
            <div class="home-section-shell">
                <div class="home-section-heading home-requirements-heading" data-aos="fade-up">
                    <div><span class="home-eyebrow"><span></span> Antes de empezar</span><h2 id="home-requirements-title">¿Puede encajar<br>tu vivienda?</h2></div>
                    <p>Estos criterios son orientativos. La comprobación final siempre es técnica y documental.</p>
                </div>
                <div class="metrics-blob-grid home-requirements-grid">
                    <article class="metric-blob-item home-requirement">
                        <span class="home-requirement-index">01</span><div class="metric-blob-icon"><i class="fa-solid fa-house" aria-hidden="true"></i></div>
                        <div class="metric-value">Vivienda</div><div class="metric-label">Unifamiliar y con más de 5 años</div>
                    </article>
                    <article class="metric-blob-item home-requirement">
                        <span class="home-requirement-index">02</span><div class="metric-blob-icon"><i class="fa-solid fa-stairs" aria-hidden="true"></i></div>
                        <div class="metric-value">Acceso</div><div class="metric-label">A desván o bajo cubierta</div>
                    </article>
                    <article class="metric-blob-item home-requirement">
                        <span class="home-requirement-index">03</span><div class="metric-blob-icon"><i class="fa-solid fa-file-circle-check" aria-hidden="true"></i></div>
                        <div class="metric-value">Ayudas</div><div class="metric-label">No haber recibido una similar en los últimos 5 años</div>
                    </article>
                    <article class="metric-blob-item home-requirement">
                        <span class="home-requirement-index">04</span><div class="metric-blob-icon"><i class="fa-solid fa-helmet-safety" aria-hidden="true"></i></div>
                        <div class="metric-value">Estado</div><div class="metric-label">Condiciones estructurales adecuadas</div>
                    </article>
                </div>
                <p class="coverage-note-hero home-requirements-note">La elegibilidad y la financiación se confirman tras revisar la vivienda, la documentación y la disponibilidad de CAE.</p>
            </div>
        </section>

        <section class="coverage-hero-section home-coverage-section" id="cobertura" aria-labelledby="home-coverage-title">
            <div class="home-section-shell home-coverage-layout">
                <div class="home-coverage-heading" data-aos="fade-right">
                    <span class="home-eyebrow"><span></span> Cobertura</span>
                    <h2 id="home-coverage-title">Cerca de ti,<br>desde el primer estudio.</h2>
                    <p>Consulta las zonas donde trabajamos. Si no encuentras tu provincia, pregúntanos.</p>
                    <a href="{{ route('leads.create') }}" class="home-text-link">Consultar mi zona <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                </div>
                <div class="area-blob-tags home-coverage-tags" data-aos="fade-left">
                    @foreach($areas as $area)
                        <span class="area-blob-tag"><i class="fa-solid fa-location-dot" aria-hidden="true"></i><span>{{ $area->city }} <small>{{ $area->province }}</small></span></span>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="faq-hero-section home-faq-section" id="faq" aria-labelledby="home-faq-title">
            <div class="home-section-shell faq-hero-container">
                <div class="faq-hero-left home-faq-intro" data-aos="fade-right">
                    <span class="home-eyebrow"><span></span> Resolvemos tus dudas</span>
                    <h2 class="faq-hero-title" id="home-faq-title">Preguntas<br><span>frecuentes.</span></h2>
                    <p class="faq-hero-description">Resolvemos tus dudas sobre el aislamiento del desván y la posible tramitación de Certificados de Ahorro Energético (CAE).</p>
                    <div class="faq-hero-contact-card home-faq-contact">
                        <span class="home-contact-mark"><i class="fa-solid fa-comments" aria-hidden="true"></i></span>
                        <h3>¿Tienes más preguntas?</h3>
                        <p>Nuestro equipo está disponible para ayudarte sin compromiso.</p>
                        <a href="{{ route('leads.create') }}" class="faq-hero-contact-btn">Hablemos <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                </div>

                <div class="faq-hero-right home-faq-list-column" data-aos="fade-left" data-aos-delay="100">
                    <div class="faq-hero-list">
                        @php
                            $homeFaqs = [
                                ['question' => '¿Qué tipo de aislamiento realizáis?', 'answer' => 'Nos centramos en áticos y bajo cubiertas de viviendas unifamiliares. Según el estudio, se puede valorar lana de roca u otro aislamiento mineral aplicado mediante insuflado mecánico.'],
                                ['question' => '¿Qué es el programa CAE?', 'answer' => 'Los Certificados de Ahorro Energético permiten acreditar ahorros de energía derivados de actuaciones de eficiencia energética. El sistema está regulado en España por el Real Decreto 36/2023; consulta la información oficial del MITECO para conocer su funcionamiento.'],
                                ['question' => '¿La obra es siempre gratuita?', 'answer' => 'No se puede garantizar de antemano. La financiación depende del ahorro validado, de que el inmueble y la actuación cumplan los requisitos vigentes y de la disponibilidad de CAE. Las condiciones se explican antes de iniciar una actuación.'],
                                ['question' => '¿Qué condiciones se revisan?', 'answer' => 'Como orientación: vivienda unifamiliar de más de cinco años, acceso al desván o cubierta, no haber recibido una ayuda similar en los últimos cinco años y condiciones estructurales adecuadas. La comprobación final es técnica y documental.'],
                                ['question' => '¿Cuesta solicitar el estudio inicial?', 'answer' => 'El estudio técnico inicial es gratuito y sin compromiso. Sirve para revisar la vivienda y explicar los siguientes pasos, pero no supone una aprobación automática del expediente ni de la financiación.'],
                            ];
                        @endphp
                        @foreach($homeFaqs as $index => $faq)
                            <article class="faq-hero-item">
                                <button class="faq-hero-question" type="button" aria-expanded="false">
                                    <span class="faq-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="faq-text">{{ $faq['question'] }}</span>
                                    <span class="faq-icon"><i class="fa-solid fa-plus" aria-hidden="true"></i></span>
                                </button>
                                <div class="faq-hero-answer"><div class="faq-hero-answer-inner">{!! nl2br(e($faq['answer'])) !!}</div></div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="final-cta-hero home-contact-section" id="contacto">
            <div class="home-section-shell">
                <div class="final-cta-blob-content home-contact-panel" data-aos="fade-up">
                    <div class="home-contact-copy">
                        <span class="home-eyebrow"><span></span> El primer paso es sencillo</span>
                        <h2>Empecemos por<br>escuchar tu casa.</h2>
                        <p>Solicita un estudio técnico gratuito para valorar el aislamiento de tu ático y comprobar si puede encajar en el programa CAE. La elegibilidad y la financiación dependen de la evaluación y la disponibilidad.</p>
                    </div>
                    <a href="{{ route('leads.create') }}" class="cta-button">Solicitar mi estudio <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </section>
    </main>

@endsection
