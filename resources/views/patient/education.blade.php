@extends('layouts.app')

@section('title', 'Edukasi Persiapan Persalinan & Video - SiagaBunda')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 space-y-8" x-data="{ activeTab: '{{ request('category') === 'video' ? 'video' : 'materi' }}', selectedCategory: '{{ request('category', 'all') }}' }">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Edukasi & Video Persiapan Persalinan</h1>
            <p class="text-xs sm:text-sm text-slate-500">Materi komprehensif P4K, teknik relaksasi napas, dan panduan visual persalinan.</p>
        </div>
        <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 hover:underline">
            ← Kembali ke Halaman Awal
        </a>
    </div>

    <!-- Navigation Tabs (Materi vs Video) -->
    <div class="flex border-b border-rose-100 gap-4">
        <button @click="activeTab = 'materi'" :class="activeTab === 'materi' ? 'border-rose-600 text-rose-600 font-bold border-b-2' : 'text-slate-500 hover:text-slate-700 font-medium'" class="pb-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            Edukasi Persiapan Persalinan (6 Topik)
        </button>
        <button @click="activeTab = 'video'" :class="activeTab === 'video' ? 'border-rose-600 text-rose-600 font-bold border-b-2' : 'text-slate-500 hover:text-slate-700 font-medium'" class="pb-3 text-sm flex items-center gap-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Video Edukasi (3 Video Pilihan)
        </button>
    </div>

    <!-- TAB 1: EDUKASI PERSIAPAN PERSALINAN -->
    <div x-show="activeTab === 'materi'" class="space-y-6">
        <!-- Interactive Category Quick Filter -->
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('patient.education', ['category' => 'all']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold {{ $category === 'all' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white border border-rose-100 text-slate-600 hover:bg-rose-50' }}">
                Semua Topik
            </a>
            <a href="{{ route('patient.education', ['category' => 'tanda_awal']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold {{ $category === 'tanda_awal' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white border border-rose-100 text-slate-600 hover:bg-rose-50' }}">
                Tanda Awal Persalinan
            </a>
            <a href="{{ route('patient.education', ['category' => 'tanda_bahaya']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold {{ $category === 'tanda_bahaya' ? 'bg-red-600 text-white shadow-sm' : 'bg-white border border-red-200 text-red-600 hover:bg-red-50' }}">
                Tanda Bahaya Kehamilan & Persalinan
            </a>
            <a href="{{ route('patient.education', ['category' => 'fisik']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold {{ $category === 'fisik' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white border border-rose-100 text-slate-600 hover:bg-rose-50' }}">
                Persiapan Fisik
            </a>
            <a href="{{ route('patient.education', ['category' => 'psikologis']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold {{ $category === 'psikologis' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white border border-rose-100 text-slate-600 hover:bg-rose-50' }}">
                Persiapan Psikologis
            </a>
            <a href="{{ route('patient.education', ['category' => 'pernapasan']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold {{ $category === 'pernapasan' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white border border-rose-100 text-slate-600 hover:bg-rose-50' }}">
                Teknik Pernapasan & Relaksasi
            </a>
            <a href="{{ route('patient.education', ['category' => 'persalinan']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-semibold {{ $category === 'persalinan' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white border border-rose-100 text-slate-600 hover:bg-rose-50' }}">
                Normal & Operasi Sesar
            </a>
        </div>

        <!-- Interactive Breathing Exercise Widget (4-4-6 Method) -->
        <div class="bg-gradient-to-r from-teal-600 to-emerald-600 rounded-3xl p-6 text-white shadow-md flex flex-col md:flex-row items-center justify-between gap-6" x-data="{
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
            <div class="space-y-1">
                <span class="inline-block px-2.5 py-0.5 rounded-full bg-white/20 text-[11px] font-bold uppercase tracking-wider">Simulasi Interaktif</span>
                <h3 class="text-xl font-extrabold">Latihan Pernapasan Relaksasi 4-4-6</h3>
                <p class="text-xs text-teal-100 max-w-lg">
                    Gunakan panduan ritme ini setiap kali merasakan ketegangan atau gelombang kontraksi. Tarik napas 4 detik, tahan 4 detik, lalu hembuskan lembut 6 detik.
                </p>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-24 h-24 rounded-full border-4 border-white/30 flex flex-col items-center justify-center transition-all duration-700" :class="running ? 'scale-110 bg-white/20 border-white' : 'bg-white/10'">
                    <span class="text-2xl font-black" x-text="count">4</span>
                    <span class="text-[9px] uppercase tracking-wider text-teal-100 text-center px-1 font-semibold" x-text="phase">Siap</span>
                </div>
                <div>
                    <button type="button" @click="running ? stop() : start()" class="px-5 py-2.5 rounded-xl font-bold text-xs shadow transition" :class="running ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-white text-teal-800 hover:bg-teal-50'">
                        <span x-text="running ? 'Hentikan Latihan' : 'Mulai Latihan 4-4-6'"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Articles Grid (6 Sitemap Subtopics) -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($articles as $art)
                <div class="bg-white rounded-3xl p-6 border {{ $art->category === 'tanda_bahaya' ? 'border-red-200 shadow-red-50' : 'border-rose-100' }} shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition">
                    <div class="space-y-2">
                        <span class="inline-block px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $art->category === 'tanda_bahaya' ? 'bg-red-100 text-red-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ str_replace('_', ' ', strtoupper($art->category)) }}
                        </span>
                        <h3 class="text-base font-bold text-slate-900 leading-snug">{{ $art->title }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-3">{{ $art->summary }}</p>
                    </div>

                    <div x-data="{ expanded: false }">
                        <div x-show="expanded" x-collapse class="mt-3 pt-3 border-t border-slate-100 text-xs text-slate-700 whitespace-pre-line leading-relaxed">
                            {{ $art->content }}
                        </div>
                        <button type="button" @click="expanded = !expanded" class="mt-2 text-xs font-bold text-rose-600 hover:text-rose-700 flex items-center gap-1">
                            <span x-text="expanded ? 'Tutup Materi ↑' : 'Baca Selengkapnya →'"></span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-8 text-center bg-white rounded-3xl border border-dashed border-slate-200">
                    <p class="text-sm text-slate-500">Materi untuk kategori ini belum tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- TAB 2: VIDEO EDUKASI -->
    <div x-show="activeTab === 'video'" class="space-y-6">
        <div class="bg-indigo-50/70 border border-indigo-100 rounded-2xl p-4 text-xs text-indigo-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            <span>Tonton bersama pasangan untuk memperkuat pemahaman teknik pernapasan dan persiapan tas siaga bersalin.</span>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($videos as $vid)
                <div class="bg-white rounded-3xl overflow-hidden border border-rose-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                    <div class="aspect-video w-full bg-slate-900">
                        @if($vid->video_url)
                            <iframe class="w-full h-full" src="{{ $vid->video_url }}" title="{{ $vid->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-500 text-xs">Video Placeholder</div>
                        @endif
                    </div>
                    <div class="p-5 space-y-2">
                        <span class="inline-block px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-800">Video Panduan</span>
                        <h3 class="text-sm font-bold text-slate-900">{{ $vid->title }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">{{ $vid->summary }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
