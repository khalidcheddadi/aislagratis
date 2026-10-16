<?php

namespace App\Models;

use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'property_type', 'address', 'city', 'province', 'postal_code',
        'area_m2', 'year_built', 'has_attic', 'has_basement',
    ];

    protected function casts(): array
    {
        return [
            'property_type' => PropertyType::class,
            'area_m2' => 'decimal:2',
            'year_built' => 'integer',
            'has_attic' => 'boolean',
            'has_basement' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
