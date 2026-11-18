@extends('layouts.app')

@section('title', 'Dashboard Pasien Maternal - RSIA SiagaBunda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 space-y-8">
    <!-- Patient Medical Chart Summary Banner (E-KMS Digital) -->
    <div class="bg-gradient-to-r from-teal-700 via-teal-800 to-cyan-900 rounded-3xl p-6 sm:p-8 text-white shadow-xl relative overflow-hidden border border-teal-600/40">
        <!-- Medical Cross Silhouette Decor -->
        <div class="absolute -right-6 -bottom-6 w-56 h-56 text-white/5 font-black text-9xl pointer-events-none select-none">
            ✚
        </div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-600/60 backdrop-blur text-xs font-bold uppercase tracking-wider text-teal-100 border border-teal-500/40">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-300"></span>
                        Rekam Medis Maternal #SB-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                    </span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold {{ ($profile->risk_level ?? 'rendah') === 'tinggi' ? 'bg-amber-400 text-amber-950 font-black' : 'bg-emerald-400/20 text-emerald-200 border border-emerald-400/40' }}">
                        <span class="w-2 h-2 rounded-full {{ ($profile->risk_level ?? 'rendah') === 'tinggi' ? 'bg-amber-800' : 'bg-emerald-400' }} animate-pulse"></span>
                        Status Risiko: {{ ucfirst($profile->risk_level ?? 'Rendah') }}
                    </span>
                </div>

                <div>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">Selamat Datang, {{ $user->name }} 👋</h1>
                    <p class="text-teal-100 text-xs sm:text-sm max-w-xl leading-relaxed mt-1">
                        Portal pemantauan kehamilan dan 7 pilar kesiapan persalinan P4K terintegrasi dengan tim medis RSIA SiagaBunda.
                    </p>
                </div>

                <!-- Vital Clinical Stats Pill Strip -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 pt-2 text-xs">
                    <div class="p-2.5 rounded-2xl bg-white/10 backdrop-blur border border-white/10 space-y-0.5">
                        <span class="text-[10px] uppercase font-bold text-teal-200">Usia Gestasi</span>
                        <div class="text-sm font-black text-white">{{ $profile?->gestationalWeeks() ?? '-' }} Minggu</div>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-white/10 backdrop-blur border border-white/10 space-y-0.5">
                        <span class="text-[10px] uppercase font-bold text-teal-200">Taksiran Persalinan</span>
                        <div class="text-xs font-bold text-white truncate">{{ $profile?->due_date ? $profile->due_date->translatedFormat('d M Y') : '-' }}</div>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-white/10 backdrop-blur border border-white/10 space-y-0.5">
                        <span class="text-[10px] uppercase font-bold text-teal-200">Golongan Darah</span>
                        <div class="text-sm font-black text-rose-300">{{ $profile->blood_type ?? '-' }}</div>
                    </div>

                    <div class="p-2.5 rounded-2xl bg-white/10 backdrop-blur border border-white/10 space-y-0.5">
                        <span class="text-[10px] uppercase font-bold text-teal-200">Faskes Rujukan</span>
                        <div class="text-xs font-bold text-white truncate">{{ $profile->referral_hospital ?? 'RSIA SiagaBunda' }}</div>
                    </div>
                </div>
            </div>

            <!-- Readiness Score Radial / Gauge Box -->
            <div class="bg-white/10 backdrop-blur rounded-3xl p-6 border border-white/20 text-center min-w-[220px] flex flex-col justify-between space-y-3">
                <span class="text-[11px] uppercase tracking-wider font-extrabold text-teal-200">Kesiapan Persalinan</span>
                <div>
                    <div class="text-5xl font-black tracking-tight text-white">{{ $readiness }}%</div>
                    <div class="w-full bg-white/20 rounded-full h-2.5 overflow-hidden my-2">
                        <div class="bg-gradient-to-r from-emerald-400 to-teal-300 h-2.5 rounded-full transition-all duration-700" style="width: {{ $readiness }}%"></div>
                    </div>
                    <p class="text-xs text-teal-100 font-medium">{{ $completedCount }} dari {{ $totalCount }} Checklist Terverifikasi</p>
                </div>
                <a href="{{ route('patient.checklist') }}" class="inline-block w-full py-2 rounded-xl bg-white text-teal-900 font-extrabold text-xs hover:bg-teal-50 transition shadow-sm">
                    Periksa 7 Pilar P4K →
                </a>
            </div>
        </div>
    </div>

    <!-- Hospital Department Services Navigation (Sitemap Links) -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base sm:text-lg font-extrabold text-slate-900 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-teal-600"></span>
                Layanan & Navigasi Maternal Terpadu
            </h2>
            <span class="text-xs text-slate-500 font-semibold hidden sm:inline">Standar Pelayanan Kebidanan Kemenkes RI</span>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            <!-- 1. Profil Pengguna -->
            <a href="{{ route('patient.profile') }}" class="p-4 rounded-3xl bg-white border border-slate-200/80 hover:border-teal-400 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center mx-auto text-xl group-hover:scale-110 transition border border-teal-100">
                    👤
                </div>
                <h3 class="font-extrabold text-slate-900 text-xs sm:text-sm">Profil Pengguna</h3>
                <p class="text-[11px] text-slate-500">HPHT, HPL & Data Medis</p>
            </a>

            <!-- 2. Edukasi Persiapan -->
            <a href="{{ route('patient.education') }}" class="p-4 rounded-3xl bg-white border border-slate-200/80 hover:border-teal-400 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-700 flex items-center justify-center mx-auto text-xl group-hover:scale-110 transition border border-cyan-100">
                    📖
                </div>
                <h3 class="font-extrabold text-slate-900 text-xs sm:text-sm">Edukasi Persiapan</h3>
                <p class="text-[11px] text-slate-500">6 Modul Panduan Klinis</p>
            </a>

            <!-- 3. Checklist Kesiapan -->
            <a href="{{ route('patient.checklist') }}" class="p-4 rounded-3xl bg-white border border-slate-200/80 hover:border-teal-400 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center mx-auto text-xl group-hover:scale-110 transition border border-emerald-100">
                    ✅
                </div>
                <h3 class="font-extrabold text-slate-900 text-xs sm:text-sm">Checklist Kesiapan</h3>
                <p class="text-[11px] text-slate-500">7 Pilar P4K Terencana</p>
            </a>

            <!-- 4. Video Edukasi -->
            <a href="{{ route('patient.education', ['category' => 'video']) }}" class="p-4 rounded-3xl bg-white border border-slate-200/80 hover:border-teal-400 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center mx-auto text-xl group-hover:scale-110 transition border border-indigo-100">
                    ▶️
                </div>
                <h3 class="font-extrabold text-slate-900 text-xs sm:text-sm">Video Edukasi</h3>
                <p class="text-[11px] text-slate-500">Napas, Senam & Tas Siaga</p>
            </a>

            <!-- 5. Pengingat & Agenda -->
            <a href="{{ route('patient.reminders') }}" class="p-4 rounded-3xl bg-white border border-slate-200/80 hover:border-teal-400 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center mx-auto text-xl group-hover:scale-110 transition border border-amber-100">
                    🗓️
                </div>
                <h3 class="font-extrabold text-slate-900 text-xs sm:text-sm">Pengingat Agenda</h3>
                <p class="text-[11px] text-slate-500">Jadwal Kontrol ANC</p>
            </a>

            <!-- 6. Bantuan & Darurat IGD -->
            <a href="{{ route('patient.emergency') }}" class="p-4 rounded-3xl bg-gradient-to-br from-red-50 to-rose-50 border border-red-200 hover:border-red-400 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-red-600 text-white flex items-center justify-center mx-auto text-xl group-hover:scale-110 transition shadow-sm">
                    🚨
                </div>
                <h3 class="font-extrabold text-red-900 text-xs sm:text-sm">Bantuan Darurat</h3>
                <p class="text-[11px] text-red-600 font-bold">Hotline IGD 119</p>
            </a>
        </div>
    </div>

    <!-- 2 Column Clinical Grid: Agenda & Tanda Bahaya -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Agenda & Pengingat Terdekat (Poli KIA) -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-xs">🩺</span>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-sm">Agenda Kontrol & Pemeriksaan ANC</h3>
                        <p class="text-[11px] text-slate-500">Jadwal pemeriksaan poliklinik kebidanan</p>
                    </div>
                </div>
                <a href="{{ route('patient.reminders') }}" class="text-xs font-bold text-teal-700 hover:underline">
                    Kelola Agenda →
                </a>
            </div>

            @if($upcomingSchedules->isEmpty())
                <div class="p-8 text-center rounded-2xl bg-slate-50 border border-dashed border-slate-200">
                    <p class="text-xs text-slate-500">Belum ada agenda pemeriksaan mendatang.</p>
                    <a href="{{ route('patient.reminders') }}" class="inline-block mt-2 text-xs font-bold text-teal-700 hover:underline">
                        + Daftarkan Jadwal ANC Baru
                    </a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($upcomingSchedules as $schedule)
                        <div class="p-4 rounded-2xl bg-slate-50/70 border border-slate-200/80 flex items-start justify-between gap-3 hover:bg-slate-50 transition">
                            <div class="space-y-1">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $schedule->type === 'anc' ? 'bg-teal-100 text-teal-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $schedule->type === 'anc' ? 'Poli KIA (ANC)' : 'Pengingat Mandiri' }}
                                </span>
                                <h4 class="text-sm font-bold text-slate-900">{{ $schedule->title }}</h4>
                                <p class="text-xs text-slate-600 font-medium">📍 {{ $schedule->location }} • 🕒 {{ $schedule->event_date->translatedFormat('l, d F Y - H:i') }} WIB</p>
                            </div>
                            <form method="POST" action="{{ route('patient.reminders.toggle', $schedule) }}">
                                @csrf
                                <button type="submit" class="text-xs px-3 py-1.5 rounded-xl border border-slate-300 text-slate-600 hover:bg-white transition" title="Tandai selesai">
                                    Selesai
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Tanda Bahaya Kehamilan & Protokol IGD -->
        <div class="bg-gradient-to-br from-red-50/80 to-rose-50/80 rounded-3xl p-6 border border-red-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-red-200/60 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-xl bg-red-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">🚨</span>
                    <div>
                        <h3 class="font-extrabold text-red-950 text-sm">Protokol Siaga Tanda Bahaya Maternal</h3>
                        <p class="text-[11px] text-red-700">Penanganan segera di IGD PONEK 24 Jam</p>
                    </div>
                </div>
                <a href="{{ route('patient.emergency') }}" class="text-xs font-bold text-red-700 hover:underline">
                    Kontak Cepat →
                </a>
            </div>

            <p class="text-xs text-red-900 leading-relaxed font-medium">
                Segera tuju IGD RSIA SiagaBunda atau fasilitas rujukan terdekat jika muncul salah satu tanda kegawatdaruratan kebidanan berikut:
            </p>

            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="p-3 rounded-2xl bg-white/90 border border-red-200/80 text-red-950 font-bold flex items-center gap-2">
                    <span class="text-red-600">⚠️</span> Perdarahan Jalan Lahir
                </div>
                <div class="p-3 rounded-2xl bg-white/90 border border-red-200/80 text-red-950 font-bold flex items-center gap-2">
                    <span class="text-red-600">⚠️</span> Ketuban Pecah Dini
                </div>
                <div class="p-3 rounded-2xl bg-white/90 border border-red-200/80 text-red-950 font-bold flex items-center gap-2">
                    <span class="text-red-600">⚠️</span> Gerak Janin Menurun
                </div>
                <div class="p-3 rounded-2xl bg-white/90 border border-red-200/80 text-red-950 font-bold flex items-center gap-2">
                    <span class="text-red-600">⚠️</span> Kejang / Pusing Hebat
                </div>
            </div>

            <div class="pt-2">
                <a href="{{ route('patient.emergency') }}" class="w-full text-center py-3 rounded-2xl bg-red-600 text-white font-extrabold text-xs hover:bg-red-700 shadow-md shadow-red-500/20 transition flex items-center justify-center gap-2">
                    <span>🚑</span> Buka Akses Bantuan Darurat IGD Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection