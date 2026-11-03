import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/home-tailwind.css',
                'resources/css/public-vendor.css',
                'resources/js/app.js',
                'resources/js/public-aos.js',
                'resources/js/admin.js',
                'resources/css/public/home.css',
                'resources/css/public/brand-experience.css',
                'resources/css/public/dark-immersive.css',
                'resources/css/public/site-theme.css',
                'resources/css/public/shared-site-header.css',
                'resources/css/public/home-navbar.css',
                'resources/css/public/brand-pages.css',
                'resources/css/public/shared-public-ui.css',
                'resources/css/public/eligibility-study.css',
                'resources/js/public/site-prompts.js',
                'resources/js/public/eligibility-study.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    build: {
        chunkSizeWarningLimit: 1000,
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['axios', 'alpinejs'],
                    ui: ['aos', 'sweetalert2'],
                },
            },
        },
    },
    server: {
        host: 'localhost',
        port: 5173,
        hmr: { host: 'localhost' },
    },
});
