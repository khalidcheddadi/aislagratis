@extends('layouts.public')

@section('title', 'Política de cookies - aislagratis')
@section('meta_description', 'Información sobre las cookies y el almacenamiento local utilizados por aislagratis y cómo gestionar tus preferencias.')

@push('styles')
    <style>
        .cookie-policy { padding: 4rem 0; }
        .cookie-policy h1 { margin-bottom: 1rem; }
        .cookie-policy h2 { margin: 2rem 0 0.75rem; color: var(--green-dark); font-size: 1.35rem; }
        .cookie-policy p, .cookie-policy li { color: var(--gray-600); }
        .cookie-policy ul { padding-left: 1.25rem; }
    </style>
@endpush

@section('content')
    <main class="cookie-policy container">
        <h1>Política de cookies</h1>
        <p>Esta página explica el uso de cookies y del almacenamiento local en el sitio web de aislagratis.</p>

        <h2>Almacenamiento necesario para el servicio</h2>
        <p>
            Laravel utiliza cookies técnicas para mantener la sesión y proteger los formularios frente a solicitudes
            no autorizadas. Estas cookies son necesarias para que el sitio y las funciones de cuenta puedan operar.
        </p>

        <h2>Preferencias de consentimiento</h2>
        <p>
            El sitio guarda en el almacenamiento local del navegador tu elección sobre cookies durante un máximo de
            12 meses y utiliza un identificador aleatorio para registrar esa elección en el servidor. El registro
            puede incluir la dirección IP, el navegador y, cuando se puede resolver, el país y la ciudad asociados
            a la solicitud.
        </p>

        <h2>Cómo cambiar o retirar tu elección</h2>
        <p>
            Puedes borrar los datos del sitio desde la configuración de tu navegador. Si vuelves a visitar el sitio,
            aparecerá de nuevo el aviso de consentimiento para que puedas registrar una elección actualizada.
        </p>

        <h2>Más información</h2>
        <p>
            Para saber cómo tratamos los datos personales relacionados con las solicitudes y el registro de
            preferencias, consulta nuestra <a href="{{ route('legal.privacy') }}">política de privacidad</a>.
        </p>
    </main>
@endsection
