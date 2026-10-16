@extends('layouts.public')

@section('title', 'Aislamiento de áticos y bajo cubierta - aislagratis')
@section('meta_description', 'Aislamiento de áticos y bajo cubierta con lana mineral e insuflado mecánico. Estudio técnico gratuito y orientación sobre el expediente CAE, sujeto a evaluación y disponibilidad.')

@push('styles')
<style>
    .service-cae-panel {
        max-width: 1000px;
        margin: 56px auto 0;
        padding: clamp(24px, 4vw, 40px);
        border: 1px solid rgba(27, 94, 32, 0.12);
        border-radius: 26px;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 14px 40px rgba(27, 94, 32, 0.08);
    }
    .service-cae-panel h3 { margin: 0 0 10px; font-size: 1.35rem; font-weight: 900; }
    .service-cae-panel p { color: var(--gray-600); line-height: 1.8; }
    .service-cae-requirements {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin: 24px 0;
        padding: 0;
        list-style: none;
    }
    .service-cae-requirements li {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px;
        border-radius: 14px;
        background: #f4f8f3;
        color: var(--gray-700);
        line-height: 1.6;
    }
    .service-cae-requirements i { margin-top: 4px; color: var(--green); }
    .service-cae-panel .service-cae-note { margin-bottom: 14px; font-size: 0.88rem; }
    .service-cae-panel > a { color: var(--green-dark); font-weight: 800; }
    @media (max-width: 600px) {
        .service-cae-requirements { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

    <div class="standalone-public-header">
        @include('partials.public-header')
    </div>

    <section class="services-hero-section" id="servicios">
        <div class="container">
            <div class="services-hero-header" data-aos="fade-up">
                <div class="services-sub">Actuaciones<br>en cubierta</div>
                <div class="services-title">Aislamiento<br>y gestión CAE</div>
            </div>

            <div class="services-blob-grid">
                    <div class="service-blob-card" data-aos="fade-up" data-aos-delay="0">
                        <div class="service-blob-image">
                            <picture>
                                <source type="image/webp" srcset="{{ asset('images/image6-320.webp') }} 320w, {{ asset('images/image6-640.webp') }} 640w, {{ asset('images/image6-960.webp') }} 960w" sizes="(max-width: 560px) 92vw, (max-width: 900px) 28vw, 46vw">
                                <img src="{{ asset('images/image6.jpg') }}" alt="Lana mineral insuflada en el suelo de un ático" loading="lazy" decoding="async" width="1600" height="1200">
                            </picture>
                            <div class="service-icon-overlay">
                                <i class="fa-solid fa-house-chimney"></i>
                            </div>
                        </div>
                        <h3>Lana de roca para cubierta</h3>
                        <p class="service-desc">Valoramos el aislamiento térmico y acústico del desván con lana de roca cuando la configuración y el estado de la vivienda lo permiten.</p>
                        <a href="{{ route('leads.create') }}" class="service-link">Solicitar valoración <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="service-blob-card" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-blob-image">
                            <picture>
                                <source type="image/webp" srcset="{{ asset('images/image7-320.webp') }} 320w, {{ asset('images/image7-640.webp') }} 640w, {{ asset('images/image7-960.webp') }} 960w" sizes="(max-width: 560px) 92vw, (max-width: 900px) 28vw, 22vw">
                                <img src="{{ asset('images/image7.jpg') }}" alt="Capa de aislamiento insuflado bajo una cubierta inclinada" loading="lazy" decoding="async" width="1200" height="1600">
                            </picture>
                            <div class="service-icon-overlay">
                                <i class="fa-solid fa-gears"></i>
                            </div>
                        </div>
                        <h3>Insuflado mecánico</h3>
                        <p class="service-desc">Aplicamos aislamiento insuflado en las zonas accesibles del bajo cubierta; el material y el espesor se determinan tras revisar cada espacio.</p>
                        <a href="{{ route('leads.create') }}" class="service-link">Solicitar valoración <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="service-blob-card" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-blob-image">
                            <picture>
                                <source type="image/webp" srcset="{{ asset('images/image3-320.webp') }} 320w, {{ asset('images/image3-640.webp') }} 640w" sizes="(max-width: 560px) 92vw, (max-width: 900px) 28vw, 22vw">
                                <img src="{{ asset('images/image3.jpg') }}" alt="Revisión técnica del aislamiento de una cubierta" loading="lazy" decoding="async" width="900" height="1600">
                            </picture>
                            <div class="service-icon-overlay">
                                <i class="fa-solid fa-file-circle-check"></i>
                            </div>
                        </div>
                        <h3>Estudio y gestión CAE</h3>
                        <p class="service-desc">Revisamos la vivienda y acompañamos la documentación y validación del expediente CAE cuando se cumplen los requisitos y hay disponibilidad.</p>
                        <a href="{{ route('leads.create') }}" class="service-link">Solicitar estudio <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
            </div>

            <div class="service-cae-panel">
                <h3>Requisitos orientativos del programa CAE</h3>
                <p>El sistema CAE, regulado en España por el Real Decreto 36/2023, permite acreditar ahorros energéticos. Antes de valorar una actuación, comprobamos las condiciones de la vivienda y la documentación disponible.</p>
                <ul class="service-cae-requirements">
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i><span>Vivienda unifamiliar con más de cinco años.</span></li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i><span>Acceso al desván o a la zona bajo cubierta.</span></li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i><span>No haber recibido una ayuda similar en los últimos cinco años.</span></li>
                    <li><i class="fa-solid fa-check" aria-hidden="true"></i><span>Condiciones estructurales adecuadas para realizar la actuación.</span></li>
                </ul>
                <p class="service-cae-note">La elegibilidad, la financiación y la disponibilidad de cupos se confirman tras la evaluación técnica y documental. No se garantiza la aprobación ni que el coste quede cubierto en todos los casos.</p>
                <a href="https://www.miteco.gob.es/es/energia/eficiencia/cae.html#accordion-6c9ad09474-item-30e76c36b0" target="_blank" rel="noopener noreferrer">Consultar información oficial del MITECO <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>

    <section class="final-cta-hero" id="contacto">
        <div class="container">
            <div class="final-cta-blob-content" data-aos="zoom-in">
                <h2>¿Listo para mejorar tu hogar?</h2>
                <p>El estudio técnico inicial es gratuito y sin compromiso. Revisaremos si la vivienda y la actuación podrían cumplir las condiciones del programa CAE.</p>
                <a href="{{ route('leads.create') }}" class="cta-button">
                    Empezar ahora <i class="fa-solid fa-arrow-right" style="margin-left:8px;"></i>
                </a>
            </div>
        </div>
    </section>

@endsection
