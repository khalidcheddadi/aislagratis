<?php

namespace App\Http\Resources;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Lead */
class LeadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'location' => [
                'postal_code' => $this->postal_code,
                'city' => $this->city,
                'province' => $this->province,
                'is_covered' => $this->is_covered,
            ],
            'property' => [
                'type' => $this->property_type->value,
                'type_label' => $this->property_type->label(),
                'area_m2' => $this->area_m2,
                'year_built' => $this->year_built,
                'has_attic' => $this->has_attic,
                'has_basement' => $this->has_basement,
            ],
            'eligibility' => [
                'is_owner' => $this->is_owner,
                'property_kind' => $this->eligibility_property_kind,
                'zone' => $this->eligibility_zone,
                'access' => $this->eligibility_access,
                'habitable' => $this->eligibility_habitable,
                'age' => $this->eligibility_age,
                'prior_aid' => $this->eligibility_prior_aid,
                'contact_preference' => $this->contact_preference,
                'cadastral_reference' => $this->cadastral_reference,
            ],
            'status' => [
                'value' => $this->status->value,
                'label' => $this->status->label(),
                'color' => $this->status->color(),
            ],
            'source' => $this->source,
            'created_at' => $this->created_at->toIso8601String(),
            'created_at_human' => $this->created_at->diffForHumans(),
        ];
    }
}
