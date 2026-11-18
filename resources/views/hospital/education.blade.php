@extends('layouts.app')

@section('title', 'Kelola Materi Edukasi Medis & Video - RSIA SiagaBunda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 space-y-8" x-data="{ showForm: false }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('hospital.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-700 hover:underline mb-1">
                ← Kembali ke Monitoring Responden
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Kelola Materi Edukasi & Video P4K</h1>
            <p class="text-xs sm:text-sm text-slate-500">Publikasikan panduan medis, teknik relaksasi, dan video pembelajaran untuk ibu hamil.</p>
        </div>
        <button type="button" @click="showForm = !showForm" class="px-5 py-2.5 rounded-2xl bg-teal-800 text-white font-extrabold text-xs hover:bg-teal-900 shadow-sm transition flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span x-text="showForm ? 'Tutup Formulir' : '+ Tambah Materi Medis Baru'"></span>
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-teal-50 border border-teal-200 text-teal-900 text-xs font-bold flex items-center gap-2">
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form Tambah Materi Baru -->
    <div x-show="showForm" x-cloak class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-lg space-y-4">
        <h3 class="font-extrabold text-slate-900 text-sm border-b border-slate-100 pb-2 flex items-center gap-2">
            <span>📝</span> Publikasi Materi Klinis atau Video Peraga Baru
        </h3>
        <form method="POST" action="{{ route('hospital.education.store') }}" class="space-y-4 text-xs">
            @csrf
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul Materi / Video</label>
                    <input type="text" name="title" required placeholder="Contoh: Senam Hamil & Relaksasi Trimester 3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori (Sitemap P4K)</label>
                    <select name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="tanda_awal">Tanda Awal Persalinan</option>
                        <option value="tanda_bahaya">Tanda Bahaya Kehamilan dan Persalinan</option>
                        <option value="fisik">Persiapan Fisik</option>
                        <option value="psikologis">Persiapan Psikologis</option>
                        <option value="pernapasan">Teknik Pernapasan dan Relaksasi</option>
                        <option value="persalinan">Persiapan Persalinan Normal dan Operasi Sesar</option>
                        <option value="video">Video Edukasi</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Ringkasan Singkat (Summary)</label>
                <input type="text" name="summary" required placeholder="Penjelasan singkat 1-2 kalimat untuk kartu preview" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">URL Video YouTube Embed (Khusus Kategori Video)</label>
                <input type="url" name="video_url" placeholder="https://www.youtube.com/embed/..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Isi Panduan Medis Lengkap</label>
                <textarea name="content" rows="4" required placeholder="Tuliskan materi panduan lengkap..." class="w-full p-4 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none"></textarea>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" @click="showForm = false" class="px-4 py-2 font-bold text-slate-500 hover:text-slate-700">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-teal-800 text-white font-extrabold hover:bg-teal-900 shadow-sm transition">
                    Publikasikan ke Portal Pasien
                </button>
            </div>
        </form>
    </div>

    <!-- Daftar Semua Konten -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-extrabold text-slate-900 text-sm flex items-center gap-2">
                <span>📚</span> Daftar Materi Medis yang Telah Dipublikasikan ({{ $contents->count() }})
            </h3>
        </div>

        <div class="divide-y divide-slate-100">
            @foreach($contents as $item)
                <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50 transition text-xs">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider {{ $item->category === 'video' ? 'bg-cyan-100 text-cyan-800' : ($item->category === 'tanda_bahaya' ? 'bg-red-100 text-red-800' : 'bg-teal-100 text-teal-800') }}">
                                {{ str_replace('_', ' ', strtoupper($item->category)) }}
                            </span>
                            <h4 class="font-bold text-slate-900 text-sm">{{ $item->title }}</h4>
                        </div>
                        <p class="text-slate-500">{{ $item->summary }}</p>
                        @if($item->video_url)
                            <a href="{{ $item->video_url }}" target="_blank" class="text-teal-700 font-bold inline-flex items-center gap-1 hover:underline">
                                <span>▶ Video: {{ $item->video_url }}</span>
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 self-end sm:self-center">
                        <form method="POST" action="{{ route('hospital.education.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-red-50 text-red-700 hover:bg-red-100 font-bold transition border border-red-200">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection