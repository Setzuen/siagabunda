<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PregnancyProfile extends Model
{
    protected $fillable = [
        'user_id',
        'hpht',
        'due_date',
        'blood_type',
        'referral_hospital',
        'gravida_para',
        'risk_level',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'hpht' => 'date',
            'due_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gestationalWeeks(): ?int
    {
        if (! $this->hpht) {
            return null;
        }
        $weeks = (int) floor($this->hpht->diffInDays(Carbon::now()) / 7);

        return max(0, min(42, $weeks));
    }

    public function daysUntilDue(): ?int
    {
        if (! $this->due_date) {
            return null;
        }

        return (int) Carbon::now()->startOfDay()->diffInDays($this->due_date->startOfDay(), false);
    }
}
