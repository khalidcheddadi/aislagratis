@extends('layouts.public')

@section('title', 'Error del servidor - aislagratis')
@section('meta_description', 'Se ha producido un error temporal. Inténtalo de nuevo más tarde.')

@section('content')
    <main class="container" role="main">
        <section aria-labelledby="error-title">
            <p>500</p>
            <h1 id="error-title">No hemos podido completar la solicitud</h1>
            <p>Ha ocurrido un error temporal. Inténtalo de nuevo más tarde.</p>
            <a href="{{ route('home') }}">Volver al inicio</a>
        </section>
    </main>
@endsection
