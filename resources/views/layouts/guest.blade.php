<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('partials.site-icons')

        <title>{{ config('app.name', 'Laravel') }}</title>

        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="{{ asset('css/site-theme.css') }}?v={{ filemtime(public_path('css/site-theme.css')) }}">
        <link rel="stylesheet" href="{{ asset('css/shared-site-header.css') }}?v={{ filemtime(public_path('css/shared-site-header.css')) }}">
        <link rel="stylesheet" href="{{ asset('css/home-navbar.css') }}?v={{ filemtime(public_path('css/home-navbar.css')) }}">
    </head>
    <body class="font-sans text-gray-900 antialiased guest-shell">
        @include('partials.shared-site-header')

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 guest-shell-frame">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 guest-panel overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        <script>
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', () => {
                    const isOpen = mobileMenu.classList.toggle('hidden') === false;
                    mobileMenuBtn.setAttribute('aria-expanded', String(isOpen));
                    mobileMenuBtn.setAttribute('aria-label', isOpen ? 'Cerrar menú' : 'Abrir menú');
                });
                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.add('hidden');
                        mobileMenuBtn.setAttribute('aria-expanded', 'false');
                        mobileMenuBtn.setAttribute('aria-label', 'Abrir menú');
                    });
                });
            }
        </script>
    </body>
</html>
