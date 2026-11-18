@extends('layouts.app')

@section('title', 'Nurse Station & Pemantauan Responden - RSIA SiagaBunda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 space-y-8">
    <!-- Clinical Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-100 text-teal-800 text-xs font-bold uppercase tracking-wider border border-teal-200">
                    <span class="w-2 h-2 rounded-full bg-teal-600"></span>
                    Nurse Station & Poli Kebidanan
                </span>
                <span class="text-xs text-slate-400">• Standar Pelayanan P4K</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Monitoring Pasien & Responden Maternal</h1>
            <p class="text-xs sm:text-sm text-slate-500">Evaluasi penapisan risiko klinis, skor kesiapan persalinan 7 pilar, dan jadwal ANC pasien terintegrasi.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('hospital.export.csv') }}" class="px-4 py-2.5 rounded-2xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>Unduh Rekap CSV (Excel)</span>
            </a>
            <a href="{{ route('hospital.education') }}" class="px-4 py-2.5 rounded-2xl border border-slate-200 text-teal-800 bg-white hover:bg-teal-50 font-bold text-xs transition flex items-center gap-1.5">
                <span>📚</span> Kelola Edukasi Medis
            </a>
        </div>
    </div>

    <!-- Clinical Monitoring Vitals Counters -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm space-y-1">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Total Responden</p>
                <span class="text-base">👩‍⚕️</span>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ $totalPatients }}</div>
            <p class="text-[11px] text-teal-700 font-semibold">Ibu Hamil Terdaftar</p>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm space-y-1">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Rata-Rata Kesiapan P4K</p>
                <span class="text-base">📈</span>
            </div>
            <div class="text-3xl font-black text-teal-600">{{ $avgReadiness }}%</div>
            <p class="text-[11px] text-slate-500 font-medium">Verifikasi 7 Pilar Maternal</p>
        </div>

        <div class="bg-white rounded-3xl p-5 border {{ $highRiskCount > 0 ? 'border-amber-300 bg-amber-50/20' : 'border-slate-200/80' }} shadow-sm space-y-1">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-extrabold text-amber-700 uppercase tracking-wider">Perhatian Khusus (Risiko Tinggi)</p>
                <span class="text-base">⚠️</span>
            </div>
            <div class="text-3xl font-black text-amber-600">{{ $highRiskCount }}</div>
            <p class="text-[11px] text-amber-800 font-semibold">Perlu Monitoring Intensif</p>
        </div>

        <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm space-y-1">
            <div class="flex items-center justify-between">
                <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Pemeriksaan ANC Mendatang</p>
                <span class="text-base">🩺</span>
            </div>
            <div class="text-3xl font-black text-indigo-600">{{ $upcomingAncCount }}</div>
            <p class="text-[11px] text-slate-500 font-medium">Kunjungan Terjadwal</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-sm">
        <form method="GET" action="{{ route('hospital.dashboard') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama ibu hamil, email, atau no WhatsApp..." class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
            </div>
            <div class="w-full sm:w-56">
                <select name="risk" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                    <option value="">Semua Tingkat Risiko</option>
                    <option value="rendah" {{ $riskFilter === 'rendah' ? 'selected' : '' }}>Risiko Rendah (Normal)</option>
                    <option value="sedang" {{ $riskFilter === 'sedang' ? 'selected' : '' }}>Risiko Sedang</option>
                    <option value="tinggi" {{ $riskFilter === 'tinggi' ? 'selected' : '' }}>Risiko Tinggi (Waspada)</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 rounded-2xl bg-teal-800 text-white font-bold text-xs hover:bg-teal-900 shadow-sm transition">
                Filter Data
            </button>
            @if($search || $riskFilter)
                <a href="{{ route('hospital.dashboard') }}" class="px-4 py-2.5 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold text-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Patients Clinical Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                <span>📋</span> Daftar Rekam Responden Ibu Hamil ({{ $patients->count() }})
            </h3>
            <span class="text-[11px] text-slate-400">Diperbarui secara real-time</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-extrabold text-[10px]">
                        <th class="p-4">Identitas Ibu Hamil</th>
                        <th class="p-4">Usia Kandungan & HPL</th>
                        <th class="p-4">Faskes & Golda</th>
                        <th class="p-4">Kesiapan 7 Pilar P4K</th>
                        <th class="p-4">Status Risiko Klinis</th>
                        <th class="p-4 text-right">Tindakan Medis</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($patients as $patient)
                        @php
                            $prof = $patient->pregnancyProfile;
                            $readiness = $patient->readinessPercentage();
                        @endphp
                        <tr class="hover:bg-teal-50/30 transition">
                            <td class="p-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $patient->name }}</div>
                                <div class="text-slate-400 text-[11px]">{{ $patient->email }} • WA: {{ $patient->phone ?: '-' }}</div>
                            </td>
                            <td class="p-4">
                                <span class="font-bold text-slate-800">{{ $prof?->gestationalWeeks() ?? '-' }} Minggu</span>
                                <div class="text-slate-400 text-[11px]">HPL: {{ $prof?->due_date ? $prof->due_date->translatedFormat('d M Y') : '-' }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-medium text-slate-800">{{ $prof->referral_hospital ?: '-' }}</div>
                                <div class="text-slate-400 text-[11px]">Golongan: <span class="font-black text-rose-600">{{ $prof->blood_type ?: '-' }}</span> ({{ $prof->gravida_para ?? 'G1P0' }})</div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-16 bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-teal-600 h-2 rounded-full" style="width: {{ $readiness }}%"></div>
                                    </div>
                                    <span class="font-black text-slate-800">{{ $readiness }}%</span>
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5">
                                    {{ $patient->checklists->where('is_completed', true)->count() }} dari {{ $patient->checklists->count() }} Siap
                                </div>
                            </td>
                            <td class="p-4">
                                @if(($prof->risk_level ?? 'rendah') === 'tinggi')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-100 text-red-800 font-extrabold uppercase text-[10px] border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-ping"></span>
                                        Risiko Tinggi
                                    </span>
                                @elseif(($prof->risk_level ?? 'rendah') === 'sedang')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-bold uppercase text-[10px] border border-amber-200">
                                        Risiko Sedang
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold uppercase text-[10px] border border-emerald-200">
                                        Normal (Rendah)
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <a href="{{ route('hospital.patients.show', $patient) }}" class="inline-block px-3.5 py-1.5 rounded-xl bg-teal-50 text-teal-800 hover:bg-teal-100 font-bold text-xs transition border border-teal-200">
                                    Detail & Evaluasi →
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