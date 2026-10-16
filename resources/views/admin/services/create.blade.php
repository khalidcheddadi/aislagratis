@extends('layouts.admin')
@section('title', 'Nuevo servicio')
@section('content')
    <section class="admin-intro"><div class="admin-intro-copy"><span class="admin-eyebrow"><i class="fa-solid fa-bolt"></i> CATÁLOGO DE aislagratis</span><h1>Nuevo servicio</h1><p>Añade una solución al catálogo público.</p></div><div class="admin-intro-image"><img src="{{ asset('images/image12.jpg') }}" alt="Vivienda eficiente"></div></section>
    @include('admin.services._form', ['service' => null, 'isEdit' => false])
@endsection