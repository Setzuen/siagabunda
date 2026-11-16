@extends('layouts.app')

@section('title', 'Monitoring Responden - Ruang Rumah Sakit / Bidan')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-block px-3 py-1 rounded-full bg-teal-100 text-teal-700 text-xs font-bold uppercase tracking-wider mb-1">
                Panel Bidan & Rumah Sakit
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Monitoring Responden Ibu Hamil</h1>
            <p class="text-xs sm:text-sm text-slate-500">Pantau kesiapan P4K digital, status risiko kehamilan, dan jadwal kontrol pasien.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('hospital.export.csv') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 shadow-sm transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Ekspor Rekap CSV
            </a>
            <a href="{{ route('hospital.education') }}" class="px-3.5 py-2.5 rounded-xl border border-teal-200 text-teal-700 bg-white hover:bg-teal-50 text-xs font-semibold transition">
                Kelola Edukasi
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Statistics Overview Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-3xl p-5 border border-teal-100 shadow-sm space-y-1">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Responden</p>
            <div class="text-3xl font-black text-slate-900">{{ $totalPatients }}</div>
            <p class="text-[11px] text-slate-500">Ibu hamil terdaftar</p>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-teal-100 shadow-sm space-y-1">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Rata-rata Kesiapan</p>
            <div class="text-3xl font-black text-teal-600">{{ $avgReadiness }}%</div>
            <p class="text-[11px] text-slate-500">Skor 7 pilar P4K</p>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-amber-200 bg-amber-50/30 shadow-sm space-y-1">
            <p class="text-xs font-semibold text-amber-700 uppercase tracking-wider">Risiko Tinggi</p>
            <div class="text-3xl font-black text-amber-600">{{ $highRiskCount }}</div>
            <p class="text-[11px] text-amber-800">Perlu atensi khusus</p>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-teal-100 shadow-sm space-y-1">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jadwal ANC Mendatang</p>
            <div class="text-3xl font-black text-indigo-600">{{ $upcomingAncCount }}</div>
            <p class="text-[11px] text-slate-500">Pemeriksaan terjadwal</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm">
        <form method="GET" action="{{ route('hospital.dashboard') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama ibu hamil atau email..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
            </div>
            <div class="w-full sm:w-48">
                <select name="risk" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                    <option value="">Semua Tingkat Risiko</option>
                    <option value="rendah" {{ $riskFilter === 'rendah' ? 'selected' : '' }}>Risiko Rendah</option>
                    <option value="sedang" {{ $riskFilter === 'sedang' ? 'selected' : '' }}>Risiko Sedang</option>
                    <option value="tinggi" {{ $riskFilter === 'tinggi' ? 'selected' : '' }}>Risiko Tinggi</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white font-bold text-xs hover:bg-slate-800 shadow-sm transition">
                Filter Data
            </button>
            @if($search || $riskFilter)
                <a href="{{ route('hospital.dashboard') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Patients Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase tracking-wider font-bold">
                        <th class="p-4">Ibu Hamil</th>
                        <th class="p-4">Usia Kandungan & HPL</th>
                        <th class="p-4">Faskes & Golda</th>
                        <th class="p-4">Kesiapan P4K</th>
                        <th class="p-4">Status Risiko</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($patients as $patient)
                        @php
                            $prof = $patient->pregnancyProfile;
                            $readiness = $patient->readinessPercentage();
                        @endphp
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $patient->name }}</div>
                                <div class="text-slate-400">{{ $patient->email }} • {{ $patient->phone ?: '-' }}</div>
                            </td>
                            <td class="p-4">
                                <span class="font-semibold text-slate-700">{{ $prof?->gestationalWeeks() ?? '-' }} Minggu</span>
                                <div class="text-slate-400">HPL: {{ $prof?->due_date ? $prof->due_date->translatedFormat('d M Y') : '-' }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-medium text-slate-800">{{ $prof->referral_hospital ?: '-' }}</div>
                                <div class="text-slate-400">Golongan: <span class="font-bold text-rose-600">{{ $prof->blood_type ?: '-' }}</span></div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-16 bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-teal-500 h-2 rounded-full" style="width: {{ $readiness }}%"></div>
                                    </div>
                                    <span class="font-bold text-slate-700">{{ $readiness }}%</span>
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    {{ $patient->checklists->where('is_completed', true)->count() }}/{{ $patient->checklists->count() }} Siap
                                </div>
                            </td>
                            <td class="p-4">
                                @if(($prof->risk_level ?? 'rendah') === 'tinggi')
                                    <span class="inline-block px-2.5 py-1 rounded-full bg-red-100 text-red-800 font-bold uppercase text-[10px]">
                                        Risiko Tinggi
                                    </span>
                                @elseif(($prof->risk_level ?? 'rendah') === 'sedang')
                                    <span class="inline-block px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-bold uppercase text-[10px]">
                                        Risiko Sedang
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold uppercase text-[10px]">
                                        Risiko Rendah
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('hospital.patients.show', $patient) }}" class="inline-block px-3 py-1.5 rounded-xl bg-teal-50 text-teal-700 hover:bg-teal-100 font-bold text-xs transition">
                                    Detail & Penilaian →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                Tidak ada data responden yang sesuai dengan pencarian atau filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
