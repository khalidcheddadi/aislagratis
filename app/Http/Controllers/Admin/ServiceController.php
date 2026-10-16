<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(): View
    {
        $services = Service::ordered()->get();

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;
        unset($data['image']);
        if ($image) {
            $data['image_path'] = $image->store('services', 'public');
        }
        Service::create($data);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Servicio creado.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(StoreServiceRequest $request, Service $service)
    {
        $data = $request->validated();
        $image = $data['image'] ?? null;
        unset($data['image']);
        if ($image) {
            if ($service->image_path) {
                Storage::disk('public')->delete($service->image_path);
            }
            $data['image_path'] = $image->store('services', 'public');
        }
        $service->update($data);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Servicio actualizado.');
    }

    public function destroy(Service $service)
    {
        if ($service->image_path) {
            Storage::disk('public')->delete($service->image_path);
        }
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Servicio eliminado.');
    }
}
