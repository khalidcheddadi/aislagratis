@extends('layouts.public')

@section('title', 'Sesión caducada - aislagratis')
@section('meta_description', 'Tu sesión ha caducado. Vuelve a cargar la página para continuar.')

@section('content')
    <main class="container" role="main">
        <section aria-labelledby="error-title">
            <p>419</p>
            <h1 id="error-title">Tu sesión ha caducado</h1>
            <p>Vuelve a cargar la página e inténtalo de nuevo.</p>
            <a href="{{ route('home') }}">Volver al inicio</a>
        </section>
    </main>
@endsection
