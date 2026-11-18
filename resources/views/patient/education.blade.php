@extends('layouts.app')

@section('title', 'Edukasi Medis & Video Persalinan - RSIA SiagaBunda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 space-y-8" x-data="{ activeTab: '{{ request('category') === 'video' ? 'video' : 'materi' }}' }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-100 text-teal-800 text-xs font-bold uppercase tracking-wider mb-1">
                Pusat Edukasi Maternal RSIA
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Edukasi & Video Persiapan Persalinan</h1>
            <p class="text-xs sm:text-sm text-slate-500">Materi panduan klinis P4K, tanda bahaya persalinan, simulasi napas 4-4-6, dan video peraga.</p>
        </div>
        <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-700 hover:underline">
            ← Kembali ke Dashboard Pasien
        </a>
    </div>

    <!-- Navigation Tabs (Materi vs Video) -->
    <div class="flex border-b border-slate-200 gap-4">
        <button @click="activeTab = 'materi'" :class="activeTab === 'materi' ? 'border-teal-700 text-teal-800 font-black border-b-2' : 'text-slate-500 hover:text-slate-800 font-semibold'" class="pb-3 text-xs sm:text-sm flex items-center gap-2 transition">
            <span>📖</span>
            Edukasi Persiapan Persalinan (6 Modul)
        </button>
        <button @click="activeTab = 'video'" :class="activeTab === 'video' ? 'border-teal-700 text-teal-800 font-black border-b-2' : 'text-slate-500 hover:text-slate-800 font-semibold'" class="pb-3 text-xs sm:text-sm flex items-center gap-2 transition">
            <span>▶️</span>
            Video Edukasi (3 Video Peraga)
        </button>
    </div>

    <!-- TAB 1: EDUKASI PERSIAPAN PERSALINAN -->
    <div x-show="activeTab === 'materi'" class="space-y-6">
        <!-- Interactive Category Quick Filter -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('patient.education', ['category' => 'all']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold {{ $category === 'all' ? 'bg-teal-800 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                Semua Topik
            </a>
            <a href="{{ route('patient.education', ['category' => 'tanda_awal']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold {{ $category === 'tanda_awal' ? 'bg-teal-800 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                Tanda Awal Persalinan
            </a>
            <a href="{{ route('patient.education', ['category' => 'tanda_bahaya']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold {{ $category === 'tanda_bahaya' ? 'bg-red-600 text-white shadow-sm' : 'bg-white border border-red-200 text-red-600 hover:bg-red-50' }}">
                ⚠️ Tanda Bahaya Kehamilan & Persalinan
            </a>
            <a href="{{ route('patient.education', ['category' => 'fisik']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold {{ $category === 'fisik' ? 'bg-teal-800 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                Persiapan Fisik
            </a>
            <a href="{{ route('patient.education', ['category' => 'psikologis']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold {{ $category === 'psikologis' ? 'bg-teal-800 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                Persiapan Psikologis
            </a>
            <a href="{{ route('patient.education', ['category' => 'pernapasan']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold {{ $category === 'pernapasan' ? 'bg-teal-800 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                Teknik Pernapasan & Relaksasi
            </a>
            <a href="{{ route('patient.education', ['category' => 'persalinan']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold {{ $category === 'persalinan' ? 'bg-teal-800 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                Normal & Operasi Sesar
            </a>
        </div>

        <!-- Interactive Breathing Exercise Widget (4-4-6 Method) -->
        <div class="bg-gradient-to-r from-teal-800 via-teal-700 to-cyan-900 rounded-3xl p-6 sm:p-8 text-white shadow-lg flex flex-col md:flex-row items-center justify-between gap-6 border border-teal-600/40" x-data="{
            running: false,
            phase: 'Siap',
            count: 4,
            timer: null,
            start() {
                this.running = true;
                this.inhale();
            },
            stop() {
                this.running = false;
                clearInterval(this.timer);
                this.phase = 'Siap';
                this.count = 4;
            },
            inhale() {
                this.phase = 'Tarik Napas (Hidung)';
                this.count = 4;
                let c = 4;
                this.timer = setInterval(() => {
                    c--;
                    this.count = c;
                    if(c <= 0) {
                        clearInterval(this.timer);
                        this.hold();
                    }
                }, 1000);
            },
            hold() {
                this.phase = 'Tahan Sebentar';
                this.count = 4;
                let c = 4;
                this.timer = setInterval(() => {
                    c--;
                    this.count = c;
                    if(c <= 0) {
                        clearInterval(this.timer);
                        this.exhale();
                    }
                }, 1000);
            },
            exhale() {
                this.phase = 'Hembuskan Perlahan (Mulut)';
                this.count = 6;
                let c = 6;
                this.timer = setInterval(() => {
                    c--;
                    this.count = c;
                    if(c <= 0) {
                        clearInterval(this.timer);
                        this.inhale();
                    }
                }, 1000);
            }
        }">
            <div class="space-y-1.5">
                <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-[10px] font-black uppercase tracking-wider text-teal-100">
                    Simulasi Klinis Relaksasi
                </span>
                <h3 class="text-xl sm:text-2xl font-black">Latihan Ritme Pernapasan 4-4-6</h3>
                <p class="text-xs text-teal-100 max-w-lg leading-relaxed">
                    Panduan ritme napas dalam medis untuk meredakan nyeri kontraksi persalinan dan menjaga pasokan oksigen janin. Tarik napas 4 detik, tahan 4 detik, lalu hembuskan perlahan 6 detik.
                </p>
            </div>

            <div class="flex items-center gap-4 flex-shrink-0">
                <div class="w-24 h-24 rounded-full border-4 border-white/40 flex flex-col items-center justify-center transition-all duration-700 shadow-md" :class="running ? 'scale-110 bg-white/20 border-white' : 'bg-white/10'">
                    <span class="text-3xl font-black" x-text="count">4</span>
                    <span class="text-[9px] uppercase tracking-wider text-teal-100 text-center px-1 font-bold truncate max-w-[80px]" x-text="phase">Siap</span>
                </div>
                <div>
                    <button type="button" @click="running ? stop() : start()" class="px-5 py-2.5 rounded-2xl font-black text-xs shadow-md transition" :class="running ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-white text-teal-900 hover:bg-teal-50'">
                        <span x-text="running ? 'Hentikan Latihan' : 'Mulai Latihan 4-4-6'"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Articles Grid (6 Sitemap Subtopics) -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($articles as $art)
                <div class="bg-white rounded-3xl p-6 border {{ $art->category === 'tanda_bahaya' ? 'border-red-200 bg-red-50/10 shadow-red-100/50' : 'border-slate-200/80' }} shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition">
                    <div class="space-y-2.5">
                        <span class="inline-block px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider {{ $art->category === 'tanda_bahaya' ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-teal-50 text-teal-800 border border-teal-200' }}">
                            {{ str_replace('_', ' ', strtoupper($art->category)) }}
                        </span>
                        <h3 class="text-base font-extrabold text-slate-900 leading-snug">{{ $art->title }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">{{ $art->summary }}</p>
                    </div>

                    <div x-data="{ expanded: false }">
                        <div x-show="expanded" x-collapse class="mt-3 pt-3 border-t border-slate-100 text-xs text-slate-700 whitespace-pre-line leading-relaxed font-normal">
                            {{ $art->content }}
                        </div>
                        <button type="button" @click="expanded = !expanded" class="mt-2 text-xs font-bold text-teal-700 hover:text-teal-900 flex items-center gap-1">
                            <span x-text="expanded ? 'Tutup Materi ↑' : 'Baca Panduan Lengkap →'"></span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-8 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                    <p class="text-xs text-slate-500">Materi edukasi untuk kategori ini belum tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- TAB 2: VIDEO EDUKASI -->
    <div x-show="activeTab === 'video'" class="space-y-6">
        <div class="bg-teal-50/70 border border-teal-200 rounded-3xl p-4 sm:p-5 text-xs text-teal-950 flex items-center gap-3">
            <span class="text-xl">🩺</span>
            <span class="font-medium">Video edukasi resmi RSIA SiagaBunda. Tonton bersama pendamping persalinan (suami/keluarga) untuk melatih kesiapsiagaan fisik dan mental.</span>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($videos as $vid)
                <div class="bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                    <div class="aspect-video w-full bg-slate-900">
                        @if($vid->video_url)
                            <iframe class="w-full h-full" src="{{ $vid->video_url }}" title="{{ $vid->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-500 text-xs">Video Placeholder</div>
                        @endif
                    </div>
                    <div class="p-5 space-y-2">
                        <span class="inline-block px-2.5 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider bg-teal-100 text-teal-800 border border-teal-200">Video Panduan Klinis</span>
                        <h3 class="text-sm font-extrabold text-slate-900">{{ $vid->title }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">{{ $vid->summary }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection