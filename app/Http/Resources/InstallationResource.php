<?php

namespace App\Http\Resources;

use App\Models\Installation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Installation */
class InstallationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'installation_date' => $this->installation_date->toDateString(),
            'total_cost' => $this->total_cost,
            'subsidy_amount' => $this->subsidy_amount,
            'net_cost' => $this->net_cost,
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
            ],
            'service' => $this->whenLoaded('service', fn () => [
                'id' => $this->service->id,
                'name' => $this->service->name,
            ]),
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
