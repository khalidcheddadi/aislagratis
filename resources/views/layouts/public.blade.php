<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'aislagratis'))</title>
    <meta name="description" content="@yield('meta_description', 'aislagratis - Expertos en aislamiento térmico con financiación CAE en España. Solicita tu estudio gratuito.')">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <meta property="og:locale" content="es_ES">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name', 'aislagratis') }}">
    <meta property="og:title" content="@yield('title', config('app.name', 'aislagratis'))">
    <meta property="og:description" content="@yield('meta_description', 'aislagratis - Expertos en aislamiento térmico con financiación CAE en España. Solicita tu estudio gratuito.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('icons/icon-512.png') }}?v={{ filemtime(public_path('icons/icon-512.png')) }}">
    <meta property="og:image:alt" content="Logotipo de aislagratis">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="@yield('title', config('app.name', 'aislagratis'))">
    <meta name="twitter:description" content="@yield('meta_description', 'aislagratis - Expertos en aislamiento térmico con financiación CAE en España. Solicita tu estudio gratuito.')">
    <meta name="twitter:image" content="{{ asset('icons/icon-512.png') }}?v={{ filemtime(public_path('icons/icon-512.png')) }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    @include('partials.site-icons')
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="aislagratis">
    <style>
        :root {
            --black: #16281c;
            --white: #ffffff;
            --gray-100: #eef6ef;
            --gray-200: #dcebde;
            --gray-400: #a9c7ad;
            --gray-500: #5d7a62;
            --gray-600: #48624c;
            --gray-800: #223a28;
            --accent: #F4A222;
            --green: #2E7D32;
            --green-light: #4CAF50;
            --green-dark: #1B5E20;
            --green-50: #eaf6ec;
            --green-light-rgb: 76, 175, 80;
            --green-dark-rgb: 27, 94, 32;
            --white-rgb: 255, 255, 255;
            --black-rgb: 0, 0, 0;
            --green-50-rgb: 234, 246, 236;
            --star-off: #ddd;
            --muted-light: #aaa;
            --border-light: rgba(var(--green-dark-rgb), 0.12);
            --overlay-hero: linear-gradient(rgba(var(--green-50-rgb), 0.88), rgba(var(--white-rgb), 0.95));
            --overlay-section: linear-gradient(rgba(var(--green-50-rgb), 0.78), rgba(var(--white-rgb), 0.92));
            --overlay-soft: linear-gradient(rgba(var(--green-50-rgb), 0.55), rgba(var(--white-rgb), 0.88));
            --overlay-medium: linear-gradient(rgba(var(--green-50-rgb), 0.75), rgba(var(--white-rgb), 0.92));
            --shadow-sm: 0 4px 15px rgba(var(--green-dark-rgb), 0.08);
            --shadow-md: 0 10px 30px rgba(var(--green-dark-rgb), 0.14);
            --shadow-lg: 0 20px 50px rgba(var(--green-dark-rgb), 0.18);
            --blob-radius: 46% 54% 40% 60% / 53% 41% 59% 47%;
            --blob-radius-2: 60% 40% 55% 45% / 50% 60% 40% 50%;
            --blob-radius-3: 40% 60% 50% 50% / 60% 40% 60% 40%;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Montserrat', sans-serif; }

        html, body {
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
            background-color: var(--white);
            color: var(--black);
            line-height: 1.6;
            scroll-behavior: smooth;
        }

        ::selection { background: var(--green-light); color: var(--white); }
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: var(--green-50); }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(var(--green-light), var(--green-dark));
            border-radius: 10px;
        }

        img { max-width: 100%; height: auto; }
        a { text-decoration: none; color: inherit; transition: all 0.3s ease; }

        .container { max-width: 1150px; margin: 0 auto; padding: 0 25px; width: 100%; }

        .hero-container {
            position: relative;
            width: 100%;
            background: var(--overlay-hero),
                        var(--hero-image, url('/images/image12-960.webp')) center/cover no-repeat;
            display: flex;
            flex-direction: column;
            padding: 1.5rem 4rem 2rem;
        }

        .custom-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1.5rem;
            z-index: 100;
            flex-wrap: wrap;
            gap: 15px;
        }

        .logo { display: flex; align-items: center; gap: 10px; }
        .logo .brand-logo-image { width: 40px; height: 40px; object-fit: contain; border-radius: 10px; background: #fff; }

        .logo-text { display: flex; flex-direction: column; line-height: 1; }
        .logo-text .bold-text {
            font-weight: 900;
            font-size: 1.1rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .nav-desktop { display: flex; list-style: none; gap: 35px; align-items: center; }
        .nav-desktop a {
            color: var(--black);
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            position: relative;
            padding: 5px 0;
        }

        .nav-desktop a::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--green);
            transition: width 0.3s ease;
        }

        .nav-desktop a.active::after,
        .nav-desktop a:hover::after { width: 100%; }

        .contact-info { text-align: right; }

        .call-text {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--gray-600);
        }

        .phone-number {
            display: block;
            font-weight: 900;
            font-size: 1.15rem;
            color: var(--black);
            letter-spacing: 1px;
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.6rem;
            cursor: pointer;
            color: var(--black);
            padding: 5px;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
        }

        .mobile-nav-backdrop {
            position: fixed;
            inset: 0;
            z-index: 10001;
            border: 0;
            background: rgba(11, 24, 15, 0.48);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }

        .mobile-nav-backdrop.show {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .mobile-nav {
            position: fixed;
            inset: 0 0 0 auto;
            z-index: 10002;
            display: flex;
            flex-direction: column;
            width: min(390px, 88vw);
            height: 100dvh;
            padding: 24px;
            background: #fff;
            box-shadow: -18px 0 50px rgba(11, 24, 15, 0.16);
            transform: translateX(105%);
            visibility: hidden;
            transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1), visibility 0.32s ease;
            overflow-y: auto;
        }

        .mobile-nav.show {
            transform: translateX(0);
            visibility: visible;
        }

        .mobile-nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border-light);
        }

        .mobile-nav-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            font-size: 0.95rem;
            font-weight: 900;
            letter-spacing: 1.5px;
        }

        .mobile-nav-brand .brand-logo-image { width: 34px; height: 34px; object-fit: contain; border-radius: 8px; background: #fff; }

        .mobile-nav-close {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-light);
            border-radius: 50%;
            background: var(--green-50);
            color: var(--green-dark);
            font-size: 1.1rem;
            cursor: pointer;
        }

        .mobile-nav-links, .mobile-nav-account {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mobile-nav-links { padding: 24px 0; }

        .mobile-nav-links a, .mobile-nav-account > a, .mobile-nav-account form button {
            display: flex;
            align-items: center;
            gap: 13px;
            min-height: 50px;
            padding: 0 15px;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: var(--gray-600);
            font: 700 0.85rem 'Montserrat', sans-serif;
            text-align: left;
            transition: color 0.2s ease, background 0.2s ease;
            cursor: pointer;
        }

        .mobile-nav-links a i, .mobile-nav-account a i, .mobile-nav-account button i {
            width: 20px;
            color: var(--green);
            text-align: center;
        }

        .mobile-nav-links a:hover, .mobile-nav-account > a:hover,
        .mobile-nav-links a.active, .mobile-nav-account > a.active {
            background: var(--green-50);
            color: var(--green-dark);
        }

        .mobile-nav-account {
            border-top: 1px solid var(--border-light);
            padding-top: 20px;
        }

        .mobile-nav-account form button { width: 100%; }

        .mobile-nav-phone {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-top: auto;
            padding: 18px 15px 4px;
            color: var(--gray-500);
            font-size: 0.75rem;
        }

        .mobile-nav-phone strong { color: var(--black); font-size: 1rem; }

        body.mobile-nav-open { overflow: hidden; }

        @media (min-width: 769px) {
            .mobile-nav, .mobile-nav-backdrop { display: none; }
        }

        .hero-main {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 10;
            gap: 40px;
            padding: 2rem 0;
        }

        .left-content { max-width: 52%; flex: 1 1 52%; min-width: 280px; }

        .typography-group {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .sub-title {
            font-weight: 700;
            font-size: 1.25rem;
            line-height: 1.25;
            text-align: right;
            border-right: 3px solid var(--gray-400);
            padding-right: 20px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--gray-600);
        }

        .main-title {
            font-weight: 900;
            font-size: 4.5rem;
            line-height: 0.88;
            letter-spacing: -2px;
            text-transform: uppercase;
            color: var(--black);
        }

        .cta-button {
            background: linear-gradient(135deg, var(--green-light), var(--green) 60%, var(--green-dark));
            color: var(--white);
            border: none;
            padding: 16px 40px;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            margin-bottom: 60px;
            transition: all 0.3s ease;
            border-radius: 8px;
            display: inline-block;
        }

        .cta-button:hover {
            background: linear-gradient(135deg, var(--green), var(--green-dark) 70%);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(27, 94, 32, 0.32);
            color: var(--white);
        }

        .bottom-promo { display: flex; align-items: center; gap: 15px; }
        .bottom-promo i { font-size: 1.8rem; color: var(--black); }
        .bottom-promo p {
            font-size: 0.75rem;
            font-weight: 700;
            line-height: 1.5;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--gray-600);
        }

        .right-content {
            position: relative;
            flex: 0 1 420px;
            display: flex;
            justify-content: center;
        }

        .image-wrapper {
            position: relative;
            width: 420px;
            height: 420px;
            max-width: 100%;
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: var(--blob-radius);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
        }

        .floating-icon {
            position: absolute;
            font-size: 1.4rem;
            color: var(--black);
            animation: float 4s ease-in-out infinite;
            opacity: 0.7;
        }

        .fi-1 { top: 8%; left: -6%; animation-delay: 0s; font-size: 1.6rem; }
        .fi-2 { top: 25%; left: 12%; font-size: 0.9rem; animation-delay: 1s; }
        .fi-3 { top: 45%; right: -6%; font-size: 1.7rem; animation-delay: 2s; }
        .fi-4 { bottom: 15%; left: -4%; font-size: 1.1rem; animation-delay: 0.5s; }
        .fi-5 { bottom: 8%; right: 10%; font-size: 1.3rem; animation-delay: 1.5s; }

        @keyframes float {
            0%   { transform: translateY(0px); }
            50%  { transform: translateY(-12px); }
            100% { transform: translateY(0px); }
        }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.6; transform: scale(1); }
            50%      { opacity: 1; transform: scale(1.08); }
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%      { opacity: 0.5; transform: scale(0.8); }
        }

        @keyframes ticker-scroll {
            0%   { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .hero-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            z-index: 10;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            flex-wrap: wrap;
            gap: 15px;
        }

        .copyright { font-size: 0.75rem; color: var(--gray-500); font-weight: 600; }

        .social-icons { display: flex; gap: 12px; }
        .social-icons a {
            color: var(--white);
            background-color: var(--green);
            width: 32px;
            height: 32px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background-color: var(--green-dark);
            transform: translateY(-3px);
        }

        .section-header { text-align: center; margin-bottom: 55px; }

        .section-header .subtitle {
            display: inline-block;
            background: var(--green-50);
            color: var(--green-dark);
            border: 1px solid var(--border-light);
            border-radius: 30px;
            padding: 7px 20px;
            text-align: center;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }

        .section-header h2 {
            font-size: 2.6rem;
            font-weight: 900;
            letter-spacing: -1px;
            text-transform: uppercase;
            line-height: 1.15;
            color: var(--black);
        }

        .ticker-bar {
            position: relative;
            width: 100%;
            background: linear-gradient(135deg, var(--green-dark), var(--green) 60%, var(--green-light));
            color: var(--white);
            overflow: hidden;
            padding: 13px 0;
            box-shadow: 0 8px 25px rgba(27, 94, 32, 0.22);
            display: flex;
            align-items: center;
        }

        .ticker-label {
            flex-shrink: 0;
            background: var(--accent);
            color: var(--black);
            font-weight: 900;
            font-size: 0.7rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 8px 22px;
            position: relative;
            z-index: 3;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: -2px;
            clip-path: polygon(0 0, 100% 0, calc(100% - 12px) 100%, 0 100%);
        }

        .ticker-label i { animation: pulse-dot 1.4s ease-in-out infinite; }

        .ticker-wrap { overflow: hidden; flex: 1; position: relative; }

        .ticker-track {
            display: flex;
            width: max-content;
            animation: ticker-scroll 30s linear infinite;
        }

        .ticker-bar:hover .ticker-track { animation-play-state: paused; }

        .ticker-item {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            white-space: nowrap;
            padding: 0 30px;
            color: var(--white);
        }

        .ticker-item i { color: var(--accent); font-size: 0.9rem; }
        .ticker-sep { color: rgba(255, 255, 255, 0.35); font-size: 0.6rem; }

        .install-prompt {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, var(--green-light), var(--green-dark));
            color: var(--white);
            padding: 14px 22px;
            border-radius: 30px;
            z-index: 9999;
            display: none;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 30px rgba(27, 94, 32, 0.35);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .install-prompt button {
            background: var(--white);
            border: none;
            color: var(--black);
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .install-prompt .close-prompt {
            background: transparent;
            color: var(--white);
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0 5px;
        }

        .cookie-consent-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #ffffff;
            color: #1a1a1a;
            padding: 16px 20px;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
            z-index: 10000;
            display: none;
            border-top: 2px solid #1B5E20;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from { transform: translateY(100%); }
            to   { transform: translateY(0); }
        }

        .cookie-consent-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .cookie-consent-text { flex: 1 1 300px; font-size: 0.9rem; line-height: 1.5; }
        .cookie-consent-text a {
            color: #1B5E20;
            text-decoration: underline;
            font-weight: 600;
        }

        .cookie-consent-buttons { display: flex; gap: 10px; flex-wrap: wrap; }

        .cookie-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
        }

        .cookie-btn-accept { background: #1B5E20; color: #ffffff; }
        .cookie-btn-accept:hover { background: #2e7d32; transform: translateY(-1px); }

        .cookie-btn-reject { background: transparent; color: #666; border: 1px solid #ccc; }
        .cookie-btn-reject:hover { background: #f5f5f5; border-color: #bbb; }

        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 9999;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            background-color: #1ebe5b;
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(0,0,0,0.3);
            color: #fff;
        }

        .blob-img {
            border-radius: var(--blob-radius);
            box-shadow: var(--shadow-lg);
            transition: all 0.4s ease;
        }

        @media (max-width: 1024px) {
            .hero-main {
                flex-direction: column;
                text-align: center;
                gap: 40px;
            }
            .left-content { max-width: 100%; text-align: center; }
            .typography-group { justify-content: center; flex-direction: column; gap: 10px; }
            .sub-title {
                border-right: none;
                border-bottom: 3px solid var(--gray-400);
                padding-right: 0;
                padding-bottom: 10px;
                text-align: center;
            }
            .main-title { font-size: 3.5rem; }
            .bottom-promo { justify-content: center; }
            .image-wrapper { width: 340px; height: 340px; }
            .nav-desktop { gap: 20px; }
        }

        @media (max-width: 768px) {
            .hero-container { padding: 1rem 1.2rem 1.5rem; }
            .nav-desktop { display: none; }
            .mobile-toggle { display: block; }
            .main-title { font-size: 2.8rem; letter-spacing: -1px; }
            .sub-title { font-size: 1rem; }
            .cta-button { padding: 14px 30px; font-size: 0.75rem; margin-bottom: 40px; }
            .image-wrapper { width: 260px; height: 260px; }
            .section-header h2 { font-size: 2rem; }
            .hero-footer { flex-direction: column; text-align: center; }
            .contact-info { display: none; }
            .ticker-label { padding: 6px 14px; font-size: 0.6rem; }
            .ticker-item { font-size: 0.68rem; padding: 0 20px; }
            .whatsapp-float {
                bottom: 20px;
                right: 20px;
                width: 55px;
                height: 55px;
                font-size: 28px;
            }
        }

        @media (max-width: 600px) {
            .cookie-consent-container { flex-direction: column; align-items: flex-start; }
            .cookie-consent-buttons { width: 100%; justify-content: flex-end; }
        }

        @media (max-width: 480px) {
            .image-wrapper { width: 200px; height: 200px; }
            .main-title { font-size: 2.2rem; }
            .sub-title { font-size: 0.9rem; }
            .section-header h2 { font-size: 1.6rem; }
        }

        @stack('styles')
    </style>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ filemtime(public_path('css/home.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/brand-experience.css') }}?v={{ filemtime(public_path('css/brand-experience.css')) }}">
    <link rel="stylesheet" href="{{ asset('css/dark-immersive.css') }}?v={{ filemtime(public_path('css/dark-immersive.css')) }}">
</head>
<body @class([
    'brand-experience' => request()->routeIs('home', 'services.index', 'about', 'leads.create', 'login', 'register'),
    'brand-home' => request()->routeIs('home'),
])>

    
    @include('partials.install-prompt')

    
    @include('partials.cookie-consent')

    @yield('content')

    @include('partials.public-footer')
    @include('partials.whatsapp-float')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 80,
        });

        const mobileToggle = document.getElementById('mobileToggle');
        const mobileNav = document.getElementById('mobileNav');
        const mobileNavClose = document.getElementById('mobileNavClose');
        const mobileNavBackdrop = document.getElementById('mobileNavBackdrop');
        if (mobileToggle && mobileNav && mobileNavBackdrop) {
            const setMobileNavOpen = (isOpen) => {
                mobileNav.classList.toggle('show', isOpen);
                mobileNavBackdrop.classList.toggle('show', isOpen);
                mobileNav.setAttribute('aria-hidden', String(!isOpen));
                mobileToggle.setAttribute('aria-expanded', String(isOpen));
                document.body.classList.toggle('mobile-nav-open', isOpen);
                if (isOpen) {
                    mobileNav.querySelector('a')?.focus();
                } else {
                    mobileToggle.focus();
                }
            };

            mobileToggle.addEventListener('click', function() {
                setMobileNavOpen(!mobileNav.classList.contains('show'));
            });
            mobileNavClose?.addEventListener('click', () => setMobileNavOpen(false));
            mobileNavBackdrop.addEventListener('click', () => setMobileNavOpen(false));
            mobileNav.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => setMobileNavOpen(false));
            });
            document.addEventListener('keydown', event => {
                if (event.key === 'Escape' && mobileNav.classList.contains('show')) {
                    setMobileNavOpen(false);
                }
            });
        }

        const userDropdownToggle = document.getElementById('userDropdownToggle');
        if (userDropdownToggle) {
            const userDropdown = userDropdownToggle.nextElementSibling;
            userDropdownToggle.addEventListener('click', function(e) {
                e.preventDefault();
                userDropdown.style.display = userDropdown.style.display === 'none' ? 'block' : 'none';
            });
            document.addEventListener('click', function(e) {
                if (!userDropdownToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.style.display = 'none';
                }
            });
        }

        const tickerTrack = document.getElementById('tickerTrack');
        if (tickerTrack) {
            tickerTrack.innerHTML += tickerTrack.innerHTML;
        }

        const homeHero = document.getElementById('home-hero');
        const heroSmokeEffect = homeHero?.querySelector('.hero-smoke-effect');
        if (homeHero && heroSmokeEffect && window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
            const smokeBlockedAreas = '.custom-header, .left-content > *, .right-content, .hero-services > *, .hero-bottom > *';
            homeHero.addEventListener('pointermove', event => {
                const target = event.target;
                if (!(target instanceof Element) || target.closest(smokeBlockedAreas)) {
                    heroSmokeEffect.classList.remove('is-active');
                    return;
                }

                const bounds = homeHero.getBoundingClientRect();
                heroSmokeEffect.style.setProperty('--smoke-x', `${event.clientX - bounds.left}px`);
                heroSmokeEffect.style.setProperty('--smoke-y', `${event.clientY - bounds.top}px`);
                heroSmokeEffect.classList.add('is-active');
            });
            homeHero.addEventListener('pointerleave', () => {
                heroSmokeEffect.classList.remove('is-active');
            });
        }

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/service-worker.js')
                    .catch(error => {
                        console.error('Service Worker registration failed:', error);
                    });
            });
        }

        let deferredPrompt;
        const installPrompt = document.getElementById('installPrompt');
        const installBtn = document.getElementById('installBtn');
        const closePrompt = document.getElementById('closePrompt');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (installPrompt) installPrompt.style.display = 'flex';
        });

        if (installBtn) {
            installBtn.addEventListener('click', () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(() => {
                        deferredPrompt = null;
                        installPrompt.style.display = 'none';
                    });
                }
            });
        }

        if (closePrompt) {
            closePrompt.addEventListener('click', () => {
                installPrompt.style.display = 'none';
            });
        }

        window.addEventListener('appinstalled', () => {
            if (installPrompt) installPrompt.style.display = 'none';
            deferredPrompt = null;
        });

        (function() {
            const COOKIE_CONSENT_KEY = 'cookies_consent';
            const VISITOR_TOKEN_KEY = 'visitor_token';
            const COOKIE_CONSENT_EXPIRY_DAYS = 365;
            const banner = document.getElementById('cookieConsentBanner');
            const acceptBtn = document.getElementById('acceptCookiesBtn');
            const rejectBtn = document.getElementById('rejectCookiesBtn');

            if (!banner) return;

            function generateVisitorToken() {
                if (window.crypto && crypto.randomUUID) return crypto.randomUUID();
                return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    const r = Math.random() * 16 | 0;
                    const v = c === 'x' ? r : (r & 0x3 | 0x8);
                    return v.toString(16);
                });
            }

            function getVisitorToken() {
                let token = localStorage.getItem(VISITOR_TOKEN_KEY);
                if (!token) {
                    token = generateVisitorToken();
                    localStorage.setItem(VISITOR_TOKEN_KEY, token);
                }
                return token;
            }

            function getConsent() {
                const stored = localStorage.getItem(COOKIE_CONSENT_KEY);
                if (!stored) return null;
                try {
                    const parsed = JSON.parse(stored);
                    if (parsed && parsed.expiry && new Date(parsed.expiry) > new Date()) {
                        return parsed.value;
                    } else {
                        localStorage.removeItem(COOKIE_CONSENT_KEY);
                        return null;
                    }
                } catch (e) {
                    localStorage.removeItem(COOKIE_CONSENT_KEY);
                    return null;
                }
            }

            function setConsentLocal(value) {
                const expiryDate = new Date();
                expiryDate.setDate(expiryDate.getDate() + COOKIE_CONSENT_EXPIRY_DAYS);
                localStorage.setItem(COOKIE_CONSENT_KEY, JSON.stringify({
                    value: value,
                    expiry: expiryDate.toISOString()
                }));
            }

            function saveConsentToServer(value) {
                const visitorToken = getVisitorToken();
                const formData = new FormData();
                formData.append('consent', value);
                formData.append('visitor_token', visitorToken);

                fetch('{{ route('cookie.consent') }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('No se pudo guardar el consentimiento.');
                    return response.json();
                })
                .catch(error => console.error('Error al conectar con el servidor:', error));
            }

            const consent = getConsent();
            if (consent === null) banner.style.display = 'block';

            acceptBtn.addEventListener('click', function() {
                setConsentLocal('accepted');
                saveConsentToServer('accepted');
                banner.style.display = 'none';
            });

            rejectBtn.addEventListener('click', function() {
                setConsentLocal('rejected');
                saveConsentToServer('rejected');
                banner.style.display = 'none';
            });
        })();

        document.querySelectorAll('.faq-hero-question, .faq-question').forEach(btn => {
            btn.addEventListener('click', function() {
                const parent = this.parentElement;
                const selector = parent.classList.contains('faq-hero-item') ? '.faq-hero-item' : '.faq-item';
                document.querySelectorAll(selector).forEach(item => {
                    if (item !== parent) {
                        item.classList.remove('active');
                        item.querySelector('.faq-hero-question, .faq-question')?.setAttribute('aria-expanded', 'false');
                    }
                });
                const isActive = parent.classList.toggle('active');
                this.setAttribute('aria-expanded', String(isActive));
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
