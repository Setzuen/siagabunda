@extends('layouts.app')

@section('title', 'Halaman Awal - SiagaBunda')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 space-y-8">
    <!-- Welcome Header & Profile Card -->
    <div class="bg-gradient-to-r from-rose-500 via-rose-600 to-pink-600 rounded-3xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 backdrop-blur text-xs font-semibold uppercase tracking-wider">
                    Program P4K Digital
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ $user->name }}! 👋</h1>
                <p class="text-rose-100 text-sm max-w-xl">
                    Mari persiapkan persalinan Anda secara aman, terencana, dan nyaman bersama keluarga dan tenaga medis.
                </p>
                <div class="flex flex-wrap items-center gap-2 pt-2 text-xs font-medium">
                    <span class="px-3 py-1 rounded-lg bg-white/15">Usia Kehamilan: <strong class="text-white">{{ $profile?->gestationalWeeks() ?? '-' }} Minggu</strong></span>
                    <span class="px-3 py-1 rounded-lg bg-white/15">Taksiran Persalinan (HPL): <strong class="text-white">{{ $profile?->due_date ? $profile->due_date->translatedFormat('d F Y') : '-' }}</strong></span>
                    <span class="px-3 py-1 rounded-lg bg-white/15">Golongan Darah: <strong class="text-white">{{ $profile->blood_type ?? '-' }}</strong></span>
                    <span class="px-3 py-1 rounded-lg {{ ($profile->risk_level ?? 'rendah') === 'tinggi' ? 'bg-amber-400 text-amber-950 font-bold' : 'bg-emerald-400/25 text-white' }}">
                        Status Risiko: {{ ucfirst($profile->risk_level ?? 'Rendah') }}
                    </span>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur rounded-2xl p-5 border border-white/20 text-center min-w-[200px]">
                <p class="text-xs uppercase tracking-wider font-semibold text-rose-100">Kesiapan Persalinan</p>
                <div class="text-4xl font-extrabold my-1">{{ $readiness }}%</div>
                <div class="w-full bg-white/20 rounded-full h-2.5 overflow-hidden my-2">
                    <div class="bg-white h-2.5 rounded-full transition-all duration-500" style="width: {{ $readiness }}%"></div>
                </div>
                <p class="text-xs text-rose-100">{{ $completedCount }} dari {{ $totalCount }} Checklist Siap</p>
                <a href="{{ route('patient.checklist') }}" class="inline-block mt-3 px-4 py-1.5 rounded-xl bg-white text-rose-600 font-bold text-xs hover:bg-rose-50 transition">
                    Lengkapi Checklist →
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Navigation to Structure Modules -->
    <div>
        <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            Menu & Layanan P4K Digital
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            <a href="{{ route('patient.profile') }}" class="p-4 rounded-2xl bg-white border border-rose-100/70 hover:border-rose-300 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mx-auto group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 text-xs sm:text-sm">Profil Pengguna</h3>
                <p class="text-[11px] text-slate-500">Data kehamilan & HPHT</p>
            </a>

            <a href="{{ route('patient.education') }}" class="p-4 rounded-2xl bg-white border border-rose-100/70 hover:border-rose-300 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center mx-auto group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 text-xs sm:text-sm">Edukasi Persiapan</h3>
                <p class="text-[11px] text-slate-500">6 Topik panduan medis</p>
            </a>

            <a href="{{ route('patient.checklist') }}" class="p-4 rounded-2xl bg-white border border-rose-100/70 hover:border-rose-300 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 text-xs sm:text-sm">Checklist Kesiapan</h3>
                <p class="text-[11px] text-slate-500">7 pilar penting P4K</p>
            </a>

            <a href="{{ route('patient.education', ['category' => 'video']) }}" class="p-4 rounded-2xl bg-white border border-rose-100/70 hover:border-rose-300 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 text-xs sm:text-sm">Video Edukasi</h3>
                <p class="text-[11px] text-slate-500">Napas, relaksasi & tas</p>
            </a>

            <a href="{{ route('patient.reminders') }}" class="p-4 rounded-2xl bg-white border border-rose-100/70 hover:border-rose-300 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto group-hover:scale-110 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 text-xs sm:text-sm">Pengingat Agenda</h3>
                <p class="text-[11px] text-slate-500">ANC & jadwal kontrol</p>
            </a>

            <a href="{{ route('patient.emergency') }}" class="p-4 rounded-2xl bg-red-50 border border-red-200 hover:border-red-400 hover:shadow-md transition group text-center space-y-2">
                <div class="w-12 h-12 rounded-xl bg-red-600 text-white flex items-center justify-center mx-auto group-hover:scale-110 transition shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="font-bold text-red-700 text-xs sm:text-sm">Bantuan Darurat</h3>
                <p class="text-[11px] text-red-500 font-semibold">Tombol IGD & 119</p>
            </a>
        </div>
    </div>

    <!-- 2 Column Layout: Agenda & Tanda Bahaya -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Pengingat & Agenda Terdekat -->
        <div class="bg-white rounded-3xl p-6 border border-rose-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Agenda & Pengingat Terdekat</h3>
                    <p class="text-xs text-slate-500">Jadwal kontrol ANC dan persiapan penting</p>
                </div>
                <a href="{{ route('patient.reminders') }}" class="text-xs font-bold text-rose-600 hover:underline">
                    Kelola Semua →
                </a>
            </div>

            @if($upcomingSchedules->isEmpty())
                <div class="p-6 text-center rounded-2xl bg-slate-50 border border-dashed border-slate-200">
                    <p class="text-xs text-slate-500">Belum ada agenda pemeriksaan mendatang.</p>
                    <a href="{{ route('patient.reminders') }}" class="inline-block mt-2 text-xs font-bold text-rose-600 hover:underline">
                        + Tambah Jadwal ANC Baru
                    </a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($upcomingSchedules as $schedule)
                        <div class="p-4 rounded-2xl bg-rose-50/50 border border-rose-100 flex items-start justify-between gap-3">
                            <div class="space-y-1">
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $schedule->type === 'anc' ? 'bg-teal-100 text-teal-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $schedule->type === 'anc' ? 'Jadwal ANC' : 'Pengingat' }}
                                </span>
                                <h4 class="text-sm font-bold text-slate-900">{{ $schedule->title }}</h4>
                                <p class="text-xs text-slate-600">{{ $schedule->location }} • {{ $schedule->event_date->translatedFormat('l, d F Y - H:i') }} WIB</p>
                            </div>
                            <form method="POST" action="{{ route('patient.reminders.toggle', $schedule) }}">
                                @csrf
                                <button type="submit" class="text-xs px-2.5 py-1 rounded-lg border border-slate-300 text-slate-600 hover:bg-white transition" title="Tandai selesai">
                                    Selesai
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Tanda Bahaya Kehamilan Ringkas -->
        <div class="bg-red-50/70 rounded-3xl p-6 border border-red-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-600 animate-ping"></span>
                    <h3 class="font-bold text-red-900 text-base">Waspada Tanda Bahaya</h3>
                </div>
                <a href="{{ route('patient.emergency') }}" class="text-xs font-bold text-red-700 hover:underline">
                    Kontak Darurat →
                </a>
            </div>

            <p class="text-xs text-red-800 leading-relaxed">
                Segera hubungi faskes atau menuju IGD jika mengalami perdarahan, gerakan janin melemah, demam tinggi, kejang, atau sakit kepala hebat berulang!
            </p>

            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="p-3 rounded-xl bg-white border border-red-100 text-red-950 font-medium flex items-center gap-2">
                    <span class="text-red-600 font-bold">⚠️</span> Perdarahan Jalan Lahir
                </div>
                <div class="p-3 rounded-xl bg-white border border-red-100 text-red-950 font-medium flex items-center gap-2">
                    <span class="text-red-600 font-bold">⚠️</span> Ketuban Pecah Dini
                </div>
                <div class="p-3 rounded-xl bg-white border border-red-100 text-red-950 font-medium flex items-center gap-2">
                    <span class="text-red-600 font-bold">⚠️</span> Gerak Janin Menurun
                </div>
                <div class="p-3 rounded-xl bg-white border border-red-100 text-red-950 font-medium flex items-center gap-2">
                    <span class="text-red-600 font-bold">⚠️</span> Bengkak & Pandangan Kabur
                </div>
            </div>

            <div class="pt-2 flex gap-2">
                <a href="{{ route('patient.emergency') }}" class="w-full text-center py-2.5 rounded-xl bg-red-600 text-white font-bold text-xs hover:bg-red-700 shadow-sm transition">
                    🚨 Buka Bantuan Darurat IGD Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
