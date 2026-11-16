@extends('layouts.app')

@section('title', 'Checklist Kesiapan Persalinan - SiagaBunda')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-block px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-bold uppercase tracking-wider mb-1">
                7 Pilar Utama P4K
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Checklist Kesiapan Persalinan</h1>
            <p class="text-xs sm:text-sm text-slate-500">Pastikan setiap elemen rencana persalinan dan pencegahan komplikasi telah siap dan disepakati keluarga.</p>
        </div>
        <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 hover:underline">
            ← Kembali ke Halaman Awal
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Progress Card -->
    <div class="bg-gradient-to-r from-rose-500 via-pink-600 to-rose-600 rounded-3xl p-6 sm:p-8 text-white shadow-md flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2 text-center md:text-left">
            <h2 class="text-xl font-bold">Skor Kesiapan Persalinan Anda</h2>
            <p class="text-xs sm:text-sm text-rose-100 max-w-lg">
                @if($readiness === 100)
                    Luar biasa! Seluruh 7 pilar persiapan persalinan Anda telah lengkap dan siap menyambut kelahiran si kecil.
                @elseif($readiness >= 50)
                    Persiapan sudah berjalan dengan baik. Lengkapi sisa pilar agar rencana persalinan semakin matang dan aman.
                @else
                    Mari mulai mencicil kelengkapan pilar P4K satu per satu bersama suami dan keluarga.
                @endif
            </p>
            <div class="pt-2 text-xs font-semibold text-rose-100">
                Status: <span class="bg-white/20 px-2.5 py-1 rounded-full text-white">{{ $completedCount }} dari {{ $totalCount }} Siap Dikonfirmasi</span>
            </div>
        </div>

        <div class="bg-white/10 backdrop-blur rounded-2xl p-6 border border-white/20 text-center min-w-[200px]">
            <div class="text-5xl font-black">{{ $readiness }}%</div>
            <div class="w-36 bg-white/20 rounded-full h-2.5 mx-auto my-3 overflow-hidden">
                <div class="bg-white h-2.5 rounded-full transition-all duration-500" style="width: {{ $readiness }}%"></div>
            </div>
            <p class="text-[11px] text-rose-100 uppercase tracking-wider font-semibold">Tingkat Kesiapan</p>
        </div>
    </div>

    <!-- 7 Checklist Items List -->
    <div class="space-y-4">
        @foreach($checklists as $index => $item)
            <div class="bg-white rounded-3xl p-5 sm:p-6 border {{ $item->is_completed ? 'border-emerald-200 bg-emerald-50/20' : 'border-rose-100' }} shadow-sm transition" x-data="{ editingDetails: false }">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="flex items-start gap-3 sm:gap-4 flex-1">
                        <!-- Number Badge -->
                        <div class="w-8 h-8 rounded-xl {{ $item->is_completed ? 'bg-emerald-600 text-white' : 'bg-rose-100 text-rose-600' }} font-bold text-sm flex items-center justify-center flex-shrink-0 mt-0.5">
                            @if($item->is_completed)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>

                        <div class="space-y-1 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="text-base font-bold text-slate-900 {{ $item->is_completed ? 'text-emerald-950' : '' }}">
                                    {{ $item->title }}
                                </h3>
                                @if($item->is_completed)
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold uppercase">
                                        Sudah Siap
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold uppercase">
                                        Belum Lengkap
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $item->description }}</p>

                            <!-- Catatan Rincian User -->
                            @if($item->details && !$errors->has('details'))
                                <div class="mt-2 p-3 rounded-xl bg-slate-50 border border-slate-200 text-xs text-slate-700 flex items-start gap-2">
                                    <svg class="w-4 h-4 text-slate-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span class="italic"><strong class="not-italic text-slate-800">Rincian Persiapan:</strong> {{ $item->details }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2 self-end sm:self-start">
                        <button type="button" @click="editingDetails = !editingDetails" class="px-3 py-1.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-semibold transition">
                            <span x-text="editingDetails ? 'Tutup Form' : 'Catat Rincian'"></span>
                        </button>

                        <form method="POST" action="{{ route('patient.checklist.update', $item) }}">
                            @csrf
                            <input type="hidden" name="is_completed" value="{{ $item->is_completed ? 0 : 1 }}">
                            <button type="submit" class="px-4 py-1.5 rounded-xl text-xs font-bold transition shadow-sm {{ $item->is_completed ? 'bg-slate-200 text-slate-700 hover:bg-slate-300' : 'bg-rose-600 text-white hover:bg-rose-700' }}">
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
                        <textarea name="details" rows="2" class="w-full p-3 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none" placeholder="Misal: Nama RS rujukan, nama pendonor darah & no HP, jenis kendaraan siaga, atau berkas BPJS.">{{ old('details', $item->details) }}</textarea>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="editingDetails = false" class="px-3 py-1 text-xs text-slate-500 hover:text-slate-700">Batal</button>
                            <button type="submit" class="px-4 py-1.5 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800">Simpan Rincian</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
