<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RSIA SiagaBunda - Sistem Pelayanan Maternal & P4K Digital')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        medical: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50/70 text-slate-800 min-h-screen flex flex-col antialiased selection:bg-teal-500 selection:text-white">

    <!-- Top Hospital Emergency & Accreditation Bar -->
    <header class="bg-gradient-to-r from-teal-900 via-teal-800 to-cyan-950 text-white text-[11px] py-2 border-b border-teal-700/50 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2.5 font-medium">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                </span>
                <span class="font-bold tracking-wider uppercase text-teal-200">Portal RSIA SiagaBunda</span>
                <span class="hidden md:inline text-teal-300/60">•</span>
                <span class="hidden md:inline text-teal-100">Pelayanan Obstetri Neonatal Emergensi Komprehensif (PONEK) 24 Jam</span>
            </div>
            <div class="flex items-center gap-3 sm:gap-4 font-semibold text-teal-100">
                <a href="tel:119" class="hover:text-white flex items-center gap-1.5 transition">
                    <span class="text-rose-400">🚑</span> Hotline IGD: <strong class="text-white underline">119</strong>
                </a>
                <span class="text-teal-500">|</span>
                <span class="hidden sm:inline-flex items-center gap-1 px-2 py-0.5 rounded bg-teal-700/60 text-[10px] text-teal-200 border border-teal-600/50">
                    <svg class="w-3 h-3 text-teal-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Standar Mutu P4K Kemenkes RI
                </span>
            </div>
        </div>
    </header>

    @auth
    <!-- Main Clinical Navigation Bar -->
    <nav class="bg-white/95 backdrop-blur border-b border-slate-200 sticky top-0 z-40 shadow-sm" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between h-16 items-center">
                <!-- Hospital Brand Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ auth()->user()->isHospitalStaff() ? route('hospital.dashboard') : route('patient.dashboard') }}" class="flex items-center gap-2.5 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-600 via-teal-700 to-cyan-800 flex items-center justify-center text-white font-extrabold shadow-sm shadow-teal-500/20 border border-teal-400/30 group-hover:scale-105 transition">
                            <span class="text-xl">✚</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-1.5">
                                <span class="font-extrabold text-slate-900 text-lg tracking-tight">SiagaBunda</span>
                                <span class="text-[10px] font-black uppercase px-1.5 py-0.5 rounded bg-teal-100 text-teal-800 border border-teal-200 tracking-wider">RSIA</span>
                            </div>
                            <p class="text-[10px] text-slate-500 font-medium -mt-1">Sistem Kesiapan Maternal Terpadu</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu Navigation -->
                <div class="hidden lg:flex items-center gap-1">
                    @if(auth()->user()->isPatient())
                        <a href="{{ route('patient.dashboard') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('patient.dashboard') ? 'bg-teal-50 text-teal-700 font-bold border border-teal-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition">Halaman Awal</a>
                        <a href="{{ route('patient.profile') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('patient.profile') ? 'bg-teal-50 text-teal-700 font-bold border border-teal-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition">Profil Pengguna</a>
                        <a href="{{ route('patient.education') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('patient.education') && request('category') !== 'video' ? 'bg-teal-50 text-teal-700 font-bold border border-teal-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition">Edukasi Persiapan</a>
                        <a href="{{ route('patient.checklist') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('patient.checklist') ? 'bg-teal-50 text-teal-700 font-bold border border-teal-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition">Checklist Kesiapan</a>
                        <a href="{{ route('patient.education', ['category' => 'video']) }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('patient.education') && request('category') === 'video' ? 'bg-teal-50 text-teal-700 font-bold border border-teal-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition">Video Edukasi</a>
                        <a href="{{ route('patient.reminders') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('patient.reminders') ? 'bg-teal-50 text-teal-700 font-bold border border-teal-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition">Pengingat & Agenda</a>
                        <a href="{{ route('patient.emergency') }}" class="ml-2 px-3.5 py-2 rounded-xl text-xs font-extrabold bg-gradient-to-r from-red-600 to-rose-600 text-white hover:from-red-700 hover:to-rose-700 shadow-sm shadow-red-200 transition flex items-center gap-1.5 animate-pulse">
                            <span class="w-2 h-2 rounded-full bg-white"></span>
                            Bantuan Darurat IGD
                        </a>
                    @else
                        <a href="{{ route('hospital.dashboard') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('hospital.dashboard') || request()->routeIs('hospital.patients.*') ? 'bg-teal-50 text-teal-800 font-bold border border-teal-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition">Monitoring Responden</a>
                        <a href="{{ route('hospital.education') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('hospital.education') ? 'bg-teal-50 text-teal-800 font-bold border border-teal-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} transition">Kelola Edukasi Medis</a>
                        <a href="{{ route('hospital.export.csv') }}" class="ml-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-emerald-600 text-white hover:bg-emerald-700 shadow-sm transition flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Ekspor Data CSV
                        </a>
                    @endif

                    <!-- User Profile & Logout -->
                    <div class="ml-3 pl-3 border-l border-slate-200 flex items-center gap-2">
                        <div class="text-right hidden xl:block">
                            <div class="text-xs font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</div>
                            <span class="text-[10px] text-slate-500 font-medium">
                                {{ auth()->user()->isHospitalStaff() ? 'Tenaga Medis / RS' : 'Pasien Maternal' }}
                            </span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition" title="Keluar dari sistem">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="open" x-cloak class="lg:hidden bg-white border-t border-slate-200 px-4 py-3 space-y-1 shadow-lg">
            @if(auth()->user()->isPatient())
                <a href="{{ route('patient.dashboard') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-teal-50 hover:text-teal-700">Halaman Awal</a>
                <a href="{{ route('patient.profile') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-teal-50 hover:text-teal-700">Profil Pengguna</a>
                <a href="{{ route('patient.education') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-teal-50 hover:text-teal-700">Edukasi Persiapan</a>
                <a href="{{ route('patient.checklist') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-teal-50 hover:text-teal-700">Checklist Kesiapan</a>
                <a href="{{ route('patient.education', ['category' => 'video']) }}" class="block px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-teal-50 hover:text-teal-700">Video Edukasi</a>
                <a href="{{ route('patient.reminders') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-teal-50 hover:text-teal-700">Pengingat & Agenda</a>
                <a href="{{ route('patient.emergency') }}" class="block px-3 py-2.5 rounded-xl text-xs font-bold bg-red-600 text-white text-center mt-2 shadow">🚨 Bantuan & Kontak Darurat IGD</a>
            @else
                <a href="{{ route('hospital.dashboard') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-teal-50 hover:text-teal-800">Monitoring Responden</a>
                <a href="{{ route('hospital.education') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold text-slate-700 hover:bg-teal-50 hover:text-teal-800">Kelola Edukasi Medis</a>
                <a href="{{ route('hospital.export.csv') }}" class="block px-3 py-2 rounded-xl text-xs font-semibold bg-emerald-600 text-white text-center mt-2">Ekspor Data CSV</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-slate-100">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 rounded-xl">Keluar ({{ auth()->user()->name }})</button>
            </form>
        </div>
    </nav>
    @endauth

    <!-- Main Content Area -->
    <main class="flex-1">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4">
                <div class="bg-teal-50 border border-teal-200 text-teal-900 px-4 py-3 rounded-2xl text-xs font-medium flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="text-teal-600 font-bold">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4">
                <div class="bg-red-50 border border-red-200 text-red-900 px-4 py-3 rounded-2xl text-xs font-medium shadow-sm">
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Hospital Clinical Footer -->
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800 py-10 mt-16 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-3 md:col-span-2">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-teal-500 text-white flex items-center justify-center font-bold text-sm">✚</div>
                    <span class="font-extrabold text-white text-base tracking-tight">RSIA SiagaBunda</span>
                    <span class="px-1.5 py-0.5 rounded bg-teal-900 text-teal-300 text-[10px] font-bold">P4K Digital</span>
                </div>
                <p class="text-slate-400 text-xs leading-relaxed max-w-md">
                    Sistem Informasi Kesiapan Persalinan dan Pencegahan Komplikasi Maternal terintegrasi. Menghubungkan ibu hamil, bidan, dan instalasi gawat darurat rumah sakit untuk mewujudkan persalinan yang aman, nyaman, dan terencana.
                </p>
                <div class="flex items-center gap-2 text-teal-400 font-semibold text-[11px]">
                    <span>✓ Rekam Medis Terverifikasi</span>
                    <span>•</span>
                    <span>✓ Hotline Darurat 24/7</span>
                    <span>•</span>
                    <span>✓ Standar Kemenkes RI</span>
                </div>
            </div>

            <div class="space-y-2">
                <h4 class="font-bold text-white text-xs uppercase tracking-wider">Poliklinik & Layanan</h4>
                <ul class="space-y-1.5 text-slate-400 text-xs">
                    <li>• Antenatal Care (ANC) Terpadu</li>
                    <li>• Konsultasi Bidan & Obgyn</li>
                    <li>• 7 Pilar Kesiapan Persalinan</li>
                    <li>• Edukasi Relaksasi & Pernapasan 4-4-6</li>
                </ul>
            </div>

            <div class="space-y-2">
                <h4 class="font-bold text-white text-xs uppercase tracking-wider">Kontak Cepat Fasilitas</h4>
                <p class="text-slate-400 text-xs">Instalasi Gawat Darurat (IGD) Maternal PONEK siap 24 jam melayani rujukan kegawatdaruratan kebidanan.</p>
                <div class="pt-1">
                    <a href="tel:119" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-600 text-white font-bold text-xs hover:bg-red-700 transition">
                        <span>🚨</span> Hubungi IGD 119
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 pt-8 mt-8 border-t border-slate-800 text-center sm:flex sm:justify-between sm:text-left text-[11px] text-slate-500">
            <p>&copy; {{ date('Y') }} RSIA SiagaBunda. Sistem Informasi Kesiapan Persalinan P4K Digital. Seluruh hak cipta dilindungi.</p>
            <p class="mt-2 sm:mt-0">Dirancang untuk Keselamatan Ibu dan Buah Hati ❤️</p>
        </div>
    </footer>
</body>
</html>