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

    protected $fillable = [
        'name',
        'email',
        'role',
        'phone',
        'password',
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
        ];
    }

    public function pregnancyProfile(): HasOne
    {
        return $this->hasOne(PregnancyProfile::class);
    }

    public function checklists(): HasMany
    {
        return $this->hasMany(Checklist::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    public function isHospitalStaff(): bool
    {
        return $this->role === 'hospital_staff';
    }

    public function readinessPercentage(): int
    {
        $total = $this->checklists()->count();
        if ($total === 0) {
            return 0;
        }
        $completed = $this->checklists()->where('is_completed', true)->count();

        return (int) round(($completed / $total) * 100);
    }

    public static function defaultChecklistItems(): array
    {
        return [
            [
                'category' => 'place',
                'title' => 'Tempat Persalinan',
                'description' => 'Menentukan RS, Klinik, atau Puskesmas tempat bersalin yang dituju.',
            ],
            [
                'category' => 'provider',
                'title' => 'Tenaga Kesehatan',
                'description' => 'Memastikan Bidan atau Dokter Obgyn yang akan menolong persalinan.',
            ],
            [
                'category' => 'transport',
                'title' => 'Transportasi',
                'description' => 'Menyiapkan kendaraan (mobil pribadi/tetangga/ambulans desa) untuk menuju faskes.',
            ],
            [
                'category' => 'cost',
                'title' => 'Biaya dan Asuransi',
                'description' => 'Memastikan kartu JKN/BPJS aktif atau dana darurat persalinan tersedia.',
            ],
            [
                'category' => 'supplies',
                'title' => 'Perlengkapan Ibu dan Bayi',
                'description' => 'Menyiapkan pakaian ibu, kain bersih, popok, baju bayi, dan dokumen (KTP, KK, Buku KIA).',
            ],
            [
                'category' => 'companion',
                'title' => 'Pendamping Persalinan',
                'description' => 'Menentukan suami atau anggota keluarga yang mendampingi selama proses persalinan.',
            ],
            [
                'category' => 'emergency',
                'title' => 'Kontak Darurat',
                'description' => 'Mencatat nomor IGD RS rujukan, Bidan, serta calon pendonor darah yang cocok.',
            ],
        ];
    }
}
