<?php

namespace App\Models;

use App\Enums\AccessType;
use App\Enums\LeadStatus;
use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Lead extends Model
{
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'service_id',
        'first_name', 'last_name', 'email', 'phone',
        'postal_code', 'address', 'city', 'province',
        'property_type', 'area_m2', 'year_built',
        'has_attic', 'has_basement', 'access_type',
        'message', 'status', 'source', 'is_covered',
        'ip_address', 'user_agent',
        'utm_source', 'utm_medium', 'utm_campaign',
        'contacted_at', 'converted_at',
    ];

    protected function casts(): array
    {
        return [
            'property_type' => PropertyType::class,
            'access_type' => AccessType::class,
            'status' => LeadStatus::class,
            'has_attic' => 'boolean',
            'has_basement' => 'boolean',
            'is_covered' => 'boolean',
            'area_m2' => 'decimal:2',
            'contacted_at' => 'datetime',
            'converted_at' => 'datetime',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'email', 'phone'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getLocationAttribute(): string
    {
        return trim(implode(', ', array_filter([
            $this->city, $this->province, $this->postal_code,
        ])));
    }

    public function scopeStatus(Builder $q, LeadStatus $status): Builder
    {
        return $q->where('status', $status->value);
    }

    public function scopeNew(Builder $q): Builder
    {
        return $q->where('status', LeadStatus::NEW->value);
    }

    public function scopePending(Builder $q): Builder
    {
        return $q->whereIn('status', [
            LeadStatus::NEW->value,
            LeadStatus::CONTACTED->value,
        ]);
    }

    public function scopeRecent(Builder $q, int $days = 30): Builder
    {
        return $q->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeSearch(Builder $q, ?string $term): Builder
    {
        if (blank($term)) {
            return $q;
        }

        return $q->where(function (Builder $sub) use ($term) {
            $sub->where('first_name', 'like', "%{$term}%")
                ->orWhere('last_name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%")
                ->orWhere('postal_code', 'like', "%{$term}%");
        });
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

    /** @return HasMany<Appointment, $this> */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /** @return HasOne<Appointment, $this> */
    public function latestAppointment(): HasOne
    {
        return $this->hasOne(Appointment::class)->latestOfMany('appointment_date');
    }
}
