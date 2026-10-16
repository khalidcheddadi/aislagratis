@extends('layouts.public')

@section('title', 'Gracias por tu solicitud')
@section('meta_robots', 'noindex, nofollow')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@section('content')

    <header class="custom-header" style="padding: 20px 25px;">
        @include('partials.public-header')
    </header>

    <div class="container" style="padding: 60px 25px; text-align: center; max-width: 900px; margin: 0 auto;">
        <i class="fa-solid fa-circle-check" style="color: #28a745; font-size: 5rem; margin-bottom: 25px; display: inline-block;"></i>
        <h1 style="font-weight: 900; font-size: 2.5rem; margin-bottom: 15px; text-transform: uppercase;">¡Gracias por tu solicitud!</h1>
        <p style="font-size: 1.2rem; color: var(--gray-600); margin-bottom: 15px;">
            Hemos recibido tus datos correctamente. Un asesor te contactará en menos de 24 horas laborables.
        </p>
        <p style="color: var(--gray-500); margin-bottom: 30px;">
            Si tienes urgencia, llámanos al <strong>{{ config('aislaplus.phone') }}</strong>.
        </p>
        <a href="{{ route('home') }}" class="cta-button" style="margin-bottom: 0;">Volver al inicio</a>
    </div>

@endsection
