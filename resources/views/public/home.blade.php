@php
    $testimonialData = [
        [
            'quote' => 'No pagué nada por la obra. El equipo de aislagratis se encargó del estudio, del expediente CAE y de la instalación. La casa ahora es otra cosa.',
            'author' => 'José Miguel R.',
            'role' => 'Propietario de unifamiliar',
            'city' => 'A Coruña',
            'saving' => '70%',
            'avatar' => asset('images/user1.jpg'),
        ],
        [
            'quote' => 'Pensaba que era demasiado bueno para ser verdad, pero se ocuparon de todo. Sin obras en casa y sin pagar absolutamente nada.',
            'author' => 'María López',
            'role' => 'Propietaria de unifamiliar',
            'city' => 'Bilbao',
            'saving' => '64%',
            'avatar' => asset('images/CHICA5.jpg'),
        ],
        [
            'quote' => 'El estudio técnico fue gratuito y en pocas semanas teníamos el aislamiento instalado y el expediente validado. Trato impecable.',
            'author' => 'Antonio García',
            'role' => 'Propietario de chalet',
            'city' => 'Zaragoza',
            'saving' => '72%',
            'avatar' => asset('images/user3.avif'),
        ],
        [
            'quote' => 'Vivo en el bajo cubierta y el cambio ha sido brutal: menos ruido, menos frío y la factura de la luz ha bajado casi a la mitad.',
            'author' => 'Lucía Fernández',
            'role' => 'Propietaria de casa adosada',
            'city' => 'Santander',
            'saving' => '68%',
            'avatar' => asset('images/user7.avif'),
        ],
        [
            'quote' => 'Me llamaron, hicieron el estudio y en tres días estaba todo instalado. Ni un solo papel tuve que firmar de más.',
            'author' => 'Carlos Méndez',
            'role' => 'Propietario de unifamiliar',
            'city' => 'Pamplona',
            'saving' => '66%',
            'avatar' => asset('images/user5.jpg'),
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>aislagratis™ — Aislamiento Térmico Sin Coste · Programa CAE</title>
    <meta name="description" content="Aislamiento de tejado sin coste para viviendas unifamiliares dentro del programa oficial CAE (Real Decreto 36/2023). Estudio técnico gratuito, gestión completa y ejecución rápida.">

    @include('partials.site-icons')
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="aislagratis">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/shared-site-header.css') }}?v={{ filemtime(public_path('css/shared-site-header.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/home-navbar.css') }}?v={{ filemtime(public_path('css/home-navbar.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/shared-public-ui.css') }}?v={{ filemtime(public_path('css/shared-public-ui.css')) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" />
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: {
                        brand: {
                            dark: '#0A161E',
                            card: '#14232E',
                            accent: '#2DD4BF',
                            lightBg: '#F8FAFC',
                            subtle: '#64748B',
                            teal: '#1A363B'
                        }
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.9s ease-out forwards',
                        'fade-in': 'fadeIn 1.2s ease-out forwards',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeUp: { '0%': { opacity: '0', transform: 'translateY(30px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } },
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        float: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-12px)' } }
                    }
                }
            }
        }
    </script>

    <style>
        .glass-panel {
            background: rgba(18, 38, 49, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 1s cubic-bezier(.16,1,.3,1), transform 1s cubic-bezier(.16,1,.3,1);
        }
        .reveal.in-view { opacity: 1; transform: translateY(0); }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }

        .nav-link { position: relative; }
        .nav-link::after {
            content: ''; position: absolute; left: 0; bottom: -2px;
            width: 0; height: 1px; background: currentColor;
            transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }

        .video-dialog {
            position: fixed;
            inset: 0;
            width: 100vw;
            height: 100vh;
            height: 100dvh;
            max-width: none;
            max-height: none;
            margin: 0;
            padding: 0;
            border: 0;
            color: white;
            background: #050b10;
        }
        .video-dialog[open] { display: grid; }
        .video-dialog::backdrop {
            background: rgba(5, 11, 16, 0.96);
            backdrop-filter: blur(12px);
        }
        .video-dialog video { outline: none; }

        .skip-link {
            position: absolute; left: 50%; top: -100px;
            transform: translateX(-50%);
            padding: 0.75rem 1.5rem;
            background: #0A161E; color: #fff;
            border-radius: 999px; font-weight: 600; font-size: 0.875rem;
            z-index: 9999; transition: top 0.3s ease;
        }
        .skip-link:focus { top: 1rem; outline: 2px solid #2DD4BF; }

        .custom-marker { display: flex; flex-direction: column; align-items: center; pointer-events: auto; }
        .marker-pulse {
            width: 12px; height: 12px; background: #2DD4BF; border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.7), 0 0 10px rgba(45, 212, 191, 0.7);
            animation: markerPulse 2s infinite; position: relative; z-index: 2;
            border: 1.5px solid rgba(255,255,255,0.9);
        }
        .marker-label {
            display: none;
            margin-top: 5px; background: rgba(10, 22, 30, 0.94);
            backdrop-filter: blur(8px); color: #fff;
            font-size: 9px; font-family: ui-monospace, "SFMono-Regular", Menlo, monospace;
            font-weight: 600; padding: 2px 8px; border-radius: 12px;
            border: 1px solid rgba(45, 212, 191, 0.4);
            white-space: nowrap; letter-spacing: 0.06em; text-transform: uppercase;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.5);
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            pointer-events: auto; cursor: pointer;
        }
        .custom-marker:hover .marker-label { display: block; }
        .marker-label:hover {
            background: #2DD4BF; color: #0A161E;
            border-color: #2DD4BF; transform: scale(1.08);
            letter-spacing: 0.1em;
            box-shadow: 0 4px 20px rgba(45, 212, 191, 0.4);
        }
        @keyframes markerPulse {
            0% { box-shadow: 0 0 0 0 rgba(45, 212, 191, 0.7), 0 0 10px rgba(45, 212, 191, 0.7); }
            70% { box-shadow: 0 0 0 12px rgba(45, 212, 191, 0), 0 0 10px rgba(45, 212, 191, 0.7); }
            100% { box-shadow: 0 0 0 0 rgba(45, 212, 191, 0), 0 0 10px rgba(45, 212, 191, 0.7); }
        }

        #cityList::-webkit-scrollbar { width: 4px; }
        #cityList::-webkit-scrollbar-track { background: transparent; }
        #cityList::-webkit-scrollbar-thumb { background: rgba(45, 212, 191, 0.25); border-radius: 4px; }
        #cityList::-webkit-scrollbar-thumb:hover { background: rgba(45, 212, 191, 0.55); }

        .carousel-3d-wrapper { perspective: 1200px; overflow: hidden; padding: 2rem 0; }
        .carousel-3d-track {
            position: relative; height: 480px;
            display: flex; align-items: center; justify-content: center;
            transform-style: preserve-3d;
        }
        .carousel-3d-slide {
            position: absolute; width: 100%; max-width: 760px; height: 420px;
            border-radius: 1.5rem; overflow: hidden; background-color: #0A161E;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            transition: all 0.7s cubic-bezier(0.25, 1, 0.5, 1);
            transform-origin: center center; opacity: 0; visibility: hidden;
        }
        .carousel-3d-slide.is-active {
            transform: translateX(0) scale(1); z-index: 30;
            opacity: 1; visibility: visible; filter: blur(0px);
        }
        .carousel-3d-slide.is-left {
            transform: translateX(-55%) scale(0.75) rotateY(15deg);
            z-index: 20; opacity: 0.5; visibility: visible;
            filter: blur(8px); pointer-events: none;
        }
        .carousel-3d-slide.is-right {
            transform: translateX(55%) scale(0.75) rotateY(-15deg);
            z-index: 20; opacity: 0.5; visibility: visible;
            filter: blur(8px); pointer-events: none;
        }
        .reveal-3d {
            opacity: 0; transform: translateY(100px) rotateX(15deg) scale(0.9);
            transition: opacity 1.2s cubic-bezier(0.34, 1.56, 0.64, 1), transform 1.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .reveal-3d.in-view { opacity: 1; transform: translateY(0) rotateX(0) scale(1); }

        .marquee-track { animation: marquee 40s linear infinite; width: max-content; }
        @keyframes marquee { from { transform: translateX(0); } to { transform: translateX(-50%); } }
        #main > section { padding-inline: clamp(1rem, 3vw, 2rem); }

        .mask-line {
            display: block; overflow: hidden;
            padding-bottom: 0.16em; margin-bottom: -0.16em;
            padding-top: 0.06em; margin-top: -0.06em;
        }
        .kinetic-line {
            display: inline-block; transform: translateY(130%);
            transition: transform 1.15s cubic-bezier(0.19, 1, 0.22, 1);
            transition-delay: var(--delay, 0ms);
        }
        .reveal.in-view .kinetic-line { transform: translateY(0); }

        .kinetic-gradient {
            background-size: 220% auto;
            animation: kineticGradient 4.5s ease-in-out infinite;
        }
        @keyframes kineticGradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .anim-up {
            opacity: 0; transform: translateY(24px);
            transition: opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1), transform 0.9s cubic-bezier(0.16, 1, 0.3, 1);
            transition-delay: var(--delay, 0ms);
        }
        .reveal.in-view .anim-up { opacity: 1; transform: translateY(0); }

        .cta-gradient-sweep {
            background-size: 220% auto;
            animation: kineticGradient 2.2s ease-in-out infinite;
        }

        .kinetic-header { position: relative; isolation: isolate; }
        .kinetic-spotlight {
            position: absolute; inset: -1rem; pointer-events: none;
            z-index: 0; border-radius: 2rem; will-change: background;
            background: radial-gradient(600px circle at 50% 30%, rgba(45, 212, 191, 0.06), transparent 55%);
        }
        .ghost-index {
            font-size: clamp(9rem, 20vw, 20rem);
            font-weight: 800; font-style: italic; line-height: 0.85;
            letter-spacing: -0.06em; color: rgba(148, 163, 184, 0.10);
            display: inline-block; user-select: none; will-change: transform;
            opacity: 0; transform: translateX(40px);
            transition: opacity 1.6s cubic-bezier(0.19, 1, 0.22, 1), transform 1.6s cubic-bezier(0.19, 1, 0.22, 1);
        }
        .reveal.in-view .ghost-index { opacity: 1; transform: translateX(0); }

        .heading-line {
            display: block;
            padding-top: 0.06em; margin-top: -0.06em;
            padding-bottom: 0.06em; margin-bottom: -0.06em;
        }
        .heading-line-underline { position: relative; display: inline-block; }

        .letter-3d {
            display: inline-block; position: relative;
            opacity: 0; transform-origin: center bottom;
            transform: translateY(0.15em) rotateX(-85deg) scale(0.95);
            transition: opacity 0.55s ease calc(var(--i, 0) * 42ms + 260ms),
                        transform 1.05s cubic-bezier(0.34, 1.56, 0.64, 1) calc(var(--i, 0) * 42ms + 260ms);
            will-change: transform, opacity; backface-visibility: hidden;
        }
        .reveal.in-view .letter-3d { opacity: 1; transform: translateY(0) rotateX(0) scale(1); }
        .letter-3d::after {
            content: attr(data-char); position: absolute; top: 0; left: 0;
            color: #2DD4BF; opacity: 0;
            transition: opacity 0.35s ease, transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform: translate(0, 0); pointer-events: none; z-index: -1;
        }
        .letter-3d.magnetic:hover::after { opacity: 0.55; transform: translate(6px, 6px); }

        .heading-underline {
            position: absolute; left: 0; bottom: -0.08em;
            width: 100%; height: 14px; overflow: visible; pointer-events: none;
        }
        .heading-underline path {
            stroke-dasharray: 1; stroke-dashoffset: 1;
            transition: stroke-dashoffset 2s cubic-bezier(0.19, 1, 0.22, 1) 1200ms;
        }
        .reveal.in-view .heading-underline path { stroke-dashoffset: 0; }

        .shimmer-badge {
            position: relative; display: inline-flex; align-items: center; gap: 8px; overflow: hidden;
            border: 1px solid rgba(148, 163, 184, 0.4); background: #fff; border-radius: 999px;
            padding: 6px 14px; font-size: 10px; font-weight: 700;
            letter-spacing: 0.22em; text-transform: uppercase; color: #334155;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04); white-space: nowrap;
        }
        .badge-dot {
            position: relative; width: 6px; height: 6px; border-radius: 50%;
            background: #2DD4BF; flex-shrink: 0;
        }
        .badge-dot::before {
            content: ''; position: absolute; inset: 0; border-radius: 50%;
            background: #2DD4BF; opacity: 0.6;
            animation: badgeDotPing 1.8s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        @keyframes badgeDotPing {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(2.5); opacity: 0; }
        }
        .badge-shimmer {
            position: absolute; inset: 0;
            background: linear-gradient(90deg, transparent, rgba(148, 163, 184, 0.5), transparent);
            animation: badgeShimmer 3.2s ease-in-out infinite; pointer-events: none;
        }
        @keyframes badgeShimmer {
            0% { transform: translateX(-100%); }
            55% { transform: translateX(220%); }
            100% { transform: translateX(220%); }
        }

        .meta-index {
            display: flex; align-items: center; gap: 10px;
            font-size: 10px; font-family: ui-monospace, "SFMono-Regular", Menlo, monospace;
            letter-spacing: 0.3em; color: #94a3b8; text-transform: uppercase;
            font-variant-numeric: tabular-nums; white-space: nowrap;
        }
        .meta-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: #2DD4BF; box-shadow: 0 0 8px rgba(45, 212, 191, 0.6);
            animation: metaPulse 2s ease-in-out infinite; flex-shrink: 0;
        }
        @keyframes metaPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(0.85); }
        }

        .counter-num { color: #0A161E; font-weight: 700; display: inline-block; min-width: 2ch; }

        .kinetic-word {
            display: inline-block; opacity: 0;
            transform: translateY(18px) scale(0.92); filter: blur(5px);
            transition: opacity 0.55s ease calc(var(--i, 0) * 22ms + 500ms),
                        transform 0.85s cubic-bezier(0.34, 1.56, 0.64, 1) calc(var(--i, 0) * 22ms + 500ms),
                        filter 0.55s ease calc(var(--i, 0) * 22ms + 500ms);
            will-change: transform, opacity, filter;
        }
        .reveal.in-view .kinetic-word { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }

        .progress-strip { display: flex; align-items: center; gap: 8px; }
        .progress-segment {
            height: 4px; width: 8px; border-radius: 999px; background: #cbd5e1;
            transition: all 0.85s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .progress-segment.is-filled { width: 32px; background: #0A161E; }
        .progress-segment.is-filled:first-child { background: linear-gradient(90deg, #0A161E, #2DD4BF); }

        .bottom-line {
            transform: scaleX(0); transform-origin: left center;
            transition: transform 1.9s cubic-bezier(0.19, 1, 0.22, 1) 1100ms;
            background: linear-gradient(90deg, #0A161E 0%, #2DD4BF 60%, transparent 100%);
            height: 100%;
        }
        .reveal.in-view .bottom-line { transform: scaleX(1); }
        .bottom-line.is-dark {
            background: linear-gradient(90deg, #2DD4BF 0%, rgba(45,212,191,0.45) 55%, transparent 100%);
        }

        .tst-quote {
            transition: opacity .45s cubic-bezier(.16,1,.3,1),
                        transform .7s cubic-bezier(.16,1,.3,1),
                        filter .45s cubic-bezier(.16,1,.3,1);
            will-change: opacity, transform, filter;
        }
        .tst-quote.is-out { opacity: 0; transform: translateY(14px) scale(.985); filter: blur(6px); }

        .tst-header-seg {
            height: 3px; width: 9px; border-radius: 999px;
            background: rgba(255,255,255,.14);
            transition: width .85s cubic-bezier(.34,1.56,.64,1), background .85s ease;
        }
        .reveal.in-view .tst-header-seg { width: 30px; background: rgba(45,212,191,.85); }
        .reveal.in-view .tst-header-seg:nth-child(1) { transition-delay: .30s; }
        .reveal.in-view .tst-header-seg:nth-child(2) { transition-delay: .46s; }
        .reveal.in-view .tst-header-seg:nth-child(3) { transition-delay: .62s; }
        .reveal.in-view .tst-header-seg:nth-child(4) { transition-delay: .78s; }

        .tst-row { transition: background .45s ease; cursor: pointer; }
        .tst-row:hover { background: rgba(255,255,255,.03); }
        .tst-row.is-active {
            background: linear-gradient(90deg, rgba(45,212,191,.11), rgba(45,212,191,0) 78%);
        }
        .tst-row-bar {
            background: #2DD4BF; transform: scaleY(0); transform-origin: top center;
            transition: transform .6s cubic-bezier(.19,1,.22,1);
            box-shadow: 0 0 14px rgba(45,212,191,.7);
        }
        .tst-row.is-active .tst-row-bar { transform: scaleY(1); }
        .tst-row-name { transition: color .35s ease; }
        .tst-row.is-active .tst-row-name { color: #2DD4BF; }

        .tst-dot {
            height: 3px; width: 12px; border-radius: 999px;
            background: rgba(255,255,255,.16);
            transition: all .5s cubic-bezier(.34,1.56,.64,1);
            cursor: pointer; border: none; padding: 0;
        }
        .tst-dot:hover { background: rgba(255,255,255,.34); }
        .tst-dot.is-active { width: 38px; background: #2DD4BF; box-shadow: 0 0 14px rgba(45,212,191,.65); }

        .tst-avatar-pop { animation: tstAvatarPop .7s cubic-bezier(.34,1.56,.64,1); }
        @keyframes tstAvatarPop {
            0% { transform: scale(.82); opacity: .3; }
            100% { transform: scale(1); opacity: 1; }
        }

        #tstAutoplay {
            transform-origin: left center; transform: scaleX(0);
            background-image: linear-gradient(90deg, #2DD4BF, #5EEAD4, #2DD4BF);
            background-size: 200% auto;
        }

        .rq-spotlight {
            background: radial-gradient(620px circle at var(--rq-mx, 50%) var(--rq-my, 50%), rgba(45, 212, 191, 0.10), rgba(45, 212, 191, 0.02) 38%, transparent 72%);
            transition: background 0.5s cubic-bezier(0.19, 1, 0.22, 1);
            pointer-events: none; z-index: 1;
        }
        .rq-ghost { transition: transform 1.2s cubic-bezier(0.19, 1, 0.22, 1); will-change: transform; }
        .rq-head h2 .rq-line {
            display: block; opacity: 0;
            transform: translateY(60px) rotate(2deg);
            transition: opacity 1.1s cubic-bezier(0.19, 1, 0.22, 1), transform 1.3s cubic-bezier(0.19, 1, 0.22, 1);
        }
        .rq-head h2 .rq-line:nth-child(2) { transition-delay: 0.15s; }
        .rq-head.in-view h2 .rq-line { opacity: 1; transform: translateY(0) rotate(0); }
        .rq-underline path {
            stroke-dasharray: 1; stroke-dashoffset: 1;
            transition: stroke-dashoffset 1.6s cubic-bezier(0.19, 1, 0.22, 1) 1s;
        }
        .rq-head.in-view .rq-underline path { stroke-dashoffset: 0; }

        .req-stamp-rotator svg text {
            animation: rqRotate 26s linear infinite;
            transform-origin: 100px 100px;
        }
        @keyframes rqRotate { to { transform: rotate(360deg); } }
        .req-stamp-rotator { animation: rqFloat 6s ease-in-out infinite; }
        @keyframes rqFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .rq-bento { perspective: 1400px; }
        .rq-card {
            opacity: 0; translate: 0 60px; rotate: y -14deg; scale: 0.95;
            transition: opacity 1s cubic-bezier(0.19, 1, 0.22, 1),
                        translate 1.3s cubic-bezier(0.19, 1, 0.22, 1),
                        rotate 1.3s cubic-bezier(0.19, 1, 0.22, 1),
                        scale 1.3s cubic-bezier(0.19, 1, 0.22, 1),
                        box-shadow 0.4s ease;
            will-change: translate, rotate, scale, opacity;
        }
        .rq-card.in-view { opacity: 1; translate: 0 0; rotate: y 0deg; scale: 1; }
        .rq-card:hover { box-shadow: 0 24px 48px -12px rgba(10, 22, 30, 0.15), 0 4px 12px -4px rgba(10, 22, 30, 0.06); }

        .rq-stamp {
            opacity: 0; transform: rotate(-32deg) scale(0.3);
            transition: opacity 0.4s cubic-bezier(0.34, 1.56, 0.64, 1),
                        transform 0.55s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .rq-card:hover .rq-stamp { opacity: 1; transform: rotate(-8deg) scale(1); }

        .rq-draw .rq-path {
            stroke-dasharray: 1; stroke-dashoffset: 1;
            transition: stroke-dashoffset 1.4s cubic-bezier(0.19, 1, 0.22, 1);
        }
        .rq-card.in-view .rq-path { stroke-dashoffset: 0; }
        .rq-card.in-view .rq-path:nth-child(1) { transition-delay: 0.5s; }
        .rq-card.in-view .rq-path:nth-child(2) { transition-delay: 0.65s; }
        .rq-card.in-view .rq-path:nth-child(3) { transition-delay: 0.8s; }
        .rq-card.in-view .rq-path:nth-child(4) { transition-delay: 0.95s; }

        .rq-counter { font-variant-numeric: tabular-nums; letter-spacing: -0.04em; }
        .rq-seg {
            display: inline-block; height: 4px; width: 10px; border-radius: 999px;
            background: rgba(10, 22, 30, 0.15);
            transition: all 0.7s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .rq-verify {
            opacity: 0; translate: 0 30px;
            transition: opacity 0.9s cubic-bezier(0.19, 1, 0.22, 1), translate 1.1s cubic-bezier(0.19, 1, 0.22, 1);
        }
        .rq-verify.in-view { opacity: 1; translate: 0 0; }
        .rq-verify.in-view .rq-seg { width: 28px; background: #0A161E; }
        .rq-verify.in-view .rq-seg:first-child { background: linear-gradient(90deg, #0A161E, #2DD4BF); }
        .rq-verify.in-view .rq-seg:nth-child(1) { transition-delay: 0.3s; }
        .rq-verify.in-view .rq-seg:nth-child(2) { transition-delay: 0.42s; }
        .rq-verify.in-view .rq-seg:nth-child(3) { transition-delay: 0.54s; }
        .rq-verify.in-view .rq-seg:nth-child(4) { transition-delay: 0.66s; }

        .fq-section { isolation: isolate; background-color: #F8FAFC; }
        .fq-spotlight {
            background: radial-gradient(640px circle at var(--fq-mx, 62%) var(--fq-my, 26%), rgba(45, 212, 191, 0.10), rgba(45, 212, 191, 0.02) 40%, transparent 65%);
            transition: background 0.4s cubic-bezier(0.19, 1, 0.22, 1);
        }
        .fq-ghost { color: rgba(10, 22, 30, 0.04); transition: transform 1.2s cubic-bezier(0.19, 1, 0.22, 1); will-change: transform; }
        .fq-item {
            position: relative; transition: background 0.5s ease;
            border-bottom: 1px solid rgba(10, 22, 30, 0.07);
        }
        .fq-item:last-child { border-bottom: none; }
        .fq-item::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
            background: linear-gradient(180deg, #2DD4BF, rgba(45, 212, 191, 0.35));
            transform: scaleY(0); transform-origin: top center;
            transition: transform 0.6s cubic-bezier(0.19, 1, 0.22, 1);
            box-shadow: 0 0 14px rgba(45, 212, 191, 0.35); z-index: 2;
        }
        .fq-item.is-open::before { transform: scaleY(1); }
        .fq-item.is-open {
            background: linear-gradient(90deg, rgba(45, 212, 191, 0.07), rgba(45, 212, 191, 0.01) 55%, transparent 85%);
        }
        .fq-item:hover:not(.is-open) {
            background: linear-gradient(90deg, rgba(10, 22, 30, 0.025), transparent 60%);
        }
        .fq-toggle { cursor: pointer; -webkit-tap-highlight-color: transparent; }
        .fq-toggle:focus-visible {
            outline: 1px solid rgba(45, 212, 191, 0.6);
            outline-offset: -1px; border-radius: 4px;
        }
        .fq-num {
            display: inline-flex; align-items: center; justify-content: flex-start;
            font-family: ui-monospace, "SFMono-Regular", Menlo, monospace;
            font-size: 10px; font-weight: 700; letter-spacing: 0.08em; color: #94A3B8;
            transition: color 0.35s ease, transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-variant-numeric: tabular-nums;
        }
        .fq-item.is-open .fq-num { color: #0F766E; }
        .fq-toggle:hover .fq-num { color: #2DD4BF; transform: translateY(-1px); }
        .fq-question {
            color: #0A161E;
            transition: color 0.35s ease, transform 0.45s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .fq-item.is-open .fq-question { color: #0F766E; }
        .fq-toggle:hover .fq-question { color: #0F766E; }
        .fq-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 2.25rem; height: 2.25rem; border-radius: 9999px;
            border: 1px solid rgba(10, 22, 30, 0.15); background: rgba(255, 255, 255, 0.7);
            color: #64748B;
            transition: transform 0.55s cubic-bezier(0.34, 1.56, 0.64, 1),
                        background-color 0.35s ease, border-color 0.35s ease,
                        color 0.35s ease, box-shadow 0.4s ease;
            flex-shrink: 0;
        }
        .fq-toggle:hover .fq-icon {
            background: rgba(45, 212, 191, 0.14);
            border-color: rgba(45, 212, 191, 0.5);
            color: #0F766E; box-shadow: 0 0 20px rgba(45, 212, 191, 0.2);
        }
        .fq-item.is-open .fq-icon {
            transform: rotate(135deg); background: #0A161E;
            border-color: #0A161E; color: #2DD4BF;
            box-shadow: 0 0 22px rgba(10, 22, 30, 0.3);
        }
        .fq-answer { display: grid; grid-template-rows: 0fr; transition: grid-template-rows 0.6s cubic-bezier(0.19, 1, 0.22, 1); }
        .fq-item.is-open .fq-answer { grid-template-rows: 1fr; }
        .fq-answer > div { overflow: hidden; min-height: 0; }
        .fq-answer-text {
            opacity: 0; transform: translateY(8px); color: #475569;
            transition: opacity 0.5s ease 0.12s, transform 0.55s cubic-bezier(0.19, 1, 0.22, 1) 0.12s;
        }
        .fq-item.is-open .fq-answer-text { opacity: 1; transform: translateY(0); }
        .fq-live-dot { position: relative; display: inline-flex; width: 6px; height: 6px; }
        .fq-live-dot::before {
            content: ''; position: absolute; inset: 0; border-radius: 50%;
            background: #2DD4BF; opacity: 0.75;
            animation: fqPing 1.8s cubic-bezier(0, 0, 0.2, 1) infinite;
        }
        .fq-live-dot::after {
            content: ''; position: relative; display: block;
            width: 6px; height: 6px; border-radius: 50%; background: #2DD4BF;
        }
        @keyframes fqPing {
            0% { transform: scale(1); opacity: 0.75; }
            80%, 100% { transform: scale(2.6); opacity: 0; }
        }
        .fq-shine {
            position: absolute; inset: 0;
            background: linear-gradient(115deg, transparent 30%, rgba(45, 212, 191, 0.09) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.9s cubic-bezier(0.19, 1, 0.22, 1);
            pointer-events: none; opacity: 0;
        }
        .fq-item:hover .fq-shine { transform: translateX(100%); opacity: 1; }

        .contact-mosaic-wrap {
            opacity: 0; transform: translateX(80px) rotateY(-16deg) scale(0.93);
            transition: opacity 1.2s cubic-bezier(0.19, 1, 0.22, 1), transform 1.5s cubic-bezier(0.19, 1, 0.22, 1);
            perspective: 1400px; will-change: transform, opacity;
        }
        .reveal.in-view .contact-mosaic-wrap { opacity: 1; transform: translateX(0) rotateY(0deg) scale(1); }
        .contact-mosaic {
            position: relative; height: 640px; overflow: hidden;
            border-radius: 32px; border: 1px solid rgba(10, 22, 30, 0.06);
            box-shadow: 0 40px 100px -30px rgba(10, 22, 30, 0.25),
                        0 12px 32px -12px rgba(10, 22, 30, 0.12),
                        inset 0 1px 0 rgba(255, 255, 255, 0.6);
            mask-image: linear-gradient(180deg, transparent 0%, black 9%, black 91%, transparent 100%);
            -webkit-mask-image: linear-gradient(180deg, transparent 0%, black 9%, black 91%, transparent 100%);
        }
        .contact-mosaic-grid {
            display: grid; grid-template-columns: repeat(3, 1fr);
            gap: 12px; height: 100%; padding: 0 4px;
        }
        .contact-mosaic-col { display: flex; flex-direction: column; will-change: transform; }
        .contact-mosaic-col--up-1 { animation: mosaicUp 42s linear infinite; }
        .contact-mosaic-col--down { animation: mosaicDown 48s linear infinite; }
        .contact-mosaic-col--up-2 { animation: mosaicUp 55s linear infinite; }
        @keyframes mosaicUp { from { transform: translate3d(0, 0, 0); } to { transform: translate3d(0, -50%, 0); } }
        @keyframes mosaicDown { from { transform: translate3d(0, -50%, 0); } to { transform: translate3d(0, 0, 0); } }
        .contact-mosaic-item {
            position: relative; border-radius: 18px; overflow: hidden;
            margin-bottom: 12px; background: #E8E3DA;
            box-shadow: 0 8px 24px -8px rgba(10, 22, 30, 0.18), 0 2px 6px -2px rgba(10, 22, 30, 0.08);
            flex-shrink: 0;
            transition: transform 0.5s cubic-bezier(0.19, 1, 0.22, 1), box-shadow 0.5s ease;
        }
        .contact-mosaic-item:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 40px -12px rgba(10, 22, 30, 0.25), 0 4px 12px -4px rgba(10, 22, 30, 0.12);
        }
        .contact-mosaic-item img {
            width: 100%; height: 100%; object-fit: cover; display: block;
            filter: saturate(0.95) brightness(1.02) contrast(1.02);
            transition: transform 0.9s cubic-bezier(0.19, 1, 0.22, 1), filter 0.6s ease;
        }
        .contact-mosaic-item::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(180deg, transparent 62%, rgba(10, 22, 30, 0.32) 100%);
            pointer-events: none; z-index: 1; transition: opacity 0.5s ease;
        }
        .contact-mosaic-item:hover img { transform: scale(1.08); filter: saturate(1.05) brightness(1.04) contrast(1.02); }
        .contact-mosaic-item:hover::after { opacity: 0.6; }
        .contact-float-card { animation: float 6s ease-in-out infinite; }
        @media (max-width: 1023px) {
            .contact-mosaic { height: 480px; }
        }
        @media (max-width: 640px) {
            .contact-mosaic { height: 400px; border-radius: 24px; }
            .contact-mosaic-grid { gap: 8px; }
            .contact-mosaic-item { border-radius: 12px; margin-bottom: 8px; }
        }

        .cinema-clip {
            clip-path: inset(100% 0 0 0);
            transition: clip-path 1.7s cubic-bezier(0.77, 0, 0.175, 1);
            will-change: clip-path;
        }
        .reveal.in-view .cinema-clip { clip-path: inset(0 0 0 0); }

        .cinema-clip-right {
            clip-path: inset(0 100% 0 0);
            transition: clip-path 1.7s cubic-bezier(0.77, 0, 0.175, 1);
            will-change: clip-path;
        }
        .reveal.in-view .cinema-clip-right { clip-path: inset(0 0 0 0); }

        .cinema-img {
            transform: scale(1.4);
            transition: transform 2.4s cubic-bezier(0.77, 0, 0.175, 1);
            will-change: transform;
        }
        .reveal.in-view .cinema-img { transform: scale(1.02); }

        .about-cinema-wrap { transition: box-shadow 0.6s cubic-bezier(0.19, 1, 0.22, 1); }
        .about-cinema-wrap:hover .cinema-img { transform: scale(1.08); transition-duration: 0.9s; }
        .about-cinema-wrap:hover { box-shadow: 0 30px 60px -20px rgba(10, 22, 30, 0.35); }

        .about-cinema-wrap::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(180deg, transparent 55%, rgba(10, 22, 30, 0.55) 100%);
            pointer-events: none; z-index: 2; opacity: 0;
            transition: opacity 0.8s ease 0.4s;
        }
        .reveal.in-view .about-cinema-wrap::after { opacity: 1; }

        .about-parallax { will-change: transform; transition: transform 0.15s linear; }

        .cinema-stagger-1 .cinema-clip { transition-delay: 0.05s; }
        .cinema-stagger-1 .cinema-img  { transition-delay: 0.05s; }
        .cinema-stagger-2 .cinema-clip { transition-delay: 0.22s; }
        .cinema-stagger-2 .cinema-img  { transition-delay: 0.22s; }
        .cinema-stagger-3 .cinema-clip { transition-delay: 0.40s; }
        .cinema-stagger-3 .cinema-img  { transition-delay: 0.40s; }

        .svc-hero {
            clip-path: polygon(0 0, 0 0, 0 100%, 0 100%);
            transition: clip-path 1.9s cubic-bezier(0.77, 0, 0.175, 1) 0.15s;
            will-change: clip-path;
        }
        .reveal.in-view .svc-hero { clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%); }

        .svc-hero-img {
            transform: scale(1.32) translateX(5%);
            transition: transform 2.6s cubic-bezier(0.77, 0, 0.175, 1) 0.15s;
            will-change: transform;
        }
        .reveal.in-view .svc-hero-img { transform: scale(1) translateX(0); }
        .svc-hero-zoom:hover .svc-hero-img { transform: scale(1.06); transition-duration: 1s; }

        .svc-row-clip {
            clip-path: inset(0 100% 0 0);
            transition: clip-path 1.4s cubic-bezier(0.77, 0, 0.175, 1);
            will-change: clip-path;
        }
        .reveal.in-view .svc-row-clip { clip-path: inset(0 0 0 0); }

        @keyframes starTwinkle {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50%      { transform: scale(1.18) rotate(4deg); }
        }
        @keyframes ratingShine {
            0%       { transform: translateX(-150%) skewX(-12deg); opacity: 0; }
            10%      { opacity: 1; }
            60%,100% { transform: translateX(150%) skewX(-12deg); opacity: 0; }
        }
        .reveal-rating { position: relative; overflow: hidden; }
        .reveal-rating .star-anim {
            animation: starTwinkle 2.6s ease-in-out infinite;
            animation-delay: calc(var(--i, 0) * 180ms);
            filter: drop-shadow(0 0 3px rgba(251, 191, 36, 0.4));
            transform-origin: center;
        }
        .reveal-rating .rating-shine {
            animation: ratingShine 4.5s ease-in-out infinite;
            animation-delay: 1.2s;
        }

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal; font-style: normal;
            font-size: 24px; line-height: 1;
            letter-spacing: normal; text-transform: none;
            display: inline-block; white-space: nowrap;
            word-wrap: normal; direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .vslider-wrapper {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            position: relative;
            margin-top: 3rem;
        }
        @media (min-width: 1024px) {
            .vslider-wrapper {
                grid-template-columns: minmax(0, 5fr) minmax(0, 7fr);
                gap: 4rem;
                align-items: start;
                margin-top: 4rem;
            }
        }

        .vslider-sticky {
            position: relative;
            padding: 2rem 0 0;
        }
        @media (min-width: 1024px) {
            .vslider-sticky {
                position: sticky;
                top: 120px;
                padding: 1rem 0;
            }
        }

        .vslider-ghost-num {
            position: absolute;
            top: -2.5rem;
            right: 0;
            font-size: 10rem;
            font-weight: 800;
            font-style: italic;
            line-height: 0.8;
            letter-spacing: -0.06em;
            color: rgba(45, 212, 191, 0.10);
            pointer-events: none;
            user-select: none;
            z-index: 0;
        }
        @media (min-width: 640px) {
            .vslider-ghost-num { font-size: 14rem; }
        }
        @media (min-width: 1024px) {
            .vslider-ghost-num { font-size: 18rem; right: -1rem; top: -3rem; }
        }

        .vslider-content {
            position: relative;
            z-index: 1;
        }
        .vslider-content.animate .vslider-badge,
        .vslider-content.animate .vslider-title,
        .vslider-content.animate .vslider-desc,
        .vslider-content.animate .vslider-cta {
            animation: vsliderContentIn 0.75s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        .vslider-content.animate .vslider-badge { animation-delay: 0ms; }
        .vslider-content.animate .vslider-title { animation-delay: 80ms; }
        .vslider-content.animate .vslider-desc { animation-delay: 160ms; }
        .vslider-content.animate .vslider-cta { animation-delay: 240ms; }

        @keyframes vsliderContentIn {
            0% { opacity: 0; transform: translateY(24px); filter: blur(6px); }
            100% { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        .vslider-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border-radius: 999px;
            background: rgba(10, 22, 30, 0.04);
            border: 1px solid rgba(10, 22, 30, 0.08);
            font-size: 10px;
            font-family: ui-monospace, monospace;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #0A161E;
            margin-bottom: 1.5rem;
            font-variant-numeric: tabular-nums;
        }

        .vslider-title {
            font-size: clamp(2.25rem, 5.5vw, 4rem);
            font-weight: 300;
            line-height: 1;
            letter-spacing: -0.035em;
            color: #0A161E;
            margin-bottom: 1.5rem;
        }

        .vslider-desc {
            font-size: 1rem;
            line-height: 1.7;
            color: #475569;
            margin-bottom: 2rem;
            max-width: 28rem;
        }
        @media (min-width: 640px) {
            .vslider-desc { font-size: 1.125rem; }
        }

        .vslider-cta {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 14px 24px;
            background: #0A161E;
            color: #fff;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.19, 1, 0.22, 1);
        }
        .vslider-cta:hover {
            background: #2DD4BF;
            color: #0A161E;
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -8px rgba(45, 212, 191, 0.4);
        }
        .vslider-cta i {
            transition: transform 0.3s cubic-bezier(0.19, 1, 0.22, 1);
        }
        .vslider-cta:hover i { transform: translateX(4px); }

        .vslider-indicators {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 2.5rem;
        }
        @media (min-width: 1024px) {
            .vslider-indicators { margin-top: 3rem; }
        }

        .vslider-indicator {
            height: 4px;
            width: 22px;
            border-radius: 999px;
            background: rgba(10, 22, 30, 0.15);
            border: none;
            padding: 0;
            cursor: pointer;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .vslider-indicator:hover { background: rgba(10, 22, 30, 0.35); }
        .vslider-indicator.active {
            width: 48px;
            background: #2DD4BF;
            box-shadow: 0 0 14px rgba(45, 212, 191, 0.55);
        }

        .vslider-track {
            height: 520px;
            overflow-y: auto;
            overflow-x: hidden;
            scroll-snap-type: y mandatory;
            padding: 70px 0;
            position: relative;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        @media (min-width: 1024px) {
            .vslider-track {
                height: 640px;
                padding: 130px 0;
            }
        }
        .vslider-track::-webkit-scrollbar { display: none; }

        .vslider-card {
            scroll-snap-align: center;
            height: 380px;
            margin: 0 auto 24px;
            border-radius: 28px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            will-change: transform, opacity, filter;
            transform-origin: center center;
            width: 100%;
            background: #0A161E;
        }
        .vslider-card.is-centered {
            box-shadow: 0 30px 60px -20px rgba(10, 22, 30, 0.4),
                        0 8px 20px -8px rgba(10, 22, 30, 0.25);
        }

        .vslider-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 1.2s cubic-bezier(0.19, 1, 0.22, 1);
        }
        .vslider-card.is-centered img { transform: scale(1.06); }

        .vslider-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 35%, rgba(10, 22, 30, 0.88) 100%);
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            pointer-events: none;
        }
        @media (min-width: 640px) {
            .vslider-card-overlay { padding: 32px; }
        }

        .vslider-card-num {
            font-family: ui-monospace, monospace;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.3em;
            color: rgba(255, 255, 255, 0.85);
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            align-self: flex-start;
            text-transform: uppercase;
        }

        .vslider-card-info h4 {
            font-size: 1.5rem;
            font-weight: 300;
            color: #fff;
            margin-bottom: 6px;
            letter-spacing: -0.02em;
            line-height: 1.15;
            transition: color 0.4s ease;
        }
        @media (min-width: 640px) {
            .vslider-card-info h4 { font-size: 1.85rem; }
        }
        .vslider-card.is-centered .vslider-card-info h4 { color: #2DD4BF; }

        .vslider-card-info span {
            font-size: 10px;
            font-family: ui-monospace, monospace;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #2DD4BF;
            font-weight: 600;
        }

        @media (prefers-reduced-motion: reduce) {
            .letter-3d, .kinetic-word, .ghost-index, .bottom-line,
            .progress-segment, .tst-header-seg, .tst-dot, .marquee-track,
            #cae .animate-ping {
                opacity: 1 !important; transform: none !important;
                filter: none !important; transition: none !important;
                animation: none !important; width: auto !important;
            }
            .heading-underline path { stroke-dashoffset: 0 !important; transition: none !important; }
            #tstAutoplay { display: none !important; }
            .fq-answer, .fq-answer-text, .fq-icon, .fq-num, .fq-question { transition: none !important; }
            .fq-answer-text { opacity: 1 !important; transform: none !important; }
            .fq-ghost { transform: none !important; }
            .fq-shine, .fq-live-dot::before { display: none !important; }
            .contact-mosaic-col { animation: none !important; }
            .contact-mosaic-wrap { opacity: 1 !important; transform: none !important; }
            .contact-float-card { animation: none !important; }
            .cinema-clip, .cinema-clip-right, .cinema-img,
            .svc-hero, .svc-hero-img, .svc-row-clip {
                clip-path: none !important; transform: none !important; transition: none !important;
            }
            .reveal-rating .star-anim, .reveal-rating .rating-shine {
                animation: none !important; filter: none !important;
            }
            .rq-card, .rq-verify, .rq-note, .rq-head h2 .rq-line {
                opacity: 1 !important; translate: 0 0 !important;
                rotate: 0 !important; scale: 1 !important; transition: none !important;
            }
            .req-stamp-rotator, .req-stamp-rotator svg text { animation: none !important; }
            .rq-path { stroke-dashoffset: 0 !important; transition: none !important; }
            .rq-underline path { stroke-dashoffset: 0 !important; }
            .rq-stamp { opacity: 1 !important; transform: rotate(-8deg) scale(1) !important; }
            .vslider-card { transform: none !important; opacity: 1 !important; filter: none !important; }
            .vslider-content.animate .vslider-badge,
            .vslider-content.animate .vslider-title,

            .vslider-content.animate .vslider-desc,
            .vslider-content.animate .vslider-cta { animation: none !important; }
        }

        .eligibility-fab {
            position: fixed;
            left: 50%;
            bottom: 1.25rem;
            transform: translateX(-50%);
            z-index: 9997;
            max-width: calc(100vw - 1.5rem);
            animation: eligFabIn 0.9s cubic-bezier(0.34, 1.56, 0.64, 1) 1.4s both;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease,
                        box-shadow 0.35s ease, transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes eligFabIn {
            0%   { opacity: 0; transform: translate(-50%, 44px) scale(0.92); }
            100% { opacity: 1; transform: translate(-50%, 0) scale(1); }
        }
        .eligibility-fab:hover {
            transform: translate(-50%, -3px);
            box-shadow: 0 18px 48px -12px rgba(45, 212, 191, 0.45);
        }

        .eligibility-card {
            opacity: 0;
            transform: translateY(30px) scale(0.96);
            transition: opacity 0.45s ease, transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            will-change: transform, opacity;
        }
        #eligibilityModal.is-open .eligibility-card {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .elig-input {
            transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }
        .elig-input:focus {
            outline: none;
            border-color: rgba(45, 212, 191, 0.55);
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.12);
        }
        .elig-input::placeholder { color: #64748b; }

        .step-dot {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            font-family: ui-monospace, monospace;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: #94a3b8;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            flex-shrink: 0;
        }
        .step-dot.active {
            background: #2DD4BF;
            border-color: #2DD4BF;
            color: #0A161E;
            box-shadow: 0 0 18px rgba(45, 212, 191, 0.5);
            transform: scale(1.08);
        }
        .step-dot.completed {
            background: rgba(45, 212, 191, 0.15);
            border-color: rgba(45, 212, 191, 0.5);
            color: #2DD4BF;
        }
        .step-line {
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            transition: background 0.4s ease;
        }
        .step-line.completed {
            background: rgba(45, 212, 191, 0.55);
            box-shadow: 0 0 6px rgba(45, 212, 191, 0.4);
        }

        .elig-step { display: none; }
        .elig-step.active { display: block; animation: stepIn 0.45s cubic-bezier(0.19, 1, 0.22, 1); }
        @keyframes stepIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .elig-opt {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.10);
            color: #cbd5e1;
            font-size: 12px;
            line-height: 1.35;
            text-align: left;
            transition: all 0.25s ease;
            cursor: pointer;
            min-height: 42px;
            width: 100%;
            font-weight: 400;
        }
        .elig-opt:hover {
            border-color: rgba(45, 212, 191, 0.35);
            background: rgba(45, 212, 191, 0.06);
            color: #fff;
        }
        .elig-opt.active {
            background: rgba(45, 212, 191, 0.12);
            border-color: rgba(45, 212, 191, 0.55);
            color: #fff;
            box-shadow: 0 0 0 1px rgba(45, 212, 191, 0.25);
        }
        .elig-opt .dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 1.5px solid rgba(148, 163, 184, 0.55);
            flex-shrink: 0;
            position: relative;
            transition: border-color 0.25s ease;
        }
        .elig-opt:hover .dot { border-color: rgba(45, 212, 191, 0.7); }
        .elig-opt.active .dot { border-color: #2DD4BF; }
        .elig-opt.active .dot::after {
            content: '';
            position: absolute;
            inset: 2.5px;
            border-radius: 50%;
            background: #2DD4BF;
        }

        .elig-opt-group.is-error .elig-opt {
            border-color: rgba(248, 113, 113, 0.6);
        }
        .elig-opt-group.is-error {
            animation: eligShake 0.45s ease;
        }
        @keyframes eligShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .elig-input.is-error {
            border-color: #f87171 !important;
            box-shadow: 0 0 0 3px rgba(248, 113, 113, 0.14) !important;
        }

        .elig-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            background: rgba(255, 255, 255, 0.04);
            cursor: pointer;
            flex-shrink: 0;
            position: relative;
            transition: all 0.2s ease;
            margin-top: 2px;
        }
        .elig-checkbox:hover { border-color: rgba(45, 212, 191, 0.6); }
        .elig-checkbox:checked {
            background: #2DD4BF;
            border-color: #2DD4BF;
        }
        .elig-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 1px;
            width: 5px;
            height: 10px;
            border: solid #0A161E;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        .elig-checkbox.is-error { border-color: #f87171; }
        label.elig-privacy-label.is-error span { color: #f87171; }

        .eligibility-card::-webkit-scrollbar { width: 6px; }
        .eligibility-card::-webkit-scrollbar-track { background: transparent; }
        .eligibility-card::-webkit-scrollbar-thumb { background: rgba(45, 212, 191, 0.3); border-radius: 4px; }

        @media (prefers-reduced-motion: reduce) {
            .eligibility-fab { animation: none; }
            .eligibility-card { transition: none; }
            .elig-step.active { animation: none; }
        }

        .brand-volcalis { color: #E30613; }
        .brand-ursa { color: #1B3A6B; }
        .volcalis-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 2.5rem; height: 2.5rem; border-radius: 50%;
            background: rgba(227, 6, 19, 0.08); color: #E30613;
            border: 1px solid rgba(227, 6, 19, 0.15);
            transition: all 0.3s ease;
        }
        .volcalis-icon:hover { background: rgba(227, 6, 19, 0.14); transform: translateY(-2px); }
        .ursa-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 2.5rem; height: 2.5rem; border-radius: 50%;
            background: rgba(27, 58, 107, 0.06); color: #1B3A6B;
            border: 1px solid rgba(27, 58, 107, 0.14);
            transition: all 0.3s ease;
        }
        .ursa-icon:hover { background: rgba(27, 58, 107, 0.12); transform: translateY(-2px); }
    </style>
</head>

<body class="brand-home bg-brand-lightBg text-slate-800 font-sans antialiased selection:bg-teal-500 selection:text-white overflow-x-hidden">

    @include('partials.site-prompts')

    <a href="#main" class="skip-link">Saltar al contenido principal</a>

    @include('partials.shared-site-header')

    <main id="main">

    <section class="relative min-h-screen flex flex-col pt-36 pb-8 px-4 sm:px-8 overflow-hidden bg-brand-dark text-white">
        <div class="absolute inset-0 z-0" aria-hidden="true">
            <video id="homeBackgroundVideo" class="w-full h-full object-cover opacity-55" muted loop playsinline preload="none" poster="{{ asset('images/image9-640.webp') }}">
                <source data-src="{{ asset('video/AislaGratis_video_web.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-gradient-to-b from-brand-dark via-brand-dark/30 to-transparent"></div>
            <div class="absolute -top-32 left-1/4 w-[600px] h-[600px] bg-brand-accent/25 rounded-full blur-[140px] animate-pulse"></div>
            <div class="absolute -bottom-32 right-1/4 w-[500px] h-[500px] bg-teal-500/20 rounded-full blur-[120px] animate-pulse" style="animation-delay: 2s"></div>
            <div class="absolute inset-0 opacity-[0.05]" style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 80px 80px; mask-image: radial-gradient(ellipse at center, black 40%, transparent 85%); -webkit-mask-image: radial-gradient(ellipse at center, black 40%, transparent 85%);"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto w-full flex flex-wrap items-center gap-3 pt-4">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-xl border border-white/20 rounded-full px-4 py-1.5 text-xs font-medium tracking-wide animate-fade-in">
                <span class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></span>
                Programa oficial CAE · RD 36/2023
            </div>
            <div class="inline-flex items-center gap-2 bg-brand-accent/10 backdrop-blur-xl border border-brand-accent/30 rounded-full px-4 py-1.5 text-xs font-medium tracking-wide text-brand-accent animate-fade-in" style="animation-delay: 0.1s">
                <i data-lucide="check-circle-2" class="w-3 h-3" aria-hidden="true"></i>
                Estudio técnico gratuito
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center flex-1 py-12">
            <div class="lg:col-span-7">
                <h1 class="text-5xl sm:text-7xl md:text-8xl font-light tracking-tight leading-[0.95] mb-6 animate-fade-up">
                    <span class="block text-white">Aísla tu tejado</span>
                    <span class="block bg-gradient-to-r from-white via-brand-accent to-teal-300 bg-clip-text text-transparent font-normal italic pr-3">sin coste para ti</span>
                </h1>

                <p class="max-w-xl text-slate-300 text-base sm:text-lg font-light leading-relaxed animate-fade-up mb-8" style="animation-delay: 0.2s">
                    Aislamiento térmico profesional para viviendas unifamiliares. Nos encargamos del estudio técnico, la gestión del expediente CAE y la ejecución completa. <span class="text-white font-medium">Tú no pagas obra, materiales ni gestión.</span>
                </p>

                <div class="flex items-center gap-4 mb-8 animate-fade-up" style="animation-delay: 0.3s">
                    <div class="flex -space-x-3" aria-hidden="true">
                        <img src="{{ asset('images/user1.jpg') }}" class="w-10 h-10 rounded-full border-2 border-brand-dark object-cover" alt="" loading="lazy">
                        <img src="{{ asset('images/user2.jpg') }}" class="w-10 h-10 rounded-full border-2 border-brand-dark object-cover" alt="" loading="lazy">
                        <img src="{{ asset('images/chica1.jpg') }}" class="w-10 h-10 rounded-full border-2 border-brand-dark object-cover" alt="" loading="lazy">
                        <div class="w-10 h-10 rounded-full border-2 border-brand-dark bg-brand-accent text-brand-dark flex items-center justify-center text-[10px] font-bold">+2K</div>
                    </div>
                    <div>
                        <div class="flex items-center gap-1 text-amber-400 text-xs">
                            <span aria-hidden="true">★★★★★</span>
                            <span class="text-white font-semibold ml-1">9.7/10</span>
                        </div>
                        <p class="text-xs text-slate-400">Valoración media de propietarios</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 animate-fade-up" style="animation-delay: 0.4s">
                    <a href="{{ route('leads.create') }}" class="group inline-flex items-center gap-2 bg-white text-slate-900 px-6 py-3.5 rounded-full font-semibold text-sm hover:bg-brand-accent hover:text-brand-dark transition-all hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-brand-accent/40">
                        Solicitar estudio gratuito
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" aria-hidden="true"></i>
                    </a>
                    <button type="button" id="howItWorksButton" class="inline-flex items-center gap-2 bg-white/5 backdrop-blur-xl border border-white/20 text-white px-6 py-3.5 rounded-full font-medium text-sm hover:bg-white/10 transition-all hover:-translate-y-0.5">
                        <i data-lucide="play" class="w-4 h-4" aria-hidden="true"></i>
                        Cómo funciona
                    </button>
                </div>
            </div>

        </div>

        <div class="relative z-10 max-w-7xl mx-auto w-full mt-6 overflow-hidden border-y border-white/10 py-3">
            <div class="marquee-track flex gap-12 whitespace-nowrap">
                <div class="flex gap-12 items-center shrink-0">
                    <span class="text-[11px] text-slate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>Real Decreto 36/2023</span>
                    <span class="text-[11px] text-slate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>Certificación CAE oficial</span>
                    <span class="text-[11px] text-slate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>+2.400 viviendas aisladas</span>
                    <span class="text-[11px] text-slate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>Cobertura en 54 ciudades</span>
                    <span class="text-[11px] text-slate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>Equipo técnico propio</span>
                    <span class="text-[11px] text-slate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>Sin obras en casa</span>
                </div>
                <div class="flex gap-12 items-center shrink-0" aria-hidden="true">
                    <span class="text-[11px] text-sllate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>Real Decreto 36/2023</span>
                    <span class="text-[11px] text-sate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>Certificación CAE oficial</span>
                    <span class="text-[11px] text-slate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>+2.400 viviendas aisladas</span>
                    <span class="text-[11px] text-slate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>Cobertura en 54 ciudades</span>
                    <span class="text-[11px] text-slate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>Equipo técnico propio</span>
                    <span class="text-[11px] text-slate-400 font-semibold tracking-[0.25em] uppercase flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-brand-accent"></span>Sin obras en casa</span>
                </div>
            </div>
        </div>
    </section>
    </section>
    <dialog id="howItWorksDialog" class="video-dialog" aria-labelledby="howItWorksTitle">
        <div class="relative flex h-full w-full items-center justify-center">
            <video id="howItWorksVideo" class="h-full w-full object-contain" controls playsinline preload="none" aria-label="Vídeo: Cómo funciona AislaGratis">
                <source data-src="{{ asset('video/AislaGratis_Premium_Cinematic.mp4') }}" type="video/mp4">
                Tu navegador no puede reproducir este vídeo.
            </video>
            <p id="howItWorksPlaybackNotice" class="pointer-events-none absolute bottom-20 left-1/2 w-max max-w-[calc(100%-2rem)] -translate-x-1/2 rounded-full border border-white/15 bg-black/70 px-4 py-2 text-center text-xs text-white/90 backdrop-blur-md sm:text-sm" role="status" aria-live="polite" hidden></p>
            <div class="pointer-events-none absolute inset-x-0 top-0 flex items-start justify-between gap-4 bg-gradient-to-b from-black/70 to-transparent p-4 sm:p-8">
                <h2 id="howItWorksTitle" class="pt-2 text-sm font-medium tracking-wide text-white/90 sm:text-base">Cómo funciona AislaGratis</h2>
                <button type="button" id="closeHowItWorksDialog" class="pointer-events-auto inline-flex min-h-11 items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 text-sm font-medium text-white backdrop-blur-xl transition hover:bg-white/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-accent" aria-label="Volver a la página principal">
                    <i data-lucide="arrow-left" class="h-4 w-4" aria-hidden="true"></i>
                    <span>Volver</span>
                </button>
            </div>
        </div>
    </dialog>

    <section id="about" class="relative py-24 px-4 sm:px-8 bg-brand-lightBg overflow-hidden">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute inset-0 opacity-[0.035]" style="background-image: linear-gradient(#0A161E 1px, transparent 1px), linear-gradient(90deg, #0A161E 1px, transparent 1px); background-size: 64px 64px; mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, black 20%, transparent 80%); -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, black 20%, transparent 80%);"></div>
            <div class="absolute -top-40 left-1/4 w-[720px] h-[720px] bg-brand-accent/[0.07] rounded-full blur-[160px]"></div>
            <div class="absolute bottom-0 right-1/4 w-[560px] h-[560px] bg-teal-500/[0.06] rounded-full blur-[150px]"></div>
            <div class="absolute top-1/3 -left-20 w-[380px] h-[380px] bg-brand-accent/[0.05] rounded-full blur-[110px]"></div>
        </div>

        <div class="absolute right-0 top-1/3 w-20 h-80 hidden xl:block pointer-events-none opacity-30" aria-hidden="true">
            <div class="flex flex-col gap-2" style="animation: mosaicUp 35s linear infinite;">
                <img src="{{ asset('images/image10.jpg') }}" class="w-full aspect-square object-cover rounded-xl" alt="" loading="lazy">
                <img src="{{ asset('images/image2-640.webp') }}" class="w-full aspect-square object-cover rounded-xl" alt="" loading="lazy">
                <img src="{{ asset('images/image5c-640.webp') }}" class="w-full aspect-square object-cover rounded-xl" alt="" loading="lazy">
                <img src="{{ asset('images/image10.jpg') }}" class="w-full aspect-square object-cover rounded-xl" alt="" loading="lazy">
                <img src="{{ asset('images/image2-640.webp') }}" class="w-full aspect-square object-cover rounded-xl" alt="" loading="lazy">
                <img src="{{ asset('images/image5c-640.webp') }}" class="w-full aspect-square object-cover rounded-xl" alt="" loading="lazy">
            </div>
        </div>

        <div class="relative max-w-7xl mx-auto z-10">
            <div class="reveal mb-14 sm:mb-16 relative">
                <div class="hidden sm:block absolute -top-10 right-0 select-none pointer-events-none overflow-hidden" aria-hidden="true">
                    <span class="ghost-index">01</span>
                </div>

                <div class="flex items-center gap-3 sm:gap-4 mb-8 sm:mb-10">
                    <span class="shimmer-badge">
                        <span class="badge-dot"></span>
                        <span class="relative z-10">aislagratis</span>
                        <span class="badge-shimmer"></span>
                    </span>
                    <div class="flex-1 h-px bg-gradient-to-r from-slate-300 via-slate-200/60 to-transparent"></div>
                    <span class="hidden sm:inline text-[10px] font-mono text-slate-400 tracking-[0.3em] tabular-nums">01 <span class="text-slate-300">/</span> 04</span>
                </div>

                <div class="reveal-rating inline-flex flex-wrap items-center gap-3 bg-white border border-brand-dark/10 rounded-full pl-4 pr-5 py-2 shadow-[0_4px_20px_-8px_rgba(10,22,30,0.15)] mb-8 sm:mb-10">
                    <span class="absolute inset-0 -skew-x-12 -translate-x-full bg-gradient-to-r from-transparent via-white/70 to-transparent rating-shine pointer-events-none"></span>
                    <div class="flex items-center gap-0.5 relative z-10" role="img" aria-label="Valoración: 5 de 5 estrellas">
                        <svg class="w-[18px] h-[18px] star-anim text-amber-400" style="--i:0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg class="w-[18px] h-[18px] star-anim text-amber-400" style="--i:1" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg class="w-[18px] h-[18px] star-anim text-amber-400" style="--i:2" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg class="w-[18px] h-[18px] star-anim text-amber-400" style="--i:3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg class="w-[18px] h-[18px] star-anim text-amber-400" style="--i:4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <span class="w-px h-3.5 bg-brand-dark/15 relative z-10" aria-hidden="true"></span>
                    <span class="text-sm font-semibold text-brand-dark tabular-nums relative z-10">9.7 <span class="text-slate-400 font-normal text-xs">/ 10</span></span>
                    <span class="hidden sm:inline text-[10px] font-mono tracking-[0.22em] text-slate-500 uppercase relative z-10">Valoración de clientes</span>
                    <span class="hidden sm:block w-px h-3.5 bg-brand-dark/15 relative z-10" aria-hidden="true"></span>
                    <div class="hidden sm:flex items-center gap-1.5 relative z-10">
                        <span class="relative flex w-1.5 h-1.5">
                            <span class="absolute inset-0 rounded-full bg-[#0F766E] animate-ping"></span>
                            <span class="relative rounded-full w-1.5 h-1.5 bg-[#0F766E]"></span>
                        </span>
                        <span class="text-[10px] font-mono font-bold tracking-[0.22em] text-[#0F766E] uppercase">+2.418 viviendas</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-end">
                    <div class="lg:col-span-8">
                        <h2 class="text-[clamp(2.5rem,7vw,6.5rem)] font-light text-slate-900 tracking-[-0.045em] leading-[0.9]">
                            <span class="mask-line block">
                                <span class="kinetic-line" style="--delay:0ms">Aislamiento</span>
                            </span>
                            <span class="mask-line block">
                                <span class="kinetic-line" style="--delay:120ms">térmico</span>
                                <span class="kinetic-line" style="--delay:240ms">
                                    <span class="kinetic-gradient italic font-medium bg-clip-text text-transparent bg-gradient-to-r from-teal-600 via-brand-accent to-teal-500 inline-block pr-3 -mr-3">sin coste</span>
                                </span>
                            </span>
                            <span class="mask-line block">
                                <span class="kinetic-line" style="--delay:360ms">para el propietario</span>
                            </span>
                        </h2>
                    </div>

                    <div class="lg:col-span-4 flex flex-col gap-6 pb-2">
                        <p class="anim-up text-slate-600 text-base leading-relaxed" style="--delay:480ms">
                            Nos encargamos de todo el proceso CAE: estudio técnico gratuito, gestión completa del expediente, ejecución rápida y validación final. <span class="text-slate-900 font-medium">Tú no pagas obra, materiales ni gestión.</span>
                        </p>

                        <div class="anim-up grid grid-cols-2 gap-3" style="--delay:550ms">
                            <div class="bg-white border border-brand-dark/[0.08] rounded-2xl p-4 shadow-sm">
                                <span class="block text-[9px] font-mono tracking-[0.2em] text-slate-400 uppercase mb-1.5">Ahorro medio</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-2xl font-light text-brand-dark tabular-nums">70</span>
                                    <span class="text-[10px] font-mono text-brand-accent font-bold">%</span>
                                </div>
                            </div>
                            <div class="bg-white border border-brand-dark/[0.08] rounded-2xl p-4 shadow-sm">
                                <span class="block text-[9px] font-mono tracking-[0.2em] text-slate-400 uppercase mb-1.5">Instalación</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-2xl font-light text-brand-dark tabular-nums">3</span>
                                    <span class="text-[10px] font-mono text-brand-accent font-bold">días</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('leads.create') }}" style="--delay:650ms" class="anim-up group relative inline-flex items-center justify-between gap-3 bg-brand-dark text-white pl-6 pr-5 py-3.5 rounded-full text-sm font-medium overflow-hidden transition-all duration-300 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-slate-900/20">
                            <span class="absolute inset-0 bg-gradient-to-r from-brand-accent via-teal-300 to-brand-accent opacity-0 group-hover:opacity-100 transition-opacity duration-300 cta-gradient-sweep"></span>
                            <span class="relative z-10 group-hover:text-brand-dark transition-colors">Solicitar estudio gratuito</span>
                            <i data-lucide="arrow-right" class="relative z-10 w-4 h-4 transition-transform duration-300 group-hover:translate-x-1 group-hover:text-brand-dark" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="carousel-3d-wrapper reveal-3d relative w-full mb-16 sm:mb-20">
                <button id="aboutPrev" aria-label="Anterior" class="absolute top-1/2 left-4 sm:left-[5%] -translate-y-1/2 z-40 w-12 h-12 bg-brand-dark text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform shadow-2xl">
                    <i data-lucide="arrow-left" class="w-5 h-5" aria-hidden="true"></i>
                </button>
                <button id="aboutNext" aria-label="Siguiente" class="absolute top-1/2 right-4 sm:right-[5%] -translate-y-1/2 z-40 w-12 h-12 bg-brand-dark text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform shadow-2xl">
                    <i data-lucide="arrow-right" class="w-5 h-5" aria-hidden="true"></i>
                </button>
                <div class="carousel-3d-track" id="aboutTrack"></div>
            </div>

            <div id="proceso-cae" class="relative isolate mt-8 overflow-hidden rounded-[2rem] border border-slate-200/70 bg-[#F8FAFC] px-5 py-12 shadow-[0_24px_70px_-48px_rgba(10,22,30,0.35)] sm:mt-12 sm:px-8 sm:py-16 lg:px-12 lg:py-20">
                <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
                    <div class="absolute -left-40 top-32 h-96 w-96 rounded-full bg-teal-200/25 blur-3xl"></div>
                    <div class="absolute -right-32 bottom-0 h-96 w-96 rounded-full bg-cyan-100/50 blur-3xl"></div>
                    <div class="absolute inset-0 opacity-[0.035]" style="background-image:linear-gradient(#0A161E 1px,transparent 1px),linear-gradient(90deg,#0A161E 1px,transparent 1px);background-size:48px 48px;mask-image:linear-gradient(to bottom,transparent,black 20%,black 80%,transparent);"></div>
                </div>

                <div class="mb-12 flex flex-col gap-8 lg:mb-16 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-3xl reveal">
                        <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-teal-200/80 bg-white/80 px-4 py-2 text-[10px] font-semibold uppercase tracking-[0.2em] text-teal-800 shadow-sm backdrop-blur">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-teal-400 opacity-50"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-teal-600"></span>
                            </span>
                            Programa CAE
                            <span class="h-3 w-px bg-teal-200"></span>
                            Información oficial · MITECO
                        </div>
                        <h2 class="text-[clamp(2.7rem,7vw,6.6rem)] font-light leading-[0.98] tracking-[-0.06em] text-brand-dark">
                            Más confort en casa.<br>
                            <span class="bg-gradient-to-r from-teal-700 via-teal-600 to-cyan-600 bg-clip-text font-normal text-transparent">Menos energía que se pierde.</span>
                        </h2>
                    </div>
                    <a href="https://www.miteco.gob.es/es/energia/eficiencia/cae.html#accordion-6c9ad09474-item-30e76c36b0" target="_blank" rel="noopener noreferrer" class="group inline-flex min-h-12 shrink-0 items-center justify-center gap-3 rounded-full bg-brand-dark px-6 py-3.5 text-sm font-semibold text-white shadow-[0_16px_34px_-18px_rgba(10,22,30,0.7)] transition-all duration-300 hover:-translate-y-0.5 hover:bg-teal-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-teal-700">
                        Descubre cómo funciona el CAE
                        <i data-lucide="arrow-up-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="mb-12 grid gap-8 border-y border-slate-200/80 py-8 lg:mb-16 lg:grid-cols-[minmax(0,1.3fr)_minmax(18rem,0.7fr)] lg:items-end lg:gap-16 lg:py-10">
                    <p class="max-w-3xl text-base leading-8 text-slate-600 sm:text-lg sm:leading-9 reveal">
                        El sistema de Certificados de Ahorro Energético (CAE) impulsa actuaciones que reducen el consumo de energía, regulado en España por el Real Decreto 36/2023. En aislagratis te acompañamos desde el estudio inicial hasta la instalación de aislamiento en áticos y bajo cubierta, sujeta a la evaluación técnica de cada vivienda.
                    </p>
                    <div class="flex items-center gap-4 reveal">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-teal-100 bg-white text-teal-700 shadow-sm">
                            <i data-lucide="landmark" class="h-5 w-5" aria-hidden="true"></i>
                        </div>
                        <div>
                            <span class="block text-[10px] font-semibold uppercase tracking-[0.18em] text-slate-400">Marco regulatorio</span>
                            <span class="mt-1 block text-sm font-medium text-brand-dark">Real Decreto 36/2023 · Sistema CAE</span>
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-3 lg:gap-5">
                    <article class="group relative overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white/85 p-6 shadow-[0_10px_40px_-30px_rgba(10,22,30,0.35)] backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:border-teal-200 hover:shadow-[0_24px_50px_-32px_rgba(10,22,30,0.45)] sm:p-8 reveal">
                        <div class="mb-10 flex items-start justify-between">
                            <span class="text-xs font-mono font-medium tracking-[0.16em] text-slate-400">ESTUDIO TÉCNICO</span>
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-50 text-teal-700 ring-1 ring-teal-100 transition-colors group-hover:bg-teal-600 group-hover:text-white">
                                <i data-lucide="scan-search" class="h-5 w-5" aria-hidden="true"></i>
                            </span>
                        </div>
                        <h3 class="text-xl font-medium tracking-tight text-brand-dark sm:text-2xl">Empieza con el estudio técnico</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600">Visitamos tu vivienda y validamos el ahorro energético antes de comenzar cualquier actuación.</p>
                        <div class="mt-8 h-px w-full bg-gradient-to-r from-teal-300/80 via-slate-200 to-transparent"></div>
                    </article>

                    <article class="group relative overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white/85 p-6 shadow-[0_10px_40px_-30px_rgba(10,22,30,0.35)] backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:border-teal-200 hover:shadow-[0_24px_50px_-32px_rgba(10,22,30,0.45)] sm:p-8 reveal">
                        <div class="mb-10 flex items-start justify-between">
                            <span class="text-xs font-mono font-medium tracking-[0.16em] text-slate-400">GESTIÓN CAE</span>
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-50 text-teal-700 ring-1 ring-teal-100 transition-colors group-hover:bg-teal-600 group-hover:text-white">
                                <i data-lucide="file-check-2" class="h-5 w-5" aria-hidden="true"></i>
                            </span>
                        </div>
                        <h3 class="text-xl font-medium tracking-tight text-brand-dark sm:text-2xl">Gestión completa del expediente CAE</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600">Tramitamos toda la documentación, ejecutamos la obra y obtenemos la validación final exigida por el sistema oficial.</p>
                        <div class="mt-8 h-px w-full bg-gradient-to-r from-teal-300/80 via-slate-200 to-transparent"></div>
                    </article>

                    <article class="group relative overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white/85 p-6 shadow-[0_10px_40px_-30px_rgba(10,22,30,0.35)] backdrop-blur-sm transition-all duration-300 hover:-translate-y-1 hover:border-teal-200 hover:shadow-[0_24px_50px_-32px_rgba(10,22,30,0.45)] sm:p-8 reveal">
                        <div class="mb-10 flex items-start justify-between">
                            <span class="text-xs font-mono font-medium tracking-[0.16em] text-slate-400">EJECUCIÓN</span>
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-50 text-teal-700 ring-1 ring-teal-100 transition-colors group-hover:bg-teal-600 group-hover:text-white">
                                <i data-lucide="house" class="h-5 w-5" aria-hidden="true"></i>
                            </span>
                        </div>
                        <h3 class="text-xl font-medium tracking-tight text-brand-dark sm:text-2xl">Actuamos en desván o bajo cubierta</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600">Es donde más ahorro energético se genera. Reduce pérdidas, mejora el confort y genera el ahorro necesario.</p>
                        <div class="mt-8 h-px w-full bg-gradient-to-r from-teal-300/80 via-slate-200 to-transparent"></div>
                    </article>
                </div>

                <div class="mt-8 flex flex-col gap-6 rounded-[1.75rem] border border-amber-200/70 bg-amber-50/75 p-5 sm:flex-row sm:items-start sm:p-6 reveal">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-amber-700 shadow-sm ring-1 ring-amber-200/70">
                        <i data-lucide="info" class="h-5 w-5" aria-hidden="true"></i>
                    </span>
                    <div>
                        <h3 class="text-sm font-semibold text-brand-dark">Información importante sobre la elegibilidad</h3>
                        <p class="mt-1.5 text-xs leading-6 text-slate-600 sm:text-sm">
                            La elegibilidad, la financiación aplicable y la disponibilidad dependen de la evaluación técnica, los requisitos vigentes y los fondos o cupos disponibles. Consulta las condiciones oficiales en MITECO.
                        </p>
                    </div>
                </div>

                <div class="mt-8 flex flex-col items-center justify-between gap-5 sm:flex-row reveal">
                    <p class="max-w-xl text-xs leading-6 text-slate-500">*Las condiciones, el ahorro y la cobertura final se confirman tras valorar cada vivienda y la disponibilidad del programa.</p>
                    <a href="https://www.miteco.gob.es/es/energia/eficiencia/cae.html#accordion-6c9ad09474-item-30e76c36b0" target="_blank" rel="noopener noreferrer" class="group inline-flex items-center gap-2 text-sm font-semibold text-teal-800 transition-colors hover:text-teal-600">
                        Descubre cómo funciona el CAE
                        <i data-lucide="arrow-up-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="relative py-24 px-4 sm:px-8 bg-white border-t border-slate-100 overflow-hidden">
        <div class="max-w-7xl mx-auto">

            <div class="kinetic-header reveal relative py-12 sm:py-16 mb-8" id="kineticHeader">
                <div class="kinetic-spotlight" aria-hidden="true"></div>

                <div class="hidden sm:block absolute -top-6 sm:-top-10 right-0 select-none pointer-events-none overflow-hidden" aria-hidden="true">
                    <span class="ghost-index">02</span>
                </div>

                <div class="relative z-10 flex items-center gap-3 sm:gap-4 mb-6 sm:mb-7">
                    <span class="shimmer-badge">
                        <span class="badge-dot"></span>
                        <span class="relative z-10">aislagratis</span>
                        <span class="badge-shimmer"></span>
                    </span>
                    <div class="flex-1 h-px bg-gradient-to-r from-slate-300 via-slate-200/60 to-transparent"></div>
                    <div class="meta-index">
                        <span class="meta-dot"></span>
                        <span class="hidden sm:inline">Servicios · </span>
                        <span class="counter-num" data-target="2">00</span>
                        <span> / 04</span>
                    </div>
                </div>

                <div class="relative z-10 reveal-rating inline-flex flex-wrap items-center gap-3 bg-white border border-brand-dark/10 rounded-full pl-4 pr-5 py-2 shadow-[0_4px_20px_-8px_rgba(10,22,30,0.15)] mb-8 sm:mb-10">
                    <span class="absolute inset-0 -skew-x-12 -translate-x-full bg-gradient-to-r from-transparent via-white/70 to-transparent rating-shine pointer-events-none"></span>

                    <div class="flex items-center gap-0.5 relative z-10" role="img" aria-label="Valoración: 5 de 5 estrellas">
                        <svg class="w-[18px] h-[18px] star-anim text-amber-400" style="--i:0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg class="w-[18px] h-[18px] star-anim text-amber-400" style="--i:1" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg class="w-[18px] h-[18px] star-anim text-amber-400" style="--i:2" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg class="w-[18px] h-[18px] star-anim text-amber-400" style="--i:3" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg class="w-[18px] h-[18px] star-anim text-amber-400" style="--i:4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>

                    <span class="w-px h-3.5 bg-brand-dark/15 relative z-10" aria-hidden="true"></span>
                    <span class="text-sm font-semibold text-brand-dark tabular-nums relative z-10">4.9 <span class="text-slate-400 font-normal text-xs">/ 5</span></span>

                    <span class="hidden sm:inline text-[10px] font-mono tracking-[0.22em] text-slate-500 uppercase relative z-10">Servicios certificados</span>

                    <span class="hidden sm:block w-px h-3.5 bg-brand-dark/15 relative z-10" aria-hidden="true"></span>

                    <div class="hidden sm:flex items-center gap-1.5 relative z-10">
                        <span class="material-symbols-outlined text-[14px] text-[#0F766E]" style="font-variation-settings:'FILL' 1;" aria-hidden="true">verified</span>
                        <span class="text-[10px] font-mono font-bold tracking-[0.22em] text-[#0F766E] uppercase">CAE · RD 36/2023</span>
                    </div>
                </div>

                <div class="relative z-10 grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-14 items-end">
                    <div class="md:col-span-7">
                        <h2 class="text-[clamp(2.5rem,7vw,6rem)] font-light text-slate-900 tracking-[-0.045em] leading-[0.9]" id="kineticHeading">
                            <span class="heading-line">
                                <span class="letter-3d magnetic" data-char="N" style="--i:0">N</span><span class="letter-3d magnetic" data-char="u" style="--i:1">u</span><span class="letter-3d magnetic" data-char="e" style="--i:2">e</span><span class="letter-3d magnetic" data-char="s" style="--i:3">s</span><span class="letter-3d magnetic" data-char="t" style="--i:4">t</span><span class="letter-3d magnetic" data-char="r" style="--i:5">r</span><span class="letter-3d magnetic" data-char="a" style="--i:6">a</span><span class="letter-3d magnetic" data-char="s" style="--i:7">s</span>
                            </span>
                            <span class="heading-line heading-line-underline">
                                <span class="letter-3d magnetic" data-char="a" style="--i:8">a</span><span class="letter-3d magnetic" data-char="c" style="--i:9">c</span><span class="letter-3d magnetic" data-char="t" style="--i:10">t</span><span class="letter-3d magnetic" data-char="u" style="--i:11">u</span><span class="letter-3d magnetic" data-char="a" style="--i:12">a</span><span class="letter-3d magnetic" data-char="c" style="--i:13">c</span><span class="letter-3d magnetic" data-char="i" style="--i:14">i</span><span class="letter-3d magnetic" data-char="o" style="--i:15">o</span><span class="letter-3d magnetic" data-char="n" style="--i:16">n</span><span class="letter-3d magnetic" data-char="e" style="--i:17">e</span><span class="letter-3d magnetic" data-char="s" style="--i:18">s</span>

                                <svg class="heading-underline" viewBox="0 0 500 14" preserveAspectRatio="none" aria-hidden="true">
                                    <path d="M2,10 Q126,3 250,10 T498,10" stroke="url(#ug)" stroke-width="2" fill="none" stroke-linecap="round" pathLength="1"></path>
                                    <defs>
                                        <linearGradient id="ug" x1="0" x2="1">
                                            <stop offset="0%" stop-color="#0A161E"/>
                                            <stop offset="70%" stop-color="#2DD4BF"/>
                                            <stop offset="100%" stop-color="#2DD4BF" stop-opacity="0"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </span>
                        </h2>
                    </div>

                    <div class="md:col-span-5 flex flex-col gap-6 pb-2">
                        <p class="kinetic-para text-slate-600 text-base sm:text-lg leading-relaxed font-normal">
                            Actuamos en el desván o bajo cubierta, donde más ahorro energético se genera. Ejecución rápida, sin obras en casa y sin interrumpir tu día a día.
                        </p>
                        <div class="progress-strip flex items-center gap-2" aria-hidden="true">
                            <span class="progress-segment" data-idx="0"></span>
                            <span class="progress-segment" data-idx="1"></span>
                            <span class="progress-segment" data-idx="2"></span>
                            <span class="progress-segment" data-idx="3"></span>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 mt-10 sm:mt-14 h-px bg-slate-200/70 overflow-hidden">
                    <div class="bottom-line"></div>
                </div>
            </div>

            <div class="vslider-wrapper reveal">
                <div class="vslider-sticky">
                    <div class="vslider-ghost-num" id="vsliderGhostNum" aria-hidden="true">01</div>
                    <div class="vslider-content" id="vsliderContent">
                        <div class="vslider-badge">
                            <span class="relative flex w-1.5 h-1.5">
                                <span class="absolute inset-0 rounded-full bg-brand-accent animate-ping opacity-75"></span>
                                <span class="relative rounded-full w-1.5 h-1.5 bg-brand-accent"></span>
                            </span>
                            <span id="vsliderIndex">01 / 04</span>
                        </div>
                        <h3 class="vslider-title" id="vsliderTitle">Lana de roca</h3>
                        <p class="vslider-desc" id="vsliderDesc">Aislamiento térmico y acústico de alta eficiencia instalado en el desván o bajo cubierta de tu vivienda unifamiliar.</p>
                        <a href="{{ route('leads.create') }}" class="vslider-cta">
                            <span>Solicitar este servicio</span>
                            <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="vslider-indicators" id="vsliderIndicators" role="tablist" aria-label="Servicios">
                        <button class="vslider-indicator active" data-index="0" role="tab" aria-label="Servicio 1: Lana de roca" aria-selected="true"></button>
                        <button class="vslider-indicator" data-index="1" role="tab" aria-label="Servicio 2: Soplado mecánico" aria-selected="false"></button>
                        <button class="vslider-indicator" data-index="2" role="tab" aria-label="Servicio 3: Estudio técnico gratuito" aria-selected="false"></button>
                        <button class="vslider-indicator" data-index="3" role="tab" aria-label="Servicio 4: Gestión y validación CAE" aria-selected="false"></button>
                    </div>
                </div>

                <div class="vslider-track" id="vsliderTrack">
                    <div class="vslider-card" data-index="0">
                        <img src="{{ asset('images/colocacion-lana-mineral.jpg') }}" style="object-position:center 55%" alt="Lana de roca" loading="lazy">
                        <div class="vslider-card-overlay">
                            <span class="vslider-card-num">01 — Lana de roca</span>
                            <div class="vslider-card-info">
                                <h4>Lana de roca</h4>
                                <span>Bajo cubierta</span>
                            </div>
                        </div>
                    </div>
                    <div class="vslider-card" data-index="1">
                        <img src="{{ asset('images/insuflado-mecanico.jpg') }}" style="object-position:center 65%" alt="Soplado mecánico" loading="lazy">
                        <div class="vslider-card-overlay">
                            <span class="vslider-card-num">02 — Soplado</span>
                            <div class="vslider-card-info">
                                <h4>Soplado mecánico</h4>
                                <span>Sin obras</span>
                            </div>
                        </div>
                    </div>
                    <div class="vslider-card" data-index="2">
                        <img src="{{ asset('images/image11-640.webp') }}" style="object-position:center 35%" alt="Estudio técnico" loading="lazy">
                        <div class="vslider-card-overlay">
                            <span class="vslider-card-num">03 — Estudio</span>
                            <div class="vslider-card-info">
                                <h4>Estudio técnico gratuito</h4>
                                <span>Sin coste</span>
                            </div>
                        </div>
                    </div>
                    <div class="vslider-card" data-index="3">
                        <img src="{{ asset('images/image7c-640.webp') }}" style="object-position:center 65%" alt="Gestión CAE" loading="lazy">
                        <div class="vslider-card-overlay">
                            <span class="vslider-card-num">04 — CAE</span>
                            <div class="vslider-card-info">
                                <h4>Gestión y validación CAE</h4>
                                <span>RD 36/2023</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section id="mapa-norte" class="relative py-24 sm:py-28 bg-brand-dark overflow-hidden">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute inset-0 opacity-[0.055]" style="background-image: linear-gradient(#2DD4BF 1px, transparent 1px), linear-gradient(90deg, #2DD4BF 1px, transparent 1px); background-size: 72px 72px; mask-image: radial-gradient(ellipse 75% 65% at 50% 45%, black 25%, transparent 82%); -webkit-mask-image: radial-gradient(ellipse 75% 65% at 50% 45%, black 25%, transparent 82%);"></div>
            <div class="absolute -top-40 left-1/3 w-[720px] h-[720px] bg-brand-accent/[0.07] rounded-full blur-[150px]"></div>
            <div class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-teal-500/[0.08] rounded-full blur-[160px]"></div>
            <div class="absolute top-1/2 left-0 w-[400px] h-[400px] bg-brand-accent/[0.04] rounded-full blur-[120px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-8">
            <div class="reveal mb-10 sm:mb-14">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                    <div class="lg:col-span-8">
                        <div class="flex flex-wrap items-center gap-3 mb-6">
                            <span class="inline-flex items-center gap-2 bg-white/[0.05] backdrop-blur-xl border border-white/10 rounded-full px-3.5 py-1.5">
                                <span class="relative flex w-2 h-2">
                                    <span class="absolute inset-0 rounded-full bg-brand-accent animate-ping opacity-75"></span>
                                    <span class="relative rounded-full w-2 h-2 bg-brand-accent"></span>
                                </span>
                                <span class="text-[10px] font-semibold tracking-[0.22em] text-brand-accent uppercase">Cobertura activa</span>
                            </span>
                            <span class="font-mono text-[10px] tracking-[0.25em] text-slate-500 uppercase border-l border-white/10 pl-3">                            De Madrid al norte · ES</span>
                        </div>

                        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-light text-white tracking-[-0.03em] leading-[1.02]">
                            Nuestra cobertura
                            <span class="bg-gradient-to-r from-brand-accent via-teal-200 to-brand-accent bg-clip-text text-transparent italic font-medium kinetic-gradient">en España</span>
                        </h2>

                        <p class="mt-5 text-slate-400 text-base sm:text-lg font-light leading-relaxed max-w-xl">
                            Atendemos Madrid y las principales ciudades del norte y el este peninsular. Selecciona una ciudad para ver su ubicación.
                        </p>
                    </div>

                    <div class="lg:col-span-4 flex justify-start lg:justify-end">
                        <div class="flex items-center gap-6 px-5 py-4 rounded-2xl bg-white/[0.03] border border-white/[0.08] backdrop-blur-xl">
                            <div>
                                <span class="block text-[9px] font-mono tracking-[0.25em] text-slate-500 uppercase mb-1">Red activa</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-3xl font-light text-white tabular-nums" id="cityCount">{{ count($cities) }}</span>
                                    <span class="text-[10px] font-mono text-brand-accent">/ {{ count($cities) }}</span>
                                </div>
                            </div>
                            <div class="w-px h-10 bg-white/10"></div>
                            <div>
                                <span class="block text-[9px] font-mono tracking-[0.25em] text-slate-500 uppercase mb-1">Status</span>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-accent shadow-[0_0_8px_#2DD4BF] animate-pulse"></span>
                                    <span class="text-xs font-mono text-white">Online</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="reveal grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6">
                <div class="lg:col-span-4 order-2 lg:order-1">
                    <div class="relative h-full rounded-3xl bg-[#0B1922]/80 backdrop-blur-2xl border border-white/[0.08] overflow-hidden flex flex-col shadow-[0_20px_60px_-20px_rgba(0,0,0,0.5)]">
                        <div class="px-5 py-4 border-b border-white/[0.06] flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-accent shadow-[0_0_6px_#2DD4BF]"></span>
                                <span class="text-[10px] font-mono font-bold tracking-[0.25em] text-white uppercase">Nodos activos</span>
                            </div>
                            <span class="text-[9px] font-mono text-slate-500">{{ count($cities) }} / {{ count($cities) }}</span>
                        </div>
                        <div class="flex-1 overflow-y-auto max-h-[440px]" id="cityList"></div>
                        <div class="px-5 py-3 border-t border-white/[0.06] flex items-center justify-between text-[10px] font-mono">
                            <span class="text-slate-500">Sync</span>
                            <span class="text-brand-accent">justo ahora</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8 order-1 lg:order-2">
                    <div class="relative rounded-3xl overflow-hidden border border-white/[0.08] shadow-[0_25px_80px_-20px_rgba(0,0,0,0.6)]" style="height: 520px;">
                        <div id="spainNorthMap" class="w-full h-full"></div>
                        <div class="absolute top-4 left-4 z-[500] flex items-center gap-1 p-1 rounded-full bg-black/70 backdrop-blur-xl border border-white/10">
                            <button class="px-3 py-1.5 text-[9px] font-mono font-bold tracking-[0.15em] uppercase text-brand-dark bg-brand-accent rounded-full">Mapa</button>
                            <button class="px-3 py-1.5 text-[9px] font-mono font-bold tracking-[0.15em] uppercase text-slate-400 hover:text-white transition-colors">Grid</button>
                        </div>
                        <div class="absolute top-4 right-4 z-[500] flex items-center gap-2 px-3 py-1.5 rounded-full bg-black/70 backdrop-blur-xl border border-white/10">
                            <span class="relative flex w-1.5 h-1.5">
                                <span class="absolute inset-0 rounded-full bg-brand-accent animate-ping"></span>
                                <span class="relative rounded-full w-1.5 h-1.5 bg-brand-accent"></span>
                            </span>
                            <span class="text-[9px] font-mono font-bold tracking-[0.2em] text-white uppercase">Live</span>
                        </div>
                        <div class="absolute bottom-4 left-4 z-[500] flex items-center gap-3 px-3.5 py-2 rounded-full bg-black/70 backdrop-blur-xl border border-white/10">
                            <div class="flex items-center gap-1.5 font-mono text-[9px]">
                                <span class="text-slate-500">RED</span>
                                <span class="text-brand-accent tabular-nums">54 ciudades</span>
                            </div>
                            <div class="w-px h-3 bg-white/20"></div>
                            <div class="flex items-center gap-1.5 font-mono text-[9px]">
                                <span class="text-slate-500">ZONA</span>
                                <span class="text-brand-accent tabular-nums">Madrid · Norte</span>
                            </div>
                        </div>
                        <div class="absolute bottom-4 right-4 z-[500] flex items-center gap-2 px-3 py-2 rounded-full bg-black/70 backdrop-blur-xl border border-white/10">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-accent shadow-[0_0_8px_#2DD4BF]"></span>
                            <span class="text-[9px] font-mono tracking-[0.15em] text-slate-300 uppercase">CAE activo</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="reveal grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mt-4 sm:mt-6">
                <div class="group p-4 sm:p-5 rounded-2xl bg-white/[0.02] border border-white/[0.06] hover:bg-white/[0.04] hover:border-brand-accent/25 transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[9px] font-mono tracking-[0.2em] text-slate-500 uppercase">Equipos</span>
                        <i data-lucide="users" class="w-3.5 h-3.5 text-brand-accent/60 group-hover:text-brand-accent transition-colors" aria-hidden="true"></i>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-light text-white tabular-nums">124</span>
                        <span class="text-[10px] font-mono text-brand-accent">técnicos</span>
                    </div>
                </div>
                <div class="group p-4 sm:p-5 rounded-2xl bg-white/[0.02] border border-white/[0.06] hover:bg-white/[0.04] hover:border-brand-accent/25 transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[9px] font-mono tracking-[0.2em] text-slate-500 uppercase">Viviendas</span>
                        <i data-lucide="home" class="w-3.5 h-3.5 text-brand-accent/60 group-hover:text-brand-accent transition-colors" aria-hidden="true"></i>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-light text-white tabular-nums">2,418</span>
                        <span class="text-[10px] font-mono text-brand-accent">aisladas</span>
                    </div>
                </div>
                <div class="group p-4 sm:p-5 rounded-2xl bg-white/[0.02] border border-white/[0.06] hover:bg-white/[0.04] hover:border-brand-accent/25 transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[9px] font-mono tracking-[0.2em] text-slate-500 uppercase">Ahorro medio</span>
                        <i data-lucide="trending-down" class="w-3.5 h-3.5 text-brand-accent/60 group-hover:text-brand-accent transition-colors" aria-hidden="true"></i>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-light text-white tabular-nums">70</span>
                        <span class="text-[10px] font-mono text-brand-accent">%</span>
                    </div>
                </div>
                <div class="group p-4 sm:p-5 rounded-2xl bg-white/[0.02] border border-white/[0.06] hover:bg-white/[0.04] hover:border-brand-accent/25 transition-all">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[9px] font-mono tracking-[0.2em] text-slate-500 uppercase">Tiempo medio</span>
                        <i data-lucide="zap" class="w-3.5 h-3.5 text-brand-accent/60 group-hover:text-brand-accent transition-colors" aria-hidden="true"></i>
                    </div>
                    <div class="flex items-baseline gap-1">
                        <span class="text-2xl font-light text-white tabular-nums">3</span>
                        <span class="text-[10px] font-mono text-brand-accent">días</span>
                    </div>
                </div>
            </div>

            <p class="reveal text-center text-[10px] font-mono text-slate-500 mt-6 tracking-[0.15em] uppercase">
                Desplázate y haz zoom para explorar · Puntos brillantes = presencia técnica activa
            </p>
        </div>
    </section>

    <section id="cae" class="py-24 overflow-hidden bg-white">
        <div class="mx-auto max-w-7xl">
            <div class="reveal mb-4 text-center">
                <h2 class="text-4xl font-light text-slate-900 sm:text-5xl">Nuestros sistemas de aislamiento</h2>
                <p class="mx-auto mt-4 max-w-2xl text-slate-600">Soluciones técnicas adaptadas a cada tipo de vivienda y cubierta, ejecutadas por nuestro propio equipo.</p>
            </div>
            <div class="carousel-3d-wrapper reveal-3d relative w-full">
                <button id="prevSlide" aria-label="Anterior" class="absolute top-1/2 left-4 sm:left-[5%] -translate-y-1/2 z-40 w-12 h-12 bg-brand-dark text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform shadow-2xl">
                    <i data-lucide="arrow-left" class="w-5 h-5" aria-hidden="true"></i>
                </button>
                <button id="nextSlide" aria-label="Siguiente" class="absolute top-1/2 right-4 sm:right-[5%] -translate-y-1/2 z-40 w-12 h-12 bg-brand-dark text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform shadow-2xl">
                    <i data-lucide="arrow-right" class="w-5 h-5" aria-hidden="true"></i>
                </button>
                <div class="carousel-3d-track" id="carouselTrack"></div>
            </div>
        </div>


    </section>

    <section id="materiales" class="relative py-24 sm:py-32 bg-white overflow-hidden border-t border-slate-100">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute inset-0 opacity-[0.025]" style="background-image: linear-gradient(#0A161E 1px, transparent 1px), linear-gradient(90deg, #0A161E 1px, transparent 1px); background-size: 64px 64px; mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, black 20%, transparent 80%); -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, black 20%, transparent 80%);"></div>
            <div class="absolute -top-40 left-1/4 w-[720px] h-[720px] bg-brand-accent/[0.04] rounded-full blur-[160px]"></div>
            <div class="absolute bottom-0 right-1/4 w-[560px] h-[560px] bg-teal-500/[0.03] rounded-full blur-[150px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-8 z-10">
            <div class="reveal mb-12 sm:mb-16">
                <div class="flex items-center gap-3 sm:gap-4 mb-8 sm:mb-10">
                    <span class="shimmer-badge">
                        <span class="badge-dot"></span>
                        <span class="relative z-10">Materiales certificados</span>
                        <span class="badge-shimmer"></span>
                    </span>
                    <div class="flex-1 h-px bg-gradient-to-r from-slate-300 via-slate-200/60 to-transparent"></div>
                    <div class="meta-index">
                        <span class="meta-dot"></span>
                        <span class="hidden sm:inline">Fichas técnicas · </span>
                        <span class="font-bold text-brand-dark tabular-nums">02</span>
                        <span class="text-slate-400"> / 02</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-14 items-end">
                    <div class="md:col-span-7">
                        <h2 class="text-[clamp(2.5rem,7vw,5.5rem)] font-light text-slate-900 tracking-[-0.045em] leading-[0.9]">
                            <span class="mask-line block"><span class="kinetic-line" style="--delay:0ms">Materiales</span></span>
                            <span class="mask-line block"><span class="kinetic-line" style="--delay:120ms">certificados</span></span>
                        </h2>
                    </div>
                    <div class="md:col-span-5 flex flex-col gap-6 pb-2">
                        <p class="text-slate-600 text-base sm:text-lg leading-relaxed">
                            Trabajamos con fabricantes europeos de referencia en aislamientos minerales. Cada material está respaldado por certificaciones técnicas y medioambientales que garantizan su rendimiento y seguridad.
                        </p>
                        <div class="flex items-center gap-2" aria-hidden="true">
                            <span class="progress-segment" style="width:24px;background:#0A161E;height:4px;border-radius:999px;"></span>
                            <span class="progress-segment" style="width:24px;background:#2DD4BF;height:4px;border-radius:999px;"></span>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 mt-10 sm:mt-14 h-px bg-slate-200/70 overflow-hidden">
                    <div class="bottom-line"></div>
                </div>
            </div>

            <div class="reveal grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6">
                <article class="group relative bg-white rounded-3xl border border-slate-200/70 shadow-[0_1px_2px_rgba(10,22,30,0.04)] overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">
                    <div class="relative h-44 sm:h-52 overflow-hidden bg-gradient-to-br from-rose-50 via-white to-rose-50 border-b border-slate-100">
                        <div class="absolute inset-0 opacity-[0.05]" style="background-image: radial-gradient(circle at 25% 35%, #E30613 1px, transparent 1px), radial-gradient(circle at 75% 65%, #E30613 1px, transparent 1px); background-size: 32px 32px;"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <svg viewBox="0 0 240 56" class="h-10 sm:h-12 mb-1" aria-label="Volcalis">
                                <text x="0" y="44" font-family="'Plus Jakarta Sans', 'Helvetica Neue', sans-serif" font-weight="800" font-size="46" fill="#E30613" letter-spacing="-2">Volcalis</text>
                            </svg>
                            <span class="text-[10px] font-mono tracking-[0.35em] text-slate-500 uppercase mt-1">Aislamientos minerales</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-rose-200 text-[9px] font-mono font-bold tracking-[0.15em] text-[#E30613] uppercase shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#E30613]"></span>
                                EASY · Rollo Kraft
                            </span>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <div class="flex items-start justify-between gap-4 mb-5">
                            <div>
                                <span class="block text-[10px] font-mono text-slate-400 tracking-[0.3em] uppercase mb-1.5">Ficha técnica · 01</span>
                                <h4 class="text-xl font-medium text-brand-dark leading-tight">Lana Mineral Revestida a Papel Kraft</h4>
                                <p class="text-sm text-slate-500 mt-1.5">Rollo revestido de un lado con una barrera de vapor en papel kraft, ligero y de fácil aplicación.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mb-5">
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <span class="block text-[8px] font-mono tracking-[0.2em] text-slate-400 uppercase mb-1">Conductividad</span>
                                <span class="text-lg font-light text-brand-dark tabular-nums">0.040 <span class="text-[10px] font-mono text-slate-500">W/m·K</span></span>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <span class="block text-[8px] font-mono tracking-[0.2em] text-slate-400 uppercase mb-1">Espesor</span>
                                <span class="text-lg font-light text-brand-dark tabular-nums">50–280 <span class="text-[10px] font-mono text-slate-500">mm</span></span>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <span class="block text-[8px] font-mono tracking-[0.2em] text-slate-400 uppercase mb-1">Resist. térmica</span>
                                <span class="text-lg font-light text-brand-dark tabular-nums">1.25–7.00 <span class="text-[10px] font-mono text-slate-500">m²·K/W</span></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 mb-5">
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-rose-50/60 transition-colors" title="Aislamiento térmico">
                                <span class="volcalis-icon"><i data-lucide="thermometer" class="w-4 h-4" aria-hidden="true"></i></span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">Térmico</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-rose-50/60 transition-colors" title="Aislamiento acústico">
                                <span class="volcalis-icon"><i data-lucide="volume-2" class="w-4 h-4" aria-hidden="true"></i></span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">Acústico</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-rose-50/60 transition-colors" title="Material incombustible">
                                <span class="volcalis-icon"><i data-lucide="flame" class="w-4 h-4" aria-hidden="true"></i></span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">Incombustible</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-rose-50/60 transition-colors" title="Múltiple aplicaciones">
                                <span class="volcalis-icon"><i data-lucide="home" class="w-4 h-4" aria-hidden="true"></i></span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">Aplicaciones</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-rose-50/60 transition-colors" title="Proceso sostenible">
                                <span class="volcalis-icon"><i data-lucide="recycle" class="w-4 h-4" aria-hidden="true"></i></span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">Sostenible</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-rose-50/60 transition-colors" title="Aplicación cómoda">
                                <span class="volcalis-icon"><i data-lucide="hand" class="w-4 h-4" aria-hidden="true"></i></span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">Fácil</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mb-4 text-[11px] font-mono text-slate-500">
                            <i data-lucide="layout" class="w-3.5 h-3.5 text-[#E30613]" aria-hidden="true"></i>
                            <span>Aplicación: techos y cubiertas inclinadas</span>
                        </div>

                        <div class="flex flex-wrap items-center gap-1.5 pt-4 border-t border-slate-100">
                            <span class="text-[9px] font-mono tracking-[0.15em] text-slate-400 uppercase mr-1">Certificaciones</span>
                            <span class="px-2 py-1 rounded-md bg-slate-100 text-[9px] font-mono font-bold text-slate-600">CE</span>
                            <span class="px-2 py-1 rounded-md bg-slate-100 text-[9px] font-mono font-bold text-slate-600">ACERMI</span>
                            <span class="px-2 py-1 rounded-md bg-slate-100 text-[9px] font-mono font-bold text-slate-600">EPD</span>
                            <span class="px-2 py-1 rounded-md bg-slate-100 text-[9px] font-mono font-bold text-slate-600">FDES</span>
                            <span class="px-2 py-1 rounded-md bg-slate-100 text-[9px] font-mono font-bold text-slate-600">EUCEB</span>
                        </div>
                    </div>
                </article>

                <article class="group relative bg-white rounded-3xl border border-slate-200/70 shadow-[0_1px_2px_rgba(10,22,30,0.04)] overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-1">
                    <div class="relative h-44 sm:h-52 overflow-hidden bg-gradient-to-br from-slate-50 via-white to-blue-50/60 border-b border-slate-100">
                        <div class="absolute inset-0 opacity-[0.05]" style="background-image: radial-gradient(circle at 30% 40%, #1B3A6B 1px, transparent 1px), radial-gradient(circle at 70% 60%, #1B3A6B 1px, transparent 1px); background-size: 32px 32px;"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <svg viewBox="0 0 140 60" class="h-14 sm:h-16 mb-1" aria-label="URSA">
                                <g fill="#1B3A6B">
                                    <ellipse cx="52" cy="36" rx="24" ry="11"/>
                                    <circle cx="30" cy="28" r="9"/>
                                    <circle cx="23" cy="21" r="3.5"/>
                                    <circle cx="36" cy="21" r="3.5"/>
                                    <ellipse cx="22" cy="31" rx="4" ry="2.4"/>
                                    <rect x="34" y="43" width="6" height="11" rx="2.5"/>
                                    <rect x="44" y="43" width="6" height="11" rx="2.5"/>
                                    <rect x="55" y="43" width="6" height="11" rx="2.5"/>
                                    <rect x="66" y="43" width="6" height="11" rx="2.5"/>
                                    <circle cx="27" cy="26" r="1.2" fill="#fff"/>
                                    <ellipse cx="100" cy="47" rx="12" ry="6"/>
                                    <circle cx="91" cy="42" r="4.5"/>
                                    <circle cx="87" cy="38" r="2"/>
                                    <circle cx="94" cy="38" r="2"/>
                                    <rect x="95" y="51" width="3" height="6" rx="1.5"/>
                                    <rect x="102" y="51" width="3" height="6" rx="1.5"/>
                                    <circle cx="89" cy="41" r="0.7" fill="#fff"/>
                                </g>
                                <text x="70" y="60" text-anchor="middle" font-family="'Plus Jakarta Sans', 'Helvetica Neue', sans-serif" font-weight="900" font-style="italic" font-size="20" fill="#1B3A6B" letter-spacing="-0.5">URSA</text>
                            </svg>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white border border-blue-200 text-[9px] font-mono font-bold tracking-[0.15em] text-[#1B3A6B] uppercase shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#1B3A6B]"></span>
                                PULS'R 47 · Soplado
                            </span>
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <div class="flex items-start justify-between gap-4 mb-5">
                            <div>
                                <span class="block text-[10px] font-mono text-slate-400 tracking-[0.3em] uppercase mb-1.5">Ficha técnica · 02</span>
                                <h4 class="text-xl font-medium text-brand-dark leading-tight">Lana mineral blanca sin ligantes</h4>
                                <p class="text-sm text-slate-500 mt-1.5">Incombustible y repelente al agua, para aplicar por soplado conforme a la norma EN 14064.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mb-5">
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <span class="block text-[8px] font-mono tracking-[0.2em] text-slate-400 uppercase mb-1">Conductividad</span>
                                <span class="text-lg font-light text-brand-dark tabular-nums">0.047 <span class="text-[10px] font-mono text-slate-500">W/m·K</span></span>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <span class="block text-[8px] font-mono tracking-[0.2em] text-slate-400 uppercase mb-1">Densidad</span>
                                <span class="text-lg font-light text-brand-dark tabular-nums">11 <span class="text-[10px] font-mono text-slate-500">kg/m³</span></span>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <span class="block text-[8px] font-mono tracking-[0.2em] text-slate-400 uppercase mb-1">Reacción fuego</span>
                                <span class="text-lg font-light text-[#1B3A6B] tabular-nums">A1 <span class="text-[10px] font-mono text-slate-500">Euroclase</span></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 sm:grid-cols-6 gap-2 mb-5">
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-blue-50/60 transition-colors" title="Conductividad λ 0.047">
                                <span class="ursa-icon text-lg font-bold leading-none" style="font-family: ui-serif, Georgia, serif;">λ</span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">λ 0.047</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-blue-50/60 transition-colors" title="Emisiones A+">
                                <span class="ursa-icon text-[10px] font-bold leading-none">A+</span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">Emisiones</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-blue-50/60 transition-colors" title="Material incombustible">
                                <span class="ursa-icon"><i data-lucide="flame" class="w-4 h-4" aria-hidden="true"></i></span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">A1 Fuego</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-blue-50/60 transition-colors" title="Más de 80% vidrio reciclado">
                                <span class="ursa-icon"><i data-lucide="recycle" class="w-4 h-4" aria-hidden="true"></i></span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">&gt;80% Rec.</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-blue-50/60 transition-colors" title="Repelente al agua">
                                <span class="ursa-icon"><i data-lucide="droplets" class="w-4 h-4" aria-hidden="true"></i></span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">Hidrófugo</span>
                            </div>
                            <div class="flex flex-col items-center gap-1.5 p-2 rounded-xl hover:bg-blue-50/60 transition-colors" title="Aislamiento acústico">
                                <span class="ursa-icon"><i data-lucide="volume-2" class="w-4 h-4" aria-hidden="true"></i></span>
                                <span class="text-[8px] font-mono tracking-wider text-slate-500 uppercase text-center leading-tight">Acústico</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mb-4 text-[11px] font-mono text-slate-500">
                            <i data-lucide="layout" class="w-3.5 h-3.5 text-[#1B3A6B]" aria-hidden="true"></i>
                            <span>Aplicación: buhardillas no habitables, bajo cubiertas y falsos techos</span>
                        </div>

                        <div class="flex flex-wrap items-center gap-1.5 pt-4 border-t border-slate-100">
                            <span class="text-[9px] font-mono tracking-[0.15em] text-slate-400 uppercase mr-1">Certificaciones</span>
                            <span class="px-2 py-1 rounded-md bg-slate-100 text-[9px] font-mono font-bold text-slate-600">CE</span>
                            <span class="px-2 py-1 rounded-md bg-slate-100 text-[9px] font-mono font-bold text-slate-600">ACERMI</span>
                            <span class="px-2 py-1 rounded-md bg-slate-100 text-[9px] font-mono font-bold text-slate-600">EUCEB</span>
                            <span class="px-2 py-1 rounded-md bg-[#1B3A6B]/10 text-[9px] font-mono font-bold text-[#1B3A6B]">Eurofins GOLD</span>
                        </div>
                    </div>
                </article>
            </div>

            <div class="reveal mt-8 sm:mt-10 flex flex-col sm:flex-row items-center justify-between gap-4 p-5 sm:p-6 rounded-3xl bg-white border border-slate-200/70 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-full bg-brand-dark flex items-center justify-center text-brand-accent shrink-0">
                        <i data-lucide="award" class="w-5 h-5" aria-hidden="true"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] font-mono tracking-[0.2em] uppercase text-slate-400">Fabricantes partners</span>
                        <span class="block text-base font-medium text-brand-dark">Volcalis · URSA · Grupo Preceram</span>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1.5 rounded-full bg-slate-50 border border-slate-100 text-[10px] font-mono font-bold text-slate-500 tracking-wider">CE</span>
                    <span class="px-3 py-1.5 rounded-full bg-slate-50 border border-slate-100 text-[10px] font-mono font-bold text-slate-500 tracking-wider">ACERMI</span>
                    <span class="px-3 py-1.5 rounded-full bg-slate-50 border border-slate-100 text-[10px] font-mono font-bold text-slate-500 tracking-wider">EPD</span>
                    <span class="px-3 py-1.5 rounded-full bg-slate-50 border border-slate-100 text-[10px] font-mono font-bold text-slate-500 tracking-wider">EUCEB</span>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="relative py-24 sm:py-32 bg-brand-dark overflow-hidden">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute inset-0 opacity-[0.055]" style="background-image: linear-gradient(#2DD4BF 1px, transparent 1px), linear-gradient(90deg, #2DD4BF 1px, transparent 1px); background-size: 72px 72px; mask-image: radial-gradient(ellipse 72% 62% at 50% 42%, black 22%, transparent 82%); -webkit-mask-image: radial-gradient(ellipse 72% 62% at 50% 42%, black 22%, transparent 82%);"></div>
            <div class="absolute -top-40 left-1/4 w-[720px] h-[720px] bg-brand-accent/[0.075] rounded-full blur-[160px]"></div>
            <div class="absolute bottom-0 right-1/3 w-[560px] h-[560px] bg-teal-500/[0.08] rounded-full blur-[150px]"></div>
            <div class="absolute top-1/3 -left-20 w-[380px] h-[380px] bg-brand-accent/[0.05] rounded-full blur-[110px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-8">
            <div class="reveal mb-10 sm:mb-14">
                <div class="flex items-center gap-3 sm:gap-4 mb-10 sm:mb-14">
                    <span class="inline-flex items-center gap-2 bg-white/[0.05] backdrop-blur-xl border border-white/10 rounded-full px-3.5 py-1.5">
                        <span class="relative flex w-1.5 h-1.5">
                            <span class="absolute inset-0 rounded-full bg-brand-accent animate-ping opacity-75"></span>
                            <span class="relative rounded-full w-1.5 h-1.5 bg-brand-accent"></span>
                        </span>
                        <span class="text-[10px] font-semibold tracking-[0.22em] text-brand-accent uppercase">Voces verificadas</span>
                    </span>
                    <div class="flex-1 h-px bg-gradient-to-r from-white/20 via-white/10 to-transparent"></div>
                    <div class="meta-index">
                        <span class="meta-dot"></span>
                        <span class="hidden sm:inline">Testimonios · </span>
                        <span class="font-bold text-white tabular-nums">03</span>
                        <span class="text-slate-500"> / 05</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-14 items-end">
                    <div class="md:col-span-7">
                        <h2 class="text-[clamp(2.5rem,7vw,6rem)] font-light text-white tracking-[-0.045em] leading-[0.9]">
                            <span class="heading-line">
                                <span class="letter-3d magnetic" data-char="H" style="--i:0">H</span><span class="letter-3d magnetic" data-char="i" style="--i:1">i</span><span class="letter-3d magnetic" data-char="s" style="--i:2">s</span><span class="letter-3d magnetic" data-char="t" style="--i:3">t</span><span class="letter-3d magnetic" data-char="o" style="--i:4">o</span><span class="letter-3d magnetic" data-char="r" style="--i:5">r</span><span class="letter-3d magnetic" data-char="i" style="--i:6">i</span><span class="letter-3d magnetic" data-char="a" style="--i:7">a</span><span class="letter-3d magnetic" data-char="s" style="--i:8">s</span>
                            </span>
                            <span class="heading-line">
                                <span class="letter-3d magnetic" data-char="r" style="--i:9">r</span><span class="letter-3d magnetic" data-char="e" style="--i:10">e</span><span class="letter-3d magnetic" data-char="a" style="--i:11">a</span><span class="letter-3d magnetic" data-char="l" style="--i:12">l</span><span class="letter-3d magnetic" data-char="e" style="--i:13">e</span><span class="letter-3d magnetic" data-char="s" style="--i:14">s</span>
                                <span class="letter-3d" style="--i:15">&nbsp;</span>
                                <span class="letter-3d magnetic" data-char="d" style="--i:16">d</span><span class="letter-3d magnetic" data-char="e" style="--i:17">e</span>
                                <span class="letter-3d" style="--i:18">&nbsp;</span>
                                <span class="letter-3d magnetic text-brand-accent" data-char="a" style="--i:19">a</span><span class="letter-3d magnetic text-brand-accent" data-char="h" style="--i:20">h</span><span class="letter-3d magnetic text-brand-accent" data-char="o" style="--i:21">o</span><span class="letter-3d magnetic text-brand-accent" data-char="r" style="--i:22">r</span><span class="letter-3d magnetic text-brand-accent" data-char="r" style="--i:23">r</span><span class="letter-3d magnetic text-brand-accent" data-char="o" style="--i:24">o</span>
                            </span>
                        </h2>
                    </div>

                    <div class="md:col-span-5 flex flex-col gap-6 pb-2">
                        <p class="kinetic-para text-slate-400 text-base sm:text-lg leading-relaxed font-light">
                            En aislagratis cada vivienda cuenta. La experiencia de nuestros propietarios es lo que impulsa nuestro trabajo.
                        </p>
                        <div class="flex items-center gap-2" aria-hidden="true">
                            <span class="tst-header-seg"></span>
                            <span class="tst-header-seg"></span>
                            <span class="tst-header-seg"></span>
                            <span class="tst-header-seg"></span>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 mt-10 sm:mt-14 h-px bg-white/10 overflow-hidden">
                    <div class="bottom-line is-dark"></div>
                </div>
            </div>

            <div class="reveal grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6">
                <div class="lg:col-span-7">
                    <div class="relative h-full rounded-3xl bg-[#0B1922]/85 backdrop-blur-2xl border border-white/[0.08] overflow-hidden flex flex-col shadow-[0_30px_90px_-30px_rgba(0,0,0,0.75)]">
                        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brand-accent/70 to-transparent"></div>
                        <div class="absolute -top-28 -right-24 w-80 h-80 bg-brand-accent/10 rounded-full blur-[110px] pointer-events-none"></div>

                        <div class="relative flex-1 flex flex-col p-7 sm:p-10">
                            <div class="flex items-center justify-between gap-4 mb-7">
                                <div class="inline-flex items-center gap-2 bg-white/[0.05] backdrop-blur-xl border border-white/10 rounded-full px-3.5 py-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-accent shadow-[0_0_6px_#2DD4BF]"></span>
                                    <span class="text-[9px] font-mono font-bold tracking-[0.2em] text-slate-300 uppercase">Testimonio verificado</span>
                                </div>
                                <div class="flex items-center gap-1 text-amber-400" role="img" aria-label="Valoración: 5 de 5 estrellas">
                                    @for ($star = 1; $star <= 5; $star++)
                                        <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400" aria-hidden="true"></i>
                                    @endfor
                                    <span class="ml-2 text-[10px] font-mono text-slate-400 tracking-widest">5.0</span>
                                </div>
                            </div>

                            <div class="relative flex-1 flex items-center min-h-[210px] sm:min-h-[240px]">
                                <span class="absolute -top-8 -left-2 text-[9rem] leading-none font-serif text-white/[0.055] select-none pointer-events-none" aria-hidden="true">"</span>
                                <blockquote id="testimonialText" class="tst-quote relative text-xl sm:text-2xl lg:text-[1.9rem] font-light text-white leading-[1.38] tracking-[-0.015em]">
                                    "{{ $testimonialData[0]['quote'] }}"
                                </blockquote>
                            </div>

                            <div class="mt-8 pt-6 border-t border-white/[0.08] flex flex-wrap items-center justify-between gap-5">
                                <div class="flex items-center gap-4">
                                    <div class="relative shrink-0">
                                        <img id="testimonialAvatar" src="{{ $testimonialData[0]['avatar'] }}" class="w-14 h-14 rounded-full object-cover ring-2 ring-brand-accent/30 shadow-lg" alt="" loading="lazy">
                                        <span class="absolute -bottom-0.5 -right-0.5 w-5 h-5 rounded-full bg-brand-accent border-2 border-[#0B1922] flex items-center justify-center">
                                            <i data-lucide="check" class="w-3 h-3 text-brand-dark" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 id="testimonialAuthor" class="text-white font-medium text-sm sm:text-base truncate">{{ $testimonialData[0]['author'] }}</h4>
                                        <p id="testimonialRole" class="text-[11px] font-mono text-slate-400 truncate">{{ $testimonialData[0]['role'] }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="px-3.5 py-2 rounded-xl bg-white/[0.03] border border-white/[0.07]">
                                        <span class="block text-[8px] font-mono tracking-[0.2em] text-slate-500 uppercase mb-0.5">Ahorro</span>
                                        <span id="tstSaving" class="text-sm font-light text-brand-accent tabular-nums leading-none">{{ $testimonialData[0]['saving'] }}</span>
                                    </div>
                                    <div class="px-3.5 py-2 rounded-xl bg-white/[0.03] border border-white/[0.07]">
                                        <span class="block text-[8px] font-mono tracking-[0.2em] text-slate-500 uppercase mb-0.5">Ciudad</span>
                                        <span id="tstCity" class="text-sm font-light text-white leading-none">{{ $testimonialData[0]['city'] }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-7 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-2" id="tstDots" role="tablist" aria-label="Testimonios"></div>
                                <div class="flex items-center gap-3">
                                    <span class="font-mono text-[10px] text-slate-500 tabular-nums tracking-[0.2em]">
                                        <span id="tstIndex" class="text-white font-bold">01</span> / {{ str_pad((string) count($testimonialData), 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <button id="prevTestimonial" aria-label="Testimonio anterior" class="w-10 h-10 rounded-full border border-white/15 bg-white/[0.03] flex items-center justify-center text-white hover:bg-brand-accent hover:text-brand-dark hover:border-brand-accent transition-all duration-300 hover:-translate-y-0.5">
                                            <i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i>
                                        </button>
                                        <button id="nextTestimonial" aria-label="Testimonio siguiente" class="w-10 h-10 rounded-full border border-white/15 bg-white/[0.03] flex items-center justify-center text-white hover:bg-brand-accent hover:text-brand-dark hover:border-brand-accent transition-all duration-300 hover:-translate-y-0.5">
                                            <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 h-[2px] bg-white/[0.06]">
                            <div id="tstAutoplay" class="h-full w-full"></div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="h-full rounded-3xl bg-[#0B1922]/85 backdrop-blur-2xl border border-white/[0.08] overflow-hidden flex flex-col shadow-[0_20px_60px_-20px_rgba(0,0,0,0.6)]">
                        <div class="px-5 py-4 border-b border-white/[0.06] flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-accent shadow-[0_0_6px_#2DD4BF]"></span>
                                <span class="text-[10px] font-mono font-bold tracking-[0.25em] text-white uppercase">Propietarios</span>
                            </div>
                            <span class="text-[9px] font-mono text-slate-500">{{ str_pad((string) count($testimonialData), 2, '0', STR_PAD_LEFT) }} / {{ str_pad((string) count($testimonialData), 2, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex-1 overflow-y-auto max-h-[360px]" id="testimonialList"></div>
                        <div class="px-5 py-3.5 border-t border-white/[0.06] flex items-center justify-between text-[10px] font-mono">
                            <span class="text-slate-500 uppercase tracking-[0.2em]">Valoración media</span>
                            <span class="text-brand-accent font-bold">9.7 / 10</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="requisitos" class="relative py-24 sm:py-32 overflow-hidden bg-brand-lightBg border-t border-slate-100">
        <div class="rq-spotlight absolute inset-0"></div>
        <div class="absolute -top-16 right-0 select-none pointer-events-none overflow-hidden" aria-hidden="true">
            <span class="rq-ghost block font-serif italic text-brand-dark/[0.035] pr-8" style="font-size: clamp(12rem, 26vw, 24rem); line-height: 1;">04</span>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-8 z-10">
            <div class="rq-head mb-16 sm:mb-20">
                <div class="flex items-center gap-3 sm:gap-4 mb-10">
                    <span class="inline-flex items-center gap-2 bg-brand-dark text-white rounded-full px-4 py-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-accent animate-pulse"></span>
                        <span class="text-[10px] font-mono tracking-[0.25em] uppercase">Antes de empezar</span>
                    </span>
                    <div class="flex-1 h-px bg-brand-dark/10"></div>
                    <span class="hidden sm:flex text-[10px] font-mono text-slate-400 tracking-[0.3em] uppercase"><span class="text-brand-dark font-bold">04</span>&nbsp;/&nbsp;04</span>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                    <div class="lg:col-span-9">
                        <h2 class="font-light tracking-[-0.04em] leading-[0.88]">
                            <span class="rq-line block font-serif italic text-brand-dark" style="font-size: clamp(3rem, 9vw, 8rem);">Requisitos</span>
                            <span class="rq-line block text-slate-500 font-sans" style="font-size: clamp(2rem, 5.5vw, 4.5rem);">para acceder <span class="font-serif italic text-[#0F766E] relative inline-block">al CAE<svg class="rq-underline absolute left-0 -bottom-2 w-full" height="8" viewBox="0 0 200 8" preserveAspectRatio="none" aria-hidden="true"><path d="M2,4 Q50,1 100,4 T198,4" stroke="#2DD4BF" stroke-width="2" fill="none" stroke-linecap="round" pathLength="1"></path></svg></span></span>
                        </h2>
                    </div>
                    <div class="lg:col-span-3 flex justify-start lg:justify-end">
                        <div class="req-stamp-rotator relative w-32 h-32 sm:w-36 sm:h-36">
                            <svg viewBox="0 0 200 200" class="w-full h-full" aria-hidden="true">
                                <defs><path id="rq-circle" d="M100,100 m-78,0 a78,78 0 1,1 156,0 a78,78 0 1,1 -156,0"/></defs>
                                <text class="fill-brand-dark/60" style="font-family: ui-monospace, monospace;" font-size="10.5" letter-spacing="5.5" font-weight="600">
                                    <textPath href="#rq-circle">VERIFIED · CAE · RD 36/2023 · VERIFIED · CAE · RD 36/2023 ·</textPath>
                                </text>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 rounded-full bg-brand-dark flex flex-col items-center justify-center text-brand-lightBg">
                                    <span class="text-[8px] font-mono tracking-widest opacity-70">STATUS</span>
                                    <span class="text-[11px] font-bold tracking-wider">OPEN</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rq-bento grid grid-cols-12 gap-4 sm:gap-5">
                <article class="rq-card col-span-12 md:col-span-7 relative bg-white rounded-3xl p-7 sm:p-9 overflow-hidden border border-brand-dark/[0.06] shadow-[0_1px_2px_rgba(10,22,30,0.04)] group">
                    <span class="rq-stamp absolute top-6 right-6 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border-2 border-dashed border-[#0F766E] text-[#0F766E] text-[9px] font-mono font-bold tracking-[0.2em] uppercase bg-white/85 backdrop-blur-sm pointer-events-none">✓ CUMPLE</span>
                    <div class="flex items-start justify-between gap-6 mb-6">
                        <div>
                            <span class="block text-[10px] font-mono text-slate-400 tracking-[0.3em] uppercase mb-2">01 — Antigüedad</span>
                            <h3 class="text-xl font-medium text-brand-dark leading-tight">Vivienda<br>de más de 5 años</h3>
                        </div>
                        <svg class="rq-draw w-14 h-14 text-[#0F766E] shrink-0" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path class="rq-path" d="M15 50 L50 18 L85 50" pathLength="1"/>
                            <path class="rq-path" d="M28 50 L28 82 L72 82 L72 50" pathLength="1"/>
                            <path class="rq-path" d="M42 82 L42 62 L58 62 L58 82" pathLength="1"/>
                        </svg>
                    </div>
                    <div class="flex items-end gap-3 mt-8">
                        <div class="rq-counter text-brand-dark leading-none" data-target="5" style="font-size: clamp(4rem, 10vw, 7rem); font-weight: 300;">0</div>
                        <div class="pb-3">
                            <span class="block text-2xl font-serif italic text-[#0F766E] leading-none mb-1">años</span>
                            <span class="block text-[10px] font-mono text-slate-400 tracking-[0.2em] uppercase">mínimo</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed mt-4 max-w-md">La vivienda unifamiliar debe tener más de 5 años de antigüedad para poder optar al programa CAE.</p>
                </article>

                <article class="rq-card col-span-12 md:col-span-5 relative bg-brand-dark text-brand-lightBg rounded-3xl p-7 sm:p-9 overflow-hidden group">
                    <span class="rq-stamp absolute top-6 right-6 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border-2 border-dashed border-[#2DD4BF] text-[#2DD4BF] text-[9px] font-mono font-bold tracking-[0.2em] uppercase bg-brand-dark/85 backdrop-blur-sm pointer-events-none">✓ CUMPLE</span>
                    <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-[#2DD4BF]/10 rounded-full blur-3xl pointer-events-none"></div>
                    <span class="block text-[10px] font-mono text-[#2DD4BF] tracking-[0.3em] uppercase mb-2 relative z-10">02 — Acceso</span>
                    <h3 class="text-xl font-medium leading-tight relative z-10">Acceso al<br>desván o cubierta</h3>
                    <div class="my-8 relative z-10">
                        <svg class="rq-draw w-full h-28 text-[#2DD4BF]" viewBox="0 0 200 100" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path class="rq-path" d="M10 88 L30 88 L30 68 L55 68 L55 48 L80 48 L80 28 L105 28 L105 88" pathLength="1"/>
                            <path class="rq-path" d="M120 88 L120 20 L180 20 L180 88" pathLength="1" stroke-dasharray="3 3" opacity="0.5"/>
                            <circle class="rq-path" cx="150" cy="55" r="10" pathLength="1"/>
                        </svg>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed relative z-10">Debe existir un acceso físico al desván o cubierta para poder realizar la actuación técnica.</p>
                </article>

                <article class="rq-card col-span-12 md:col-span-5 relative bg-white rounded-3xl p-7 sm:p-9 overflow-hidden border border-brand-dark/[0.06] shadow-[0_1px_2px_rgba(10,22,30,0.04)] group">
                    <span class="rq-stamp absolute top-6 right-6 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border-2 border-dashed border-[#0F766E] text-[#0F766E] text-[9px] font-mono font-bold tracking-[0.2em] uppercase bg-white/85 backdrop-blur-sm pointer-events-none">✓ CUMPLE</span>
                    <span class="block text-[10px] font-mono text-slate-400 tracking-[0.3em] uppercase mb-2">03 — Historial</span>
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <h3 class="text-xl font-medium text-brand-dark leading-tight">Sin subvención previa reciente</h3>
                        <svg class="rq-draw w-12 h-12 text-[#0F766E] shrink-0" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect class="rq-path" x="20" y="28" width="60" height="54" rx="4" pathLength="1"/>
                            <path class="rq-path" d="M20 44 L80 44" pathLength="1"/>
                            <path class="rq-path" d="M36 18 L36 34 M64 18 L64 34" pathLength="1"/>
                            <path class="rq-path" d="M38 58 L62 78 M62 58 L38 78" pathLength="1" stroke="#dc2626"/>
                        </svg>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">No haber obtenido ayuda o subvención similar en los últimos 5 años para la misma vivienda.</p>
                </article>

                <article class="rq-card col-span-12 md:col-span-7 relative bg-brand-dark text-brand-lightBg rounded-3xl p-7 sm:p-9 overflow-hidden group">
                    <span class="rq-stamp absolute top-6 right-6 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border-2 border-dashed border-[#2DD4BF] text-[#2DD4BF] text-[9px] font-mono font-bold tracking-[0.2em] uppercase bg-brand-dark/85 backdrop-blur-sm pointer-events-none">✓ CUMPLE</span>
                    <div class="absolute top-1/2 -right-16 w-56 h-56 bg-[#2DD4BF]/10 rounded-full blur-3xl pointer-events-none -translate-y-1/2"></div>
                    <span class="block text-[10px] font-mono text-[#2DD4BF] tracking-[0.3em] uppercase mb-2 relative z-10">04 — Estructura</span>
                    <div class="flex items-start justify-between gap-6 mb-4 relative z-10">
                        <h3 class="text-xl font-medium leading-tight">Condiciones estructurales adecuadas</h3>
                        <svg class="rq-draw w-14 h-14 text-[#2DD4BF] shrink-0" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect class="rq-path" x="25" y="45" width="50" height="40" pathLength="1"/>
                            <path class="rq-path" d="M35 45 L35 25 L65 25 L65 45" pathLength="1"/>
                            <path class="rq-path" d="M40 55 L48 55 M52 55 L60 55 M40 68 L48 68 M52 68 L60 68" pathLength="1" opacity="0.7"/>
                        </svg>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed relative z-10">Las condiciones estructurales del inmueble deben ser adecuadas para garantizar la viabilidad de la instalación.</p>
                </article>
            </div>

            <div class="rq-verify mt-10 sm:mt-12 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 p-5 sm:p-6 rounded-3xl bg-white border border-brand-dark/[0.08] shadow-sm">
                <div class="flex items-center gap-3 flex-1">
                    <div class="w-11 h-11 rounded-full bg-brand-dark flex items-center justify-center text-[#2DD4BF] shrink-0">
                        <i data-lucide="shield-check" class="w-5 h-5" aria-hidden="true"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] font-mono tracking-[0.2em] uppercase text-slate-400">Verificación</span>
                        <span class="block text-base font-medium text-brand-dark">Revisa si cumples los 4 requisitos</span>
                    </div>
                </div>
                <div class="flex items-center gap-1.5" aria-hidden="true">
                    <span class="rq-seg"></span><span class="rq-seg"></span><span class="rq-seg"></span><span class="rq-seg"></span>
                </div>
                <a href="{{ route('leads.create') }}" class="inline-flex items-center justify-center gap-2 bg-brand-dark hover:bg-[#0F766E] text-brand-lightBg px-5 py-3 rounded-full text-sm font-medium transition-all hover:-translate-y-0.5">
                    Comprobar mi caso
                    <i data-lucide="arrow-right" class="w-4 h-4" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>

    <section id="faq" class="fq-section relative py-24 sm:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04] pointer-events-none" style="background-image: linear-gradient(#0A161E 1px, transparent 1px), linear-gradient(90deg, #0A161E 1px, transparent 1px); background-size: 64px 64px; mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, black 20%, transparent 80%); -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, black 20%, transparent 80%);"></div>
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute -top-40 left-1/3 w-[720px] h-[720px] bg-brand-accent/[0.06] rounded-full blur-[160px]"></div>
            <div class="absolute bottom-0 right-1/4 w-[560px] h-[560px] bg-teal-500/[0.05] rounded-full blur-[150px]"></div>
            <div class="absolute top-1/3 -left-20 w-[380px] h-[380px] bg-brand-accent/[0.04] rounded-full blur-[110px]"></div>
        </div>
        <div class="fq-spotlight absolute inset-0 pointer-events-none z-[1]"></div>
        <div class="absolute -top-10 right-0 select-none pointer-events-none overflow-hidden" aria-hidden="true">
            <span class="fq-ghost block font-serif italic pr-8" style="font-size: clamp(12rem, 26vw, 26rem); line-height: 1;">FAQ</span>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-8 z-10">
            <div class="reveal mb-14 sm:mb-20">
                <div class="flex items-center gap-3 sm:gap-4 mb-10 sm:mb-14">
                    <span class="inline-flex items-center gap-2 bg-brand-dark text-white rounded-full px-4 py-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-accent animate-pulse"></span>
                        <span class="text-[10px] font-mono tracking-[0.25em] uppercase">Resolvemos tus dudas</span>
                    </span>
                    <div class="flex-1 h-px bg-brand-dark/10"></div>
                    <div class="flex items-center gap-2 text-[10px] font-mono text-slate-400 tracking-[0.3em] uppercase">
                        <span class="hidden sm:inline">FAQ ·</span>
                        <span class="text-brand-dark font-bold tabular-nums">05</span>
                        <span>/ 05</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-14 items-end">
                    <div class="md:col-span-7">
                        <h2 class="font-light tracking-[-0.045em] leading-[0.9]">
                            <span class="block font-serif italic text-brand-dark" style="font-size: clamp(2.5rem, 7vw, 6rem);">Preguntas</span>
                            <span class="relative inline-block bg-gradient-to-r from-[#0F766E] via-brand-accent to-[#0F766E] bg-clip-text text-transparent" style="font-size: clamp(2.5rem, 7vw, 6rem);">frecuentes<svg class="absolute left-0 -bottom-3 w-full" height="10" viewBox="0 0 300 10" preserveAspectRatio="none" aria-hidden="true"><path d="M2,6 Q75,2 150,6 T298,6" stroke="#2DD4BF" stroke-width="2" fill="none" stroke-linecap="round" opacity="0.7"/></svg></span>
                        </h2>
                    </div>
                    <div class="md:col-span-5 flex flex-col gap-6 pb-2">
                        <p class="kinetic-para text-slate-600 text-base sm:text-lg leading-relaxed font-normal">Respuestas directas sobre el programa CAE, el proceso, los requisitos y lo que cubre el aislamiento sin coste.</p>
                    </div>
                </div>
                <div class="relative z-10 mt-10 sm:mt-14 h-px bg-brand-dark/10 overflow-hidden">
                    <div class="bottom-line"></div>
                </div>
            </div>

            <div class="reveal grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6">
                <div class="lg:col-span-4 order-2 lg:order-1 lg:sticky lg:top-28 lg:self-start">
                    <div class="relative rounded-3xl bg-white border border-brand-dark/[0.08] overflow-hidden shadow-[0_25px_70px_-30px_rgba(10,22,30,0.15)]">
                        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brand-accent/70 to-transparent"></div>
                        <div class="absolute -top-24 -right-20 w-64 h-64 bg-brand-accent/[0.08] rounded-full blur-[100px] pointer-events-none"></div>
                        <div class="relative p-7 sm:p-9">
                            <div class="w-12 h-12 rounded-2xl bg-brand-accent/[0.12] border border-brand-accent/30 flex items-center justify-center text-[#0F766E] mb-6">
                                <i data-lucide="message-circle-question" class="w-6 h-6" aria-hidden="true"></i>
                            </div>
                            <span class="block text-[10px] font-mono tracking-[0.3em] uppercase text-slate-400 mb-2">Atención directa</span>
                            <h3 class="text-2xl sm:text-3xl font-serif italic text-brand-dark leading-tight mb-3">¿No encuentras<br>lo que buscas?</h3>
                            <p class="text-sm text-slate-600 leading-relaxed mb-7">Nuestro equipo técnico responde en menos de 24 horas. Sin compromiso, sin letra pequeña.</p>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', config('aislaplus.phone')) }}" class="group flex items-center justify-between gap-3 w-full bg-brand-dark text-white px-5 py-3.5 rounded-full text-sm font-semibold hover:bg-brand-accent hover:text-brand-dark transition-all hover:-translate-y-0.5 mb-3">
                                <span class="flex items-center gap-2"><i data-lucide="phone" class="w-4 h-4" aria-hidden="true"></i>{{ config('aislaplus.phone') }}</span>
                                <i data-lucide="arrow-up-right" class="w-4 h-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" aria-hidden="true"></i>
                            </a>
                            <a href="https://wa.me/{{ config('aislaplus.phone_whatsapp') }}" target="_blank" rel="noopener noreferrer" class="group flex items-center justify-between gap-3 w-full bg-white border border-brand-dark/15 text-brand-dark px-5 py-3.5 rounded-full text-sm font-medium hover:bg-brand-lightBg hover:border-brand-accent/50 transition-all hover:-translate-y-0.5">
                                <span class="flex items-center gap-2"><i data-lucide="message-circle" class="w-4 h-4" aria-hidden="true"></i>WhatsApp</span>
                                <i data-lucide="arrow-up-right" class="w-4 h-4 transition-transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5" aria-hidden="true"></i>
                            </a>
                            <div class="flex items-center justify-between mt-7 pt-6 border-t border-brand-dark/[0.08]">
                                <div class="flex items-center gap-2.5">
                                    <span class="fq-live-dot" aria-hidden="true"></span>
                                    <span class="text-[10px] font-mono tracking-[0.2em] uppercase text-slate-400">Respuesta media · 4h</span>
                                </div>
                                <span class="text-[9px] font-mono tracking-[0.15em] uppercase text-[#0F766E]">Activo</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8 order-1 lg:order-2">
                    <div class="rounded-3xl bg-white border border-brand-dark/[0.08] overflow-hidden shadow-[0_25px_70px_-30px_rgba(10,22,30,0.12)]">
                        <div class="flex items-center justify-between px-6 sm:px-8 py-4 border-b border-brand-dark/[0.08]">
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-brand-accent shadow-[0_0_6px_#2DD4BF]"></span>
                                <span class="text-[10px] font-mono font-bold tracking-[0.25em] text-brand-dark uppercase">Preguntas</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-mono text-[10px] tracking-[0.2em] tabular-nums">
                                    <span id="fqActive" class="text-brand-dark font-bold">01</span>
                                    <span class="text-slate-400"> / 05</span>
                                </span>
                            </div>
                        </div>

                        <div id="fqList">
                            <div class="fq-item is-open" data-fq-index="0">
                                <span class="fq-shine" aria-hidden="true"></span>
                                <button type="button" class="fq-toggle w-full grid grid-cols-[1.75rem_1fr_auto] gap-3 sm:gap-5 items-start text-left px-5 sm:px-8 py-6 sm:py-7" aria-expanded="true">
                                    <span class="fq-num pt-1 sm:pt-1.5">01</span>
                                    <span class="fq-question text-base sm:text-xl font-light leading-snug pr-2">¿En qué consiste exactamente el programa CAE?</span>
                                    <span class="fq-icon" aria-hidden="true"><i data-lucide="plus" class="w-4 h-4"></i></span>
                                </button>
                                <div class="fq-answer"><div><div class="grid grid-cols-[1.75rem_1fr_auto] gap-3 sm:gap-5 px-5 sm:px-8 pb-6 sm:pb-7"><span aria-hidden="true"></span><p class="fq-answer-text text-sm sm:text-[15px] leading-relaxed">Es un mecanismo oficial regulado por el Gobierno (Real Decreto 36/2023) mediante el cual las empresas energéticas están obligadas a justificar ahorro energético. Para ello, financian actuaciones como el aislamiento de viviendas a través de los Certificados de Ahorro Energético (CAE).</p><span aria-hidden="true"></span></div></div></div>
                            </div>
                            <div class="fq-item" data-fq-index="1">
                                <span class="fq-shine" aria-hidden="true"></span>
                                <button type="button" class="fq-toggle w-full grid grid-cols-[1.75rem_1fr_auto] gap-3 sm:gap-5 items-start text-left px-5 sm:px-8 py-6 sm:py-7" aria-expanded="false">
                                    <span class="fq-num pt-1 sm:pt-1.5">02</span>
                                    <span class="fq-question text-base sm:text-xl font-light leading-snug pr-2">¿Realmente no tengo que pagar nada?</span>
                                    <span class="fq-icon" aria-hidden="true"><i data-lucide="plus" class="w-4 h-4"></i></span>
                                </button>
                                <div class="fq-answer"><div><div class="grid grid-cols-[1.75rem_1fr_auto] gap-3 sm:gap-5 px-5 sm:px-8 pb-6 sm:pb-7"><span aria-hidden="true"></span><p class="fq-answer-text text-sm sm:text-[15px] leading-relaxed">Correcto. El coste de la obra queda cubierto por el ahorro energético generado. Puedes mejorar tu vivienda sin pagar obra, materiales ni gestión.</p><span aria-hidden="true"></span></div></div></div>
                            </div>
                            <div class="fq-item" data-fq-index="2">
                                <span class="fq-shine" aria-hidden="true"></span>
                                <button type="button" class="fq-toggle w-full grid grid-cols-[1.75rem_1fr_auto] gap-3 sm:gap-5 items-start text-left px-5 sm:px-8 py-6 sm:py-7" aria-expanded="false">
                                    <span class="fq-num pt-1 sm:pt-1.5">03</span>
                                    <span class="fq-question text-base sm:text-xl font-light leading-snug pr-2">¿Qué mejoras se realizan en mi vivienda?</span>
                                    <span class="fq-icon" aria-hidden="true"><i data-lucide="plus" class="w-4 h-4"></i></span>
                                </button>
                                <div class="fq-answer"><div><div class="grid grid-cols-[1.75rem_1fr_auto] gap-3 sm:gap-5 px-5 sm:px-8 pb-6 sm:pb-7"><span aria-hidden="true"></span><p class="fq-answer-text text-sm sm:text-[15px] leading-relaxed">Actuamos en el desván o bajo cubierta con aislamiento de lana de roca (térmico y acústico) o aislamiento soplado mecánico de alta eficiencia. Esto reduce las pérdidas de energía, mejora el confort y genera el ahorro necesario para acceder al CAE.</p><span aria-hidden="true"></span></div></div></div>
                            </div>
                            <div class="fq-item" data-fq-index="3">
                                <span class="fq-shine" aria-hidden="true"></span>
                                <button type="button" class="fq-toggle w-full grid grid-cols-[1.75rem_1fr_auto] gap-3 sm:gap-5 items-start text-left px-5 sm:px-8 py-6 sm:py-7" aria-expanded="false">
                                    <span class="fq-num pt-1 sm:pt-1.5">04</span>
                                    <span class="fq-question text-base sm:text-xl font-light leading-snug pr-2">¿Hay plazas limitadas?</span>
                                    <span class="fq-icon" aria-hidden="true"><i data-lucide="plus" class="w-4 h-4"></i></span>
                                </button>
                                <div class="fq-answer"><div><div class="grid grid-cols-[1.75rem_1fr_auto] gap-3 sm:gap-5 px-5 sm:px-8 pb-6 sm:pb-7"><span aria-hidden="true"></span><p class="fq-answer-text text-sm sm:text-[15px] leading-relaxed">Sí. El acceso depende de los cupos de ahorro energético (CAE) disponibles. Las plazas son limitadas y se asignan por orden de validación.</p><span aria-hidden="true"></span></div></div></div>
                            </div>
                            <div class="fq-item" data-fq-index="4">
                                <span class="fq-shine" aria-hidden="true"></span>
                                <button type="button" class="fq-toggle w-full grid grid-cols-[1.75rem_1fr_auto] gap-3 sm:gap-5 items-start text-left px-5 sm:px-8 py-6 sm:py-7" aria-expanded="false">
                                    <span class="fq-num pt-1 sm:pt-1.5">05</span>
                                    <span class="fq-question text-base sm:text-xl font-light leading-snug pr-2">¿Quién es aislagratis?</span>
                                    <span class="fq-icon" aria-hidden="true"><i data-lucide="plus" class="w-4 h-4"></i></span>
                                </button>
                                <div class="fq-answer"><div><div class="grid grid-cols-[1.75rem_1fr_auto] gap-3 sm:gap-5 px-5 sm:px-8 pb-6 sm:pb-7"><span aria-hidden="true"></span><p class="fq-answer-text text-sm sm:text-[15px] leading-relaxed">Somos el equipo técnico y de atención al cliente especializado en actuaciones CAE en viviendas unifamiliares. Nos encargamos de todo el proceso, desde el estudio técnico gratuito hasta la validación final.</p><span aria-hidden="true"></span></div></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="relative py-24 sm:py-32 overflow-hidden bg-brand-lightBg border-t border-slate-100">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute inset-0" style="background-image: url(&quot;data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='3' stitchTiles='stitch'/%3E%3CfeColorMatrix values='0 0 0 0 0.35 0 0 0 0 0.30 0 0 0 0 0.24 0 0 0 0.04 0'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E&quot;); opacity: 0.4; mix-blend-mode: multiply;"></div>
            <div class="absolute inset-0" style="background: radial-gradient(700px circle at 85% 20%, rgba(45, 212, 191, 0.10), transparent 60%), radial-gradient(600px circle at 10% 80%, rgba(20, 184, 166, 0.08), transparent 65%);"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-8 z-10">
            <div class="reveal grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-center">
                <div class="lg:col-span-6 order-2 lg:order-1">
                    <div class="anim-up inline-flex flex-wrap items-center gap-3 bg-white border border-brand-dark/10 rounded-full pl-4 pr-5 py-2 shadow-[0_4px_20px_-8px_rgba(10,22,30,0.15)]" style="--delay: 0ms">
                        <div class="flex items-center gap-0.5 text-amber-500" role="img" aria-label="Valoración: 5 de 5 estrellas">
                            @for ($star = 1; $star <= 5; $star++)
                                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings:'FILL' 1;" aria-hidden="true">star</span>
                            @endfor
                        </div>
                        <span class="w-px h-3.5 bg-brand-dark/15" aria-hidden="true"></span>
                        <span class="text-sm font-semibold text-brand-dark tabular-nums">9.7 / 10</span>
                        <span class="text-[10px] font-mono tracking-[0.22em] text-slate-500 uppercase">Valoración de clientes</span>
                    </div>

                    <h2 class="mt-6 text-[clamp(2.5rem,6.5vw,5.5rem)] font-light text-brand-dark tracking-[-0.04em] leading-[0.92]">
                        <span class="mask-line block"><span class="kinetic-line" style="--delay: 100ms">Reserva tu</span></span>
                        <span class="mask-line block"><span class="kinetic-line italic font-medium bg-clip-text text-transparent bg-gradient-to-r from-[#0F766E] via-brand-accent to-[#0F766E] kinetic-gradient pr-3 -mr-3 inline-block" style="--delay: 220ms">aislamiento gratis</span></span>
                    </h2>

                    <p class="anim-up mt-6 max-w-md text-slate-600 text-base sm:text-lg font-light leading-relaxed" style="--delay: 400ms">
                        Escríbenos y comprobamos sin compromiso si tu vivienda cumple los requisitos del programa CAE.
                    </p>

                    <div class="anim-up mt-8 flex flex-col sm:flex-row gap-3" style="--delay: 550ms">
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', config('aislaplus.phone')) }}" class="group inline-flex items-center justify-between gap-3 bg-brand-dark text-white pl-5 pr-4 py-3.5 rounded-full font-semibold text-sm hover:bg-brand-accent hover:text-brand-dark transition-all hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-brand-accent/30">
                            <span class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings:'FILL' 1;" aria-hidden="true">call</span>
                                {{ config('aislaplus.phone') }}
                            </span>
                            <span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-1" aria-hidden="true">arrow_forward</span>
                        </a>
                        <a href="https://wa.me/{{ config('aislaplus.phone_whatsapp') }}" target="_blank" rel="noopener noreferrer" class="group inline-flex items-center justify-between gap-3 bg-white border border-brand-dark/15 text-brand-dark pl-5 pr-4 py-3.5 rounded-full font-medium text-sm hover:bg-white hover:border-brand-accent/50 transition-all hover:-translate-y-0.5 shadow-[0_4px_16px_-6px_rgba(10,22,30,0.12)]">
                            <span class="flex items-center gap-2.5">
                                <span class="material-symbols-outlined text-[20px] text-[#25D366]" aria-hidden="true">chat</span>
                                {{ config('aislaplus.phone') }}
                            </span>
                            <span class="material-symbols-outlined text-[18px] text-slate-400 group-hover:text-brand-accent transition-colors" aria-hidden="true">arrow_outward</span>
                        </a>
                    </div>

                    <div class="anim-up mt-8 flex flex-wrap items-center gap-x-6 gap-y-3 pt-6 border-t border-brand-dark/10" style="--delay: 700ms">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-[#0F766E]" style="font-variation-settings:'FILL' 1;" aria-hidden="true">verified</span>
                            <span class="text-xs text-slate-600 font-medium">Sin compromiso</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-[#0F766E]" style="font-variation-settings:'FILL' 1;" aria-hidden="true">bolt</span>
                            <span class="text-xs text-slate-600 font-medium">Respuesta &lt; 24h</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-[#0F766E]" style="font-variation-settings:'FILL' 1;" aria-hidden="true">savings</span>
                            <span class="text-xs text-slate-600 font-medium">Coste 0€</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6 order-1 lg:order-2 contact-mosaic-wrap relative">
                    <div class="contact-mosaic">
                        <div class="contact-mosaic-grid">
                            <div class="contact-mosaic-col contact-mosaic-col--up-1">
                                <div class="contact-mosaic-item" style="aspect-ratio: 4/5;"><img src="{{ asset('images/image1-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 1/1;"><img src="{{ asset('images/image10.jpg') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 3/4;"><img src="{{ asset('images/image8-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 4/5;"><img src="{{ asset('images/image5c-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 4/5;"><img src="{{ asset('images/image1-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 1/1;"><img src="{{ asset('images/image10.jpg') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 3/4;"><img src="{{ asset('images/image8-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 4/5;"><img src="{{ asset('images/image5c-640.webp') }}" alt="" loading="lazy"></div>
                            </div>
                            <div class="contact-mosaic-col contact-mosaic-col--down">
                                <div class="contact-mosaic-item" style="aspect-ratio: 1/1;"><img src="{{ asset('images/aislamiento-cubierta-instalado.jpg') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 4/5;"><img src="{{ asset('images/image2-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 1/1;"><img src="{{ asset('images/image11-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 3/4;"><img src="{{ asset('images/image12-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 1/1;"><img src="{{ asset('images/aislamiento-cubierta-instalado.jpg') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 4/5;"><img src="{{ asset('images/image2-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 1/1;"><img src="{{ asset('images/image11-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 3/4;"><img src="{{ asset('images/image12-640.webp') }}" alt="" loading="lazy"></div>
                            </div>
                            <div class="contact-mosaic-col contact-mosaic-col--up-2">
                                <div class="contact-mosaic-item" style="aspect-ratio: 3/4;"><img src="{{ asset('images/image3.jpg') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 1/1;"><img src="{{ asset('images/image9.jpg') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 4/5;"><img src="{{ asset('images/image7c-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 1/1;"><img src="{{ asset('images/colocacion-lana-mineral.jpg') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 3/4;"><img src="{{ asset('images/image3.jpg') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 1/1;"><img src="{{ asset('images/image9.jpg') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 4/5;"><img src="{{ asset('images/image7c-640.webp') }}" alt="" loading="lazy"></div>
                                <div class="contact-mosaic-item" style="aspect-ratio: 1/1;"><img src="{{ asset('images/colocacion-lana-mineral.jpg') }}" alt="" loading="lazy"></div>
                            </div>
                        </div>
                    </div>
                    <div class="contact-float-card absolute bottom-6 left-6 sm:bottom-8 sm:left-8 z-10 bg-white/95 backdrop-blur-2xl border border-brand-dark/10 rounded-2xl px-4 py-3 shadow-[0_20px_50px_-15px_rgba(10,22,30,0.35)]">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#0F766E]/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[#0F766E] text-[20px]" style="font-variation-settings:'FILL' 1;" aria-hidden="true">home</span>
                            </div>
                            <div>
                                <div class="flex items-baseline gap-1"><span class="text-xl font-light text-brand-dark tabular-nums">2.418</span></div>
                                <span class="text-[9px] font-mono tracking-[0.2em] text-slate-500 uppercase">Viviendas aisladas</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4 z-10 flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/95 backdrop-blur-xl border border-brand-dark/10 shadow-[0_4px_16px_-6px_rgba(10,22,30,0.2)]">
                        <span class="relative flex w-1.5 h-1.5">
                            <span class="absolute inset-0 rounded-full bg-[#0F766E] animate-ping"></span>
                            <span class="relative rounded-full w-1.5 h-1.5 bg-[#0F766E]"></span>
                        </span>
                        <span class="text-[9px] font-mono font-bold tracking-[0.2em] text-brand-dark uppercase">Live</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    </main>

    @include('partials.shared-public-footer')

    <button id="eligibilityBtn" type="button" class="eligibility-fab group inline-flex items-center gap-2.5 sm:gap-3 bg-brand-dark text-white pl-5 sm:pl-6 pr-5 sm:pr-6 py-3 sm:py-3.5 rounded-full text-sm sm:text-base font-medium border border-white/10 shadow-[0_12px_40px_-10px_rgba(10,22,30,0.55)] hover:bg-brand-accent hover:text-brand-dark hover:border-brand-accent whitespace-nowrap" aria-haspopup="dialog" aria-controls="eligibilityModal">
        <span class="relative flex w-2 h-2 shrink-0">
            <span class="absolute inset-0 rounded-full bg-brand-accent animate-ping opacity-75 group-hover:bg-brand-dark"></span>
            <span class="relative rounded-full w-2 h-2 bg-brand-accent group-hover:bg-brand-dark"></span>
        </span>
        <span>Consulta tu elegibilidad para los CAE</span>
        <i data-lucide="arrow-right" class="w-4 h-4 shrink-0 transition-transform group-hover:translate-x-1" aria-hidden="true"></i>
    </button>

    <div id="eligibilityModal" class="fixed inset-0 z-[9998] hidden items-center justify-center p-3 sm:p-6" role="dialog" aria-modal="true" aria-labelledby="eligibilityTitle">
        <div id="eligibilityBackdrop" class="absolute inset-0 bg-brand-dark/80 backdrop-blur-md"></div>
        <div class="eligibility-card relative w-full max-w-2xl max-h-[92vh] overflow-y-auto rounded-3xl glass-panel text-white shadow-[0_40px_120px_-30px_rgba(0,0,0,0.85)]">
            <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-brand-accent/80 to-transparent"></div>
            <div class="absolute -top-24 -right-20 w-72 h-72 bg-brand-accent/10 rounded-full blur-[110px] pointer-events-none"></div>

            <div class="relative p-5 sm:p-8">
                <div class="flex items-start justify-between gap-4 mb-5">
                    <div class="min-w-0">
                        <div class="inline-flex items-center gap-2 bg-white/[0.05] backdrop-blur-xl border border-white/10 rounded-full px-3.5 py-1.5 mb-3">
                            <span class="relative flex w-1.5 h-1.5">
                                <span class="absolute inset-0 rounded-full bg-brand-accent animate-ping opacity-75"></span>
                                <span class="relative rounded-full w-1.5 h-1.5 bg-brand-accent"></span>
                            </span>
                            <span class="text-[9px] font-mono font-bold tracking-[0.22em] text-brand-accent uppercase">Elegibilidad CAE</span>
                        </div>
                        <h3 id="eligibilityTitle" class="text-xl sm:text-2xl lg:text-3xl font-light leading-tight tracking-[-0.02em]">
                            ¿Tu vivienda puede
                            <span class="italic font-medium bg-clip-text text-transparent bg-gradient-to-r from-brand-accent via-teal-200 to-brand-accent kinetic-gradient">beneficiarse de los CAE?</span>
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-400 mt-2 max-w-md leading-relaxed">Comprueba si puedes mejorar el aislamiento térmico de tu vivienda y acceder a una compensación mediante el sistema de Certificados de Ahorro Energético (CAE).</p>
                        <div class="flex flex-wrap items-center gap-1.5 mt-3">
                            <span class="inline-flex items-center gap-1.5 bg-white/[0.04] border border-white/10 rounded-full px-2.5 py-1 text-[10px] text-slate-300">
                                <i data-lucide="check" class="w-3 h-3 text-brand-accent" aria-hidden="true"></i>
                                Estudio inicial sin compromiso
                            </span>
                            <span class="inline-flex items-center gap-1.5 bg-white/[0.04] border border-white/10 rounded-full px-2.5 py-1 text-[10px] text-slate-300">
                                <i data-lucide="check" class="w-3 h-3 text-brand-accent" aria-hidden="true"></i>
                                Evaluación de requisitos
                            </span>
                        </div>
                    </div>
                    <button id="eligibilityClose" type="button" aria-label="Cerrar formulario" class="shrink-0 w-10 h-10 rounded-full border border-white/15 bg-white/[0.05] flex items-center justify-center text-slate-300 hover:bg-brand-accent hover:text-brand-dark hover:border-brand-accent transition-all duration-300">
                        <i data-lucide="x" class="w-5 h-5" aria-hidden="true"></i>
                    </button>
                </div>

                <div class="flex items-center gap-2 mb-6">
                    <div class="step-dot active" data-step="0">1</div>
                    <div class="step-line"></div>
                    <div class="step-dot" data-step="1">2</div>
                    <div class="step-line"></div>
                    <div class="step-dot" data-step="2">3</div>
                </div>

                <form id="eligibilityForm" novalidate>

                    <div class="elig-step active" data-step="0">
                        <div class="mb-4">
                            <h4 class="text-base font-medium text-white">1. Datos de la vivienda</h4>
                            <p class="text-xs text-slate-400 mt-1">Cuéntanos qué tipo de inmueble quieres aislar.</p>
                        </div>
                        <div class="space-y-3.5">

                            <div class="elig-opt-group" data-name="propietario" data-required="true">
                                <span class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">¿Eres propietario de la vivienda?*</span>
                                <div class="grid grid-cols-2 gap-2">
                                    <button type="button" class="elig-opt" data-value="si"><span class="dot"></span>Sí</button>
                                    <button type="button" class="elig-opt" data-value="no"><span class="dot"></span>No</button>
                                </div>
                                <input type="hidden" name="propietario">
                            </div>

                            <div class="elig-opt-group" data-name="tipoInmueble" data-required="true">
                                <span class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">Tipo de inmueble*</span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <button type="button" class="elig-opt" data-value="unifamiliar"><span class="dot"></span>Vivienda unifamiliar o chalet</button>
                                    <button type="button" class="elig-opt" data-value="piso"><span class="dot"></span>Piso en comunidad de propietarios</button>
                                    <button type="button" class="elig-opt" data-value="edificio"><span class="dot"></span>Edificio completo</button>
                                    <button type="button" class="elig-opt" data-value="otro"><span class="dot"></span>Otro tipo de inmueble</button>
                                </div>
                                <input type="hidden" name="tipoInmueble">
                            </div>

                            <div class="elig-opt-group" data-name="zona" data-required="true">
                                <span class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">¿Qué zona quieres aislar?*</span>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <button type="button" class="elig-opt" data-value="desvan"><span class="dot"></span>Desván o buhardilla no habitable</button>
                                    <button type="button" class="elig-opt" data-value="bajo"><span class="dot"></span>Bajo cubierta o suelo del ático</button>
                                    <button type="button" class="elig-opt" data-value="otra"><span class="dot"></span>Otra zona</button>
                                </div>
                                <input type="hidden" name="zona">
                            </div>

                            <div class="elig-opt-group" data-name="acceso" data-required="true">
                                <span class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">¿Cómo se accede al desván o bajo cubierta?*</span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <button type="button" class="elig-opt" data-value="fija"><span class="dot"></span>Escalera fija</button>
                                    <button type="button" class="elig-opt" data-value="trampilla"><span class="dot"></span>Trampilla o escalera portátil</button>
                                    <button type="button" class="elig-opt" data-value="dificil"><span class="dot"></span>Acceso difícil o pendiente de comprobar</button>
                                    <button type="button" class="elig-opt" data-value="sin"><span class="dot"></span>No dispone de acceso</button>
                                </div>
                                <input type="hidden" name="acceso">
                            </div>

                            <div class="elig-opt-group" data-name="habitable" data-required="true">
                                <span class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">¿El desván es habitable?*</span>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <button type="button" class="elig-opt" data-value="no"><span class="dot"></span>No, es un espacio no habitable</button>
                                    <button type="button" class="elig-opt" data-value="si"><span class="dot"></span>Sí, está acondicionado como vivienda</button>
                                    <button type="button" class="elig-opt" data-value="nose"><span class="dot"></span>No lo sé</button>
                                </div>
                                <input type="hidden" name="habitable">
                            </div>

                            <div class="elig-opt-group" data-name="antiguedad" data-required="true">
                                <span class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">Antigüedad aproximada del inmueble*</span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <button type="button" class="elig-opt" data-value="20"><span class="dot"></span>Más de 20 años</button>
                                    <button type="button" class="elig-opt" data-value="10-20"><span class="dot"></span>Entre 10 y 20 años</button>
                                    <button type="button" class="elig-opt" data-value="10"><span class="dot"></span>Menos de 10 años</button>
                                    <button type="button" class="elig-opt" data-value="nose"><span class="dot"></span>No lo sé</button>
                                </div>
                                <input type="hidden" name="antiguedad">
                            </div>

                            <div class="elig-opt-group" data-name="ayudas" data-required="true">
                                <span class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">¿Has recibido ayudas o realizado actuaciones de aislamiento en esta zona durante los últimos 5 años?*</span>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <button type="button" class="elig-opt" data-value="no"><span class="dot"></span>No</button>
                                    <button type="button" class="elig-opt" data-value="si"><span class="dot"></span>Sí</button>
                                    <button type="button" class="elig-opt" data-value="nose"><span class="dot"></span>No lo sé</button>
                                </div>
                                <input type="hidden" name="ayudas">
                            </div>

                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <button type="button" data-elig-next class="group inline-flex items-center gap-2 bg-white text-slate-900 hover:bg-brand-accent hover:text-brand-dark px-6 py-3 rounded-full text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 shadow-lg">
                                Siguiente
                                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="elig-step" data-step="1">
                        <div class="mb-4">
                            <h4 class="text-base font-medium text-white">2. Tus datos de contacto</h4>
                            <p class="text-xs text-slate-400 mt-1">Los utilizaremos para estudiar tu solicitud.</p>
                        </div>
                        <div class="space-y-4">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="el-nombre" class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">Nombre*</label>
                                    <input id="el-nombre" name="nombre" type="text" required autocomplete="given-name" placeholder="Tu nombre" class="elig-input w-full rounded-xl bg-white/[0.04] border border-white/10 px-4 py-2.5 text-sm text-white">
                                </div>
                                <div>
                                    <label for="el-apellidos" class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">Apellidos*</label>
                                    <input id="el-apellidos" name="apellidos" type="text" required autocomplete="family-name" placeholder="Tus apellidos" class="elig-input w-full rounded-xl bg-white/[0.04] border border-white/10 px-4 py-2.5 text-sm text-white">
                                </div>
                            </div>

                            <div>
                                <label for="el-telefono" class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">Teléfono de contacto*</label>
                                <input id="el-telefono" name="telefono" type="tel" required autocomplete="tel" placeholder="600 000 000" class="elig-input w-full rounded-xl bg-white/[0.04] border border-white/10 px-4 py-2.5 text-sm text-white">
                            </div>

                            <div class="elig-opt-group" data-name="whatsappPref" data-required="true">
                                <span class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">¿Podemos contactarte por WhatsApp?*</span>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    <button type="button" class="elig-opt" data-value="wa"><span class="dot"></span>Sí, prefiero WhatsApp</button>
                                    <button type="button" class="elig-opt" data-value="ambos"><span class="dot"></span>Sí, llamada o WhatsApp</button>
                                    <button type="button" class="elig-opt" data-value="solo-llamada"><span class="dot"></span>No, solo llamadas</button>
                                </div>
                                <input type="hidden" name="whatsappPref">
                            </div>

                        </div>
                        <div class="flex items-center justify-between gap-3 mt-6">
                            <button type="button" data-elig-prev class="inline-flex items-center gap-2 bg-white/[0.05] border border-white/15 text-white px-5 py-3 rounded-full text-sm font-medium hover:bg-white/10 transition-all">
                                <i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i>
                                Anterior
                            </button>
                            <button type="button" data-elig-next class="group inline-flex items-center gap-2 bg-white text-slate-900 hover:bg-brand-accent hover:text-brand-dark px-6 py-3 rounded-full text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 shadow-lg">
                                Siguiente
                                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="elig-step" data-step="2">
                        <div class="mb-4">
                            <h4 class="text-base font-medium text-white">3. Ubicación del inmueble</h4>
                            <p class="text-xs text-slate-400 mt-1">Necesitamos estos datos para valorar la actuación.</p>
                        </div>
                        <div class="space-y-4">

                            <div>
                                <label for="el-direccion" class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">Dirección completa*</label>
                                <input id="el-direccion" name="direccion" type="text" required autocomplete="street-address" placeholder="Calle, número, piso" class="elig-input w-full rounded-xl bg-white/[0.04] border border-white/10 px-4 py-2.5 text-sm text-white">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="el-cp" class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">Código postal*</label>
                                    <input id="el-cp" name="cp" type="text" required inputmode="numeric" pattern="[0-9]{5}" autocomplete="postal-code" placeholder="28001" class="elig-input w-full rounded-xl bg-white/[0.04] border border-white/10 px-4 py-2.5 text-sm text-white">
                                </div>
                                <div>
                                    <label for="el-ciudad" class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">Ciudad o municipio*</label>
                                    <input id="el-ciudad" name="ciudad" type="text" required autocomplete="address-level2" placeholder="Tu ciudad" class="elig-input w-full rounded-xl bg-white/[0.04] border border-white/10 px-4 py-2.5 text-sm text-white">
                                </div>
                            </div>

                            <div>
                                <label for="el-catastral" class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">Referencia catastral <span class="text-slate-500 normal-case font-normal tracking-normal">(opcional)</span></label>
                                <input id="el-catastral" name="catastral" type="text" placeholder="Referencia catastral" class="elig-input w-full rounded-xl bg-white/[0.04] border border-white/10 px-4 py-2.5 text-sm text-white">
                                <p class="text-[10px] text-slate-500 mt-1.5">Si no la tienes a mano, puedes dejar este campo vacío.</p>
                            </div>

                            <div>
                                <label for="el-comentario" class="block text-[10px] font-bold tracking-widest text-slate-300 uppercase mb-2">Comentarios adicionales <span class="text-slate-500 normal-case font-normal tracking-normal">(opcional)</span></label>
                                <textarea id="el-comentario" name="comentario" rows="3" placeholder="Cuéntanos cualquier detalle relevante…" class="elig-input w-full rounded-xl bg-white/[0.04] border border-white/10 px-4 py-3 text-sm text-white resize-none"></textarea>
                            </div>

                            <label class="elig-privacy-label flex items-start gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" name="privacidad" id="el-privacidad" required class="elig-checkbox">
                                <span class="text-xs text-slate-300 leading-relaxed">He leído y acepto la <a href="{{ route('legal.privacy') }}" class="text-brand-accent underline hover:text-teal-200 transition-colors">política de privacidad</a> y el tratamiento de mis datos para gestionar esta solicitud.*</span>
                            </label>

                        </div>

                        <div class="mt-5 p-3 rounded-xl bg-white/[0.03] border border-white/[0.08]">
                            <p class="text-[11px] text-slate-400 leading-relaxed">La evaluación inicial no garantiza la concesión de CAE. La viabilidad se confirmará tras revisar los requisitos técnicos y la documentación correspondiente.</p>
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 mt-6">
                            <button type="button" data-elig-prev class="inline-flex items-center justify-center gap-2 bg-white/[0.05] border border-white/15 text-white px-5 py-3 rounded-full text-sm font-medium hover:bg-white/10 transition-all">
                                <i data-lucide="arrow-left" class="w-4 h-4" aria-hidden="true"></i>
                                Anterior
                            </button>
                            <button type="submit" class="group inline-flex items-center justify-center gap-2 bg-white text-slate-900 hover:bg-brand-accent hover:text-brand-dark px-6 py-3 rounded-full text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 shadow-lg">
                                Consultar mi elegibilidad
                                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        const homeBackgroundVideo = document.getElementById('homeBackgroundVideo');
        const homeBackgroundSource = homeBackgroundVideo?.querySelector('source[data-src]');
        const howItWorksButton = document.getElementById('howItWorksButton');
        const howItWorksDialog = document.getElementById('howItWorksDialog');
        const howItWorksVideo = document.getElementById('howItWorksVideo');
        const howItWorksSource = howItWorksVideo?.querySelector('source[data-src]');
        const howItWorksPlaybackNotice = document.getElementById('howItWorksPlaybackNotice');
        const closeHowItWorksDialog = document.getElementById('closeHowItWorksDialog');
        let resumeHomeBackgroundVideo = false;

        if (
            howItWorksButton instanceof HTMLButtonElement &&
            howItWorksDialog instanceof HTMLDialogElement &&
            howItWorksVideo instanceof HTMLVideoElement &&
            howItWorksSource instanceof HTMLSourceElement &&
            howItWorksPlaybackNotice instanceof HTMLParagraphElement &&
            closeHowItWorksDialog instanceof HTMLButtonElement
        ) {
            howItWorksButton.addEventListener('click', () => {
                resumeHomeBackgroundVideo = homeBackgroundVideo instanceof HTMLVideoElement && !homeBackgroundVideo.paused;
                homeBackgroundVideo?.pause();
                howItWorksPlaybackNotice.hidden = true;
                howItWorksDialog.showModal();
                if (!howItWorksSource.src) {
                    howItWorksSource.src = howItWorksSource.dataset.src;
                    howItWorksVideo.load();
                }
                howItWorksVideo.play().catch(() => {
                    if (howItWorksDialog.open) {
                        howItWorksPlaybackNotice.textContent = 'Pulsa ▶ en los controles para iniciar el vídeo.';
                        howItWorksPlaybackNotice.hidden = false;
                    }
                });
            });

            howItWorksVideo.addEventListener('playing', () => {
                howItWorksPlaybackNotice.hidden = true;
            });
            howItWorksVideo.addEventListener('error', () => {
                if (howItWorksDialog.open) {
                    howItWorksPlaybackNotice.textContent = 'No se pudo cargar el vídeo. Comprueba tu conexión e inténtalo de nuevo.';
                    howItWorksPlaybackNotice.hidden = false;
                }
            });
            const closeHowItWorks = () => {
                howItWorksVideo.pause();
                if (howItWorksVideo.readyState > 0) howItWorksVideo.currentTime = 0;
                howItWorksSource.removeAttribute('src');
                howItWorksVideo.load();
                howItWorksDialog.close();
                if (resumeHomeBackgroundVideo) {
                    homeBackgroundVideo.play().catch(error => console.error('Unable to resume the homepage background video.', error));
                }
                resumeHomeBackgroundVideo = false;
                howItWorksButton.focus({ preventScroll: true });
            };

            closeHowItWorksDialog.addEventListener('click', closeHowItWorks);
            howItWorksDialog.addEventListener('click', event => {
                if (event.target === howItWorksDialog) closeHowItWorks();
            });
            howItWorksDialog.addEventListener('cancel', event => {
                event.preventDefault();
                closeHowItWorks();
            });
        }

        if (
            homeBackgroundVideo &&
            homeBackgroundSource &&
            !navigator.connection?.saveData &&
            !window.matchMedia('(prefers-reduced-motion: reduce)').matches
        ) {
            homeBackgroundSource.src = homeBackgroundSource.dataset.src;
            homeBackgroundVideo.load();
            homeBackgroundVideo.play().catch(error => console.error('Unable to play homepage background video.', error));
        }

        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                const expanded = mobileMenu.classList.toggle('hidden') === false;
                mobileMenuBtn.setAttribute('aria-expanded', expanded);
            });
            mobileMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', 'false');
            }));
        }

        const header = document.getElementById('mainHeader');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                header.classList.remove('sm:py-4');
                header.classList.add('sm:py-2');
            } else {
                header.classList.remove('sm:py-2');
                header.classList.add('sm:py-4');
            }
        });

        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.reveal, .reveal-3d').forEach(el => revealObserver.observe(el));

        document.querySelectorAll('.kinetic-para').forEach(el => {
            const words = el.textContent.trim().split(/\s+/);
            el.innerHTML = words.map((w, i) => `<span class="kinetic-word" style="--i:${i}">${w}</span>`).join(' ');
        });

        (function initKineticHeader() {
            const section = document.getElementById('kineticHeader');
            if (!section) return;
            const magneticLetters = [...section.querySelectorAll('.letter-3d.magnetic')];
            const spotlight = section.querySelector('.kinetic-spotlight');
            const counter = section.querySelector('.counter-num');
            const segments = [...section.querySelectorAll('.progress-segment')];
            const ghost = section.querySelector('.ghost-index');
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const isFine = window.matchMedia('(pointer: fine)').matches;
            let letterRects = [];
            function cacheRects() { letterRects = magneticLetters.map(l => l.getBoundingClientRect()); }
            cacheRects();
            window.addEventListener('resize', cacheRects);
            window.addEventListener('scroll', cacheRects, { passive: true });
            if (isFine && !reducedMotion) {
                let rafMagnetic = null;
                let mx = 0, my = 0;
                section.addEventListener('pointermove', (e) => {
                    mx = e.clientX; my = e.clientY;
                    if (rafMagnetic) return;
                    rafMagnetic = requestAnimationFrame(() => {
                        rafMagnetic = null;
                        magneticLetters.forEach((letter, i) => {
                            const r = letterRects[i]; if (!r) return;
                            const cx = r.left + r.width / 2; const cy = r.top + r.height / 2;
                            const dx = mx - cx; const dy = my - cy; const dist = Math.hypot(dx, dy);
                            const maxR = 130;
                            if (dist < maxR) {
                                const f = (maxR - dist) / maxR;
                                const ang = Math.atan2(dy, dx);
                                const push = f * 9;
                                letter.style.transform = `translate(${Math.cos(ang) * -push}px, ${Math.sin(ang) * -push}px) scale(${1 + f * 0.08})`;
                                letter.style.textShadow = `0 8px ${f * 26}px rgba(45, 212, 191, ${f * 0.55})`;
                            } else { letter.style.transform = ''; letter.style.textShadow = ''; }
                        });
                    });
                }, { passive: true });
                section.addEventListener('pointerleave', () => {
                    magneticLetters.forEach(l => { l.style.transform = ''; l.style.textShadow = ''; });
                });
            }
            let tx = 50, ty = 30, cx = 50, cy = 30, isActive = false;
            let rafSpot = null;
            function spotTick() {
                cx += (tx - cx) * 0.10; cy += (ty - cy) * 0.10;
                if (spotlight) spotlight.style.background = `radial-gradient(620px circle at ${cx}% ${cy}%, rgba(45, 212, 191, 0.09), transparent 55%)`;
                if (isActive || Math.abs(tx - cx) > 0.3 || Math.abs(ty - cy) > 0.3) rafSpot = requestAnimationFrame(spotTick);
                else rafSpot = null;
            }
            section.addEventListener('pointermove', (e) => {
                const r = section.getBoundingClientRect();
                tx = ((e.clientX - r.left) / r.width) * 100;
                ty = ((e.clientY - r.top) / r.height) * 100;
                isActive = true;
                if (!rafSpot) spotTick();
            }, { passive: true });
            section.addEventListener('pointerleave', () => { isActive = false; });
            if (counter) {
                const target = parseInt(counter.dataset.target, 10) || 0;
                const io = new IntersectionObserver(([entry]) => {
                    if (!entry.isIntersecting) return;
                    io.disconnect();
                    const start = performance.now(); const duration = 1400;
                    function tick(t) {
                        const p = Math.min((t - start) / duration, 1);
                        const eased = 1 - Math.pow(1 - p, 4);
                        counter.textContent = String(Math.round(eased * target)).padStart(2, '0');
                        if (p < 1) requestAnimationFrame(tick);
                    }
                    requestAnimationFrame(tick);
                }, { threshold: 0.5 });
                io.observe(counter);
            }
            if (segments.length) {
                const io = new IntersectionObserver(([entry]) => {
                    if (!entry.isIntersecting) return;
                    io.disconnect();
                    segments.forEach((seg, i) => setTimeout(() => seg.classList.add('is-filled'), 300 + i * 160));
                }, { threshold: 0.4 });
                io.observe(segments[0]);
            }
            if (ghost && !reducedMotion) {
                let rafGhost = null;
                function updateGhost() {
                    rafGhost = null;
                    const r = section.getBoundingClientRect();
                    const vh = window.innerHeight;
                    const progress = Math.max(0, Math.min(1, 1 - (r.top + r.height * 0.5) / vh));
                    ghost.style.transform = `translateX(${(0.5 - progress) * 60}px) translateY(${(0.5 - progress) * -30}px)`;
                }
                window.addEventListener('scroll', () => { if (rafGhost) return; rafGhost = requestAnimationFrame(updateGhost); }, { passive: true });
                updateGhost();
            }
        })();

        const carouselData = [
            { tag: "LANA DE ROCA", title: "Aislamiento con lana de roca", size: "Térmico", beds: "Acústico", guests: "Bajo cubierta", img: "{{ asset('images/instalacion-aislamiento-05.jpeg') }}", pos: 50 },
            { tag: "SOPLADO", title: "Aislamiento soplado mecánico", size: "Alta eficiencia", beds: "Sin obras", guests: "Ejecución rápida", img: "{{ asset('images/insuflado-mecanico.jpg') }}", pos: 70 },
            { tag: "GESTIÓN CAE", title: "Gestión y validación CAE", size: "Expediente", beds: "Oficial", guests: "RD 36/2023", img: "{{ asset('images/image5c-640.webp') }}", pos: 55 }
        ];

        const track = document.getElementById('carouselTrack');
        let currentIndex = 0;

        function renderSlides() {
            if (!track) return;
            track.innerHTML = '';
            carouselData.forEach((data, index) => {
                const slide = document.createElement('div');
                slide.className = 'carousel-3d-slide';
                if (index === currentIndex) slide.classList.add('is-active');
                else if (index === (currentIndex - 1 + carouselData.length) % carouselData.length) slide.classList.add('is-left');
                else if (index === (currentIndex + 1) % carouselData.length) slide.classList.add('is-right');
                slide.innerHTML = `
                    <div class="relative w-full h-full">
                        <img src="${data.img}" style="object-position:center ${data.pos}%" class="absolute inset-0 w-full h-full object-cover" alt="${data.title}" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                        <div class="absolute top-6 left-6">
                            <span class="bg-white/20 backdrop-blur-md text-white border border-white/30 text-[10px] uppercase tracking-widest font-semibold px-4 py-1.5 rounded-full">${data.tag}</span>
                        </div>
                        <div class="absolute bottom-0 left-0 w-full p-6 sm:p-8">
                            <h3 class="text-white text-2xl sm:text-3xl font-medium mb-4">${data.title}</h3>
                            <div class="flex items-center gap-6 text-sm text-slate-200">
                                <div class="flex items-center gap-2"><i data-lucide="maximize" class="w-4 h-4" aria-hidden="true"></i><span>${data.size}</span></div>
                                <div class="flex items-center gap-2"><i data-lucide="layout" class="w-4 h-4" aria-hidden="true"></i><span>${data.beds}</span></div>
                                <div class="flex items-center gap-2"><i data-lucide="users" class="w-4 h-4" aria-hidden="true"></i><span>${data.guests}</span></div>
                            </div>
                        </div>
                    </div>`;
                track.appendChild(slide);
            });
            lucide.createIcons();
        }

        function updateCarousel() {
            const slides = track.querySelectorAll('.carousel-3d-slide');
            slides.forEach((slide, index) => {
                slide.classList.remove('is-active', 'is-left', 'is-right');
                if (index === currentIndex) slide.classList.add('is-active');
                else if (index === (currentIndex - 1 + carouselData.length) % carouselData.length) slide.classList.add('is-left');
                else if (index === (currentIndex + 1) % carouselData.length) slide.classList.add('is-right');
            });
        }

        renderSlides();
        document.getElementById('nextSlide')?.addEventListener('click', () => { currentIndex = (currentIndex + 1) % carouselData.length; updateCarousel(); });
        document.getElementById('prevSlide')?.addEventListener('click', () => { currentIndex = (currentIndex - 1 + carouselData.length) % carouselData.length; updateCarousel(); });

        (function initAboutCarousel() {
            const aboutTrack = document.getElementById('aboutTrack');
            if (!aboutTrack) return;
            const aboutData = [
                { tag: "AISLAGRATIS", title: "Aislamiento térmico bajo cubierta", meta1: "Vivienda", meta2: "Bajo cubierta", meta3: "Trabajo real", video: "{{ asset('video/AislaGratis_Premium_Cinematic.mp4') }}", poster: "{{ asset('images/instalacion-aislamiento-01.jpeg') }}", fit: "object-cover" },
                { tag: "INSTALACIÓN REAL", title: "Así se realiza el aislamiento insuflado", meta1: "Instalación", meta2: "Aislamiento", meta3: "Trabajo real", video: "{{ asset('video/WhatsApp Video 2026-10-29 at 16.41.41.mp4') }}", poster: "{{ asset('images/instalacion-aislamiento-02.jpeg') }}", fit: "object-cover" },
                { tag: "AISLAGRATIS", title: "Aislamiento para tu vivienda", meta1: "Vivienda", meta2: "Eficiencia", meta3: "Sin coste", video: "{{ asset('video/aislagratis_video_vertical.mp4') }}", poster: "{{ asset('images/instalacion-aislamiento-03.jpeg') }}", fit: "object-contain bg-black" },
                { tag: "AISLAGRATIS", title: "Instalación profesional y gestión CAE", meta1: "Instalación", meta2: "Gestión CAE", meta3: "Trabajo real", video: "{{ asset('video/AislaGratis_video_web.mp4') }}", poster: "{{ asset('images/instalacion-aislamiento-04.jpeg') }}", fit: "object-cover" }
            ];
            let aboutIdx = 0;
            let aboutInView = false;
            function aboutRender() {
                aboutTrack.innerHTML = '';
                aboutData.forEach((d, i) => {
                    const s = document.createElement('div');
                    s.className = 'carousel-3d-slide';
                    if (i === aboutIdx) s.classList.add('is-active');
                    else if (i === (aboutIdx - 1 + aboutData.length) % aboutData.length) s.classList.add('is-left');
                    else if (i === (aboutIdx + 1) % aboutData.length) s.classList.add('is-right');
                    s.innerHTML = `
                        <div class="relative w-full h-full">
                            <video class="absolute inset-0 w-full h-full ${d.fit}" poster="${d.poster}" muted loop playsinline preload="none" aria-label="${d.title}">
                                <source src="${d.video}" type="video/mp4">
                            </video>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                            <div class="absolute top-6 left-6">
                                <span class="bg-white/20 backdrop-blur-md text-white border border-white/30 text-[10px] uppercase tracking-widest font-semibold px-4 py-1.5 rounded-full">${d.tag}</span>
                            </div>
                            <div class="absolute bottom-0 left-0 w-full p-6 sm:p-8">
                                <h3 class="text-white text-2xl sm:text-3xl font-medium mb-4">${d.title}</h3>
                                <div class="flex items-center gap-6 text-sm text-slate-200">
                                    <div class="flex items-center gap-2"><i data-lucide="maximize" class="w-4 h-4" aria-hidden="true"></i><span>${d.meta1}</span></div>
                                    <div class="flex items-center gap-2"><i data-lucide="layout" class="w-4 h-4" aria-hidden="true"></i><span>${d.meta2}</span></div>
                                    <div class="flex items-center gap-2"><i data-lucide="users" class="w-4 h-4" aria-hidden="true"></i><span>${d.meta3}</span></div>
                                </div>
                            </div>
                        </div>`;
                    aboutTrack.appendChild(s);
                });
                lucide.createIcons();
            }
            function aboutUpdate() {
                const slides = aboutTrack.querySelectorAll('.carousel-3d-slide');
                slides.forEach((slide, i) => {
                    slide.classList.remove('is-active', 'is-left', 'is-right');
                    if (i === aboutIdx) slide.classList.add('is-active');
                    else if (i === (aboutIdx - 1 + aboutData.length) % aboutData.length) slide.classList.add('is-left');
                    else if (i === (aboutIdx + 1) % aboutData.length) slide.classList.add('is-right');

                    const video = slide.querySelector('video');
                    if (!video) return;
                    if (aboutInView && i === aboutIdx) {
                        video.play().catch(error => console.error('Unable to play homepage video carousel.', error));
                    } else {
                        video.pause();
                    }
                });
            }
            aboutRender();
            const aboutCarousel = aboutTrack.closest('.carousel-3d-wrapper');
            if (aboutCarousel && 'IntersectionObserver' in window) {
                const aboutObserver = new IntersectionObserver(([entry]) => {
                    aboutInView = entry.isIntersecting;
                    aboutUpdate();
                }, { threshold: 0.1 });
                aboutObserver.observe(aboutCarousel);
            } else {
                aboutInView = true;
                aboutUpdate();
            }
            document.getElementById('aboutNext')?.addEventListener('click', () => { aboutIdx = (aboutIdx + 1) % aboutData.length; aboutUpdate(); });
            document.getElementById('aboutPrev')?.addEventListener('click', () => { aboutIdx = (aboutIdx - 1 + aboutData.length) % aboutData.length; aboutUpdate(); });
        })();

        (function initVSlider() {
            const vsTrack = document.getElementById('vsliderTrack');
            if (!vsTrack) return;
            const vsCards = [...vsTrack.querySelectorAll('.vslider-card')];
            const vsContent = document.getElementById('vsliderContent');
            const vsGhost = document.getElementById('vsliderGhostNum');
            const vsIndexEl = document.getElementById('vsliderIndex');
            const vsTitleEl = document.getElementById('vsliderTitle');
            const vsDescEl = document.getElementById('vsliderDesc');
            const vsIndicators = [...document.querySelectorAll('.vslider-indicator')];
            const vsReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            const vsServices = [
                { num: '01', title: 'Lana de roca', desc: 'Aislamiento térmico y acústico de alta eficiencia instalado en el desván o bajo cubierta de tu vivienda unifamiliar.' },
                { num: '02', title: 'Soplado mecánico', desc: 'Aislamiento soplado mecánico de alta eficiencia: ejecución rápida, limpia y sin obras dentro de la vivienda.' },
                { num: '03', title: 'Estudio técnico gratuito', desc: 'Visita técnica para validar el ahorro energético necesario y confirmar el acceso al programa CAE, sin ningún coste.' },
                { num: '04', title: 'Gestión y validación CAE', desc: 'Tramitamos el expediente completo y obtenemos la validación final exigida por el sistema oficial de ahorro energético.' }
            ];

            let vsActive = 0;

            function vsSetActive(index) {
                if (index === vsActive) return;
                vsActive = index;
                const d = vsServices[index];

                vsContent.classList.remove('animate');
                void vsContent.offsetWidth;

                vsIndexEl.textContent = `${d.num} / 04`;
                vsTitleEl.textContent = d.title;
                vsDescEl.textContent = d.desc;
                if (vsGhost) vsGhost.textContent = d.num;

                vsContent.classList.add('animate');

                vsIndicators.forEach((ind, i) => {
                    ind.classList.toggle('active', i === index);
                    ind.setAttribute('aria-selected', i === index ? 'true' : 'false');
                });
            }

            function vsUpdate() {
                const trackRect = vsTrack.getBoundingClientRect();
                const trackCenter = trackRect.top + trackRect.height / 2;
                let closest = 0;
                let minDist = Infinity;

                vsCards.forEach((card, i) => {
                    const rect = card.getBoundingClientRect();
                    const cardCenter = rect.top + rect.height / 2;
                    const dist = cardCenter - trackCenter;
                    const absDist = Math.abs(dist);

                    if (absDist < minDist) {
                        minDist = absDist;
                        closest = i;
                    }

                    if (vsReduced) {
                        card.style.transform = '';
                        card.style.opacity = '';
                        card.style.filter = '';
                        card.classList.toggle('is-centered', absDist < 60);
                        return;
                    }

                    const maxDist = trackRect.height * 0.65;
                    const normalized = Math.min(absDist / maxDist, 1);
                    const scale = 1 - normalized * 0.14;
                    const rotateX = (dist / trackRect.height) * 20;
                    const opacity = 1 - normalized * 0.55;
                    const blur = normalized * 3;

                    card.style.transform = `perspective(1200px) rotateX(${(-rotateX).toFixed(2)}deg) scale(${scale.toFixed(3)})`;
                    card.style.opacity = Math.max(opacity, 0.22).toFixed(2);
                    card.style.filter = blur > 0.5 ? `blur(${blur.toFixed(1)}px)` : 'none';
                    card.classList.toggle('is-centered', absDist < 60);
                });

                if (closest !== vsActive) vsSetActive(closest);
            }

            let vsRaf = null;
            vsTrack.addEventListener('scroll', () => {
                if (vsRaf) return;
                vsRaf = requestAnimationFrame(() => {
                    vsRaf = null;
                    vsUpdate();
                });
            }, { passive: true });

            window.addEventListener('resize', vsUpdate);

            vsCards.forEach((card) => {
                card.addEventListener('click', () => {
                    card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
            });

            vsIndicators.forEach((ind, i) => {
                ind.addEventListener('click', () => {
                    vsCards[i].scrollIntoView({ behavior: 'smooth', block: 'center' });
                });
            });

            const vsIo = new IntersectionObserver(([entry]) => {
                if (!entry.isIntersecting) return;
                vsUpdate();
                vsIo.disconnect();
            }, { threshold: 0.15 });
            vsIo.observe(vsTrack);

            requestAnimationFrame(() => {
                vsContent.classList.add('animate');
                vsUpdate();
            });
        })();

        (function initTestimonialStage() {
            const quoteEl = document.getElementById('testimonialText');
            const data = @json($testimonialData);
            if (!quoteEl || data.length === 0) return;
            const authorEl = document.getElementById('testimonialAuthor');
            const roleEl = document.getElementById('testimonialRole');
            const avatarEl = document.getElementById('testimonialAvatar');
            const cityEl = document.getElementById('tstCity');
            const savingEl = document.getElementById('tstSaving');
            const indexEl = document.getElementById('tstIndex');
            const listEl = document.getElementById('testimonialList');
            const dotsEl = document.getElementById('tstDots');
            const autoplayEl = document.getElementById('tstAutoplay');
            const DURATION = 9000;
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            let current = 0, timer = null, swapToken = 0;
            const rows = data.map((item, i) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'tst-row w-full text-left px-5 py-4 border-b border-white/[0.04] relative flex items-center gap-3';
                btn.setAttribute('aria-label', `Ver testimonio de ${item.author}`);
                btn.innerHTML = `
                    <span class="tst-row-bar absolute left-0 top-0 bottom-0 w-[2px]"></span>
                    <span class="text-[10px] font-mono text-slate-500 tabular-nums shrink-0 w-5">${String(i + 1).padStart(2, '0')}</span>
                    <img src="${item.avatar}" class="w-9 h-9 rounded-full object-cover ring-1 ring-white/15 shrink-0" alt="" loading="lazy">
                    <span class="min-w-0 flex-1">
                        <span class="tst-row-name block text-sm text-white font-medium truncate">${item.author}</span>
                        <span class="block text-[10px] font-mono text-slate-500 truncate">${item.city} · ${item.role}</span>
                    </span>
                    <span class="shrink-0 text-[10px] font-mono text-brand-accent/80 tabular-nums">${item.saving}</span>`;
                btn.addEventListener('click', () => select(i));
                listEl.appendChild(btn);
                return btn;
            });
            const dots = data.map((item, i) => {
                const d = document.createElement('button');
                d.type = 'button'; d.className = 'tst-dot';
                d.setAttribute('role', 'tab'); d.setAttribute('aria-label', `Testimonio ${i + 1}`);
                d.addEventListener('click', () => select(i));
                dotsEl.appendChild(d);
                return d;
            });
            function restartAutoplay() {
                if (timer) clearTimeout(timer);
                if (reducedMotion || !autoplayEl) return;
                autoplayEl.style.transition = 'none';
                autoplayEl.style.transform = 'scaleX(0)';
                void autoplayEl.offsetWidth;
                autoplayEl.style.transition = `transform ${DURATION}ms linear`;
                autoplayEl.style.transform = 'scaleX(1)';
                timer = setTimeout(() => select((current + 1) % data.length), DURATION);
            }
            function select(index, animate = true) {
                current = index;
                const item = data[index];
                const token = ++swapToken;
                if (animate && !reducedMotion) {
                    quoteEl.classList.add('is-out');
                    setTimeout(() => {
                        if (token !== swapToken) return;
                        quoteEl.textContent = `"${item.quote}"`;
                        quoteEl.classList.remove('is-out');
                    }, 260);
                } else {
                    quoteEl.textContent = `"${item.quote}"`;
                    quoteEl.classList.remove('is-out');
                }
                authorEl.textContent = item.author;
                roleEl.textContent = item.role;
                cityEl.textContent = item.city;
                savingEl.textContent = item.saving;
                indexEl.textContent = String(index + 1).padStart(2, '0');
                avatarEl.src = item.avatar;
                avatarEl.alt = `Foto de ${item.author}`;
                avatarEl.classList.remove('tst-avatar-pop');
                void avatarEl.offsetWidth;
                avatarEl.classList.add('tst-avatar-pop');
                rows.forEach((r, i) => r.classList.toggle('is-active', i === index));
                dots.forEach((d, i) => { d.classList.toggle('is-active', i === index); d.setAttribute('aria-selected', i === index ? 'true' : 'false'); });
                const activeRow = rows[index];
                if (activeRow && listEl) {
                    const top = activeRow.offsetTop; const bottom = top + activeRow.offsetHeight;
                    if (top < listEl.scrollTop || bottom > listEl.scrollTop + listEl.clientHeight) {
                        listEl.scrollTo({ top: top - listEl.clientHeight / 2 + activeRow.offsetHeight / 2, behavior: 'smooth' });
                    }
                }
                restartAutoplay();
            }
            document.getElementById('nextTestimonial').addEventListener('click', () => select((current + 1) % data.length));
            document.getElementById('prevTestimonial').addEventListener('click', () => select((current - 1 + data.length) % data.length));
            document.addEventListener('keydown', (e) => {
                const section = document.getElementById('testimonials');
                if (!section) return;
                const r = section.getBoundingClientRect();
                const visible = r.top < window.innerHeight * 0.6 && r.bottom > window.innerHeight * 0.4;
                if (!visible) return;
                if (e.key === 'ArrowRight') select((current + 1) % data.length);
                if (e.key === 'ArrowLeft') select((current - 1 + data.length) % data.length);
            });
            let touchStartX = null;
            const stage = document.getElementById('testimonials');
            stage.addEventListener('touchstart', (e) => { touchStartX = e.touches[0].clientX; }, { passive: true });
            stage.addEventListener('touchend', (e) => {
                if (touchStartX === null) return;
                const dx = e.changedTouches[0].clientX - touchStartX;
                if (Math.abs(dx) > 60) {
                    if (dx < 0) select((current + 1) % data.length);
                    else select((current - 1 + data.length) % data.length);
                }
                touchStartX = null;
            }, { passive: true });
            select(0, false);
            if (timer) clearTimeout(timer);
            if (autoplayEl) { autoplayEl.style.transition = 'none'; autoplayEl.style.transform = 'scaleX(0)'; }
            const io = new IntersectionObserver(([entry]) => { if (entry.isIntersecting) { restartAutoplay(); io.disconnect(); } }, { threshold: 0.35 });
            io.observe(stage);
        })();

        const heroForm = document.getElementById('heroForm');
        if (heroForm) {
            heroForm.addEventListener('submit', (e) => e.preventDefault());
        }

        document.querySelectorAll('.counter').forEach(counter => {
            const target = parseInt(counter.dataset.target || '0', 10);
            const duration = 1800;
            const start = performance.now();
            function tick(now) {
                const p = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - p, 3);
                counter.textContent = Math.floor(eased * target);
                if (p < 1) requestAnimationFrame(tick);
                else counter.textContent = target;
            }
            requestAnimationFrame(tick);
        });

        document.addEventListener('DOMContentLoaded', () => {
            const mapContainer = document.getElementById('spainNorthMap');
            if (!mapContainer) return;
            L.TileLayer.prototype.options.referrerPolicy = 'strict-origin-when-cross-origin';

            const cities = @json($cities);

            const map = L.map('spainNorthMap', { zoomControl: false, scrollWheelZoom: false, attributionControl: false });
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
            const createIcon = (cityName) => L.divIcon({
                className: 'custom-marker',
                html: `<div class="marker-pulse"></div><div class="marker-label">${cityName}</div>`,
                iconSize: [80, 40], iconAnchor: [40, 20]
            });
            const markerRefs = [];
            cities.forEach(city => {
                const marker = L.marker([city.lat, city.lng], { icon: createIcon(city.name) })
                    .addTo(map)
                    .bindPopup(`<strong>${city.name}</strong><br><span style="font-size:11px;color:#64748b;">Cobertura CAE activa</span>`);
                markerRefs.push({ city, marker });
            });
            map.fitBounds(L.latLngBounds(cities.map(city => [city.lat, city.lng])), { padding: [32, 32] });
            L.control.zoom({ position: 'bottomright' }).addTo(map);
            const cityListEl = document.getElementById('cityList');
            if (cityListEl) {
                cities.forEach((city, idx) => {
                    const row = document.createElement('button');
                    row.type = 'button';
                    row.className = 'w-full text-left px-5 py-3.5 border-b border-white/[0.04] hover:bg-white/[0.035] transition-colors group flex items-center justify-between';
                    const latDir = city.lat >= 0 ? 'N' : 'S';
                    const lngDir = city.lng >= 0 ? 'E' : 'W';
                    row.innerHTML = `
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="text-[10px] font-mono text-slate-500 tabular-nums shrink-0">${String(idx + 1).padStart(2, '0')}</span>
                            <div class="min-w-0">
                                <div class="text-sm text-white font-medium group-hover:text-brand-accent transition-colors truncate">${city.name}</div>
                                <div class="text-[10px] font-mono text-slate-500 tabular-nums truncate">${Math.abs(city.lat).toFixed(2)}°${latDir} · ${Math.abs(city.lng).toFixed(2)}°${lngDir}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-brand-accent shadow-[0_0_6px_#2DD4BF] opacity-60 group-hover:opacity-100 group-hover:scale-150 transition-all"></span>
                            <i data-lucide="arrow-up-right" class="w-3 h-3 text-slate-600 group-hover:text-brand-accent transition-colors" aria-hidden="true"></i>
                        </div>`;
                    row.addEventListener('mouseenter', () => markerRefs[idx].marker.openPopup());
                    row.addEventListener('mouseleave', () => markerRefs[idx].marker.closePopup());
                    row.addEventListener('click', () => {
                        map.flyTo([city.lat, city.lng], 10, { duration: 1.2 });
                        markerRefs[idx].marker.openPopup();
                    });
                    cityListEl.appendChild(row);
                });
                lucide.createIcons();
            }
            setTimeout(() => map.invalidateSize(), 300);
        });

        (function initRequisitos() {
            const section = document.getElementById('requisitos');
            if (!section) return;
            const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const isFine = window.matchMedia('(pointer: fine)').matches;

            if (isFine && !reduced) {
                let rafId = null;
                let tx = 50, ty = 50, cx = 50, cy = 50, active = false;
                function tick() {
                    cx += (tx - cx) * 0.10;
                    cy += (ty - cy) * 0.10;
                    section.style.setProperty('--rq-mx', cx + '%');
                    section.style.setProperty('--rq-my', cy + '%');
                    if (active || Math.abs(tx - cx) > 0.2 || Math.abs(ty - cy) > 0.2) {
                        rafId = requestAnimationFrame(tick);
                    } else {
                        rafId = null;
                    }
                }
                section.addEventListener('pointermove', (e) => {
                    const r = section.getBoundingClientRect();
                    tx = ((e.clientX - r.left) / r.width) * 100;
                    ty = ((e.clientY - r.top) / r.height) * 100;
                    active = true;
                    if (!rafId) tick();
                }, { passive: true });
                section.addEventListener('pointerleave', () => { active = false; });
            }

            const ghost = section.querySelector('.rq-ghost');
            if (ghost && !reduced) {
                let rafGhost = null;
                function updateGhost() {
                    rafGhost = null;
                    const r = section.getBoundingClientRect();
                    const vh = window.innerHeight;
                    const progress = Math.max(0, Math.min(1, 1 - (r.top + r.height * 0.5) / vh));
                    ghost.style.transform = `translate(${(0.5 - progress) * 40}px, ${(0.5 - progress) * 80}px)`;
                }
                window.addEventListener('scroll', () => {
                    if (rafGhost) return;
                    rafGhost = requestAnimationFrame(updateGhost);
                }, { passive: true });
                updateGhost();
            }

            const cards = section.querySelectorAll('.rq-card');
            const io = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) return;
                    const target = entry.target;
                    if (target.matches('.rq-card')) {
                        const idx = [...cards].indexOf(target);
                        target.style.transitionDelay = `${idx * 90}ms, ${idx * 90}ms, ${idx * 90}ms, ${idx * 90}ms, 0s`;
                        setTimeout(() => { target.style.transitionDelay = ''; }, 1700);
                    }
                    target.classList.add('in-view');
                    if (target.matches('.rq-card') && target.querySelector('.rq-counter')) {
                        startCounter(target.querySelector('.rq-counter'));
                    }
                    io.unobserve(target);
                });
            }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

            section.querySelectorAll('.rq-head, .rq-card, .rq-verify, .rq-note').forEach(el => io.observe(el));

            function startCounter(counter) {
                if (!counter || counter.dataset.done) return;
                counter.dataset.done = '1';
                const target = parseInt(counter.dataset.target, 10) || 0;
                const start = performance.now();
                const duration = 1400;
                function tick(now) {
                    const p = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - p, 4);
                    counter.textContent = Math.round(eased * target);
                    if (p < 1) requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);
            }
        })();

        (function initFAQ() {
            const section = document.getElementById('faq');
            if (!section) return;
            const listEl = document.getElementById('fqList');
            const activeEl = document.getElementById('fqActive');
            const items = listEl ? [...listEl.querySelectorAll('.fq-item')] : [];
            const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const isFine = window.matchMedia('(pointer: fine)').matches;

            function setActive(idx) {
                items.forEach((item, i) => {
                    item.classList.toggle('is-open', i === idx);
                    const btn = item.querySelector('.fq-toggle');
                    if (btn) btn.setAttribute('aria-expanded', i === idx ? 'true' : 'false');
                });
                if (activeEl) activeEl.textContent = String(idx + 1).padStart(2, '0');
            }

            items.forEach((item, i) => {
                const btn = item.querySelector('.fq-toggle');
                if (!btn) return;
                btn.addEventListener('click', () => {
                    if (item.classList.contains('is-open')) return;
                    setActive(i);
                });
            });

            if (items.length) setActive(0);

            if (isFine && !reduced) {
                let rafId = null;
                let tx = 62, ty = 26, cx = 62, cy = 26, active = false;
                function tick() {
                    cx += (tx - cx) * 0.10;
                    cy += (ty - cy) * 0.10;
                    section.style.setProperty('--fq-mx', cx + '%');
                    section.style.setProperty('--fq-my', cy + '%');
                    if (active || Math.abs(tx - cx) > 0.2 || Math.abs(ty - cy) > 0.2) {
                        rafId = requestAnimationFrame(tick);
                    } else {
                        rafId = null;
                    }
                }
                section.addEventListener('pointermove', (e) => {
                    const r = section.getBoundingClientRect();
                    tx = ((e.clientX - r.left) / r.width) * 100;
                    ty = ((e.clientY - r.top) / r.height) * 100;
                    active = true;
                    if (!rafId) tick();
                }, { passive: true });
                section.addEventListener('pointerleave', () => { active = false; });
            }

            const ghost = section.querySelector('.fq-ghost');
            if (ghost && !reduced) {
                let rafGhost = null;
                function updateGhost() {
                    rafGhost = null;
                    const r = section.getBoundingClientRect();
                    const vh = window.innerHeight;
                    const progress = Math.max(0, Math.min(1, 1 - (r.top + r.height * 0.5) / vh));
                    ghost.style.transform = `translate(${(0.5 - progress) * 40}px, ${(0.5 - progress) * 70}px)`;
                }
                window.addEventListener('scroll', () => {
                    if (rafGhost) return;
                    rafGhost = requestAnimationFrame(updateGhost);
                }, { passive: true });
                updateGhost();
            }
        })();

        (function initAboutParallax() {
            const layers = document.querySelectorAll('.about-parallax');
            if (!layers.length) return;
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            let rafId = null;
            function update() {
                rafId = null;
                const vh = window.innerHeight;
                layers.forEach(layer => {
                    const wrap = layer.closest('.about-cinema-wrap');
                    if (!wrap) return;
                    const r = wrap.getBoundingClientRect();
                    if (r.bottom < -100 || r.top > vh + 100) return;
                    const progress = (r.top + r.height / 2 - vh / 2) / vh;
                    layer.style.transform = `translate3d(0, ${progress * -32}px, 0)`;
                });
            }
            window.addEventListener('scroll', () => {
                if (rafId) return;
                rafId = requestAnimationFrame(update);
            }, { passive: true });
            window.addEventListener('resize', update);
            update();
        })();
    </script>

    <script>
        (function initEligibility() {
            const btn = document.getElementById('eligibilityBtn');
            const modal = document.getElementById('eligibilityModal');
            const backdrop = document.getElementById('eligibilityBackdrop');
            const closeBtn = document.getElementById('eligibilityClose');
            const form = document.getElementById('eligibilityForm');
            if (!btn || !modal || !form) return;

            const card = modal.querySelector('.eligibility-card');
            const steps = [...modal.querySelectorAll('.elig-step')];
            const stepDots = [...modal.querySelectorAll('.step-dot')];
            const stepLines = [...modal.querySelectorAll('.step-line')];
            const nextBtns = [...modal.querySelectorAll('[data-elig-next]')];
            const prevBtns = [...modal.querySelectorAll('[data-elig-prev]')];
            const optGroups = [...modal.querySelectorAll('.elig-opt-group')];
            let currentStep = 0;
            let closeTimer = null;

            optGroups.forEach(group => {
                const options = [...group.querySelectorAll('.elig-opt')];
                const hidden = group.querySelector('input[type="hidden"]');
                options.forEach(opt => {
                    opt.addEventListener('click', () => {
                        options.forEach(o => o.classList.remove('active'));
                        opt.classList.add('active');
                        if (hidden) hidden.value = opt.dataset.value;
                        group.classList.remove('is-error');
                    });
                });
            });

            function updateStepUI() {
                steps.forEach((s, i) => s.classList.toggle('active', i === currentStep));
                stepDots.forEach((d, i) => {
                    d.classList.toggle('active', i === currentStep);
                    d.classList.toggle('completed', i < currentStep);
                });
                stepLines.forEach((l, i) => l.classList.toggle('completed', i < currentStep));
                if (card) card.scrollTo({ top: 0, behavior: 'smooth' });
            }

            function validateStep(stepIdx) {
                const stepEl = steps[stepIdx];
                if (!stepEl) return true;
                let valid = true;

                stepEl.querySelectorAll('.elig-opt-group[data-required="true"]').forEach(group => {
                    const hidden = group.querySelector('input[type="hidden"]');
                    if (!hidden || !hidden.value) {
                        valid = false;
                        group.classList.add('is-error');
                        setTimeout(() => group.classList.remove('is-error'), 1600);
                    }
                });

                stepEl.querySelectorAll('input[required], select[required], textarea[required]').forEach(inp => {
                    if (inp.type === 'hidden') return;
                    if (inp.type === 'checkbox') {
                        if (!inp.checked) {
                            valid = false;
                            inp.classList.add('is-error');
                            const lbl = inp.closest('label');
                            if (lbl) lbl.classList.add('is-error');
                            setTimeout(() => {
                                inp.classList.remove('is-error');
                                if (lbl) lbl.classList.remove('is-error');
                            }, 1600);
                        }
                    } else if (!String(inp.value).trim()) {
                        valid = false;
                        inp.classList.add('is-error');
                        setTimeout(() => inp.classList.remove('is-error'), 1600);
                    }
                });

                return valid;
            }

            nextBtns.forEach(b => {
                b.addEventListener('click', () => {
                    if (!validateStep(currentStep)) return;
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        updateStepUI();
                    }
                });
            });
            prevBtns.forEach(b => {
                b.addEventListener('click', () => {
                    if (currentStep > 0) {
                        currentStep--;
                        updateStepUI();
                    }
                });
            });

            function openModal() {
                if (closeTimer) { clearTimeout(closeTimer); closeTimer = null; }
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
                requestAnimationFrame(() => requestAnimationFrame(() => modal.classList.add('is-open')));
                setTimeout(() => {
                    const first = modal.querySelector('.elig-step.active input:not([type="hidden"]), .elig-step.active select, .elig-step.active textarea');
                    if (first) first.focus({ preventScroll: true });
                }, 150);
            }

            function closeModal() {
                modal.classList.remove('is-open');
                document.body.style.overflow = '';
                if (closeTimer) clearTimeout(closeTimer);
                closeTimer = setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    closeTimer = null;
                    btn.focus({ preventScroll: true });
                }, 320);
            }

            btn.addEventListener('click', openModal);
            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (backdrop) backdrop.addEventListener('click', closeModal);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });

            form.addEventListener('submit', (e) => {
                e.preventDefault();

                let firstInvalidStep = -1;
                for (let i = 0; i < steps.length; i++) {
                    if (!validateStep(i)) {
                        if (firstInvalidStep === -1) firstInvalidStep = i;
                    }
                }
                if (firstInvalidStep !== -1) {
                    currentStep = firstInvalidStep;
                    updateStepUI();
                    return;
                }

                alert('✅ Consulta de elegibilidad recibida.\n\nNuestro equipo revisará los datos de tu vivienda y te contactará en menos de 24 h.\n\nTambién puedes llamarnos al ' + @json(config('aislaplus.phone')) + ' o escribir al ' + @json(config('aislaplus.phone_whatsapp')) + ' (WhatsApp).');

                form.reset();
                optGroups.forEach(group => {
                    group.querySelectorAll('.elig-opt').forEach(o => o.classList.remove('active'));
                    const hidden = group.querySelector('input[type="hidden"]');
                    if (hidden) hidden.value = '';
                });
                currentStep = 0;
                updateStepUI();
                closeModal();
            });

            form.querySelectorAll('input:not([type="hidden"]), select, textarea').forEach(inp => {
                inp.addEventListener('input', () => inp.classList.remove('is-error'));
                inp.addEventListener('change', () => inp.classList.remove('is-error'));
            });
        })();
    </script>

    <script src="{{ asset('js/site-prompts.js') }}?v={{ filemtime(public_path('js/site-prompts.js')) }}" defer></script>

</body>
</html>