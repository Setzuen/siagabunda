@extends('layouts.app')

@section('title', 'Agenda Kontrol ANC & Pengingat - RSIA SiagaBunda')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 space-y-8" x-data="{ currentFilter: 'all', showModal: false }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-100 text-teal-800 text-xs font-bold uppercase tracking-wider mb-1">
                Poliklinik KIA & Agenda Maternal
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Pengingat & Agenda Kehamilan</h1>
            <p class="text-xs sm:text-sm text-slate-500">Jadwal Antenatal Care (ANC), pengingat persiapan persalinan, dan peringatan tanda bahaya.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" @click="showModal = true" class="px-4 py-2.5 rounded-2xl bg-teal-800 text-white font-extrabold text-xs hover:bg-teal-900 shadow-sm transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>+ Daftarkan Agenda Baru</span>
            </button>
            <a href="{{ route('patient.dashboard') }}" class="px-3.5 py-2.5 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 text-xs font-bold">
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-teal-50 border border-teal-200 text-teal-900 text-xs font-bold flex items-center gap-2">
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Category Filter (Sesuai Sitemap) -->
    <div class="flex flex-wrap items-center gap-2">
        <button type="button" @click="currentFilter = 'all'" :class="currentFilter === 'all' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50'" class="px-4 py-2 rounded-2xl text-xs font-bold transition">
            Semua Agenda ({{ $schedules->count() }})
        </button>
        <button type="button" @click="currentFilter = 'anc'" :class="currentFilter === 'anc' ? 'bg-teal-800 text-white shadow-sm' : 'bg-white border border-teal-200 text-teal-800 hover:bg-teal-50'" class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-teal-400"></span>
            Jadwal Antenatal Care ({{ $schedules->where('type', 'anc')->count() }})
        </button>
        <button type="button" @click="currentFilter = 'persiapan'" :class="currentFilter === 'persiapan' ? 'bg-cyan-800 text-white shadow-sm' : 'bg-white border border-cyan-200 text-cyan-800 hover:bg-cyan-50'" class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
            Pengingat Persiapan ({{ $schedules->where('type', 'persiapan')->count() }})
        </button>
        <button type="button" @click="currentFilter = 'tanda_bahaya'" :class="currentFilter === 'tanda_bahaya' ? 'bg-red-600 text-white shadow-sm' : 'bg-white border border-red-200 text-red-700 hover:bg-red-50'" class="px-4 py-2 rounded-2xl text-xs font-bold transition flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-red-400"></span>
            Pengingat Tanda Bahaya ({{ $schedules->where('type', 'tanda_bahaya')->count() }})
        </button>
    </div>

    <!-- Schedules List -->
    <div class="space-y-3">
        @forelse($schedules as $item)
            <div x-show="currentFilter === 'all' || currentFilter === '{{ $item->type }}'" class="bg-white rounded-3xl p-5 sm:p-6 border {{ $item->status === 'completed' ? 'border-slate-200 opacity-60' : 'border-slate-200/80 shadow-sm' }} flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition hover:shadow-md">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0 text-xl {{ $item->type === 'anc' ? 'bg-teal-100 text-teal-800 border border-teal-200' : ($item->type === 'tanda_bahaya' ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-cyan-100 text-cyan-800 border border-cyan-200') }}">
                        @if($item->type === 'anc')
                            🩺
                        @elseif($item->type === 'tanda_bahaya')
                            ⚠️
                        @else
                            📋
                        @endif
                    </div>

                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $item->type === 'anc' ? 'bg-teal-100 text-teal-800 border border-teal-200' : ($item->type === 'tanda_bahaya' ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-cyan-100 text-cyan-800 border border-cyan-200') }}">
                                {{ $item->type === 'anc' ? 'Jadwal Antenatal Care' : ($item->type === 'tanda_bahaya' ? 'Pengingat Tanda Bahaya' : 'Pengingat Persiapan') }}
                            </span>
                            @if($item->status === 'completed')
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-200 text-slate-700">
                                    ✓ Selesai
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    ● Mendatang
                                </span>
                            @endif
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900 {{ $item->status === 'completed' ? 'line-through text-slate-400' : '' }}">{{ $item->title }}</h3>
                        <p class="text-xs text-slate-500 font-medium">{{ $item->description }}</p>
                        <div class="flex flex-wrap items-center gap-3 pt-1 text-xs text-slate-600">
                            <span class="flex items-center gap-1 font-bold text-teal-700">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $item->event_date->translatedFormat('l, d F Y - H:i') }} WIB
                            </span>
                            <span>•</span>
                            <span class="text-slate-500">📍 {{ $item->location }}</span>
                        </div>
                    </div>
                </div>

                <div class="self-end sm:self-center">
                    <form method="POST" action="{{ route('patient.reminders.toggle', $item) }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $item->status === 'completed' ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-teal-700 text-white hover:bg-teal-800 shadow-sm' }}">
                            {{ $item->status === 'completed' ? 'Aktifkan Kembali' : 'Tandai Selesai ✓' }}
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                <p class="text-xs text-slate-500">Belum ada agenda atau pengingat yang tersimpan.</p>
            </div>
        @endforelse
    </div>

    <!-- Modal Tambah Agenda Baru -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-4 shadow-2xl border border-slate-200" @click.away="showModal = false">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-sm sm:text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🗓️</span> Tambah Agenda Kontrol / Pengingat
                </h3>
                <button type="button" @click="showModal = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
            </div>

            <form method="POST" action="{{ route('patient.reminders.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Kategori Agenda (Sitemap)</label>
                    <select name="type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                        <option value="anc">Jadwal Antenatal Care (Poli KIA / ANC)</option>
                        <option value="persiapan">Pengingat Persiapan Persalinan</option>
                        <option value="tanda_bahaya">Pengingat Tanda Bahaya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Judul Agenda</label>
                    <input type="text" name="title" required placeholder="Contoh: USG Trimester 3 / Evaluasi HB Lab" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                </div>

                <div class="grid sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Tanggal & Waktu</label>
                        <input type="datetime-local" name="event_date" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Lokasi Pemeriksaan</label>
                        <input type="text" name="location" placeholder="Poli Kebidanan RSIA SiagaBunda" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Catatan Tambahan</label>
                    <textarea name="description" rows="2" placeholder="Misal: Bawa buku KIA, fotokopi KTP, dan hasil lab darah terakhir" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" @click="showModal = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-700">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-teal-800 text-white text-xs font-black hover:bg-teal-900 shadow-sm">Simpan Agenda</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection