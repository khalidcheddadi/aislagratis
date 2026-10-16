@extends('layouts.public')

@section('title', 'Política de privacidad - aislagratis')
@section('meta_description', 'Consulta cómo aislagratis trata y protege tus datos personales al solicitar información o utilizar sus servicios.')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Poppins', sans-serif; background: var(--white); color: #222; line-height: 1.6; }

    .custom-header { position: relative; z-index: 1000; padding: 20px 0; background: transparent; }
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
    .custom-nav { display: flex; gap: 15px; flex-wrap: wrap; align-items: center; }
    .custom-nav a { text-decoration: none; color: #666; font-size: 14px; font-weight: 500; transition: color 0.3s; }
    .custom-nav a:hover, .custom-nav a.active { color: #294738; }
    .btn-solicitar {
        display: inline-block;
        padding: 12px 24px;
        border-radius: 30px;
        font-weight: 500;
        border: 1px solid #294738;
        color: #294738;
        background: transparent;
        white-space: nowrap;
        text-decoration: none;
        transition: 0.3s;
    }
    .btn-solicitar:hover { background: #294738; color: var(--white); }

    .privacy-hero {
        background: url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80') no-repeat center center/cover;
        color: var(--white);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }
    .privacy-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(135deg, rgb(27 27 27 / 85%) 0%, rgb(0 0 0 / 36%) 100%);
        z-index: 1;
    }
    .privacy-hero .container { position: relative; z-index: 2; max-width: 1200px; margin: 0 auto; padding: 0 19px; }
    .privacy-hero h1 { font-size: 48px; font-weight: 700; margin-bottom: 20px; }
    .privacy-hero .lead { font-size: 18px; color: rgba(255,255,255,0.85); max-width: 700px; }
    .privacy-hero .subtitle {
        color: var(--accent);
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: block;
        margin-bottom: 10px;
    }

    .privacy-content-section { padding: 80px 0; background: #F8F9FA; }
    .privacy-card {
        background: var(--white);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.05);
        max-width: 1200px;
        margin: 0 auto;
    }
    .privacy-card h2 { font-size: 28px; margin-bottom: 20px; color: #294738; }
    .privacy-card h3 { font-size: 20px; margin-top: 30px; margin-bottom: 10px; color: #222; font-weight: 600; }
    .privacy-card p { color: #666; margin-bottom: 15px; }
    .privacy-card ul { color: #666; padding-left: 20px; margin-bottom: 15px; }
    .privacy-card ul li { margin-bottom: 8px; }

    @media (max-width: 992px) {
        .privacy-hero h1 { font-size: 36px; }
        .privacy-card { padding: 25px; }
    }
    @media (max-width: 768px) {
        .custom-nav-container { flex-direction: column; align-items: stretch; border-radius: 25px; padding: 20px; }
        .custom-nav { justify-content: center; gap: 10px; flex-wrap: wrap; }
        .privacy-hero { padding: 60px 0; }
        .privacy-hero h1 { font-size: 30px; }
        .privacy-card { padding: 20px; }
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
        <section class="privacy-hero">
            <div class="container">
                <span class="subtitle" data-aos="fade-up">Legal</span>
                <h1 data-aos="fade-up" data-aos-delay="100">Política de privacidad</h1>
                <p class="lead" data-aos="fade-up" data-aos-delay="200">Última actualización: {{ date('d/m/Y') }}</p>
            </div>
        </section>

        <section class="privacy-content-section">
            <div class="container" style="padding: 0 19px;">
                <div class="privacy-card" data-aos="fade-up">
                    <h2>Información sobre protección de datos</h2>

                    <h3>1. Responsable del tratamiento</h3>
                    <p>aislagratis, con domicilio en Calle Ejemplo 123, Madrid, España. Email: {{ config('aislaplus.email') }}</p>

                    <h3>2. Finalidad del tratamiento</h3>
                    <p>Los datos personales facilitados a través de los formularios de este sitio web serán utilizados para:</p>
                    <ul>
                        <li>Gestionar las solicitudes de estudio de aislamiento.</li>
                        <li>Contactar con el interesado para ofrecer información sobre nuestros servicios.</li>
                        <li>Gestionar la relación contractual y la prestación de los servicios solicitados.</li>
                        <li>Enviar comunicaciones comerciales si el usuario lo ha consentido.</li>
                    </ul>

                    <h3>3. Legitimación</h3>
                    <p>La base legal para el tratamiento es el consentimiento del interesado y la ejecución de un contrato o precontrato.</p>

                    <h3>4. Conservación de los datos</h3>
                    <p>Los datos se conservarán mientras dure la relación comercial y, posteriormente, durante los plazos legales exigibles.</p>

                    <h3>5. Derechos del usuario</h3>
                    <p>Puedes ejercer tus derechos de acceso, rectificación, supresión, oposición, limitación y portabilidad escribiendo a {{ config('aislaplus.email') }}.</p>

                    <h3>6. Cookies</h3>
                    <p>Utilizamos cookies técnicas necesarias para la sesión y almacenamiento local para recordar tu elección sobre cookies. Al registrar esa elección, el servidor puede conservar un identificador aleatorio, la dirección IP, el navegador y, cuando está disponible, el país y la ciudad asociados a la solicitud. Consulta nuestra <a href="{{ route('legal.cookies') }}">política de cookies</a> para más información.</p>
                </div>
            </div>
        </section>
    </main>

@endsection
