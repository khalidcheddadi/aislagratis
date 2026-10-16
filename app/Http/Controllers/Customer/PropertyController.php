<?php

namespace App\Http\Controllers\Customer;

use App\Enums\PropertyType;
use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function index(Request $request): View
    {
        $properties = $request->user()->properties()->latest()->get();
        $editingProperty = $request->filled('edit')
            ? $request->user()->properties()->findOrFail($request->integer('edit'))
            : null;

        return view('customer.properties.index', [
            'properties' => $properties,
            'editingProperty' => $editingProperty,
            'propertyTypes' => PropertyType::cases(),
        ]);
    }

    public function store(Request $request)
    {
        $request->user()->properties()->create($this->validated($request));

        return redirect()->route('customer.properties.index')->with('success', 'Inmueble añadido correctamente.');
    }

    public function update(Request $request, Property $property)
    {
        abort_unless($property->user_id === $request->user()->id, 403);
        $property->update($this->validated($request));

        return redirect()->route('customer.properties.index')->with('success', 'Inmueble actualizado correctamente.');
    }

    public function destroy(Request $request, Property $property)
    {
        abort_unless($property->user_id === $request->user()->id, 403);
        $property->delete();

        return redirect()->route('customer.properties.index')->with('success', 'Inmueble eliminado.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'property_type' => ['required', Rule::enum(PropertyType::class)],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:10'],
            'area_m2' => ['nullable', 'numeric', 'gt:0', 'max:999999'],
            'year_built' => ['nullable', 'integer', 'min:1800', 'max:'.now()->year],
            'has_attic' => ['boolean'],
            'has_basement' => ['boolean'],
        ]);
    }
}
