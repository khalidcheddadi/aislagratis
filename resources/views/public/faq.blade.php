@extends('layouts.public')

@section('title', 'Preguntas frecuentes - aislagratis')
@section('meta_description', 'Resuelve tus dudas sobre el aislamiento de áticos y bajo cubierta, la lana mineral y los requisitos orientativos del programa CAE.')

@push('styles')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    .page-banner { padding: 60px 0 40px; background: var(--white); position: relative; text-align: center; }
    .page-banner h1 { font-size: 42px; font-weight: 700; margin-bottom: 15px; letter-spacing: -0.5px; font-family: 'Poppins', sans-serif; }
    .page-banner p { color: #666; max-width: 600px; margin: 0 auto; font-size: 16px; line-height: 1.8; font-family: 'Poppins', sans-serif; }
    .page-banner .subtitle {
        color: var(--accent);
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        display: inline-block;
        margin-bottom: 10px;
        position: relative;
        padding-left: 30px;
        font-family: 'Poppins', sans-serif;
    }
    .page-banner .subtitle::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 2px;
        background: var(--accent);
        border-radius: 2px;
    }

    .faq-section { padding: 80px 0; background: var(--white); font-family: 'Poppins', sans-serif; }
    .faq-section .section-header { display: flex; justify-content: center; text-align: center; margin-bottom: 60px; flex-wrap: wrap; gap: 20px; }
    .faq-section .section-header h2 { font-size: 40px; font-weight: 700; letter-spacing: -0.5px; font-family: 'Poppins', sans-serif; }
    .faq-list { max-width: 800px; margin: 0 auto; }
    .faq-item { border: 1px solid rgba(0,0,0,0.06); border-radius: 15px; margin-bottom: 10px; background: var(--white); overflow: hidden; transition: box-shadow 0.3s; }
    .faq-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .faq-question {
        padding: 20px 25px;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        font-size: 16px;
        font-family: 'Poppins', sans-serif;
    }
    .faq-question i { transition: transform 0.3s; color: #294738; }
    .faq-answer { padding: 0 25px 20px; color: #666; display: none; line-height: 1.8; font-family: 'Poppins', sans-serif; }
    .faq-item.active .faq-answer { display: block; }
    .faq-item.active .faq-question i { transform: rotate(180deg); }

    .final-cta { background: white; padding: 80px 0; text-align: center; font-family: 'Poppins', sans-serif; }
    .final-cta h2 { font-size: 36px; margin-bottom: 15px; color: black; font-family: 'Poppins', sans-serif; }
    .final-cta p { color: #7b7b7b; max-width: 600px; margin: 0 auto 30px; font-family: 'Poppins', sans-serif; }
    .btn-accent-cta {
        display: inline-block;
        padding: 16px 40px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 500;
        font-size: 18px;
        background: var(--accent);
        color: #222;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
    }
    .btn-accent-cta:hover { background: #e0910d; color: #222; }

    @media (max-width: 992px) {
        .page-banner h1 { font-size: 34px; }
        .faq-section .section-header h2 { font-size: 32px; }
    }
    @media (max-width: 768px) {
        .page-banner h1 { font-size: 28px; }
        .faq-section .section-header h2 { font-size: 26px; }
    }
    @media (max-width: 576px) {
        .page-banner { padding: 40px 0 30px; }
        .page-banner h1 { font-size: 24px; }
    }
</style>
@endpush

@section('content')

    <header class="custom-header" style="padding: 20px 25px;">
        @include('partials.public-header')
    </header>

    <main>
        
        <section class="page-banner">
            <div class="container">
                <span class="subtitle" data-aos="fade-up">FAQ</span>
                <h1 data-aos="fade-up" data-aos-delay="100">Preguntas frecuentes</h1>
                <p data-aos="fade-up" data-aos-delay="200">Resolvemos tus dudas sobre el aislamiento térmico y el programa CAE.</p>
            </div>
        </section>

        
        <section id="faq" class="faq-section">
            <div class="container">
                <div class="section-header" data-aos="fade-up">
                    <div>
                        <span class="subtitle" style="color: var(--accent);">¿Tienes dudas?</span>
                        <h2>Preguntas frecuentes</h2>
                    </div>
                </div>

                @if($faqs->isEmpty())
                    <div style="text-align:center;" data-aos="fade-up" data-aos-delay="100">
                        <p style="color: #666; font-size: 16px;">No hay preguntas frecuentes disponibles en este momento.</p>
                    </div>
                @else
                    <div class="faq-list" data-aos="fade-up" data-aos-delay="100">
                        @foreach($faqs as $faq)
                            <div class="faq-item">
                                <button class="faq-question">
                                    {{ $faq->question }}
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div style="text-align: center; margin-top: 50px;" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('leads.create') }}" style="display: inline-block; padding: 12px 24px; border-radius: 30px; background: #294738; color: #fff; text-decoration: none; font-weight: 500; font-family: 'Poppins', sans-serif;">
                        ¿Tienes más preguntas? Solicita información <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>

        
        <section class="final-cta" id="contacto" data-aos="zoom-in">
            <div class="container">
                <h2>¿Listo para mejorar tu hogar?</h2>
                <p>Solicita tu estudio gratuito y descubre cuánto puedes ahorrar con el programa CAE.</p>
                <a href="{{ route('leads.create') }}" class="btn-accent-cta">
                    Empezar ahora <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </section>
    </main>

@endsection
