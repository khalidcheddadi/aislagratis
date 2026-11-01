<?php

namespace App\Services;

use App\Actions\Leads\CreateLeadAction;
use App\Actions\Leads\UpdateLeadStatusAction;
use App\Enums\LeadStatus;
use App\Models\CoverageArea;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LeadService
{
    public function __construct(
        protected CreateLeadAction $createAction,
        protected UpdateLeadStatusAction $updateStatusAction,
    ) {}

    public function create(array $data, ?User $user = null): Lead
    {
        return DB::transaction(function () use ($data, $user) {

            $data['user_id'] = $user?->id;
            $data['ip_address'] = request()->ip();
            $data['user_agent'] = request()->userAgent();
            $data['utm_source'] = request()->input('utm_source');
            $data['utm_medium'] = request()->input('utm_medium');
            $data['utm_campaign'] = request()->input('utm_campaign');
            $data['source'] = 'web';

            $data['is_covered'] = $this->checkCoverage($data['postal_code']);

            if (! $data['is_covered']) {
                $data['message'] = ($data['message'] ?? '').
                    "\n[ATENCIÓN: CP no cubierto - {$data['postal_code']}]";
            }

            return $this->createAction->execute($data);
        });
    }

    public function paginate(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        return Lead::query()
            ->with([
                'user:id,first_name,last_name',
                'service:id,name,slug',
            ])
            ->when($filters['status'] ?? null, fn ($q, $v) => $q->status(LeadStatus::from($v)))
            ->when($filters['search'] ?? null, fn ($q, $v) => $q->search($v))
            ->when($filters['service_id'] ?? null, fn ($q, $v) => $q->where('service_id', $v))
            ->when($filters['date_from'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($filters['date_to'] ?? null, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function updateStatus(Lead $lead, LeadStatus $newStatus, User $user): Lead
    {
        return $this->updateStatusAction->execute($lead, $newStatus, $user);
    }

    public function getStats(): array
    {
        return Cache::remember('leads.stats', now()->addMinutes(5), function () {
            $counts = Lead::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            return [
                'total' => array_sum($counts),
                'new' => $counts[LeadStatus::NEW->value] ?? 0,
                'contacted' => $counts[LeadStatus::CONTACTED->value] ?? 0,
                'scheduled' => $counts[LeadStatus::SCHEDULED->value] ?? 0,
                'completed' => $counts[LeadStatus::COMPLETED->value] ?? 0,
                'discarded' => $counts[LeadStatus::DISCARDED->value] ?? 0,
                'today' => Lead::whereDate('created_at', today())->count(),
                'this_week' => Lead::whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                ])->count(),
                'this_month' => Lead::whereMonth('created_at', now()->month)->count(),
            ];
        });
    }

    public function checkCoverage(string $postalCode): bool
    {
        return Cache::remember(
            "coverage.{$postalCode}",
            now()->addHours(24),
            fn () => CoverageArea::query()
                ->where('postal_code', $postalCode)
                ->where('is_covered', true)
                ->exists()
        );
    }

    public function exportToArray(Lead $lead): array
    {
        return [
            'ID' => $lead->id,
            'Nombre' => $lead->full_name,
            'Email' => $lead->email,
            'Teléfono' => $lead->phone ?? 'N/D',
            'Dirección' => $lead->address ?? 'N/D',
            'CP' => $lead->postal_code,
            'Ciudad' => $lead->city,
            'Provincia' => $lead->province,
            'Servicio solicitado' => $lead->service?->name ?? 'Estudio energético',
            'Tipo inmueble' => $lead->property_type->label(),
            'Superficie' => $lead->area_m2 ? "{$lead->area_m2} m²" : 'N/D',
            'Año construcción' => $lead->year_built ?? 'N/D',
            'Buhardilla' => $lead->has_attic ? 'Sí' : 'No',
            'Sótano' => $lead->has_basement ? 'Sí' : 'No',
            'Zona cubierta' => $lead->is_covered ? 'Sí' : 'No',
            'Acceso' => $lead->access_type?->label() ?? 'N/D',
            'Propietario' => is_null($lead->is_owner) ? 'N/D' : ($lead->is_owner ? 'Sí' : 'No'),
            'Tipo indicado' => $lead->eligibility_property_kind ?? 'N/D',
            'Zona a aislar' => $lead->eligibility_zone ?? 'N/D',
            'Acceso indicado' => $lead->eligibility_access ?? 'N/D',
            'Desván habitable' => $lead->eligibility_habitable ?? 'N/D',
            'Antigüedad' => $lead->eligibility_age ?? 'N/D',
            'Ayudas previas' => $lead->eligibility_prior_aid ?? 'N/D',
            'Preferencia de contacto' => $lead->contact_preference ?? 'N/D',
            'Referencia catastral' => $lead->cadastral_reference ?? 'N/D',
            'Privacidad aceptada' => $lead->privacy_accepted_at?->format('d/m/Y H:i') ?? 'N/D',
            'Estado' => $lead->status->label(),
            'Fuente' => $lead->source,
            'Campaña' => $lead->utm_campaign ?? 'N/D',
            'Usuario registrado' => $lead->user?->full_name ?? 'No vinculado',
            'Creado' => $lead->created_at->format('d/m/Y H:i'),
            'Contactado' => $lead->contacted_at?->format('d/m/Y H:i') ?? 'N/D',
            'Completado' => $lead->converted_at?->format('d/m/Y H:i') ?? 'N/D',
            'Mensaje' => strip_tags($lead->message ?? ''),
        ];
    }
}
