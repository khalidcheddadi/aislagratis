<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        $partners = Partner::orderBy('sort_order')->get();

        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        Partner::create($this->validated($request));

        return back()->with('success', 'Partner añadido.');
    }

    public function update(Request $request, Partner $partner)
    {
        $partner->update($this->validated($request));

        return back()->with('success', 'Partner actualizado.');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();

        return back()->with('success', 'Partner eliminado.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);
    }
}
