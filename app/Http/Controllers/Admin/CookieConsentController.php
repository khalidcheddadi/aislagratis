<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CookieConsent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CookieConsentController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'consent' => ['nullable', 'in:accepted,rejected'],
            'search' => ['nullable', 'string', 'max:100'],
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:date_from'],
        ]);

        $consents = CookieConsent::query()
            ->with('user:id,first_name,last_name,email')
            ->when($filters['consent'] ?? null, fn ($query, $value) => $query->where('consent_value', $value))
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('country', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%");
                });
            })
            ->when($filters['date_from'] ?? null, fn ($query, $date) => $query->whereDate('updated_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn ($query, $date) => $query->whereDate('updated_at', '<=', $date))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $stats = [
            'total' => CookieConsent::count(),
            'accepted' => CookieConsent::where('consent_value', 'accepted')->count(),
            'rejected' => CookieConsent::where('consent_value', 'rejected')->count(),
        ];

        return view('admin.cookie-consents.index', compact('consents', 'filters', 'stats'));
    }
}
