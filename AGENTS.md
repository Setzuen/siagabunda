# SiagaBunda - Project Guidelines & Architecture Rules

## 1. Environment & Runtime Conventions
- **OS**: Windows (PowerShell environment)
- **PHP CLI**: Always use `c:\xampp\php\php.exe` when executing Artisan commands, migrations, or tinker (e.g., `c:\xampp\php\php.exe artisan serve`).
- **Database**: SQLite (`database/database.sqlite`). Migrations are managed via Laravel standard commands.
- **Frontend Assets**: Tailwind CSS & Alpine.js are integrated via CDN in `resources/views/layouts/app.blade.php`. No heavy Node compile step is required for basic UI rendering.

## 2. Multi-Agent Interoperability (Antigravity & Hermes Agent)
- The codebase was co-authored between Hermes Agent and Antigravity.
- When adding features or refactoring:
  - Preserve established controller methods, models, and Eloquent relationships.
  - Do NOT break existing role-based routes (`role:patient` and `role:hospital_staff`).
  - Keep test accounts seeded in `DatabaseSeeder.php` (`ibu.sari@siagabunda.id` and `bidan@siagabunda.id`).

## 3. P4K Digital Sitemap & Information Architecture
All future views and modifications MUST adhere to this exact sitemap hierarchy:

Halaman Awal
│
├── Profil Pengguna (patient.profile)
│   - HPHT, Taksiran HPL (+280 hari otomatis), Usia Kehamilan, Gravida/Para, Golongan Darah, RS Rujukan
│
├── Edukasi Persiapan Persalinan (patient.education)
│   ├── Tanda Awal Persalinan
│   ├── Tanda Bahaya Kehamilan dan Persalinan
│   ├── Persiapan Fisik
│   ├── Persiapan Psikologis
│   ├── Teknik Pernapasan dan Relaksasi (Metode 4-4-6)
│   └── Persiapan Persalinan Normal dan Operasi Sesar
│
├── Checklist Kesiapan Persalinan (patient.checklist)
│   ├── 1. Tempat Persalinan
│   ├── 2. Tenaga Kesehatan
│   ├── 3. Transportasi
│   ├── 4. Biaya dan Asuransi
│   ├── 5. Perlengkapan Ibu dan Bayi
│   ├── 6. Pendamping Persalinan
│   └── 7. Kontak Darurat
│
├── Video Edukasi (patient.education tab video)
│   ├── Teknik Pernapasan Persalinan
│   ├── Latihan Relaksasi
│   └── Persiapan Persalinan
│
├── Pengingat dan Agenda (patient.reminders)
│   ├── Jadwal Antenatal Care (type: anc)
│   ├── Pengingat Persiapan Persalinan (type: persiapan)
│   └── Pengingat Tanda Bahaya (type: tanda_bahaya)
│
└── Bantuan dan Kontak Darurat (patient.emergency)
    - Hotline Ambulans 119, IGD RS Rujukan, Donor Darah WhatsApp, Protokol Darurat

## 4. Hospital / Nakes Role Scope (hospital.*)
- Monitoring Responden Dashboard: list pasien, filter status risiko (rendah/sedang/tinggi), rata-rata skor kesiapan.
- Penilaian Klinis: penapisan risiko oleh bidan & penjadwalan kontrol ANC langsung ke akun pasien.
- Ekspor CSV: rekapitulasi data responden dengan header UTF-8 BOM untuk Microsoft Excel.
- Kelola Edukasi: CRUD artikel & link video YouTube embed.

