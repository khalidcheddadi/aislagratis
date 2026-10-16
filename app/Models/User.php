<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Mail\VerifyAccountEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone',
        'password', 'role', 'is_active', 'avatar',
        'locale', 'timezone',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'is_active' => 'boolean',
        ];
    }

    public function sendEmailVerificationNotification(): void
    {
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $this->getKey(),
                'hash' => sha1($this->getEmailForVerification()),
            ]
        );

        Mail::to($this->getEmailForVerification())->send(
            new VerifyAccountEmail($this->first_name, $verificationUrl)
        );
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(
            mb_substr($this->first_name ?? '', 0, 1).mb_substr($this->last_name ?? '', 0, 1)
        );
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/'.$this->avatar)
            : 'https://ui-avatars.com/api/?name='.urlencode($this->full_name)
                .'&background=1B5E20&color=fff&bold=true&size=128';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRole($query, UserRole $role)
    {
        return $query->where('role', $role->value);
    }

    public function scopeCustomers($query)
    {
        return $query->where('role', UserRole::CUSTOMER->value);
    }

    public function scopeTechnicians($query)
    {
        return $query->where('role', UserRole::TECHNICIAN->value);
    }

    /** @return HasMany<Lead, $this> */
    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    /** @return HasMany<Appointment, $this> */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /** @return HasMany<Appointment, $this> */
    public function technicianAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'technician_id');
    }

    /** @return HasMany<Installation, $this> */
    public function installations(): HasMany
    {
        return $this->hasMany(Installation::class);
    }

    /** @return HasMany<Review, $this> */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /** @return HasMany<Property, $this> */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    /** @return HasMany<CookieConsent, $this> */
    public function cookieConsents(): HasMany
    {
        return $this->hasMany(CookieConsent::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isSales(): bool
    {
        return $this->role === UserRole::SALES;
    }

    public function isTechnician(): bool
    {
        return $this->role === UserRole::TECHNICIAN;
    }

    public function isCustomer(): bool
    {
        return $this->role === UserRole::CUSTOMER;
    }

    public function canManageLeads(): bool
    {
        return $this->role->canManage();
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            UserRole::ADMIN, UserRole::SALES => route('admin.dashboard'),
            UserRole::TECHNICIAN => route('admin.appointments.index'),
            UserRole::CUSTOMER => route('customer.dashboard'),
        };
    }

    public function recordLogin(string $ip): void
    {
        $this->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
        ])->saveQuietly();
    }
}
