<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoverageArea;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoverageAreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        $areas = CoverageArea::orderBy('province')->orderBy('city')->get();

        return view('admin.coverage-areas.index', compact('areas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'postal_code' => ['required', 'string', 'max:10'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'is_covered' => ['boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        CoverageArea::create($data);

        return back()->with('success', 'Área añadida.');
    }

    public function update(Request $request, CoverageArea $coverageArea)
    {
        $data = $request->validate([
            'postal_code' => ['required', 'string', 'max:10'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'is_covered' => ['boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        $coverageArea->update($data);

        return back()->with('success', 'Área actualizada.');
    }

    public function destroy(CoverageArea $coverageArea)
    {
        $coverageArea->delete();

        return back()->with('success', 'Área eliminada.');
    }
}
