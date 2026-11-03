@extends('layouts.public')

@section('title', 'Solicitar estudio CAE gratuito')
@section('meta_description', 'Comprueba si tu vivienda puede beneficiarse de los CAE y solicita una evaluación inicial gratuita, sin compromiso.')
@section('meta_robots', 'noindex, nofollow')

@push('page-styles')
    @vite('resources/css/public/eligibility-study.css')
@endpush

@push('scripts')
    @vite('resources/js/public/eligibility-study.js')
@endpush

@section('content')
    @include('partials.shared-site-header')

    <main class="eligibility-study-section">
        @if(session('success'))
            <section class="eligibility-page-success" role="status" aria-labelledby="eligibilitySuccessTitle">
                <span class="eligibility-page-success-icon"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                <span class="eligibility-page-eyebrow">Solicitud recibida</span>
                <h1 id="eligibilitySuccessTitle">Gracias por confiar en nosotros.</h1>
                <p>{{ session('success') }}</p>
                <a href="{{ route('home') }}" class="eligibility-page-submit">Volver al inicio <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            </section>
        @else
            @include('partials.eligibility-study-form')
        @endif
    </main>
@endsection
