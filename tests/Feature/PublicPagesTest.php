<?php

use App\Models\CoverageArea;
use Illuminate\Support\Facades\Cache;

test('home page presents the CAE introduction as a link to the official MITECO information', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('programa CAE')
        ->assertSee('aislagratis')
        ->assertSee('+34 641 322 118')
        ->assertSee('tel:+34641322118', false)
        ->assertSee('https://wa.me/34641322118', false)
        ->assertSee('Información oficial en MITECO')
        ->assertSee('href="https://www.miteco.gob.es/es/energia/eficiencia/cae.html#accordion-6c9ad09474-item-30e76c36b0"', false)
        ->assertSee('La elegibilidad, la financiación aplicable y la disponibilidad', false)
        ->assertSee('Insuflado mecánico')
        ->assertSee('Unifamiliar y con más de 5 años')
        ->assertSee('class="brand-experience brand-home"', false)
        ->assertSee('css/brand-experience.css', false)
        ->assertSee('css/dark-immersive.css', false)
        ->assertSee('Real Decreto 36/2023')
        ->assertSee('más de 5 años')
        ->assertSee('image7-640.webp', false)
        ->assertDontSee('aerotermia')
        ->assertDontSee('placas solares')
        ->assertDontSee('Paneles instalados')
        ->assertDontSee('No sabíamos si podíamos beneficiarnos');
});

test('robots and sitemap endpoints are available to search engines', function () {
    $this->get(route('robots'))
        ->assertOk()
        ->assertSee('Sitemap: '.route('sitemap'), false)
        ->assertSee('Disallow: /admin/', false)
        ->assertSee('Disallow: /mi-cuenta/', false);

    $this->get(route('sitemap'))
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml')
        ->assertSee(route('home'), false)
        ->assertSee(route('services.index'), false);
});

test('account and conversion pages are excluded from search results', function () {
    foreach (['login', 'register', 'leads.thanks'] as $route) {
        $this->get(route($route))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow">', false);
    }
});

test('services page describes only attic insulation and conditional CAE support', function () {
    $this->get(route('services.index'))
        ->assertOk()
        ->assertSee('Lana de roca para cubierta')
        ->assertSee('Insuflado mecánico')
        ->assertSee('Estudio y gestión CAE')
        ->assertSee('image6-640.webp', false)
        ->assertSee('No se garantiza la aprobación')
        ->assertSee('Real Decreto 36/2023')
        ->assertDontSee('Aislamiento de fachadas')
        ->assertDontSee('Suelos radiantes')
        ->assertDontSee('Ventanas eficientes');
});

test('about page uses real insulation work and avoids unsupported company statistics', function () {
    $this->get(route('about'))
        ->assertOk()
        ->assertSee('Aislamiento Rbay · aislagratis')
        ->assertSee('Especialistas en aislamiento de áticos')
        ->assertSee('lana de roca')
        ->assertSee('Real Decreto 36/2023')
        ->assertSee('image6-960.webp', false)
        ->assertSee('No se puede asegurar de antemano')
        ->assertDontSee('Más de 10 años')
        ->assertDontSee('500 proyectos')
        ->assertDontSee('Carlos García')
        ->assertDontSee('Endesa');
});

test('selected public and account pages use the dark brand experience', function () {
    foreach (['services.index', 'about', 'leads.create', 'login', 'register'] as $route) {
        $this->get(route($route))
            ->assertOk()
            ->assertSee('class="brand-experience"', false)
            ->assertSee('css/brand-experience.css', false)
            ->assertSee('css/dark-immersive.css', false);
    }

    $this->get(route('login'))
        ->assertOk()
        ->assertSee('image12-640.webp', false);

    $this->get(route('register'))
        ->assertOk()
        ->assertSee('image6-640.webp', false);
});

test('services page omits the hero copyright and social links', function () {
    $this->get(route('services.index'))
        ->assertOk()
        ->assertDontSee('© '.date('Y').' aislagratis. Todos los derechos reservados.')
        ->assertDontSee('class="hero-footer"', false)
        ->assertDontSee('class="social-icons"', false);
});

test('coverage page displays its empty state when no areas are available', function () {
    $this->get(route('coverage'))
        ->assertOk()
        ->assertSee('Áreas de cobertura')
        ->assertSee('Estamos actualizando nuestras áreas de cobertura.');
});

test('coverage page lists covered cities by province', function () {
    Cache::forget('coverage.areas.all');
    CoverageArea::query()->create([
        'postal_code' => '28001',
        'city' => 'Madrid',
        'province' => 'Madrid',
        'is_covered' => true,
    ]);

    $this->get(route('coverage'))
        ->assertOk()
        ->assertSee('Madrid')
        ->assertSee('28001');
});

test('cookie policy page is available', function () {
    $this->get(route('legal.cookies'))
        ->assertOk()
        ->assertSee('Política de cookies')
        ->assertSee('almacenamiento local del navegador');
});

test('unknown pages use the custom not found page and return a 404 status', function () {
    $this->get('/does-not-exist')
        ->assertNotFound()
        ->assertSee('No encontramos esta página')
        ->assertSee('Volver al inicio');
});
