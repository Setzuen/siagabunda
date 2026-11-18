@extends('layouts.app')

@section('title', 'Profil Pasien & Data Kehamilan - RSIA SiagaBunda')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-100 text-teal-800 text-xs font-bold uppercase tracking-wider mb-1">
                Rekam Medis Maternal
            </span>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Profil Pasien & Data Kehamilan</h1>
            <p class="text-xs sm:text-sm text-slate-500">Kelola identitas medis, riwayat HPHT, perhitungan HPL otomatis, dan faskes rujukan persalinan.</p>
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

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Medical Profile Card -->
        <div class="md:col-span-1 space-y-4">
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm text-center space-y-3">
                <div class="w-20 h-20 rounded-3xl bg-gradient-to-tr from-teal-600 via-teal-700 to-cyan-800 text-white font-black text-2xl flex items-center justify-center mx-auto shadow-md shadow-teal-500/20 border border-teal-400/30">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h2 class="font-black text-slate-900 text-lg">{{ $user->name }}</h2>
                    <p class="text-xs text-slate-400">{{ $user->email }}</p>
                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-bold {{ ($profile->risk_level ?? 'rendah') === 'tinggi' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-emerald-100 text-emerald-800 border border-emerald-200' }}">
                        Status: Risiko {{ ucfirst($profile->risk_level ?? 'Rendah') }}
                    </span>
                </div>

                <div class="pt-4 border-t border-slate-100 text-left space-y-2.5 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Usia Gestasi:</span>
                        <strong class="text-slate-900 font-bold">{{ $profile?->gestationalWeeks() ?? '-' }} Minggu</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Taksiran Lahir (HPL):</span>
                        <strong class="text-teal-700 font-bold">{{ $profile?->due_date ? $profile->due_date->translatedFormat('d M Y') : '-' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Gravida / Para:</span>
                        <strong class="text-slate-900">{{ $profile->gravida_para ?? 'G1P0A0' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Golongan Darah:</span>
                        <strong class="text-rose-600 font-black">{{ $profile->blood_type ?? '-' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Catatan Tim Medis / Bidan -->
            <div class="bg-teal-50/80 rounded-3xl p-5 border border-teal-200 text-xs space-y-2">
                <div class="flex items-center gap-2 text-teal-900 font-extrabold">
                    <span>🩺</span>
                    <span>Catatan Klinis Bidan / Dokter RS</span>
                </div>
                <p class="text-teal-950 leading-relaxed font-medium">
                    {{ $profile->notes ?: 'Belum ada catatan khusus dari tim dokter / bidan pemeriksa.' }}
                </p>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="md:col-span-2 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
            <h3 class="font-extrabold text-slate-900 text-sm pb-3 border-b border-slate-100 flex items-center gap-2">
                <span>📝</span> Perbarui Informasi Data Medis Pasien
            </h3>

            <form method="POST" action="{{ route('patient.profile.update') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Nama Lengkap Ibu Hamil</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-xs outline-none">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">No. WhatsApp / HP Siaga</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-xs outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Gravida - Para - Abortus</label>
                        <input type="text" name="gravida_para" value="{{ old('gravida_para', $profile->gravida_para ?? 'G1P0A0') }}" placeholder="Contoh: G1P0A0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-xs outline-none">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">HPHT (Hari Pertama Haid Terakhir)</label>
                        <input type="date" name="hpht" value="{{ old('hpht', optional($profile?->hpht)->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-xs outline-none">
                        <p class="text-[10px] text-teal-600 mt-1 font-semibold">*HPL dihitung otomatis secara klinis (+280 hari / Rumus Naegele)</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Golongan Darah & Rhesus</label>
                        <select name="blood_type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-xs outline-none">
                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bt)
                                <option value="{{ $bt }}" {{ old('blood_type', $profile->blood_type ?? '') === $bt ? 'selected' : '' }}>{{ $bt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Fasilitas Kesehatan / Rumah Sakit Rujukan</label>
                    <input type="text" name="referral_hospital" value="{{ old('referral_hospital', $profile->referral_hospital ?? 'RSIA SiagaBunda') }}" required placeholder="Contoh: RSIA SiagaBunda / RSUD Dr. Soetomo" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-xs outline-none">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-teal-800 text-white font-extrabold text-xs hover:bg-teal-900 shadow-md shadow-teal-700/20 transition">
                        Simpan Perubahan Rekam Medis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection