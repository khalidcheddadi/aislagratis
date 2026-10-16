<section class="admin-panel"><div class="admin-panel-head"><h2>Información del servicio</h2><a class="admin-button" href="{{ route('admin.services.index') }}"><i class="fa-solid fa-arrow-left"></i> Volver</a></div><div class="admin-panel-body"><form method="POST" enctype="multipart/form-data" action="{{ $isEdit ? route('admin.services.update', $service) : route('admin.services.store') }}">@csrf @if($isEdit) @method('PUT') @endif<div class="admin-form-grid">
    <div class="admin-field"><label for="name">Nombre</label><input id="name" name="name" value="{{ old('name', $service?->name) }}" required maxlength="150"></div>
    <div class="admin-field"><label for="icon_class">Clase de icono</label><input id="icon_class" name="icon_class" value="{{ old('icon_class', $service?->icon_class ?? 'fa-solid fa-house') }}" required maxlength="100" placeholder="fa-solid fa-house"></div>
    <div class="admin-field admin-field-full"><label for="description">Descripción breve</label><textarea id="description" name="description" maxlength="1000" required>{{ old('description', $service?->description) }}</textarea></div>
    <div class="admin-field admin-field-full"><label for="long_description">Descripción completa</label><textarea id="long_description" name="long_description">{{ old('long_description', $service?->long_description) }}</textarea></div>
    <div class="admin-field"><label for="base_price">Precio base (€)</label><input id="base_price" type="number" min="0" step="0.01" name="base_price" value="{{ old('base_price', $service?->base_price ?? '0.00') }}" required></div>
    <div class="admin-field"><label for="estimated_hours">Horas estimadas</label><input id="estimated_hours" type="number" min="1" max="999" name="estimated_hours" value="{{ old('estimated_hours', $service?->estimated_hours ?? 1) }}" required></div>
    <div class="admin-field"><label for="sort_order">Orden</label><input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $service?->sort_order ?? 0) }}"></div>
    <div class="admin-field"><label for="image">Imagen</label><input id="image" type="file" name="image" accept="image/*">@if($service?->image_path)<small>Imagen actual: <a href="{{ Storage::disk('public')->url($service->image_path) }}" target="_blank" rel="noopener">Ver imagen</a></small>@endif</div>
    <div class="admin-field admin-field-full"><label>Características</label><div id="service-features" style="display:grid;gap:8px">@foreach(old('features', $service?->features ?? []) as $feature)<div class="admin-feature-row" style="display:flex;gap:8px"><input name="features[]" value="{{ $feature }}" maxlength="200" placeholder="Característica del servicio"><button type="button" class="admin-button" data-remove-feature aria-label="Quitar característica"><i class="fa-solid fa-minus"></i></button></div>@endforeach</div><button type="button" class="admin-button" id="add-service-feature" style="margin-top:8px"><i class="fa-solid fa-plus"></i> Añadir característica</button></div>
    <div class="admin-field"><label class="admin-check"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service?->is_active ?? true))> Publicado</label></div>
    <div class="admin-field"><label class="admin-check"><input type="hidden" name="is_featured" value="0"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $service?->is_featured ?? false))> Destacado</label></div>
    <div class="admin-field-full"><button type="submit" class="admin-button admin-button-primary"><i class="fa-solid fa-floppy-disk"></i> {{ $isEdit ? 'Guardar cambios' : 'Crear servicio' }}</button></div>
</div></form></div></section>
@push('scripts')<script>
document.getElementById('add-service-feature')?.addEventListener('click', () => {
    const row = document.createElement('div');
    row.className = 'admin-feature-row';
    row.style.cssText = 'display:flex;gap:8px';
    row.innerHTML = '<input name="features[]" maxlength="200" placeholder="Característica del servicio"><button type="button" class="admin-button" data-remove-feature aria-label="Quitar característica"><i class="fa-solid fa-minus"></i></button>';
    document.getElementById('service-features').append(row);
});
document.getElementById('service-features')?.addEventListener('click', event => {
    if (event.target.closest('[data-remove-feature]')) event.target.closest('.admin-feature-row').remove();
});
document.querySelector('form[enctype="multipart/form-data"]')?.addEventListener('submit', () => {
    document.querySelectorAll('#service-features input').forEach(input => {
        if (!input.value.trim()) input.closest('.admin-feature-row').remove();
    });
});
</script>@endpush