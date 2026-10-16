@extends('layouts.public')

@section('title', $service->name . ' - aislagratis')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($service->description), 160))

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Poppins', sans-serif; background: var(--white); }

    .service-detail-header {
        position: relative;
        z-index: 1000;
        padding: 20px 25px;
    }

    .custom-nav-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--white);
        padding: 15px 30px;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        flex-wrap: wrap;
        gap: 10px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .custom-logo { display: flex; align-items: center; font-weight: 700; font-size: 20px; text-decoration: none; color: #222; }
    .custom-logo .logo-icon {
        width: 30px;
        height: 30px;
        object-fit: contain;
        border-radius: 8px;
        margin-right: 10px;
    }

    .custom-nav { display: flex; gap: 15px; flex-wrap: wrap; align-items: center; font-family: 'Poppins', sans-serif; }
    .custom-nav a {
        text-decoration: none;
        color: #666;
        font-size: 14px;
        font-weight: 500;
        transition: color 0.3s;
    }
    .custom-nav a:hover, .custom-nav a.active { color: #294738; }

    .btn-solicitar {
        display: inline-block;
        padding: 12px 24px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        cursor: pointer;
        border: 1px solid #294738;
        color: #294738;
        background: transparent;
        white-space: nowrap;
        font-family: 'Poppins', sans-serif;
    }
    .btn-solicitar:hover { background: #294738; color: var(--white); }

    .service-hero {
        background: linear-gradient(135deg, #294738 0%, #1e3328 100%);
        color: var(--white);
        padding: 80px 0;
        position: relative;
        overflow: hidden;
        font-family: 'Poppins', sans-serif;
    }
    .service-hero::after {
        content: '';
        position: absolute;
        top: -150px;
        right: -150px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(244,162,34,0.15) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .service-hero .container { position: relative; z-index: 1; }
    .breadcrumb { background: transparent; padding: 0; margin-bottom: 20px; font-size: 14px; display: flex; gap: 8px; list-style: none; }
    .breadcrumb a { color: rgba(255,255,255,0.7); text-decoration: none; }
    .breadcrumb a:hover { color: var(--accent); }
    .breadcrumb .active { color: var(--white); }
    .service-hero h1 { font-size: 48px; font-weight: 700; margin-bottom: 20px; font-family: 'Poppins', sans-serif; }
    .service-hero .lead { font-size: 18px; color: rgba(255,255,255,0.8); max-width: 700px; margin-bottom: 30px; font-family: 'Poppins', sans-serif; }
    .service-hero .badge-cae {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.3);
        color: var(--white);
        padding: 8px 16px;
        border-radius: 30px;
        display: inline-block;
        margin-bottom: 20px;
        font-size: 14px;
        font-family: 'Poppins', sans-serif;
    }
    .service-hero .badge-cae i { color: var(--accent); margin-right: 5px; }

    .btn-accent {
        background: var(--accent);
        color: #222;
        padding: 12px 28px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 500;
        display: inline-block;
        transition: 0.3s;
        font-family: 'Poppins', sans-serif;
    }
    .btn-accent:hover { background: #e0910d; color: #222; }

    .service-card-detail {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        padding: 30px;
        margin-top: -50px;
        position: relative;
        z-index: 2;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }
    .service-card-detail .info-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        font-size: 16px;
        font-family: 'Poppins', sans-serif;
    }
    .service-card-detail .info-item i {
        width: 40px;
        height: 40px;
        background: #f0f7f2;
        color: #294738;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }
    .service-card-detail .price-tag { font-size: 24px; font-weight: 700; color: var(--accent); }
    .service-card-detail .price-note { font-size: 14px; color: #666; margin-top: 5px; }

    .features-section { padding: 60px 0; font-family: 'Poppins', sans-serif; }
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }
    .feature-item {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 25px;
        transition: all 0.3s;
    }
    .feature-item:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .feature-item i { font-size: 32px; color: var(--accent); margin-bottom: 15px; }
    .feature-item h4 { font-size: 18px; margin-bottom: 10px; font-family: 'Poppins', sans-serif; }
    .feature-item p { color: #666; font-size: 14px; }

    .final-cta { background: white; padding: 80px 0; text-align: center; font-family: 'Poppins', sans-serif; }
    .final-cta h2 { font-size: 36px; margin-bottom: 15px; color: black; }
    .final-cta p { color: #7b7b7b; max-width: 600px; margin: 0 auto 30px; }

    .related-services { background: #f8f9fa; padding: 80px 0; font-family: 'Poppins', sans-serif; }
    .related-services .section-header { text-align: center; margin-bottom: 40px; }
    .related-services h2 { font-size: 36px; }
    .related-services .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; }
    .related-services .service-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    .related-services .service-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
    .related-services .icon-box {
        width: 60px;
        height: 60px;
        background: #294738;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 15px;
        font-size: 24px;
        margin-bottom: 20px;
    }
    .related-services h4 { font-size: 20px; margin-bottom: 10px; }
    .related-services p { color: #666; font-size: 14px; margin-bottom: 15px; }
    .related-services .learn-more {
        color: #294738;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .related-services .learn-more:hover { color: var(--accent); }

    @media (max-width: 768px) {
        .service-hero h1 { font-size: 32px; }
        .service-hero .lead { font-size: 16px; }
        .service-card-detail { margin-top: -30px; padding: 20px; }
    }
    @media (max-width: 576px) {
        .service-hero { padding: 50px 0; }
        .service-hero h1 { font-size: 28px; }
    }
</style>
@endpush

@section('content')

    
    <header class="service-detail-header">
        <div class="custom-nav-container">
            <a href="{{ route('home') }}" class="custom-logo">
                <img class="logo-icon" src="{{ asset('icons/icon-192.png') }}?v={{ filemtime(public_path('icons/icon-192.png')) }}" alt="" aria-hidden="true" width="30" height="30">
                <span>aislagratis</span>
            </a>
            <nav class="custom-nav">
                <a href="{{ route('home') }}">Inicio</a>
                <a href="{{ route('services.index') }}" class="active">Servicios</a>
                <a href="{{ route('about') }}">Sobre nosotros</a>
                <a href="{{ route('leads.create') }}">Solicitar estudio</a>
                @auth
                    <a href="{{ auth()->user()->dashboardRoute() }}"><i class="fa-solid fa-user"></i> {{ auth()->user()->first_name }}</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar sesión</a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">@csrf</form>
                @else
                    <a href="{{ route('login') }}">Iniciar sesión</a>
                    <a href="{{ route('register') }}">Registrarse</a>
                @endauth
            </nav>
            <a href="{{ route('leads.create') }}" class="btn-solicitar">Solicitar estudio</a>
        </div>
    </header>

    <main>
        
        <section class="service-hero">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 19px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><span style="color: rgba(255,255,255,0.5); margin: 0 8px;">/</span></li>
                        <li><a href="{{ route('services.index') }}">Servicios</a></li>
                        <li><span style="color: rgba(255,255,255,0.5); margin: 0 8px;">/</span></li>
                        <li class="active">{{ $service->name }}</li>
                    </ol>
                </nav>
                <span class="badge-cae"><i class="fas fa-leaf"></i> Financiación CAE hasta 100%</span>
                <h1 data-aos="fade-up">{{ $service->name }}</h1>
                <p class="lead" data-aos="fade-up" data-aos-delay="100">{{ $service->description }}</p>
                <a href="{{ route('leads.create', ['service_id' => $service->id]) }}" class="btn-accent" data-aos="fade-up" data-aos-delay="200">
                    Solicitar estudio gratuito <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </section>

        
        <section style="padding: 0 19px;">
            <div class="service-card-detail" data-aos="fade-up" data-aos-delay="300">
                <div class="row g-4" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                    <div>
                        <div class="info-item">
                            <i class="fas fa-euro-sign"></i>
                            <div>
                                <div style="font-weight: 700;">Precio desde</div>
                                <div class="price-tag">{{ number_format($service->base_price, 0, ',', '.') }} €</div>
                                <div class="price-note">* El precio final depende de la superficie y condiciones del inmueble.</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <div style="font-weight: 700;">Duración estimada</div>
                                <div>{{ (int) $service->estimated_hours }} horas</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-top: 15px; font-family: 'Poppins', sans-serif;">
                    <i class="fas fa-check-circle me-2"></i> Con el programa CAE podrías obtener financiación de hasta el 100% del coste del proyecto.
                </div>
            </div>
        </section>

        
        <section class="features-section">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 19px;">
                <div style="text-align: center;" data-aos="fade-up">
                    <span style="color: var(--accent); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 10px;">Beneficios</span>
                    <h2 style="font-family: 'Poppins', sans-serif;">¿Por qué elegir este servicio?</h2>
                </div>
                <div class="features-grid">
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-chart-line"></i>
                        <h4>Ahorro energético</h4>
                        <p>Reduce tu factura energética hasta un 30% anual gracias a un aislamiento eficiente.</p>
                    </div>
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-leaf"></i>
                        <h4>Materiales ecológicos</h4>
                        <p>Utilizamos materiales certificados y respetuosos con el medio ambiente.</p>
                    </div>
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-tools"></i>
                        <h4>Instalación rápida</h4>
                        <p>Proceso limpio y sin obras mayores. La mayoría de los trabajos se completan en pocos días.</p>
                    </div>
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="400">
                        <i class="fas fa-headset"></i>
                        <h4>Asesoramiento personalizado</h4>
                        <p>Te acompañamos desde la evaluación inicial hasta la finalización del proyecto.</p>
                    </div>
                </div>
            </div>
        </section>

        
        <section class="final-cta" data-aos="zoom-in">
            <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 19px;">
                <h2>¿Listo para mejorar tu hogar?</h2>
                <p>Solicita tu estudio gratuito y descubre cuánto puedes ahorrar con el programa CAE.</p>
                <a href="{{ route('leads.create', ['service_id' => $service->id]) }}" class="btn-accent" style="font-size: 18px; padding: 16px 40px;">
                    Empezar ahora <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </section>

        
        @if($related->isNotEmpty())
            <section class="related-services">
                <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 19px;">
                    <div class="section-header" data-aos="fade-up">
                        <span style="color: var(--accent); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 10px;">Otros servicios</span>
                        <h2>También te puede interesar</h2>
                    </div>
                    <div class="services-grid">
                        @foreach($related as $index => $relService)
                            <div class="service-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                                <div class="icon-box"><i class="{{ $relService->icon_class }}"></i></div>
                                <h4>{{ $relService->name }}</h4>
                                <p>{{ \Illuminate\Support\Str::limit($relService->description, 90) }}</p>
                                <span style="color: #294738; font-weight: 700; display: block; margin-bottom: 15px; font-family: 'Poppins', sans-serif;">
                                    Desde {{ number_format($relService->base_price, 0, ',', '.') }} €
                                </span>
                                <a href="{{ route('services.show', $relService) }}" class="learn-more">
                                    Ver detalles <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>

@endsection
