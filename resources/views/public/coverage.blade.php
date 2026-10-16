@extends('layouts.public')

@section('title', 'Áreas de cobertura - aislagratis')
@section('meta_description', 'Consulta las ciudades y provincias donde aislagratis ofrece sus servicios de mejora energética.')

@push('styles')
    <style>
        .coverage-page { padding: 4rem 0; }
        .coverage-page h1 { margin-bottom: 1rem; }
        .coverage-intro { max-width: 720px; margin-bottom: 2rem; color: var(--gray-600); }
        .coverage-provinces { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem; }
        .coverage-province { padding: 1.5rem; border: 1px solid var(--border-light); border-radius: 16px; background: var(--white); box-shadow: var(--shadow-sm); }
        .coverage-province h2 { margin-bottom: 1rem; color: var(--green-dark); font-size: 1.25rem; }
        .coverage-cities { margin: 0; padding-left: 1.25rem; }
        .coverage-cities li + li { margin-top: 0.5rem; }
        .coverage-empty { padding: 1.5rem; border-radius: 16px; background: var(--green-50); }
    </style>
@endpush

@section('content')
    <main class="coverage-page container">
        <h1>Áreas de cobertura</h1>
        <p class="coverage-intro">
            Consulta las localidades en las que prestamos nuestros servicios. Si no encuentras tu ciudad,
            ponte en contacto con nuestro equipo para confirmar la disponibilidad.
        </p>

        @if ($areas->isEmpty())
            <p class="coverage-empty">Estamos actualizando nuestras áreas de cobertura. Contacta con nosotros para consultar la disponibilidad en tu zona.</p>
        @else
            <div class="coverage-provinces">
                @foreach ($areas as $province => $provinceAreas)
                    <section class="coverage-province" aria-labelledby="province-{{ \Illuminate\Support\Str::slug($province) }}">
                        <h2 id="province-{{ \Illuminate\Support\Str::slug($province) }}">{{ $province }}</h2>
                        <ul class="coverage-cities">
                            @foreach ($provinceAreas as $area)
                                <li>
                                    {{ $area->city }}
                                    @if ($area->postal_code)
                                        <span>({{ $area->postal_code }})</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endforeach
            </div>
        @endif
    </main>
@endsection
