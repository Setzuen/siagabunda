@extends('layouts.app')

@section('title', 'Verifikasi 7 Pilar Kesiapan Persalinan - RSIA SiagaBunda')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-100 text-teal-800 text-xs font-bold uppercase tracking-wider mb-1">
                Standar Kemenkes RI • 7 Pilar Maternal
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Checklist Kesiapan Persalinan (P4K)</h1>
            <p class="text-xs sm:text-sm text-slate-500">Pastikan setiap elemen rencana persalinan dan pencegahan komplikasi terverifikasi bersama keluarga dan tim medis.</p>
        </div>
        <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-700 hover:underline">
            ← Kembali ke Dashboard Pasien
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-teal-50 border border-teal-200 text-teal-900 text-xs font-bold flex items-center gap-2">
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Clinical Verification Progress Card -->
    <div class="bg-gradient-to-r from-teal-700 via-teal-800 to-cyan-900 rounded-3xl p-6 sm:p-8 text-white shadow-lg flex flex-col md:flex-row items-center justify-between gap-6 border border-teal-600/40">
        <div class="space-y-2 text-center md:text-left">
            <div class="flex items-center justify-center md:justify-start gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs uppercase font-extrabold tracking-wider text-teal-200">Indikator Kesiapan Klinis</span>
            </div>
            <h2 class="text-xl sm:text-2xl font-black">Status Kesiapan Persalinan</h2>
            <p class="text-xs sm:text-sm text-teal-100 max-w-lg leading-relaxed">
                @if($readiness === 100)
                    Luar biasa! Seluruh 7 pilar persiapan persalinan Anda telah lengkap dan terverifikasi siap menyambut persalinan aman.
                @elseif($readiness >= 50)
                    Persiapan persalinan berjalan dengan baik. Lengkapi pilar yang belum terverifikasi agar tindakan tanggap darurat semakin matang.
                @else
                    Mari mulai melengkapi rincian 7 pilar P4K satu per satu bersama suami dan konsultasikan dengan bidan saat kontrol.
                @endif
            </p>
            <div class="pt-2 text-xs font-semibold text-teal-200">
                Verifikasi: <span class="bg-white/20 px-3 py-1 rounded-full text-white font-bold">{{ $completedCount }} dari {{ $totalCount }} Pilar Siap</span>
            </div>
        </div>

        <div class="bg-white/10 backdrop-blur rounded-3xl p-6 border border-white/20 text-center min-w-[220px]">
            <div class="text-5xl font-black text-white tracking-tight">{{ $readiness }}%</div>
            <div class="w-36 bg-white/20 rounded-full h-2.5 mx-auto my-3 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-400 to-teal-300 h-2.5 rounded-full transition-all duration-700" style="width: {{ $readiness }}%"></div>
            </div>
            <p class="text-[11px] text-teal-200 uppercase tracking-wider font-extrabold">Skor Kesiapan Maternal</p>
        </div>
    </div>

    <!-- 7 Checklist Items List -->
    <div class="space-y-4">
        @foreach($checklists as $index => $item)
            <div class="bg-white rounded-3xl p-5 sm:p-6 border {{ $item->is_completed ? 'border-teal-200 bg-teal-50/20' : 'border-slate-200/80' }} shadow-sm transition hover:shadow-md" x-data="{ editingDetails: false }">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="flex items-start gap-3 sm:gap-4 flex-1">
                        <!-- Number Badge -->
                        <div class="w-9 h-9 rounded-2xl {{ $item->is_completed ? 'bg-teal-600 text-white' : 'bg-slate-100 text-slate-600' }} font-black text-sm flex items-center justify-center flex-shrink-0 mt-0.5 border {{ $item->is_completed ? 'border-teal-500' : 'border-slate-200' }}">
                            @if($item->is_completed)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>

                        <div class="space-y-1 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-sm sm:text-base font-extrabold text-slate-900 {{ $item->is_completed ? 'text-teal-950' : '' }}">
                                    {{ $item->title }}
                                </h3>
                                @if($item->is_completed)
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase border border-emerald-200">
                                        ✓ Terverifikasi Siap
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold uppercase border border-amber-200">
                                        ● Belum Lengkap
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $item->description }}</p>

                            <!-- Catatan Rincian User -->
                            @if($item->details && !$errors->has('details'))
                                <div class="mt-2 p-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 flex items-start gap-2">
                                    <span class="text-teal-600 font-bold mt-0.5">📋</span>
                                    <span class="italic"><strong class="not-italic text-slate-900 font-bold">Rincian Persiapan Pasien:</strong> {{ $item->details }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2 self-end sm:self-start">
                        <button type="button" @click="editingDetails = !editingDetails" class="px-3.5 py-2 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50 text-xs font-bold transition">
                            <span x-text="editingDetails ? 'Tutup Catatan' : 'Catat Rincian'"></span>
                        </button>

                        <form method="POST" action="{{ route('patient.checklist.update', $item) }}">
                            @csrf
                            <input type="hidden" name="is_completed" value="{{ $item->is_completed ? 0 : 1 }}">
                            <button type="submit" class="px-4 py-2 rounded-xl text-xs font-extrabold transition shadow-sm {{ $item->is_completed ? 'bg-slate-200 text-slate-700 hover:bg-slate-300' : 'bg-teal-700 text-white hover:bg-teal-800' }}">
                                {{ $item->is_completed ? 'Batalkan Siap' : 'Tandai Siap ✓' }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Expanded Details Form -->
                <div x-show="editingDetails" x-cloak class="mt-4 pt-4 border-t border-slate-100">
                    <form method="POST" action="{{ route('patient.checklist.update', $item) }}" class="space-y-2">
                        @csrf
                        <label class="block text-xs font-bold text-slate-700">Tulis Rincian Kesiapan Pilar Ini:</label>
                        <textarea name="details" rows="2" class="w-full p-3 rounded-2xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none" placeholder="Misal: Nama RS rujukan, no kontak darurat calon pendonor darah, jenis mobil siaga, atau nomor kepesertaan BPJS Kesehatan.">{{ old('details', $item->details) }}</textarea>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="editingDetails = false" class="px-3 py-1 text-xs font-semibold text-slate-500 hover:text-slate-700">Batal</button>
                            <button type="submit" class="px-4 py-1.5 rounded-xl bg-teal-800 text-white text-xs font-bold hover:bg-teal-900">Simpan Rincian</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection