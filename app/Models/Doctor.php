<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialty_id',
        'name',
        'photo',
        'bio',
        'rating',
        'price',
        'years_experience',
        'location',
        'is_active',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'price' => 'integer',
        'years_experience' => 'integer',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function photoUrl(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return "https://i.pravatar.cc/300?img=" . (($this->id % 70) + 1);
    }
}
