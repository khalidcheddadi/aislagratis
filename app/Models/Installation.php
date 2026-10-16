<?php

namespace App\Models;

use App\Enums\InstallationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'appointment_id', 'user_id', 'service_id',
        'installation_date', 'total_cost', 'subsidy_amount',
        'status', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'installation_date' => 'date',
            'total_cost' => 'decimal:2',
            'subsidy_amount' => 'decimal:2',
            'status' => InstallationStatus::class,
        ];
    }

    public function getNetCostAttribute(): float
    {
        return (float) $this->total_cost - (float) $this->subsidy_amount;
    }

    public function scopeCompleted(Builder $q): Builder
    {
        return $q->where('status', InstallationStatus::COMPLETED->value);
    }

    public function scopeByStatus(Builder $q, InstallationStatus $status): Builder
    {
        return $q->where('status', $status->value);
    }

    /** @return BelongsTo<Appointment, $this> */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Service, $this> */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /** @return HasMany<Review, $this> */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
