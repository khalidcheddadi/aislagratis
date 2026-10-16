<?php

return [
    'login_rate_limit' => (int) env('LOGIN_RATE_LIMIT', 5),
    'seed_demo_users' => env('SEED_DEMO_USERS', false),
    'seeded_users' => [
        'admin' => [
            'email' => env('SEED_ADMIN_EMAIL', 'admin@aislaplus.test'),
            'password' => env('SEED_ADMIN_PASSWORD'),
            'first_name' => 'Admin',
            'last_name' => 'Demo',
        ],
        'sales' => [
            'email' => env('SEED_SALES_EMAIL', 'sales@aislaplus.test'),
            'password' => env('SEED_SALES_PASSWORD'),
            'first_name' => 'Sales',
            'last_name' => 'Demo',
        ],
        'technician' => [
            'email' => env('SEED_TECHNICIAN_EMAIL', 'technician@aislaplus.test'),
            'password' => env('SEED_TECHNICIAN_PASSWORD'),
            'first_name' => 'Technician',
            'last_name' => 'Demo',
        ],
    ],
    




    'phone' => env('BUSINESS_PHONE', '+34 641 322 118'),
    'phone_whatsapp' => env('BUSINESS_PHONE_WHATSAPP', '34641322118'),
    'email' => env('BUSINESS_EMAIL', 'info@aislaplus.es'),

    




    'stats' => [
        'projects' => 500,
        'satisfaction' => 98,
        'experience' => 10,
        'cae' => 100,
    ],

    




    'ticker' => [
        ['icon' => 'fa-bolt', 'text' => 'Financiación CAE al 100% sin coste inicial'],
        ['icon' => 'fa-euro-sign', 'text' => 'Ahorra hasta un 70% en tu factura energética'],
        ['icon' => 'fa-magnifying-glass-chart', 'text' => 'Estudio energético gratuito y sin compromiso'],
        ['icon' => 'fa-house-chimney', 'text' => 'Más de 500 viviendas rehabilitadas en España'],
        ['icon' => 'fa-leaf', 'text' => 'Reduce tu huella de CO₂ desde el primer día'],
        ['icon' => 'fa-shield-halved', 'text' => 'Garantía de instalación hasta 10 años'],
    ],

    




    'pwa' => [
        'name' => env('PWA_APP_NAME', 'aislagratis'),
        'theme_color' => env('PWA_THEME_COLOR', '#1B5E20'),
        'background_color' => env('PWA_BACKGROUND_COLOR', '#ffffff'),
    ],

    




    'coverage_note' => '¿No ves tu provincia? Consúltanos',
];
