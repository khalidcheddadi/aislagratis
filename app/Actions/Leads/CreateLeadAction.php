<?php

namespace App\Actions\Leads;

use App\Enums\LeadStatus;
use App\Models\Lead;

class CreateLeadAction
{
    public function execute(array $data): Lead
    {
        return Lead::create([
            'user_id' => $data['user_id'] ?? null,
            'service_id' => $data['service_id'] ?? null,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'postal_code' => $data['postal_code'],
            'address' => $data['address'] ?? null,
            'city' => $data['city'] ?? null,
            'province' => $data['province'] ?? null,
            'property_type' => $data['property_type'],
            'area_m2' => $data['area_m2'] ?? null,
            'year_built' => $data['year_built'] ?? null,
            'has_attic' => (bool) ($data['has_attic'] ?? false),
            'has_basement' => (bool) ($data['has_basement'] ?? false),
            'access_type' => $data['access_type'] ?? null,
            'message' => $data['message'] ?? null,
            'status' => LeadStatus::NEW,
            'source' => $data['source'] ?? 'web',
            'is_covered' => $data['is_covered'] ?? true,
            'ip_address' => $data['ip_address'] ?? null,
            'user_agent' => $data['user_agent'] ?? null,
            'utm_source' => $data['utm_source'] ?? null,
            'utm_medium' => $data['utm_medium'] ?? null,
            'utm_campaign' => $data['utm_campaign'] ?? null,
        ]);
    }
}
