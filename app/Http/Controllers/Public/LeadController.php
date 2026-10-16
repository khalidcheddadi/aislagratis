<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreLeadRequest;
use App\Models\Service;
use App\Services\LeadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function __construct(protected LeadService $service) {}

    public function create(): View
    {
        $services = Service::active()->ordered()->get(['id', 'name']);

        return view('public.lead-form', compact('services'));
    }

    public function store(StoreLeadRequest $request): RedirectResponse
    {
        $this->service->create(
            $request->validated(),
            $request->user()
        );

        return redirect()
            ->route('leads.thanks')
            ->with('success', '¡Gracias! Hemos recibido tu solicitud. Te contactaremos pronto.');
    }

    public function thanks(): View
    {
        return view('public.thanks');
    }
}
