<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverageArea extends Model
{
    use HasFactory;

    protected $fillable = ['postal_code', 'city', 'province', 'is_covered', 'notes'];

    protected function casts(): array
    {
        return ['is_covered' => 'boolean'];
    }

    public function scopeCovered(Builder $query): Builder
    {
        return $query->where('is_covered', true)
            ->orderBy('province')
            ->orderBy('city');
    }
}
