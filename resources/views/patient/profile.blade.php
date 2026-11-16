@extends('layouts.app')

@section('title', 'Profil Pengguna - SiagaBunda')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Profil Pengguna & Kehamilan</h1>
            <p class="text-xs sm:text-sm text-slate-500">Kelola informasi data diri, HPHT, taksiran HPL, dan faskes rujukan persalinan.</p>
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

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Summary Card -->
        <div class="md:col-span-1 space-y-4">
            <div class="bg-white rounded-3xl p-6 border border-rose-100 shadow-sm text-center space-y-3">
                <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-rose-400 to-pink-500 text-white font-extrabold text-2xl flex items-center justify-center mx-auto shadow-md">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h2 class="font-extrabold text-slate-900 text-lg">{{ $user->name }}</h2>
                    <p class="text-xs text-slate-500">{{ $user->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-semibold {{ ($profile->risk_level ?? 'rendah') === 'tinggi' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                        Risiko: {{ ucfirst($profile->risk_level ?? 'Rendah') }}
                    </span>
                </div>

                <div class="pt-4 border-t border-slate-100 text-left space-y-2 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Usia Kandungan:</span>
                        <strong class="text-slate-800">{{ $profile?->gestationalWeeks() ?? '-' }} Minggu</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Taksiran Lahir:</span>
                        <strong class="text-slate-800">{{ $profile?->due_date ? $profile->due_date->translatedFormat('d M Y') : '-' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Gravida / Para:</span>
                        <strong class="text-slate-800">{{ $profile->gravida_para ?? 'G1P0A0' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Golongan Darah:</span>
                        <strong class="text-slate-800">{{ $profile->blood_type ?? '-' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Catatan Tenaga Medis / Bidan -->
            <div class="bg-teal-50/80 rounded-3xl p-5 border border-teal-200 text-xs space-y-2">
                <div class="flex items-center gap-2 text-teal-800 font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Catatan Tim Medis RS / Bidan
                </div>
                <p class="text-teal-900 leading-relaxed">
                    {{ $profile->notes ?: 'Belum ada catatan khusus dari Bidan/Dokter pemeriksa.' }}
                </p>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="md:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-rose-100 shadow-sm space-y-6">
            <h3 class="font-bold text-slate-900 text-base pb-3 border-b border-slate-100">
                Perbarui Informasi Kehamilan
            </h3>

            <form method="POST" action="{{ route('patient.profile.update') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Nama Lengkap Ibu Hamil</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm outline-none">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">No. WhatsApp / HP Siaga</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Gravida - Para - Abortus</label>
                        <input type="text" name="gravida_para" value="{{ old('gravida_para', $profile->gravida_para ?? 'G1P0A0') }}" placeholder="Contoh: G1P0A0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm outline-none">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">HPHT (Hari Pertama Haid Terakhir)</label>
                        <input type="date" name="hpht" value="{{ old('hpht', optional($profile?->hpht)->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm outline-none">
                        <p class="text-[11px] text-slate-400 mt-1">*HPL dihitung otomatis (+280 hari)</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Golongan Darah & Rhesus</label>
                        <select name="blood_type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm outline-none">
                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bt)
                                <option value="{{ $bt }}" {{ old('blood_type', $profile->blood_type ?? '') === $bt ? 'selected' : '' }}>{{ $bt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Fasilitas Kesehatan / Rumah Sakit Rujukan</label>
                    <input type="text" name="referral_hospital" value="{{ old('referral_hospital', $profile->referral_hospital ?? '') }}" required placeholder="Contoh: RSIA Kasih Bunda / RSUD Dr. Soetomo" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 text-sm outline-none">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-rose-600 text-white font-bold text-sm hover:bg-rose-700 shadow-sm transition">
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
