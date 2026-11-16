<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiagaBunda - P4K Digital')</title>
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
<body class="bg-rose-50/40 text-slate-800 min-h-screen flex flex-col">
    @auth
    <nav class="bg-white border-b border-rose-100 sticky top-0 z-40 shadow-sm" x-data="{ open: false }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <a href="{{ auth()->user()->isHospitalStaff() ? route('hospital.dashboard') : route('patient.dashboard') }}" class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center text-white font-bold shadow-sm">
                            SB
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 text-lg tracking-tight">SiagaBunda</span>
                            <span class="hidden sm:inline-block ml-1.5 text-xs font-semibold px-2 py-0.5 rounded-full {{ auth()->user()->isHospitalStaff() ? 'bg-teal-100 text-teal-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ auth()->user()->isHospitalStaff() ? 'Ruang Nakes / RS' : 'P4K Digital' }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-1">
                    @if(auth()->user()->isPatient())
                        <a href="{{ route('patient.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('patient.dashboard') ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">Halaman Awal</a>
                        <a href="{{ route('patient.profile') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('patient.profile') ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">Profil Pengguna</a>
                        <a href="{{ route('patient.education') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('patient.education') && request('category') !== 'video' ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">Edukasi Persiapan</a>
                        <a href="{{ route('patient.checklist') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('patient.checklist') ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">Checklist Kesiapan</a>
                        <a href="{{ route('patient.education', ['category' => 'video']) }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('patient.education') && request('category') === 'video' ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">Video Edukasi</a>
                        <a href="{{ route('patient.reminders') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('patient.reminders') ? 'bg-rose-50 text-rose-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">Pengingat & Agenda</a>
                        <a href="{{ route('patient.emergency') }}" class="ml-2 px-3.5 py-2 rounded-lg text-sm font-bold bg-red-600 text-white hover:bg-red-700 shadow-sm transition">Bantuan & Darurat</a>
                    @else
                        <a href="{{ route('hospital.dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('hospital.dashboard') || request()->routeIs('hospital.patients.*') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">Monitoring Responden</a>
                        <a href="{{ route('hospital.education') }}" class="px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('hospital.education') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:bg-slate-50' }}">Kelola Edukasi</a>
                        <a href="{{ route('hospital.export.csv') }}" class="ml-2 px-3.5 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700 shadow-sm transition">Ekspor CSV</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="ml-3 pl-3 border-l border-slate-200">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-slate-500 hover:text-rose-600 px-2 py-1">Keluar</button>
                    </form>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-rose-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown -->
        <div x-show="open" x-cloak class="md:hidden bg-white border-t border-rose-100 px-4 py-3 space-y-1">
            @if(auth()->user()->isPatient())
                <a href="{{ route('patient.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-rose-50">Halaman Awal</a>
                <a href="{{ route('patient.profile') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-rose-50">Profil Pengguna</a>
                <a href="{{ route('patient.education') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-rose-50">Edukasi Persiapan</a>
                <a href="{{ route('patient.checklist') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-rose-50">Checklist Kesiapan</a>
                <a href="{{ route('patient.education', ['category' => 'video']) }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-rose-50">Video Edukasi</a>
                <a href="{{ route('patient.reminders') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-rose-50">Pengingat & Agenda</a>
                <a href="{{ route('patient.emergency') }}" class="block px-3 py-2 rounded-lg text-sm font-bold bg-red-600 text-white text-center mt-2">Bantuan & Kontak Darurat</a>
            @else
                <a href="{{ route('hospital.dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-teal-50">Monitoring Responden</a>
                <a href="{{ route('hospital.education') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:bg-teal-50">Kelola Edukasi</a>
                <a href="{{ route('hospital.export.csv') }}" class="block px-3 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white text-center mt-2">Ekspor Data CSV</a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-slate-100">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 text-sm font-medium text-rose-600">Keluar ({{ auth()->user()->name }})</button>
            </form>
        </div>
    </nav>
    @endauth

    <main class="flex-1">
        @if(session('success'))
            <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-4">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-6xl mx-auto px-4 sm:px-6 mt-4">
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm font-medium">
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t border-rose-100 py-5 mt-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-2">
            <p>&copy; {{ date('Y') }} <strong>SiagaBunda (P4K Digital)</strong> &mdash; Modul Edukasi & Monitoring Kesiapan Persalinan.</p>
            <p>Sistem Informasi Tugas Akhir Kesehatan Ibu & Anak</p>
        </div>
    </footer>
</body>
</html>
