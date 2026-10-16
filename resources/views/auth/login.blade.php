@extends('layouts.public')

@section('title', 'Iniciar sesión - aislagratis')
@section('meta_robots', 'noindex, nofollow')

@push('styles')
<style>
    .login-hero-section {
        position: relative;
        width: 100%;
        min-height: calc(100vh - 120px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 25px;
        background: linear-gradient(135deg, rgba(234, 246, 236, 0.92) 0%, rgba(255, 255, 255, 0.97) 50%, rgba(220, 235, 222, 0.9) 100%),
                    url('https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        overflow: hidden;
        z-index: 1;
    }

    .login-hero-section::before {
        content: '';
        position: absolute;
        top: -15%;
        right: -10%;
        width: 550px;
        height: 550px;
        background: radial-gradient(circle, rgba(var(--green-light-rgb), 0.12) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
        animation: pulse-glow 6s ease-in-out infinite;
    }

    .login-hero-section::after {
        content: '';
        position: absolute;
        bottom: -20%;
        left: -12%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(27, 94, 32, 0.10) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
        animation: pulse-glow 8s ease-in-out infinite reverse;
    }

    .login-blob-card {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 480px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 35px;
        padding: 45px 40px;
        border: 1px solid rgba(27, 94, 32, 0.12);
        box-shadow: var(--shadow-lg);
        transition: all 0.5s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
    }

    .login-blob-card::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, var(--green-light), var(--green-dark));
        border-radius: var(--blob-radius);
        opacity: 0.15;
        z-index: 0;
        animation: float 4s ease-in-out infinite;
    }

    .login-blob-card::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: -30px;
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--accent), var(--green-light));
        border-radius: var(--blob-radius-2);
        opacity: 0.12;
        z-index: 0;
        animation: float 5s ease-in-out infinite reverse;
    }

    .login-blob-card > * { position: relative; z-index: 1; }

    .login-logo { text-align: center; margin-bottom: 10px; }
    .login-logo img {
        width: 80px;
        height: 80px;
        display: inline-block;
        object-fit: contain;
        background: #fff;
        padding: 4px;
        border-radius: var(--blob-radius);
        box-shadow: var(--shadow-sm);
        margin-bottom: 15px;
        transition: all 0.4s ease;
    }

    .login-blob-card:hover .login-logo img {
        border-radius: var(--blob-radius-2);
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    .login-title { text-align: center; margin-bottom: 8px; }

    .login-title .subtitle-badge {
        display: inline-block;
        background: var(--green-50);
        color: var(--green-dark);
        border: 1px solid var(--border-light);
        border-radius: 30px;
        padding: 6px 18px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .login-title h1 {
        font-size: 2rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -1px;
        color: var(--black);
        line-height: 1.1;
    }

    .login-sub {
        text-align: center;
        color: var(--gray-500);
        font-size: 0.85rem;
        margin-bottom: 30px;
        font-weight: 500;
    }

    .login-form .form-group { margin-bottom: 20px; }

    .login-form label {
        display: block;
        font-weight: 700;
        font-size: 0.75rem;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: var(--gray-600);
        margin-bottom: 8px;
    }

    .input-wrapper { position: relative; }
    .input-wrapper i {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        color: var(--gray-400);
        font-size: 0.95rem;
        transition: color 0.3s;
    }

    .input-wrapper input {
        width: 100%;
        padding: 14px 18px 14px 45px;
        border-radius: 14px;
        border: 1.5px solid var(--border-light);
        background: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
        font-family: 'Montserrat', sans-serif;
        transition: all 0.3s;
        color: var(--black);
        outline: none;
    }

    .input-wrapper input:focus {
        border-color: var(--green);
        box-shadow: 0 0 0 4px rgba(var(--green-light-rgb), 0.12);
        background: var(--white);
    }

    .input-wrapper input:focus ~ i { color: var(--green); }
    .input-wrapper input::placeholder { color: var(--gray-400); font-weight: 400; }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .remember-check {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 0.78rem;
        font-weight: 600;
        color: var(--gray-600);
    }

    .remember-check input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--green);
        cursor: pointer;
        border-radius: 4px;
    }

    .forgot-link {
        font-size: 0.78rem;
        font-weight: 700;
        color: var(--green);
        letter-spacing: 0.5px;
        transition: all 0.3s;
    }

    .forgot-link:hover {
        color: var(--green-dark);
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    .btn-login {
        width: 100%;
        background: linear-gradient(135deg, var(--green-light), var(--green) 60%, var(--green-dark));
        color: var(--white);
        border: none;
        padding: 16px 30px;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        cursor: pointer;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-family: 'Montserrat', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-login:hover {
        background: linear-gradient(135deg, var(--green), var(--green-dark) 70%);
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(27, 94, 32, 0.32);
        color: var(--white);
    }

    .btn-login i { font-size: 0.9rem; transition: transform 0.3s; }
    .btn-login:hover i { transform: translateX(5px); }

    .register-link {
        text-align: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid var(--border-light);
        font-size: 0.82rem;
        color: var(--gray-600);
        font-weight: 500;
    }

    .register-link a {
        color: var(--accent);
        font-weight: 800;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        position: relative;
    }

    .register-link a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--accent);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .register-link a:hover { color: var(--green-dark); }
    .register-link a:hover::after { transform: scaleX(1); background: var(--green-dark); }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 22px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        font-size: 0.82rem;
        color: #dc2626;
        font-weight: 600;
    }

    .alert-error i { font-size: 1.1rem; margin-top: 2px; flex-shrink: 0; }
    .alert-error ul { list-style: none; padding: 0; margin: 0; }

    .alert-success {
        background: #edf6ee;
        border: 1px solid #c8e2cc;
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 22px;
        color: #1b5e20;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .floating-blob-icon {
        position: absolute;
        font-size: 1.4rem;
        color: var(--green);
        opacity: 0.5;
        animation: float 5s ease-in-out infinite;
        pointer-events: none;
        z-index: 1;
    }

    .fbi-1 { top: 15%; left: 8%; animation-delay: 0s; font-size: 1.8rem; }
    .fbi-2 { top: 25%; right: 10%; animation-delay: 1.2s; font-size: 1.2rem; }
    .fbi-3 { bottom: 20%; left: 5%; animation-delay: 2s; font-size: 1.5rem; }
    .fbi-4 { bottom: 15%; right: 6%; animation-delay: 0.6s; font-size: 1.3rem; }
    .fbi-5 { top: 50%; left: -5px; animation-delay: 1.8s; font-size: 1rem; }
    .fbi-6 { top: 55%; right: -5px; animation-delay: 0.3s; font-size: 1.1rem; }

    @media (max-width: 768px) {
        .login-hero-section { min-height: calc(100vh - 80px); padding: 40px 16px; }
        .login-blob-card { padding: 35px 25px; border-radius: 28px; }
        .login-title h1 { font-size: 1.6rem; }
        .login-logo img { width: 65px; height: 65px; }
        .floating-blob-icon { display: none; }
    }

    @media (max-width: 480px) {
        .login-blob-card { padding: 28px 18px; border-radius: 22px; }
        .login-title h1 { font-size: 1.3rem; letter-spacing: 0; }
        .form-options { flex-direction: column; align-items: flex-start; }
        .btn-login { padding: 14px 24px; font-size: 0.75rem; }
    }

    .auth-header-shell { padding: 1rem clamp(16px, 4vw, 64px); background: #fff; border-bottom: 1px solid var(--border-light); }
    .auth-header-shell .custom-header { padding: 0; }
    .login-hero-section { min-height: 0; padding: clamp(24px, 5vw, 64px) 20px; background: #f1f5f0; }
    .login-hero-section::before, .login-hero-section::after { display: none; }
    .auth-layout {
        display: grid;
        grid-template-columns: minmax(0, 0.95fr) minmax(420px, 1.05fr);
        width: min(1080px, 100%);
        margin: 0 auto;
        overflow: hidden;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 24px 70px rgba(22, 40, 28, 0.14);
    }
    .auth-story { position: relative; display: flex; min-height: 680px; align-items: flex-end; padding: 42px; overflow: hidden; color: #fff; background: var(--green-dark); }
    .auth-story::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(10, 33, 19, 0.08) 5%, rgba(10, 33, 19, 0.82) 100%); }
    .auth-story-image { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .auth-story-content { position: relative; z-index: 1; max-width: 430px; }
    .auth-story-label { display: inline-block; margin-bottom: 16px; color: #d8f0d9; font-size: 0.72rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; }
    .auth-story-content h2 { margin: 0 0 14px; color: #fff; font-size: 2.15rem; font-weight: 800; line-height: 1.15; }
    .auth-story-content p { margin: 0; color: rgba(255,255,255,0.86); font-size: 0.95rem; line-height: 1.7; }
    .auth-story-points { display: grid; gap: 12px; margin-top: 24px; }
    .auth-story-points span { display: flex; align-items: center; gap: 10px; color: rgba(255,255,255,0.94); font-size: 0.82rem; font-weight: 600; }
    .auth-story-points i { color: #a7e3a9; }
    .login-blob-card { max-width: none; align-self: center; padding: 48px clamp(28px, 5vw, 64px); border: 0; border-radius: 0; background: #fff; box-shadow: none; backdrop-filter: none; }
    .login-blob-card::before, .login-blob-card::after { display: none; }
    .login-title h1 { font-size: 1.9rem; letter-spacing: 0; text-transform: none; }
    .input-wrapper input { min-height: 52px; border-radius: 8px; }
    .btn-login { min-height: 52px; border-radius: 8px; }

    @media (max-width: 820px) {
        .auth-layout { grid-template-columns: 1fr; max-width: 560px; }
        .auth-story { min-height: 250px; padding: 26px; }
        .auth-story-content h2 { font-size: 1.65rem; }
        .login-blob-card { padding: 36px clamp(24px, 7vw, 44px); }
    }

    @media (max-width: 480px) {
        .login-hero-section { padding: 16px 12px 30px; }
        .auth-layout { border-radius: 10px; }
        .auth-story { min-height: 210px; padding: 22px; }
        .auth-story-points { grid-template-columns: 1fr; margin-top: 16px; }
        .login-blob-card { padding: 28px 20px; }
    }
</style>
@endpush

@section('content')

    <div class="auth-header-shell">
        @include('partials.public-header')
    </div>

    <main>
        <section class="login-hero-section">
            <div class="auth-layout">
                <aside class="auth-story">
                    <picture class="auth-story-media">
                        <source
                            type="image/webp"
                            srcset="{{ asset('images/image12-320.webp') }} 320w, {{ asset('images/image12-640.webp') }} 640w, {{ asset('images/image12-960.webp') }} 960w"
                            sizes="(max-width: 820px) 100vw, 45vw">
                        <img class="auth-story-image" src="{{ asset('images/image12.jpg') }}" alt="Aislamiento de lana mineral insuflado en un ático" width="1200" height="1600" decoding="async">
                    </picture>
                    <div class="auth-story-content">
                        <span class="auth-story-label">aislagratis · TU ESPACIO PERSONAL</span>
                        <h2>Tu hogar, cada vez más eficiente.</h2>
                        <p>Entra para consultar tus solicitudes y seguir el avance de tus mejoras energéticas.</p>
                        <div class="auth-story-points">
                            <span><i class="fa-solid fa-circle-check"></i> Seguimiento de tus solicitudes</span>
                            <span><i class="fa-solid fa-circle-check"></i> Información clara en cada paso</span>
                        </div>
                    </div>
                </aside>
                <div class="login-blob-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                <div class="login-logo">
                    <img src="{{ asset('icons/icon-192.png') }}?v={{ filemtime(public_path('icons/icon-192.png')) }}" alt="aislagratis" width="56" height="56">
                </div>
                <div class="login-title">
                    <span class="subtitle-badge">Acceso</span>
                    <h1>Iniciar sesión</h1>
                </div>
                <p class="login-sub">Accede a tu panel de cliente o administración</p>

                @if(session('status') === 'email-verified')
                    <div class="alert-success" role="status">Tu correo ha sido verificado. Inicia sesión para continuar.</div>
                @endif

                @if($errors->any())
                    <div class="alert-error" data-aos="zoom-in">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" required
                                   value="{{ old('email') }}" placeholder="tu@email.com">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" required placeholder="••••••••">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-options">
                        <label class="remember-check">
                            <input type="checkbox" id="remember" name="remember">
                            Recuérdame
                        </label>
                        @if(Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>
                        @endif
                    </div>
                    <button type="submit" class="btn-login">
                        Entrar <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <div class="register-link">
                    ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
                </div>
            </div>
            </div>
        </section>
    </main>

@endsection
