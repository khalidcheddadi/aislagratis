@extends('layouts.public')

@section('title', 'Sobre nosotros - aislagratis')
@section('meta_description', 'Conoce Aislamiento Rbay y aislagratis: aislamiento de áticos y bajo cubierta con lana mineral, estudio técnico y orientación sobre el programa CAE.')

@push('styles')
<style>
    .story-section { background: var(--white); padding: 100px 0; }
    .story-container { display: flex; align-items: center; gap: 60px; flex-wrap: wrap; }
    .story-image { flex: 1 1 40%; display: flex; justify-content: center; min-width: 280px; }
    .story-image .blob-img {
        width: 380px;
        height: 380px;
        object-fit: cover;
        border-radius: var(--blob-radius);
        box-shadow: var(--shadow-lg);
        max-width: 100%;
    }
    .story-content { flex: 1 1 50%; min-width: 280px; }
    .story-content .subtitle {
        background: var(--green-50);
        color: var(--green-dark);
        border: 1px solid var(--border-light);
        border-radius: 30px;
        padding: 7px 20px;
        display: inline-block;
        margin-bottom: 15px;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 2px;
    }
    .story-content h2 {
        font-size: 2.2rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -0.5px;
        line-height: 1.15;
        margin-bottom: 20px;
    }
    .story-content p { color: var(--gray-600); font-size: 0.9rem; line-height: 1.8; margin-bottom: 30px; }

    .values-section { background: var(--gray-100); padding: 90px 0; }
    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    .value-blob-card {
        background: var(--white);
        border-radius: 25px;
        padding: 35px 25px;
        text-align: center;
        border: 1px solid rgba(var(--green-dark-rgb), 0.1);
        box-shadow: 0 10px 30px rgba(27, 94, 32, 0.08);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .value-blob-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(27, 94, 32, 0.16);
        border-color: rgba(var(--green-dark-rgb), 0.25);
    }
    .value-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--green-light), var(--green-dark));
        color: var(--white);
        border-radius: var(--blob-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 20px;
        box-shadow: 0 10px 25px rgba(var(--green-dark-rgb), 0.25);
        transition: all 0.4s ease;
    }
    .value-blob-card:hover .value-icon {
        border-radius: var(--blob-radius-2);
        transform: scale(1.08);
        box-shadow: 0 15px 35px rgba(27, 94, 32, 0.35);
    }
    .value-blob-card h4 {
        font-size: 1.1rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 10px;
        color: var(--black);
    }
    .value-blob-card p { color: var(--gray-500); font-size: 0.85rem; line-height: 1.7; }

    .stats-section {
        position: relative;
        width: 100%;
        padding: 100px 0;
        overflow: hidden;
        z-index: 1;
    }
    .stats-section::before {
        content: '';
        position: absolute;
        top: -20%;
        left: -15%;
        width: 550px;
        height: 550px;
        background: radial-gradient(circle, rgba(var(--green-light-rgb), 0.1) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
        animation: pulse-glow 7s ease-in-out infinite;
    }
    .stats-section::after {
        content: '';
        position: absolute;
        bottom: -25%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(27, 94, 32, 0.08) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
        animation: pulse-glow 9s ease-in-out infinite reverse;
    }
    .stats-section .container { position: relative; z-index: 2; }
    .stats-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 30px;
        margin-bottom: 60px;
        flex-wrap: wrap;
        text-align: center;
    }
    .stats-header .stats-sub {
        font-weight: 700;
        font-size: 1.1rem;
        line-height: 1.3;
        text-align: right;
        border-right: 3px solid var(--gray-400);
        padding-right: 20px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: var(--gray-600);
    }
    .stats-header .stats-title {
        font-weight: 900;
        font-size: 3.2rem;
        line-height: 0.9;
        letter-spacing: -2px;
        text-transform: uppercase;
        color: var(--black);
        text-align: left;
    }
    .stats-blob-grid {
        display: flex;
        justify-content: center;
        gap: 35px;
        flex-wrap: wrap;
        position: relative;
    }
    .stat-blob-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        padding: 25px 20px;
        min-width: 150px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 25px;
        border: 1px solid rgba(var(--green-dark-rgb), 0.1);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        z-index: 1;
    }
    .stat-blob-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(27, 94, 32, 0.18);
        border-color: rgba(var(--green-dark-rgb), 0.25);
    }
    .stat-blob-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--green-light), var(--green-dark));
        color: var(--white);
        border-radius: var(--blob-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 10px 25px rgba(var(--green-dark-rgb), 0.25);
        transition: all 0.4s ease;
    }
    .stat-blob-item:hover .stat-blob-icon {
        border-radius: var(--blob-radius-2);
        transform: scale(1.08);
        box-shadow: 0 15px 35px rgba(27, 94, 32, 0.35);
    }
    .stat-blob-item .stat-value {
        font-weight: 900;
        font-size: 1.5rem;
        color: var(--black);
        letter-spacing: -0.5px;
        line-height: 1;
    }
    .stat-blob-item .stat-label {
        font-weight: 700;
        font-size: 0.7rem;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: var(--gray-500);
        text-align: center;
        line-height: 1.4;
    }

    .team-section { background: var(--white); padding: 90px 0; }
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    .team-blob-member {
        text-align: center;
        background: var(--white);
        border-radius: 25px;
        padding: 35px 25px;
        border: 1px solid rgba(var(--green-dark-rgb), 0.1);
        box-shadow: 0 10px 30px rgba(27, 94, 32, 0.08);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .team-blob-member:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(27, 94, 32, 0.16);
        border-color: rgba(var(--green-dark-rgb), 0.25);
    }
    .team-avatar {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, var(--green-light), var(--green-dark));
        color: var(--white);
        border-radius: var(--blob-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 15px;
        box-shadow: 0 10px 25px rgba(var(--green-dark-rgb), 0.25);
        transition: all 0.4s ease;
    }
    .team-blob-member:hover .team-avatar {
        border-radius: var(--blob-radius-2);
        transform: scale(1.05);
    }
    .team-blob-member h5 {
        font-weight: 800;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .team-blob-member span { color: var(--gray-500); font-size: 0.8rem; font-weight: 600; }

    .partners-section { background: var(--gray-100); padding: 90px 0; text-align: center; }
    .partners-blob-logos {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 18px;
        margin-top: 40px;
        position: relative;
    }
    .partner-blob-logo {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(27, 94, 32, 0.12);
        border-radius: 20px;
        padding: 18px 30px;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 1px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--black);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        box-shadow: 0 8px 25px rgba(27, 94, 32, 0.08);
        position: relative;
        z-index: 1;
    }
    .partner-blob-logo i { color: var(--green); font-size: 1.3rem; transition: all 0.3s; }
    .partner-blob-logo:hover {
        border-color: var(--green);
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(27, 94, 32, 0.2);
        border-radius: var(--blob-radius);
        background: rgba(255, 255, 255, 0.98);
    }
    .partner-blob-logo:hover i { color: var(--green-dark); transform: scale(1.15); }

    .final-cta-hero {
        position: relative;
        width: 100%;
        padding: 120px 0;
        overflow: hidden;
        z-index: 1;
        text-align: center;
    }
    .final-cta-hero::before {
        content: '';
        position: absolute;
        top: -20%;
        left: 50%;
        transform: translateX(-50%);
        width: 700px;
        height: 700px;
        background: radial-gradient(circle, rgba(var(--green-light-rgb), 0.12) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
        animation: pulse-glow 6s ease-in-out infinite;
    }
    .final-cta-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(var(--green-dark-rgb), 0.1) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
        animation: pulse-glow 8s ease-in-out infinite reverse;
    }
    .final-cta-hero .container { position: relative; z-index: 2; }
    .final-cta-blob-content {
        max-width: 700px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-radius: 40px;
        padding: 50px 40px;
        border: 1px solid rgba(27, 94, 32, 0.12);
        box-shadow: 0 20px 60px rgba(27, 94, 32, 0.15);
        position: relative;
    }
    .final-cta-blob-content::before {
        content: '';
        position: absolute;
        top: -15px;
        right: -15px;
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--green-light), var(--green-dark));
        border-radius: var(--blob-radius);
        opacity: 0.3;
        z-index: -1;
        animation: float 4s ease-in-out infinite;
    }
    .final-cta-blob-content::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: -10px;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--green-light), var(--green-dark));
        border-radius: var(--blob-radius-2);
        opacity: 0.25;
        z-index: -1;
        animation: float 5s ease-in-out infinite reverse;
    }
    .final-cta-hero h2 {
        font-size: 2.6rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -1.5px;
        margin-bottom: 15px;
        color: var(--black);
        line-height: 1.1;
    }
    .final-cta-hero p {
        color: var(--gray-500);
        max-width: 500px;
        margin: 0 auto 30px;
        font-size: 0.9rem;
        line-height: 1.7;
    }
    .final-cta-hero .cta-button {
        font-size: 1rem;
        padding: 18px 45px;
        margin-bottom: 0;
        border-radius: 50px;
        letter-spacing: 2px;
    }

    @media (max-width: 1024px) {
        .story-container { flex-direction: column; text-align: center; }
        .story-content { text-align: center; }
        .stats-header { flex-direction: column; gap: 10px; }
        .stats-header .stats-sub {
            border-right: none;
            border-bottom: 3px solid var(--gray-400);
            padding-right: 0;
            padding-bottom: 10px;
            text-align: center;
        }
        .stats-header .stats-title { font-size: 2.5rem; text-align: center; }
    }
    @media (max-width: 768px) {
        .story-image .blob-img { width: 260px; height: 260px; }
        .stats-header .stats-title { font-size: 2rem; }
        .stats-header .stats-sub { font-size: 0.9rem; }
        .stat-blob-item { min-width: 120px; padding: 20px 15px; }
        .stat-blob-icon { width: 55px; height: 55px; font-size: 1.2rem; }
        .stat-blob-item .stat-value { font-size: 1.3rem; }
        .story-content h2 { font-size: 1.8rem; }
        .final-cta-hero h2 { font-size: 1.8rem; }
        .final-cta-blob-content { padding: 35px 25px; }
        .partner-blob-logo { padding: 14px 22px; font-size: 0.75rem; }
    }
    @media (max-width: 480px) {
        .story-image .blob-img { width: 200px; height: 200px; }
        .stats-header .stats-title { font-size: 1.6rem; }
        .stats-blob-grid { gap: 15px; }
        .stat-blob-item { min-width: 100px; padding: 15px 10px; }
        .final-cta-hero h2 { font-size: 1.5rem; }
    }
</style>
@endpush

@section('content')

    <div class="standalone-public-header">
        @include('partials.public-header')
    </div>

    <section class="story-section" id="historia">
        <div class="container story-container">
            <div class="story-image" data-aos="zoom-in">
                <picture>
                    <source
                        type="image/webp"
                        srcset="{{ asset('images/image6-320.webp') }} 320w, {{ asset('images/image6-640.webp') }} 640w, {{ asset('images/image6-960.webp') }} 960w"
                        sizes="(max-width: 480px) 200px, (max-width: 768px) 260px, 380px">
                    <img src="{{ asset('images/image6.jpg') }}" alt="Aislamiento insuflado aplicado en un ático bajo cubierta" class="blob-img" loading="lazy" decoding="async" width="1600" height="1200">
                </picture>
            </div>
            <div class="story-content" data-aos="fade-left">
                <span class="subtitle">Aislamiento Rbay · aislagratis</span>
                <h2>Especialistas en aislamiento de áticos</h2>
                <p>Nos centramos en viviendas unifamiliares y en el aislamiento del desván o bajo cubierta, una zona importante para reducir las pérdidas de energía. Valoramos la aplicación de lana de roca o aislamiento mineral insuflado mediante maquinaria, según las características del inmueble.</p>
                <p>También orientamos sobre el sistema de Certificados de Ahorro Energético (CAE), regulado en España por el Real Decreto 36/2023: estudio técnico, revisión de requisitos, gestión documental, ejecución de la actuación y validación final cuando corresponda.</p>
                <a href="{{ route('leads.create') }}" class="cta-button" style="margin-bottom:0;">Solicitar estudio gratuito</a>
            </div>
        </div>
    </section>

    
    <section class="values-section" id="valores">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <span class="subtitle">Nuestros valores</span>
                <h2>Lo que nos define</h2>
            </div>
            <div class="values-grid">
                <div class="value-blob-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="value-icon"><i class="fas fa-hand-holding-usd"></i></div>
                    <h4>Transparencia</h4>
                    <p>Explicamos los requisitos y las condiciones económicas antes de iniciar cualquier actuación.</p>
                </div>
                <div class="value-blob-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="value-icon"><i class="fas fa-tools"></i></div>
                    <h4>Solución adecuada</h4>
                    <p>La técnica, el material y el espesor se valoran según el acceso, la cubierta y el estado del espacio.</p>
                </div>
                <div class="value-blob-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="value-icon"><i class="fas fa-leaf"></i></div>
                    <h4>Aislamiento termoacústico</h4>
                    <p>Valoramos lana de roca y aislamiento mineral para contribuir al confort térmico y acústico de la vivienda.</p>
                </div>
                <div class="value-blob-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="value-icon"><i class="fas fa-headset"></i></div>
                    <h4>Atención personalizada</h4>
                    <p>Te acompañamos en el estudio, la documentación y la validación CAE cuando la actuación resulta elegible.</p>
                </div>
            </div>
        </div>
    </section>

    
    <section class="stats-section" id="metricas">
        <div class="container">
            <div class="stats-header" data-aos="fade-up">
                <div class="stats-sub">Cómo<br>trabajamos</div>
                <div class="stats-title">Un proceso<br>acompañado</div>
            </div>

            <div class="stats-blob-grid">
                <div class="stat-blob-item" data-aos="zoom-in" data-aos-delay="0">
                    <div class="stat-blob-icon"><i class="fa-solid fa-house-chimney"></i></div>
                    <div class="stat-value">Estudio</div>
                    <div class="stat-label">Revisión inicial de la vivienda y del acceso al desván</div>
                </div>
                <div class="stat-blob-item" data-aos="zoom-in" data-aos-delay="100">
                    <div class="stat-blob-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                    <div class="stat-value">Elegibilidad</div>
                    <div class="stat-label">Comprobación de condiciones y documentación CAE</div>
                </div>
                <div class="stat-blob-item" data-aos="zoom-in" data-aos-delay="200">
                    <div class="stat-blob-icon"><i class="fa-solid fa-gears"></i></div>
                    <div class="stat-value">Actuación</div>
                    <div class="stat-label">Aislamiento de cubierta según la solución aprobada</div>
                </div>
                <div class="stat-blob-item" data-aos="zoom-in" data-aos-delay="300">
                    <div class="stat-blob-icon"><i class="fa-solid fa-file-circle-check"></i></div>
                    <div class="stat-value">Validación</div>
                    <div class="stat-label">Cierre documental conforme a los requisitos aplicables</div>
                </div>
            </div>
            <p style="max-width: 820px; margin: 35px auto 0; text-align: center; color: var(--gray-600); line-height: 1.8;">El acceso al programa CAE no es automático: depende de la evaluación técnica, los requisitos vigentes y la disponibilidad de certificados. No se puede asegurar de antemano que la actuación sea gratuita o quede financiada al 100%.</p>
            <p style="text-align: center; margin-top: 14px;"><a href="https://www.miteco.gob.es/es/energia/eficiencia/cae.html#accordion-6c9ad09474-item-30e76c36b0" target="_blank" rel="noopener noreferrer" style="color: var(--green-dark); font-weight: 800;">Información oficial sobre el sistema CAE · MITECO</a></p>
        </div>
    </section>

    <section class="final-cta-hero" id="contacto">
        <div class="container">
            <div class="final-cta-blob-content" data-aos="zoom-in">
                <h2>¿Listo para mejorar tu hogar?</h2>
                <p>Solicita un estudio inicial gratuito y sin compromiso. La posible financiación CAE se determina tras revisar la vivienda y la disponibilidad.</p>
                <a href="{{ route('leads.create') }}" class="cta-button">
                    Empezar ahora <i class="fa-solid fa-arrow-right" style="margin-left:8px;"></i>
                </a>
            </div>
        </div>
    </section>

@endsection
