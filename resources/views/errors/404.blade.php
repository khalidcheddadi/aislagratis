@extends('layouts.public')

@section('title', 'Página no encontrada - aislagratis')
@section('meta_description', 'La página que buscas no está disponible.')

@section('content')
    <main class="container" role="main">
        <section aria-labelledby="error-title">
            <p>404</p>
            <h1 id="error-title">No encontramos esta página</h1>
            <p>Es posible que el enlace haya cambiado o que la dirección no sea correcta.</p>
            <a href="{{ route('home') }}">Volver al inicio</a>
        </section>
    </main>
@endsection
