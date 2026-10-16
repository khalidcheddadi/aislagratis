@extends('layouts.public')

@section('title', 'Términos y condiciones - aislagratis')
@section('meta_description', 'Consulta las condiciones de uso del sitio web y la información sobre los servicios de aislamiento y la evaluación de elegibilidad CAE.')

@push('styles')

<style>
    body { font-family: 'Poppins', sans-serif; background: var(--white); color: #222; line-height: 1.6; }
    .custom-header { padding: 20px 0; }
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
    .custom-logo { display: flex; align-items: center; font-weight: 700; font-size: 20px; color: #222; }
    .custom-logo .logo-icon {
        width: 30px;
        height: 30px;
        object-fit: contain;
        border-radius: 8px;
        margin-right: 10px;
    }
    .custom-nav { display: flex; gap: 15px; flex-wrap: wrap; align-items: center; }
    .custom-nav a { text-decoration: none; color: #666; font-size: 14px; font-weight: 500; transition: color 0.3s; }
    .custom-nav a:hover, .custom-nav a.active { color: #294738; }
    .btn-solicitar { padding: 12px 24px; border-radius: 30px; border: 1px solid #294738; color: #294738; text-decoration: none; font-weight: 500; transition: 0.3s; white-space: nowrap; }
    .btn-solicitar:hover { background: #294738; color: var(--white); }

    .legal-hero {
        background: url('https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80') no-repeat center center/cover;
        color: var(--white);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }
    .legal-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, rgb(27 27 27 / 85%) 0%, rgb(0 0 0 / 36%) 100%);
        z-index: 1;
    }
    .legal-hero .container { position: relative; z-index: 2; max-width: 1200px; margin: 0 auto; padding: 0 19px; }
    .legal-hero h1 { font-size: 48px; font-weight: 700; margin-bottom: 20px; }
    .legal-hero .lead { font-size: 18px; color: rgba(255,255,255,0.85); max-width: 700px; }
    .legal-hero .subtitle {
        color: var(--accent);
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
        margin-bottom: 10px;
    }
    .legal-content-section { padding: 80px 0; background: #F8F9FA; }
    .legal-card {
        background: var(--white);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        max-width: 1200px;
        margin: 0 auto;
    }
    .legal-card h2 { font-size: 28px; margin-bottom: 20px; color: #294738; }
    .legal-card h3 { font-size: 20px; margin-top: 30px; margin-bottom: 10px; color: #222; font-weight: 600; }
    .legal-card p { color: #666; margin-bottom: 15px; }

    @media (max-width: 992px) {
        .legal-hero h1 { font-size: 36px; }
        .legal-card { padding: 25px; }
    }
    @media (max-width: 768px) {
        .custom-nav-container { flex-direction: column; align-items: stretch; border-radius: 25px; padding: 20px; }
        .custom-nav { justify-content: center; gap: 10px; flex-wrap: wrap; }
        .legal-hero { padding: 60px 0; }
        .legal-hero h1 { font-size: 30px; }
        .legal-card { padding: 20px; }
    }
</style>
@endpush

@section('content')

    <header class="custom-header">
        <div class="custom-nav-container">
            <a href="{{ route('home') }}" class="custom-logo">
                <img class="logo-icon" src="{{ asset('icons/icon-192.png') }}?v={{ filemtime(public_path('icons/icon-192.png')) }}" alt="" aria-hidden="true" width="30" height="30">
                <span>aislagratis</span>
            </a>
            <nav class="custom-nav">
                <a href="{{ route('home') }}">Inicio</a>
                <a href="{{ route('services.index') }}">Servicios</a>
                <a href="{{ route('about') }}">Sobre nosotros</a>
                <a href="{{ route('leads.create') }}">Solicitar estudio</a>
                @auth
                    <a href="{{ auth()->user()->dashboardRoute() }}"><i class="fa-solid fa-user"></i> {{ auth()->user()->first_name }}</a>
                @else
                    <a href="{{ route('login') }}">Iniciar sesión</a>
                    <a href="{{ route('register') }}">Registrarse</a>
                @endauth
            </nav>
            <a href="{{ route('leads.create') }}" class="btn-solicitar">Solicitar estudio</a>
        </div>
    </header>

    <main>
        <section class="legal-hero">
            <div class="container">
                <span class="subtitle" data-aos="fade-up">Legal</span>
                <h1 data-aos="fade-up" data-aos-delay="100">Términos y condiciones de uso</h1>
                <p class="lead" data-aos="fade-up" data-aos-delay="200">Última actualización: {{ date('d/m/Y') }}</p>
            </div>
        </section>

        <section class="legal-content-section">
            <div class="container" style="padding: 0 19px;">
                <div class="legal-card" data-aos="fade-up">
                    <h2>Información legal</h2>

                    <h3>1. Aceptación de las condiciones</h3>
                    <p>El acceso y uso de este sitio web implica la aceptación plena de estas condiciones.</p>

                    <h3>2. Objeto</h3>
                    <p>aislagratis ofrece información sobre servicios de aislamiento térmico y gestión de solicitudes de financiación CAE.</p>

                    <h3>3. Financiación CAE</h3>
                    <p>La financiación mediante el programa CAE está sujeta a requisitos de elegibilidad y a la normativa vigente. aislagratis no garantiza la gratuidad total de los trabajos.</p>

                    <h3>4. Propiedad intelectual</h3>
                    <p>Todos los contenidos de este sitio son propiedad de aislagratis o de sus licenciantes.</p>

                    <h3>5. Limitación de responsabilidad</h3>
                    <p>aislagratis no se hace responsable de los daños derivados del uso indebido de la información contenida en este sitio.</p>

                    <h3>6. Legislación aplicable</h3>
                    <p>Estas condiciones se rigen por la legislación española.</p>
                </div>
            </div>
        </section>
    </main>

@endsection
