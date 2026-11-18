<?php

namespace Database\Seeders;

use App\Models\Checklist;
use App\Models\EducationContent;
use App\Models\PregnancyProfile;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Rumah Sakit / Bidan (Admin / Peneliti)
        User::firstOrCreate(
            ['email' => 'bidan@siagabunda.id'],
            [
                'name' => 'Bidan Ratna Wijaya, S.Keb',
                'role' => 'hospital_staff',
                'phone' => '081122334455',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Akun Responden / Ibu Hamil
        $patients = [
            [
                'name' => 'Ibu Sari Dewi',
                'email' => 'ibu.sari@siagabunda.id',
                'phone' => '081234567890',
                'hpht' => Carbon::now()->subWeeks(34),
                'blood_type' => 'O+',
                'referral_hospital' => 'RSIA Kasih Bunda',
                'gravida_para' => 'G1P0A0',
                'risk_level' => 'rendah',
                'completed_count' => 5,
                'notes' => 'Kondisi janin baik, aktif bergerak. Rutin kontrol ANC.',
            ],
            [
                'name' => 'Ibu Rina Kartika',
                'email' => 'ibu.rina@siagabunda.id',
                'phone' => '081398765432',
                'hpht' => Carbon::now()->subWeeks(37),
                'blood_type' => 'AB+',
                'referral_hospital' => 'RSUD Dr. Soetomo',
                'gravida_para' => 'G2P1A0',
                'risk_level' => 'tinggi',
                'completed_count' => 3,
                'notes' => 'Riwayat hipertensi ringan, perlu pemantauan tekanan darah ketat dan kesiapan transportasi darurat.',
            ],
            [
                'name' => 'Ibu Maya Putri',
                'email' => 'ibu.maya@siagabunda.id',
                'phone' => '085611223344',
                'hpht' => Carbon::now()->subWeeks(29),
                'blood_type' => 'A+',
                'referral_hospital' => 'RSIA Kasih Bunda',
                'gravida_para' => 'G1P0A0',
                'risk_level' => 'rendah',
                'completed_count' => 7,
                'notes' => 'Seluruh perlengkapan P4K sudah lengkap dan terverifikasi.',
            ],
        ];

        foreach ($patients as $p) {
            $user = User::firstOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'role' => 'patient',
                    'phone' => $p['phone'],
                    'password' => Hash::make('password'),
                ]
            );

            $dueDate = (clone $p['hpht'])->addDays(280);

            PregnancyProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'hpht' => $p['hpht']->toDateString(),
                    'due_date' => $dueDate->toDateString(),
                    'blood_type' => $p['blood_type'],
                    'referral_hospital' => $p['referral_hospital'],
                    'gravida_para' => $p['gravida_para'],
                    'risk_level' => $p['risk_level'],
                    'notes' => $p['notes'],
                ]
            );

            foreach (User::defaultChecklistItems() as $idx => $item) {
                Checklist::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'title' => $item['title'],
                    ],
                    [
                        'category' => $item['category'],
                        'description' => $item['description'],
                        'details' => $idx < $p['completed_count'] ? 'Sudah disiapkan dan dicatat oleh keluarga.' : null,
                        'is_completed' => $idx < $p['completed_count'],
                    ]
                );
            }

            Schedule::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => 'Kontrol Antenatal Care (ANC) Rutin',
                ],
                [
                    'description' => 'Pemeriksaan tekanan darah, DJJ janin, dan evaluasi kesiapan P4K bersama Bidan/Dokter.',
                    'event_date' => Carbon::now()->addDays(3)->setTime(9, 0),
                    'location' => $p['referral_hospital'].' - Poli KIA',
                    'type' => 'anc',
                    'status' => 'upcoming',
                ]
            );

            Schedule::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'title' => 'Finalisasi Tas Bersalin & Dokumen BPJS',
                ],
                [
                    'description' => 'Pastikan KTP, KK, Buku KIA, dan pakaian bayi sudah masuk dalam satu tas siaga.',
                    'event_date' => Carbon::now()->addDays(7)->setTime(10, 0),
                    'location' => 'Rumah',
                    'type' => 'persiapan',
                    'status' => 'upcoming',
                ]
            );
        }

        // 3. Konten Edukasi & Video Edukasi (Sesuai Struktur P4K Digital)
        $educations = [
            [
                'slug' => 'tanda-awal-persalinan',
                'title' => 'Tanda Awal Persalinan',
                'category' => 'tanda_awal',
                'summary' => 'Kenali kontraksi asli (His), keluarnya lendir bercampur darah, dan pecahnya ketuban.',
                'content' => "1. Kontraksi Teratur (His Adekuat): Perut terasa kencang secara teratur (misalnya setiap 5-10 menit), semakin lama semakin kuat dan tidak hilang saat istirahat.\n2. Keluar Lendir Bercampur Darah (Bloody Show): Sumbat lendir serviks keluar akibat mulai adanya pembukaan jalan lahir.\n3. Keluarnya Air Ketuban: Cairan jernih merembes atau menyembur dari jalan lahir yang tidak dapat ditahan seperti buang air kecil. Segera menuju fasilitas kesehatan bila ketuban pecah!",
            ],
            [
                'slug' => 'tanda-bahaya-kehamilan-dan-persalinan',
                'title' => 'Tanda Bahaya Kehamilan dan Persalinan',
                'category' => 'tanda_bahaya',
                'summary' => 'Gejala darurat yang mengharuskan Ibu segera dibawa ke IGD Rumah Sakit tanpa menunda.',
                'content' => "SEGERA KE IGD BILA MENGALAMI SALAH SATU TANDA BERIKUT:\n• Perdarahan dari jalan lahir (merah segar atau bergumpal).\n• Sakit kepala hebat, pandangan kabur, disertai bengkak pada wajah dan tangan (waspada Preeklamsia).\n• Gerakan janin berkurang drastis (<10 gerakan dalam 12 jam) atau tidak terasa sama sekali.\n• Demam tinggi menggigil atau kejang.\n• Air ketuban pecah berwarna keruh, hijau, atau berbau.",
            ],
            [
                'slug' => 'persiapan-fisik',
                'title' => 'Persiapan Fisik',
                'category' => 'fisik',
                'summary' => 'Menjaga stamina, nutrisi bergizi seimbang, senam hamil, dan posisi tidur yang aman.',
                'content' => "• Nutrisi & Hidrasi: Konsumsi makanan tinggi protein, zat besi, dan cukup air putih minimal 2-2.5 liter/hari untuk menjaga energi saat mengejan.\n• Aktivitas Ringan: Jalan santai pagi hari selama 15-20 menit dan latihan panggul (pelvic rocking) dengan gym ball membantu kepala janin turun ke panggul.\n• Istirahat Cukup: Biasakan tidur miring ke kiri untuk melancarkan aliran darah dan oksigen ke plasenta.",
            ],
            [
                'slug' => 'persiapan-psikologis',
                'title' => 'Persiapan Psikologis',
                'category' => 'psikologis',
                'summary' => 'Mengelola rasa cemas menjelang lahiran melalui afirmasi positif dan peran pendamping.',
                'content' => "• Komunikasi dengan Pasangan: Diskusikan peran suami atau pendamping saat persalinan (memijat punggung, mengingatkan tarik napas, memberi minum).\n• Afirmasi Positif: Yakinkan diri bahwa tubuh Ibu dirancang secara alami untuk melahirkan dengan aman.\n• Kurangi Paparan Cerita Negatif: Fokus pada informasi medis terpercaya dari Bidan atau Dokter.",
            ],
            [
                'slug' => 'teknik-pernapasan-dan-relaksasi',
                'title' => 'Teknik Pernapasan dan Relaksasi',
                'category' => 'pernapasan',
                'summary' => 'Metode napas dalam (4-4-6) untuk mengurangi nyeri kontraksi dan menjaga suplai oksigen janin.',
                'content' => "• Tarik napas perlahan melalui hidung selama 4 hitungan.\n• Tahan sejenak selama 2-4 hitungan sambil merilekskan bahu dan rahang.\n• Hembuskan perlahan melalui mulut seperti meniup lilin selama 6 hitungan.\n• Hindari mengejan sebelum pembukaan lengkap (10 cm) sesuai instruksi Bidan/Dokter agar jalan lahir tidak bengkak.",
            ],
            [
                'slug' => 'persiapan-persalinan-normal-dan-operasi-sesar',
                'title' => 'Persiapan Persalinan Normal dan Operasi Sesar',
                'category' => 'persalinan',
                'summary' => 'Memahami alur tindakan persalinan pervaginam maupun Sectio Caesarea (SC) sesuai indikasi medis.',
                'content' => "• Persalinan Normal: Meliputi Kala I (pembukaan 1-10 cm), Kala II (kelahiran bayi), Kala III (kelahiran plasenta), dan Kala IV (pemantauan 2 jam pasca salin).\n• Operasi Sesar (SC): Dilakukan bila ada indikasi medis (letak lintang, plasenta previa, preeklamsia berat, atau gawat janin). Ibu perlu berpuasa 6-8 jam sebelum tindakan terencana dan menyiapkan pendamping serta dokumen persetujuan tindakan.",
            ],
            [
                'slug' => 'video-teknik-pernapasan-persalinan',
                'title' => 'Teknik Pernapasan Persalinan',
                'category' => 'video',
                'summary' => 'Panduan visual cara mengatur ritme napas saat menghadapi gelombang kontraksi.',
                'content' => 'Ikuti panduan video berikut bersama pasangan untuk melatih ritme pernapasan 4-4-6 sebelum hari persalinan tiba.',
                'video_url' => 'https://www.youtube.com/embed/j7YucfJuziU',
            ],
            [
                'slug' => 'video-latihan-relaksasi',
                'title' => 'Latihan Relaksasi',
                'category' => 'video',
                'summary' => 'Gerakan relaksasi dan peregangan lembut untuk meredakan kecemasan dan nyeri punggung.',
                'content' => 'Lakukan latihan relaksasi pernapasan dan peregangan panggul di tempat yang tenang setiap pagi atau sore hari.',
                'video_url' => 'https://www.youtube.com/embed/B87FpW1y5I8',
            ],
            [
                'slug' => 'video-persiapan-persalinan',
                'title' => 'Persiapan Persalinan',
                'category' => 'video',
                'summary' => 'Panduan visual menyiapkan tas bersalin dan perlengkapan esensial P4K.',
                'content' => 'Pastikan tas siaga bersalin sudah siap di minggu ke-36 kehamilan agar keluarga tidak panik saat tanda persalinan muncul.',
                'video_url' => 'https://www.youtube.com/embed/S-K0s_5yN48',
            ],
        ];

        foreach ($educations as $edu) {
            EducationContent::updateOrCreate(
                ['slug' => $edu['slug']],
                $edu
            );
        }
    }
}
