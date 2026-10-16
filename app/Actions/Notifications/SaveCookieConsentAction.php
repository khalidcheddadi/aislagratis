<?php

namespace App\Actions\Notifications;

use App\Models\CookieConsent;
use Illuminate\Support\Facades\Http;

class SaveCookieConsentAction
{
    public function execute(array $data): CookieConsent
    {
        $ip = request()->ip();
        $geo = $this->resolveGeo($ip);

        return CookieConsent::updateOrCreate(
            ['visitor_token' => $data['visitor_token']],
            [
                'user_id' => auth()->id(),
                'consent_value' => $data['consent'],
                'ip_address' => $ip,
                'country' => $geo['country'] ?? null,
                'city' => $geo['city'] ?? null,
                'user_agent' => request()->userAgent(),
            ]
        );
    }

    protected function resolveGeo(?string $ip): array
    {
        if (! $ip || in_array($ip, ['127.0.0.1', '::1'], true)) {
            return [];
        }

        try {
            $response = Http::timeout(3)->get(
                config('services.ip_geo.url').$ip,
                ['fields' => 'status,country,city']
            );

            if ($response->successful() && $response->json('status') === 'success') {
                return [
                    'country' => $response->json('country'),
                    'city' => $response->json('city'),
                ];
            }
        } catch (\Throwable $e) {
            logger()->warning('GeoIP lookup failed', [
                'ip' => $ip,
                'error' => $e->getMessage(),
            ]);
        }

        return [];
    }
}
