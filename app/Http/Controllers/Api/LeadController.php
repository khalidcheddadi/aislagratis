<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\StoreLeadRequest;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use App\Services\LeadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LeadController extends Controller
{
    public function __construct(protected LeadService $service) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $leads = $request->user()
            ->leads()
            ->latest()
            ->paginate(20);

        return LeadResource::collection($leads);
    }

    public function store(StoreLeadRequest $request): JsonResponse
    {
        $lead = $this->service->create(
            $request->validated(),
            $request->user()
        );

        return response()->json([
            'message' => 'Solicitud recibida.',
            'lead' => new LeadResource($lead),
        ], 201);
    }

    public function show(Request $request, Lead $lead): LeadResource
    {
        abort_unless(
            $request->user()->id === $lead->user_id || $request->user()->role->canManage(),
            403
        );

        return new LeadResource($lead);
    }
}
