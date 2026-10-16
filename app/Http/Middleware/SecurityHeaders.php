<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self)');

        if (app()->environment('production')) {
            if ($request->isSecure()) {
                $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            }

            $response->headers->set(
                'Content-Security-Policy',
                "default-src 'self'; ".
                "img-src 'self' data: https:; ".
                "script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://unpkg.com; ".
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; ".
                "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; ".
                "connect-src 'self' https: wss:; ".
                "frame-ancestors 'self';"
            );
        }

        return $response;
    }
}
