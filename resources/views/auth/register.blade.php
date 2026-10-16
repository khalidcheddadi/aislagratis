@extends('layouts.public')

@section('title', 'Crear cuenta - aislagratis')
@section('meta_robots', 'noindex, nofollow')

@push('styles')
<style>
    .register-hero-section {
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

    .register-hero-section::before {
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

    .register-hero-section::after {
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

    .register-blob-card {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 520px;
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

    .register-blob-card::before {
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

    .register-blob-card::after {
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

    .register-blob-card > * { position: relative; z-index: 1; }

    .register-logo { text-align: center; margin-bottom: 10px; }
    .register-logo i {
        font-size: 3rem;
        color: var(--green);
        background: var(--green-50);
        width: 80px;
        height: 80px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--blob-radius);
        box-shadow: var(--shadow-sm);
        margin-bottom: 15px;
    }
    .register-blob-card:hover .register-logo i {
        border-radius: var(--blob-radius-2);
        transform: scale(1.05);
    }

    .register-title { text-align: center; margin-bottom: 8px; }
    .register-title .subtitle-badge {
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
    .register-title h1 {
        font-size: 2rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: -1px;
        color: var(--black);
        line-height: 1.1;
    }
    .register-sub {
        text-align: center;
        color: var(--gray-500);
        font-size: 0.85rem;
        margin-bottom: 30px;
        font-weight: 500;
    }

    .register-form .form-group { margin-bottom: 20px; }
    .register-form label {
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
        pointer-events: none;
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

    .btn-register {
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
        margin-top: 10px;
    }
    .btn-register:hover {
        background: linear-gradient(135deg, var(--green), var(--green-dark) 70%);
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(27, 94, 32, 0.32);
        color: var(--white);
    }
    .btn-register i { transition: transform 0.3s; }
    .btn-register:hover i { transform: translateX(5px); }

    .login-link {
        text-align: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid var(--border-light);
        font-size: 0.82rem;
        color: var(--gray-600);
        font-weight: 500;
    }
    .login-link a {
        color: var(--accent);
        font-weight: 800;
        letter-spacing: 0.5px;
        transition: all 0.3s;
    }
    .login-link a:hover { color: var(--green-dark); }

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
    .alert-error ul { list-style: none; padding: 0; margin: 0; }
    .alert-error i { font-size: 1.1rem; margin-top: 2px; flex-shrink: 0; }

    .floating-blob-icon {
        position: absolute;
        font-size: 1.4rem;
        color: var(--green);
        opacity: 0.5;
        animation: float 5s ease-in-out infinite;
        pointer-events: none;
        z-index: 1;
    }
    .fbi-1 { top: 15%; left: 8%; font-size: 1.8rem; }
    .fbi-2 { top: 25%; right: 10%; animation-delay: 1.2s; font-size: 1.2rem; }
    .fbi-3 { bottom: 20%; left: 5%; animation-delay: 2s; font-size: 1.5rem; }
    .fbi-4 { bottom: 15%; right: 6%; animation-delay: 0.6s; font-size: 1.3rem; }
    .fbi-5 { top: 50%; left: -5px; animation-delay: 1.8s; font-size: 1rem; }
    .fbi-6 { top: 55%; right: -5px; animation-delay: 0.3s; font-size: 1.1rem; }

    @media (max-width: 768px) {
        .register-hero-section { min-height: calc(100vh - 80px); padding: 40px 16px; }
        .register-blob-card { padding: 35px 25px; border-radius: 28px; }
        .register-title h1 { font-size: 1.6rem; }
        .register-logo i { font-size: 2.5rem; width: 65px; height: 65px; }
        .floating-blob-icon { display: none; }
    }
    @media (max-width: 480px) {
        .register-blob-card { padding: 28px 18px; border-radius: 22px; }
        .register-title h1 { font-size: 1.3rem; letter-spacing: 0; }
        .btn-register { padding: 14px 24px; font-size: 0.75rem; }
    }

    .auth-header-shell { padding: 1rem clamp(16px, 4vw, 64px); background: #fff; border-bottom: 1px solid var(--border-light); }
    .auth-header-shell .custom-header { padding: 0; }
    .register-hero-section { min-height: 0; padding: clamp(24px, 5vw, 64px) 20px; background: #f1f5f0; }
    .register-hero-section::before, .register-hero-section::after { display: none; }
    .auth-layout {
        display: grid;
        grid-template-columns: minmax(0, 0.9fr) minmax(460px, 1.1fr);
        width: min(1160px, 100%);
        margin: 0 auto;
        overflow: hidden;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 24px 70px rgba(22, 40, 28, 0.14);
    }
    .auth-story { position: relative; display: flex; min-height: 760px; align-items: flex-end; padding: 42px; overflow: hidden; color: #fff; background: var(--green-dark); }
    .auth-story::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(10, 33, 19, 0.08) 5%, rgba(10, 33, 19, 0.84) 100%); }
    .auth-story-image { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .auth-story-content { position: relative; z-index: 1; max-width: 430px; }
    .auth-story-label { display: inline-block; margin-bottom: 16px; color: #d8f0d9; font-size: 0.72rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; }
    .auth-story-content h2 { margin: 0 0 14px; color: #fff; font-size: 2.15rem; font-weight: 800; line-height: 1.15; }
    .auth-story-content p { margin: 0; color: rgba(255,255,255,0.86); font-size: 0.95rem; line-height: 1.7; }
    .auth-story-points { display: grid; gap: 12px; margin-top: 24px; }
    .auth-story-points span { display: flex; align-items: center; gap: 10px; color: rgba(255,255,255,0.94); font-size: 0.82rem; font-weight: 600; }
    .auth-story-points i { color: #a7e3a9; }
    .register-blob-card { max-width: none; align-self: center; padding: 44px clamp(28px, 4vw, 56px); border: 0; border-radius: 0; background: #fff; box-shadow: none; backdrop-filter: none; }
    .register-blob-card::before, .register-blob-card::after { display: none; }
    .register-title h1 { font-size: 1.9rem; letter-spacing: 0; text-transform: none; }
    .register-sub { margin-bottom: 22px; }
    .register-form .form-group { margin-bottom: 15px; }
    .input-wrapper input { min-height: 50px; border-radius: 8px; }
    .btn-register { min-height: 52px; border-radius: 8px; }

    @media (max-width: 900px) {
        .auth-layout { grid-template-columns: 1fr; max-width: 600px; }
        .auth-story { min-height: 230px; padding: 26px; }
        .auth-story-content h2 { font-size: 1.65rem; }
        .register-blob-card { padding: 36px clamp(24px, 7vw, 44px); }
    }

    @media (max-width: 480px) {
        .register-hero-section { padding: 16px 12px 30px; }
        .auth-layout { border-radius: 10px; }
        .auth-story { min-height: 210px; padding: 22px; }
        .register-blob-card { padding: 28px 20px; }
    }
</style>
@endpush

@section('content')

    <div class="auth-header-shell">
        @include('partials.public-header')
    </div>

    <main>
        <section class="register-hero-section">
            <div class="auth-layout">
                <aside class="auth-story">
                    <picture class="auth-story-media">
                        <source
                            type="image/webp"
                            srcset="{{ asset('images/image6-320.webp') }} 320w, {{ asset('images/image6-640.webp') }} 640w, {{ asset('images/image6-960.webp') }} 960w"
                            sizes="(max-width: 900px) 100vw, 40vw">
                        <img class="auth-story-image" src="{{ asset('images/image6.jpg') }}" alt="Aislamiento de lana mineral aplicado en un ático bajo cubierta" width="1600" height="1200" decoding="async">
                    </picture>
                    <div class="auth-story-content">
                        <span class="auth-story-label">aislagratis · EMPIEZA AQUÍ</span>
                        <h2>Un hogar más cómodo, paso a paso.</h2>
                        <p>Crea tu cuenta para gestionar tus solicitudes y mantener toda la información de tu proyecto en un mismo lugar.</p>
                        <div class="auth-story-points">
                            <span><i class="fa-solid fa-circle-check"></i> Solicitudes centralizadas</span>
                            <span><i class="fa-solid fa-circle-check"></i> Seguimiento de cada proyecto</span>
                            <span><i class="fa-solid fa-circle-check"></i> Atención personalizada</span>
                        </div>
                    </div>
                </aside>
                <div class="register-blob-card" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                <div class="register-logo">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div class="register-title">
                    <span class="subtitle-badge">Registro</span>
                    <h1>Crear cuenta</h1>
                </div>
                <p class="register-sub">Regístrate para gestionar tus solicitudes y citas.</p>

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

                <form method="POST" action="{{ route('register') }}" class="register-form">
                    @csrf
                    <div class="form-group">
                        <label for="first_name">Nombre *</label>
                        <div class="input-wrapper">
                            <input type="text" id="first_name" name="first_name" required
                                   value="{{ old('first_name') }}" placeholder="Tu nombre">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Apellidos *</label>
                        <div class="input-wrapper">
                            <input type="text" id="last_name" name="last_name" required
                                   value="{{ old('last_name') }}" placeholder="Tus apellidos">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <div class="input-wrapper">
                            <input type="email" id="email" name="email" required
                                   value="{{ old('email') }}" placeholder="tu@email.com">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono</label>
                        <div class="input-wrapper">
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone') }}" placeholder="+34 641 322 118">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña *</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" required
                                   minlength="8" placeholder="Mínimo 8 caracteres">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar contraseña *</label>
                        <div class="input-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   placeholder="Repite la contraseña">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn-register">
                        Registrarse <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <div class="login-link">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
                </div>
            </div>
            </div>
        </section>
    </main>

@endsection