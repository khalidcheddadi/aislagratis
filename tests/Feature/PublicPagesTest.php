<?php

use App\Enums\UserRole;
use App\Models\CoverageArea;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Cache;

test('home page matches the standalone reference design and links to Laravel routes', function () {
    $response = $this->get(route('home'));

    $response
        ->assertOk()
        ->assertSee('<html lang="es" class="scroll-smooth">', false)
        ->assertSee('Plus Jakarta Sans')
        ->assertSee('Aísla tu tejado')
        ->assertSee('id="about"', false)
        ->assertSee('id="services"', false)
        ->assertSee('id="mapa-norte"', false)
        ->assertSee('id="cae"', false)
        ->assertSee('id="materiales"', false)
        ->assertSee('id="testimonials"', false)
        ->assertSee('id="requisitos"', false)
        ->assertSee('id="faq"', false)
        ->assertSee('id="contact"', false)
        ->assertSee('Programa oficial CAE')
        ->assertSee('Más confort en casa.')
        ->assertSee('Menos energía que se pierde.')
        ->assertSee('ESTUDIO TÉCNICO')
        ->assertSee('Empieza con el estudio técnico')
        ->assertSee('Visitamos tu vivienda y validamos el ahorro energético antes de comenzar cualquier actuación.')
        ->assertSee('GESTIÓN CAE')
        ->assertSee('Gestión completa del expediente CAE')
        ->assertSee('Tramitamos toda la documentación, ejecutamos la obra y obtenemos la validación final exigida por el sistema oficial.')
        ->assertSee('EJECUCIÓN')
        ->assertSee('Actuamos en desván o bajo cubierta')
        ->assertSee('Es donde más ahorro energético se genera. Reduce pérdidas, mejora el confort y genera el ahorro necesario.')
        ->assertSee('La elegibilidad, la financiación aplicable y la disponibilidad dependen')
        ->assertSee('https://www.miteco.gob.es/es/energia/eficiencia/cae.html#accordion-6c9ad09474-item-30e76c36b0', false)
        ->assertSee('target="_blank" rel="noopener noreferrer"', false)
        ->assertSee('Nuestros sistemas de aislamiento')
        ->assertSee('Soluciones técnicas adaptadas a cada tipo de vivienda y cubierta, ejecutadas por nuestro propio equipo.')
        ->assertSee('id="carouselTrack"', false)
        ->assertSee('id="proceso-cae"', false)
        ->assertSee('#main > section { padding-inline: clamp(1rem, 3vw, 2rem); }', false)
        ->assertSee('video/AislaGratis_video_web.mp4', false)
        ->assertSee('video/AislaGratis_Premium_Cinematic.mp4', false)
        ->assertSee('id="howItWorksButton"', false)
        ->assertSee('Cómo funciona')
        ->assertSee('id="howItWorksDialog"', false)
        ->assertSee('data-src="'.asset('video/AislaGratis_Premium_Cinematic.mp4').'"', false)
        ->assertSee('id="howItWorksVideo"', false)
        ->assertSee('id="howItWorksPlaybackNotice"', false)
        ->assertSee('aria-label="Volver a la página principal"', false)
        ->assertSee('video/aislagratis_video_vertical.mp4', false)
        ->assertSee('video/WhatsApp Video 2026-10-29 at 16.41.41.mp4', false)
        ->assertSee('<video class="absolute inset-0 w-full h-full', false)
        ->assertSee('preload="none"', false)
        ->assertSee('images/instalacion-aislamiento-01.jpeg', false)
        ->assertSee('image7c-640.webp', false)
        ->assertSee('images/user1.jpg', false)
        ->assertSee('image2-640.webp', false)
        ->assertSee('image5c-640.webp', false)
        ->assertSee('image11-640.webp', false)
        ->assertSee('+34 641 322 118')
        ->assertSee('tel:+34641322118', false)
        ->assertSee('https://wa.me/34641322118', false)
        ->assertSee(route('leads.create'), false)
        ->assertSee(route('services.index'), false)
        ->assertDontSee('aerotermia')
        ->assertDontSee('placas solares')
        ->assertDontSee('Paneles instalados');

    $html = $response->getContent();
    expect($html)
        ->toContain('avatarEl.src = item.avatar;')
        ->toContain('avatarEl.alt = `Foto de ${item.author}`;');

    preg_match('/const carouselData = \[(.*?)\];\s*const track/s', $html, $lowerCarousel);
    preg_match('/const aboutData = \[(.*?)\];\s*let aboutIdx/s', $html, $upperCarousel);

    expect(substr_count($html, 'video/AislaGratis_video_web.mp4'))->toBe(2)
        ->and(substr_count($upperCarousel[1] ?? '', 'video:'))->toBe(4)
        ->and($upperCarousel[1] ?? '')->not->toContain('img:')
        ->and(substr_count($lowerCarousel[1] ?? '', 'img:'))->toBe(3)
        ->and($lowerCarousel[1] ?? '')->toContain('images/instalacion-aislamiento-05.jpeg');

    expect(strpos($html, 'id="aboutTrack"'))
        ->toBeLessThan(strpos($html, 'id="proceso-cae"'))
        ->toBeLessThan(strpos($html, 'id="carouselTrack"'));
});

test('home map shows all listed cities as covered', function () {
    CoverageArea::query()->create([
        'postal_code' => '41001',
        'city' => 'Sevilla',
        'province' => 'Sevilla',
        'is_covered' => true,
    ]);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('id="spainNorthMap"', false)
        ->assertSee('id="cityCount"', false)
        ->assertSee('id="cityCount">54</span>', false)
        ->assertSee('"name":"Madrid"', false)
        ->assertSee('"name":"Eibar"', false)
        ->assertSee('De Madrid al norte')
        ->assertSee('Bilbao')
        ->assertDontSee('Sevilla');
});

test('home page displays the five reference testimonials and their photos', function () {
    $response = $this->get(route('home'))
        ->assertOk()
        ->assertSee('05 / 05')
        ->assertSee('9.7 / 10');

    preg_match('/const data = (\[.*?\]);/s', $response->getContent(), $matches);
    expect($matches)->toHaveKey(1);

    $testimonials = json_decode($matches[1], true, 512, JSON_THROW_ON_ERROR);
    expect($testimonials)->toHaveCount(5)
        ->and(array_column($testimonials, 'author'))->toBe([
            'José Miguel R.',
            'María López',
            'Antonio García',
            'Lucía Fernández',
            'Carlos Méndez',
        ])
        ->and(array_column($testimonials, 'saving'))->toBe(['70%', '64%', '72%', '68%', '66%'])
        ->and(array_map(
            static fn (array $testimonial) => basename(parse_url($testimonial['avatar'], PHP_URL_PATH)),
            $testimonials,
        ))->toBe(['user1.jpg', 'CHICA5.jpg', 'user3.avif', 'user7.avif', 'user5.jpg']);
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

    expect(Cache::has('public.sitemap.xml'))->toBeTrue();
});

test('security headers are applied to web and API responses', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

    $this->getJson('/api/v1/auth/me')
        ->assertUnauthorized()
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN');
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
        ->assertSee('insuflado-mecanico-640.webp', false)
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
        ->assertSee('aislamiento-cubierta-instalado-640.webp', false)
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
            ->assertSee('brand-experience', false)
            ->assertSee('class="shared-site-header"', false)
            ->assertSee('css/shared-site-header.css', false)
            ->assertSee('css/brand-experience.css', false)
            ->assertSee('css/dark-immersive.css', false);
    }

    $this->get(route('login'))
        ->assertOk()
        ->assertSee('aislamiento-cubierta-instalado-640.webp', false);

    $this->get(route('register'))
        ->assertOk()
        ->assertSee('colocacion-lana-mineral-640.webp', false);
});

test('about, services, login, and register use their tailored homepage-inspired redesigns', function () {
    foreach ([
        'about' => 'brand-about',
        'services.index' => 'brand-services',
        'login' => 'brand-login',
        'register' => 'brand-register',
    ] as $route => $pageClass) {
        $this->get(route($route))
            ->assertOk()
            ->assertSee('css/brand-pages.css', false)
            ->assertSee($pageClass, false)
            ->assertSee('home-navbar.css', false);
    }

    $this->get(route('about'))
        ->assertSee('<h1>Especialistas en aislamiento de áticos</h1>', false)
        ->assertSee('aislamiento-cubierta-instalado.jpg', false);

    $this->get(route('services.index'))
        ->assertSee('<h1 class="services-title">Aislamiento<br>y gestión CAE</h1>', false)
        ->assertSee('insuflado-mecanico.jpg', false)
        ->assertSee('colocacion-lana-mineral.jpg', false);
});

test('all public content pages inherit the homepage visual theme', function () {
    foreach (['coverage', 'faq', 'legal.cookies', 'legal.privacy', 'legal.terms', 'leads.create'] as $route) {
        $this->get(route($route))
            ->assertOk()
            ->assertSee('class="brand-experience"', false)
            ->assertSee('css/site-theme.css', false)
            ->assertSee('class="shared-site-header"', false);
    }
});

test('study request page presents the CAE eligibility questionnaire and submits to lead storage', function () {
    $this->get(route('leads.create'))
        ->assertOk()
        ->assertSee('¿Tu vivienda puede <span>beneficiarse de los CAE?</span>', false)
        ->assertSee('¿Eres propietario de la vivienda?')
        ->assertSee('¿Qué zona quieres aislar?')
        ->assertSee('¿Cómo se accede al desván o bajo cubierta?')
        ->assertSee('¿El desván es habitable?')
        ->assertSee('Antigüedad aproximada del inmueble')
        ->assertSee('¿Has recibido ayudas o realizado actuaciones de aislamiento')
        ->assertSee('id="eligibilityForm" method="POST" action="'.route('leads.store').'"', false)
        ->assertSee('name="first_name"', false)
        ->assertSee('name="email"', false)
        ->assertSee('name="postal_code"', false)
        ->assertSee('name="property_type"', false)
        ->assertSee('name="privacy"', false)
        ->assertSee('css/eligibility-study.css', false)
        ->assertSee('js/eligibility-study.js', false)
        ->assertSee('home-nav-promo-content', false)
        ->assertSee('home-mobile-promo', false)
        ->assertSee('aislamiento-cubierta-instalado-640.webp', false)
        ->assertSee('Evaluación gratuita · Sin compromiso')
        ->assertDontSee('id="leadForm"', false);
});

test('the shared homepage navbar links to every public section from every public page', function () {
    $destinations = [
        'home',
        'services.index',
        'coverage',
        'about',
        'faq',
        'leads.create',
        'legal.privacy',
        'legal.terms',
        'legal.cookies',
        'login',
        'register',
    ];

    foreach (['home', 'services.index', 'about', 'coverage', 'faq', 'legal.cookies', 'leads.create', 'login', 'register'] as $page) {
        $response = $this->get(route($page))->assertOk();

        foreach ($destinations as $destination) {
            $response->assertSee(route($destination), false);
        }

        $response->assertSee('home-nav-shell', false)
            ->assertSee('home-navbar.css', false);
    }

    $this->get(route('leads.thanks'))
        ->assertOk()
        ->assertSee('class="shared-site-header"', false)
        ->assertSee('home-nav-shell', false);
});

test('home and public pages share cookie, install, footer, and icon branding', function () {
    foreach (['home', 'services.index', 'about', 'coverage', 'faq', 'legal.cookies', 'leads.create', 'login', 'register'] as $page) {
        $this->get(route($page))
            ->assertOk()
            ->assertSee('id="cookieConsentBanner"', false)
            ->assertSee('id="installPrompt"', false)
            ->assertSee('class="brand-footer"', false)
            ->assertSee('class="home-nav-brand-icon"', false)
            ->assertSee('css/shared-public-ui.css', false)
            ->assertSee('js/site-prompts.js', false);
    }

    $this->get(route('home'))
        ->assertSee('rel="manifest"', false)
        ->assertSee('aislagratis en tu dispositivo')
        ->assertSee('data-consent-url="'.route('cookie.consent').'"', false)
        ->assertSee('meta name="csrf-token"', false);
});

test('authenticated, profile, and guest pages use the shared theme', function () {
    $this->get(route('password.request'))
        ->assertOk()
        ->assertSee('guest-shell', false)
        ->assertSee('css/site-theme.css', false)
        ->assertSee('home-nav-shell', false)
        ->assertSee('home-navbar.css', false);

    $this->seed(RolesAndPermissionsSeeder::class);
    $admin = User::factory()->admin()->create();
    $admin->assignRole(UserRole::ADMIN->value);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee('site-admin', false)
        ->assertSee('css/site-theme.css', false);

    $this->get(route('profile.edit'))
        ->assertOk()
        ->assertSee('app-shell', false)
        ->assertSee('css/site-theme.css', false);
});

test('services page omits the hero copyright and social links', function () {
    $this->get(route('services.index'))
        ->assertOk()
        ->assertDontSee('© '.date('Y').' aislagratis. Todos los derechos reservados.')
        ->assertDontSee('class="hero-footer"', false)
        ->assertDontSee('class="social-icons"', false);
});

test('coverage page presents a searchable directory of homepage map cities', function () {
    $response = $this->get(route('coverage'));

    $response
        ->assertOk()
        ->assertSee('Áreas de cobertura')
        ->assertSee('Tu ciudad.')
        ->assertSee('Encuentra tu ciudad')
        ->assertSee('id="coverage-city-search"', false)
        ->assertSee('Solicitar estudio gratuito')
        ->assertSee('A Coruña')
        ->assertSee('Eibar')
        ->assertDontSee('Áreas con código postal confirmado')
        ->assertDontSee('28001');

    expect(substr_count($response->getContent(), 'class="coverage-city-card"'))->toBe(54);
});

test('coverage page excludes postal-code areas from its city directory', function () {
    CoverageArea::query()->create([
        'postal_code' => '28001',
        'city' => 'Madrid',
        'province' => 'Madrid',
        'is_covered' => true,
    ]);

    $this->get(route('coverage'))
        ->assertOk()
        ->assertSee('Madrid')
        ->assertDontSee('28001')
        ->assertDontSee('Áreas con código postal confirmado');
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
