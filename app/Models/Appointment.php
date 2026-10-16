<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'lead_id', 'user_id', 'technician_id',
        'appointment_date', 'duration_minutes',
        'status', 'notes', 'technician_notes',
        'reminder_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'datetime',
            'duration_minutes' => 'integer',
            'status' => AppointmentStatus::class,
            'reminder_sent_at' => 'datetime',
        ];
    }

    public function scopeUpcoming(Builder $q): Builder
    {
        return $q->where('appointment_date', '>=', now())
            ->orderBy('appointment_date');
    }

    public function scopePending(Builder $q): Builder
    {
        return $q->where('status', AppointmentStatus::PENDING->value);
    }

    public function scopeForTechnician(Builder $q, int $technicianId): Builder
    {
        return $q->where('technician_id', $technicianId);
    }

    /** @return BelongsTo<Lead, $this> */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<User, $this> */
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    /** @return HasOne<Installation, $this> */
    public function installation(): HasOne
    {
        return $this->hasOne(Installation::class);
    }
}
