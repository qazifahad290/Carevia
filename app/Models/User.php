<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_PATIENT = 'patient';
    public const ROLE_DOCTOR  = 'doctor';
    public const ROLE_ADMIN   = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'dob',
        'address',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dob' => 'date',
        ];
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function quickCareRequests(): HasMany
    {
        return $this->hasMany(QuickCareRequest::class, 'patient_id');
    }

    public function doctorProfile(): HasOne
    {
        return $this->hasOne(Doctor::class, 'user_id');
    }

    public function isPatient(): bool
    {
        return $this->role === self::ROLE_PATIENT;
    }

    public function isDoctor(): bool
    {
        return $this->role === self::ROLE_DOCTOR;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            self::ROLE_DOCTOR => route('doctor.dashboard'),
            self::ROLE_ADMIN  => route('admin.dashboard'),
            default           => route('dashboard'),
        };
    }

    public function avatarUrl(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        $hash = md5(strtolower(trim($this->email)));
        return "https://i.pravatar.cc/200?u={$hash}";
    }
}
