@extends('layouts.public')

@section('title', 'Solicitar estudio gratuito')

@push('styles')
<style>
    .hero-container {
        min-height: 10px;
        padding: 1.5rem 4rem 0;
    }
    .hero-container.compact {
        min-height: auto;
        padding: 1rem 4rem 0;
    }

    .hero-container.compact .custom-header { padding-bottom: 0; }

    .lead-form-section {
        padding: 8px 0 72px;
        background: linear-gradient(135deg, #f4f7f3 0%, #edf3ed 100%);
        position: relative;
    }

    .lead-form-card {
        width: min(100%, 1040px);
        background: #fff;
        border-radius: 12px;
        padding: 48px;
        border: 1px solid rgba(var(--green-dark-rgb), 0.1);
        box-shadow: 0 20px 55px rgba(27, 94, 32, 0.09);
        margin: 0 auto;
        position: relative;
    }

    .lead-form-card h1 {
        font-size: 2.15rem;
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 12px;
        color: var(--black);
    }

    .lead-form-card .lead {
        color: var(--gray-500);
        font-size: 0.92rem;
        line-height: 1.7;
        margin-bottom: 34px;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--green-dark);
        margin: 34px 0 20px;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--border-light);
        letter-spacing: 0.3px;
    }

    .form-section-title i {
        display: inline-grid;
        place-items: center;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: var(--green-50);
        color: var(--green);
        font-size: 0.95rem;
    }

    .form-label {
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--gray-600);
        margin-bottom: 7px;
        display: block;
    }

    .form-control, .form-select {
        width: 100%;
        min-height: 50px;
        padding: 12px 14px;
        border-radius: 7px;
        border: 1px solid #d9e4da;
        background: #fbfcfb;
        font-size: 0.88rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        color: var(--black);
        font-family: 'Montserrat', sans-serif;
    }

    .form-control:hover, .form-select:hover { border-color: #a9c7ad; }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: var(--green);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(var(--green-light-rgb), 0.14);
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%235d7a62' stroke-width='2' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 40px;
    }

    textarea.form-control { min-height: 130px; resize: vertical; }

    .btn-submit {
        background: linear-gradient(135deg, var(--green-light), var(--green) 60%, var(--green-dark));
        color: var(--white);
        border: none;
        padding: 16px 40px;
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        cursor: pointer;
        border-radius: 8px;
        width: 100%;
        min-height: 54px;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, var(--green), var(--green-dark) 70%);
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(27, 94, 32, 0.32);
    }

    .alert { border-radius: 8px; padding: 15px 18px; margin-bottom: 20px; }
    .alert-success {
        background: var(--green-50);
        border: 1px solid var(--green);
        color: var(--green-dark);
        font-weight: 600;
    }
    .alert-danger {
        background: #fff0f0;
        border: 1px solid #dc3545;
        color: #721c24;
        font-weight: 600;
    }
    .alert-danger ul { margin: 0; padding-left: 20px; }

    .form-check { display: flex; align-items: flex-start; gap: 10px; margin-top: 10px; }
    .form-check input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--green); cursor: pointer; }
    .form-check label { cursor: pointer; font-size: 0.86rem; line-height: 1.5; color: var(--gray-600); }

    .form-row {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 20px 18px;
    }

    .form-row > div { grid-column: span 3; min-width: 0; }
    .form-row > div.full { grid-column: 1 / -1; }
    .form-row > div.third { grid-column: span 2; min-width: 0; }
    .form-row > div:has(> #property_type) { grid-column: span 4; }

    @media (max-width: 1024px) {
        .lead-form-section { padding: 56px 0; }
        .lead-form-card { padding: 36px; }
    }
    @media (max-width: 768px) {
        .hero-container.compact { padding: 0.75rem 1.2rem 0; }
        .lead-form-section { padding: 6px 0 48px; }
        .lead-form-card { padding: 30px; }
        .form-row { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px 14px; }
        .form-row > div, .form-row > div.third { grid-column: span 1; }
        .form-row > div.full, .form-row > div:has(> #property_type) { grid-column: 1 / -1; }
        .form-section-title { font-size: 1rem; margin: 26px 0 16px; }
    }
    @media (max-width: 480px) {
        .lead-form-section { padding: 4px 0 36px; }
        .lead-form-card { padding: 24px 18px; border-radius: 10px; }
        .lead-form-card h1 { font-size: 1.65rem; }
        .form-row { grid-template-columns: minmax(0, 1fr); gap: 16px; }
        .form-row > div, .form-row > div.third,
        .form-row > div.full, .form-row > div:has(> #property_type) { grid-column: 1 / -1; }
        .lead-form-card .lead { margin-bottom: 26px; }
    }
</style>
@endpush

@section('content')

    <div class="hero-container compact">
        @include('partials.public-header')
    </div>

    <section class="lead-form-section" id="formulario">
        <div class="container lead-form-layout">
            <aside class="lead-form-aside">
                <span class="editorial-kicker">Primer paso · Sin compromiso</span>
                <h2 class="lead-aside-title">HABLEMOS<br>DE TU ÁTICO.</h2>
                <p class="lead-aside-copy">Cuéntanos cómo es tu vivienda. Revisaremos los datos iniciales y te explicaremos las opciones de aislamiento y los siguientes pasos.</p>
                <div class="lead-aside-image">
                    <picture>
                        <source type="image/webp" srcset="{{ asset('images/image11-320.webp') }} 320w, {{ asset('images/image11-640.webp') }} 640w, {{ asset('images/image11-960.webp') }} 960w" sizes="(max-width: 768px) 82vw, 32vw">
                        <img src="{{ asset('images/image11.jpg') }}" alt="Aislamiento insuflado instalado bajo la cubierta de una vivienda" width="900" height="1600" loading="lazy" decoding="async">
                    </picture>
                </div>
                <div class="lead-aside-steps">
                    <span><i class="fa-solid fa-1" aria-hidden="true"></i> Revisamos la información</span>
                    <span><i class="fa-solid fa-2" aria-hidden="true"></i> Valoramos acceso y cubierta</span>
                    <span><i class="fa-solid fa-3" aria-hidden="true"></i> Te contamos las opciones</span>
                </div>
                <p class="lead-aside-note">La elegibilidad CAE y cualquier financiación se confirman tras evaluación técnica y documental.</p>
            </aside>

            <div class="lead-form-card" data-aos="fade-up">

                <span class="subtitle" style="background: var(--green-50); color: var(--green-dark); border: 1px solid var(--border-light); border-radius: 30px; padding: 7px 20px; display: inline-block; margin-bottom: 15px; font-size: 0.8rem; font-weight: 700; letter-spacing: 2px;">
                    Estudio gratuito
                </span>

                <h1>Solicita tu estudio gratuito</h1>
                <p class="lead">Rellena el formulario y un asesor te contactará en menos de 24 horas.</p>

                @if(session('success'))
                    <div class="alert alert-success" data-aos="zoom-in">
                        <i class="fa-solid fa-circle-check" style="margin-right:8px;"></i> {{ session('success') }}
                        <a href="{{ route('home') }}" style="color: var(--green-dark); font-weight: 800; margin-left: 8px;">Volver al inicio</a>
                    </div>
                @else

                    @if($errors->any())
                        <div class="alert alert-danger" data-aos="zoom-in">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('leads.store') }}" id="leadForm" novalidate>
                        @csrf

                        
                        <div class="form-section-title">
                            <i class="fa-solid fa-user" style="margin-right:8px;"></i> Datos personales
                        </div>
                        <div class="form-row">
                            <div>
                                <label for="first_name" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                       value="{{ old('first_name') }}" required>
                            </div>
                            <div>
                                <label for="last_name" class="form-label">Apellidos *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                       value="{{ old('last_name') }}" required>
                            </div>
                            <div>
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email') }}" required>
                            </div>
                            <div>
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="phone" name="phone"
                                       value="{{ old('phone') }}">
                            </div>
                        </div>

                        
                        <div class="form-section-title" style="margin-top: 30px;">
                            <i class="fa-solid fa-house" style="margin-right:8px;"></i> Datos de la vivienda
                        </div>
                        <div class="form-row">
                            <div class="third">
                                <label for="postal_code" class="form-label">Código postal *</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code"
                                       value="{{ old('postal_code') }}" maxlength="5" required>
                            </div>
                            <div style="flex: 2 1 calc(66.666% - 15px); min-width: 250px;">
                                <label for="property_type" class="form-label">Tipo de inmueble *</label>
                                <select class="form-select" id="property_type" name="property_type" required>
                                    <option value="">Selecciona...</option>
                                    @foreach(\App\Enums\PropertyType::cases() as $type)
                                        <option value="{{ $type->value }}" @selected(old('property_type') === $type->value)>
                                            {{ $type->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="full">
                                <label for="address" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="address" name="address"
                                       value="{{ old('address') }}">
                            </div>
                            <div>
                                <label for="city" class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                            </div>
                            <div>
                                <label for="province" class="form-label">Provincia</label>
                                <input type="text" class="form-control" id="province" name="province" value="{{ old('province') }}">
                            </div>
                            <div class="third">
                                <label for="area_m2" class="form-label">Superficie (m²)</label>
                                <input type="text" class="form-control" id="area_m2" name="area_m2" value="{{ old('area_m2') }}">
                            </div>
                            <div class="third">
                                <label for="year_built" class="form-label">Año de construcción</label>
                                <input type="text" class="form-control" id="year_built" name="year_built"
                                       value="{{ old('year_built') }}" maxlength="4">
                            </div>
                            <div class="third">
                                <label for="access_type" class="form-label">Tipo de acceso</label>
                                <select class="form-select" id="access_type" name="access_type">
                                    <option value="">Selecciona...</option>
                                    @foreach(\App\Enums\AccessType::cases() as $type)
                                        <option value="{{ $type->value }}" @selected(old('access_type') === $type->value)>
                                            {{ $type->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input type="checkbox" id="has_attic" name="has_attic" value="1" @checked(old('has_attic'))>
                                    <label for="has_attic">¿Tiene buhardilla/ático?</label>
                                </div>
                            </div>
                            <div>
                                <div class="form-check">
                                    <input type="checkbox" id="has_basement" name="has_basement" value="1" @checked(old('has_basement'))>
                                    <label for="has_basement">¿Tiene sótano?</label>
                                </div>
                            </div>
                            <div class="full">
                                <label for="message" class="form-label">Mensaje (opcional)</label>
                                <textarea class="form-control" id="message" name="message" rows="4">{{ old('message') }}</textarea>
                            </div>

                            @if(request('service_id'))
                                <input type="hidden" name="service_id" value="{{ request('service_id') }}">
                            @endif

                            <div class="full">
                                <div class="form-check" style="margin-bottom: 15px;">
                                    <input type="checkbox" id="privacy" name="privacy" value="1" required>
                                    <label for="privacy">Acepto la <a href="{{ route('legal.privacy') }}" target="_blank" style="color: var(--green); text-decoration: underline;">política de privacidad</a> *</label>
                                </div>
                                <button type="submit" class="btn-submit">
                                    Enviar solicitud <i class="fa-solid fa-arrow-right" style="margin-left:8px;"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </section>

@endsection
