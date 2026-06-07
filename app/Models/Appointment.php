<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'date',
        'time',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'string',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function isUpcoming(): bool
    {
        return $this->date->isFuture() || $this->date->isToday();
    }

    public function scopeForDoctor(Builder $query, int $doctorId): Builder
    {
        return $query->where('doctor_id', $doctorId);
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->where('date', now()->toDateString());
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('date', '>=', now()->toDateString())
            ->whereIn('status', ['confirmed'])
            ->orderBy('date')->orderBy('time');
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->where('date', '<', now()->toDateString())
              ->orWhereIn('status', ['cancelled', 'completed']);
        })->orderByDesc('date')->orderByDesc('time');
    }
}
