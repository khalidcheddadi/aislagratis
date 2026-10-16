@extends('layouts.public')

@section('title', 'Verifica tu correo - aislagratis')
@section('meta_robots', 'noindex, nofollow')

@push('styles')
<style>
    .verify-hero {
        min-height: calc(100vh - 120px);
        padding: 48px 24px;
        display: grid;
        place-items: center;
        background: linear-gradient(135deg, #edf6ee 0%, #fff 54%, #e3efe5 100%);
    }

    .verify-layout {
        width: min(1100px, 100%);
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(320px, 0.9fr);
        align-items: center;
        gap: clamp(32px, 6vw, 80px);
    }

    .verify-photo {
        position: relative;
        min-height: 460px;
        overflow: hidden;
        border-radius: 8px;
        background: #1b5e20;
    }

    .verify-photo img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .verify-photo::after {
        position: absolute;
        inset: 35% 0 0;
        content: '';
        background: linear-gradient(transparent, rgba(16, 43, 23, 0.88));
    }

    .verify-photo-copy {
        position: absolute;
        z-index: 1;
        right: 32px;
        bottom: 32px;
        left: 32px;
        color: #fff;
    }

    .verify-photo-copy span,
    .verify-eyebrow {
        display: block;
        color: #287a35;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .verify-photo-copy span { color: #d8f0dc; }

    .verify-photo-copy h2 {
        margin: 10px 0 0;
        font-size: clamp(1.8rem, 4vw, 2.7rem);
        line-height: 1.12;
    }

    .verify-content { max-width: 460px; }

    .verify-icon {
        width: 58px;
        height: 58px;
        display: grid;
        place-items: center;
        margin-bottom: 24px;
        border-radius: 50%;
        background: #e5f3e7;
        color: #1b5e20;
        font-size: 1.35rem;
    }

    .verify-content h1 {
        margin: 10px 0 14px;
        color: #16281c;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        line-height: 1.08;
    }

    .verify-description {
        color: #526657;
        line-height: 1.75;
    }

    .verify-address {
        display: block;
        margin-top: 6px;
        color: #1b5e20;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .verify-alert {
        margin: 22px 0;
        padding: 14px 16px;
        border-left: 4px solid #2e7d32;
        background: #edf6ee;
        color: #1b5e20;
        line-height: 1.55;
    }

    .verify-alert.is-error {
        border-color: #b42318;
        background: #fff1f0;
        color: #8f1d14;
    }

    .verify-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 18px;
        margin-top: 28px;
    }

    .verify-submit {
        min-height: 50px;
        padding: 0 22px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        border: 0;
        border-radius: 4px;
        background: #1b5e20;
        color: #fff;
        font: inherit;
        font-weight: 700;
        cursor: pointer;
    }

    .verify-submit:hover { background: #124719; }

    .verify-logout {
        border: 0;
        background: transparent;
        color: #526657;
        font: inherit;
        text-decoration: underline;
        cursor: pointer;
    }

    @media (max-width: 760px) {
        .verify-hero { padding: 32px 20px; }
        .verify-layout { grid-template-columns: 1fr; gap: 28px; }
        .verify-photo { min-height: 230px; order: 2; }
        .verify-content { max-width: none; order: 1; }
        .verify-photo-copy { right: 20px; bottom: 20px; left: 20px; }
    }
</style>
@endpush

@section('content')
    <div class="auth-header-shell">
        @include('partials.public-header')
    </div>

    <main class="verify-hero">
        <div class="verify-layout">
            <div class="verify-photo">
                <img src="{{ asset('images/image12.jpg') }}" alt="Vivienda con mejoras de eficiencia energética">
                <div class="verify-photo-copy">
                    <span>aislagratis · Tu espacio personal</span>
                    <h2>Un hogar más eficiente empieza aquí.</h2>
                </div>
            </div>

            <section class="verify-content" aria-labelledby="verify-title">
                <div class="verify-icon" aria-hidden="true"><i class="fa-solid fa-envelope-circle-check"></i></div>
                <span class="verify-eyebrow">Un último paso</span>
                <h1 id="verify-title">Confirma tu correo</h1>
                <p class="verify-description">
                    Hemos enviado un enlace seguro a tu dirección. Confírmala para acceder a tus solicitudes y a tu panel personal.
                    <span class="verify-address">{{ request()->user()->email }}</span>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <div class="verify-alert" role="status">Hemos enviado un nuevo enlace. Revisa también la carpeta de correo no deseado.</div>
                @elseif (session('status') === 'verification-link-failed')
                    <div class="verify-alert is-error" role="alert">No pudimos enviar el correo ahora. Comprueba la configuración SMTP o inténtalo de nuevo más tarde.</div>
                @endif

                <div class="verify-actions">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button class="verify-submit" type="submit">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                            Reenviar enlace
                        </button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="verify-logout" type="submit">Cerrar sesión</button>
                    </form>
                </div>
            </section>
        </div>
    </main>
@endsection
