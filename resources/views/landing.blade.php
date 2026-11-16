@extends('layouts.app')

@section('title', 'SiagaBunda - Sistem Informasi Kesiapan Persalinan P4K Digital')

@section('content')
<div class="min-h-screen flex flex-col justify-center bg-gradient-to-b from-rose-50 via-white to-pink-50/40">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 lg:py-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-rose-100 text-rose-700 text-xs font-bold tracking-wide uppercase">
                    Program P4K Digital
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 leading-tight">
                    Persiapan Persalinan Lebih <span class="text-rose-600">Aman & Terencana</span>
                </h1>
                <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
                    <strong>SiagaBunda</strong> membantu Ibu Hamil dan Keluarga memantau kesiapan persalinan (Tempat, Nakes, Transportasi, Biaya, Perlengkapan, Pendamping, Darurat) serta terhubung langsung dengan pantauan Bidan / Rumah Sakit.
                </p>

                <div class="flex flex-wrap gap-3 pt-2">
                    <a href="{{ route('login') }}" class="px-6 py-3.5 rounded-xl bg-rose-600 text-white font-bold text-sm hover:bg-rose-700 shadow-md shadow-rose-200 transition">
                        Masuk ke Sistem
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-3.5 rounded-xl bg-white text-rose-700 border border-rose-200 font-bold text-sm hover:bg-rose-50 transition">
                        Daftar Ibu Hamil Baru
                    </a>
                </div>

                <!-- Demo Quick Credentials Box -->
                <div class="bg-white/90 border border-rose-100 rounded-2xl p-5 shadow-sm space-y-2">
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Akun Demo Pengujian (Tugas Akhir)</p>
                    <div class="grid sm:grid-cols-2 gap-3 text-xs text-slate-700">
                        <div class="p-3 rounded-xl bg-rose-50/70 border border-rose-100">
                            <p class="font-bold text-rose-700">Ruang Ibu Hamil (Pasien)</p>
                            <p>Email: <code class="font-semibold">ibu.sari@siagabunda.id</code></p>
                            <p>Password: <code class="font-semibold">password</code></p>
                        </div>
                        <div class="p-3 rounded-xl bg-teal-50/70 border border-teal-100">
                            <p class="font-bold text-teal-700">Ruang Rumah Sakit (Nakes)</p>
                            <p>Email: <code class="font-semibold">bidan@siagabunda.id</code></p>
                            <p>Password: <code class="font-semibold">password</code></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-bold">01</div>
                    <h3 class="font-bold text-slate-900">Edukasi & Video P4K</h3>
                    <p class="text-sm text-slate-600">Materi tanda awal persalinan, tanda bahaya, teknik pernapasan 4-4-6, dan senam hamil.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center font-bold">02</div>
                    <h3 class="font-bold text-slate-900">7 Checklist Kesiapan</h3>
                    <p class="text-sm text-slate-600">Pelacakan skor kesiapan persalinan secara real-time bersama keluarga.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center font-bold">03</div>
                    <h3 class="font-bold text-slate-900">Monitoring Rumah Sakit</h3>
                    <p class="text-sm text-slate-600">Bidan memantau status risiko ibu hamil, jadwal ANC, dan rekap data penelitian.</p>
                </div>
                <div class="bg-white p-6 rounded-2xl border border-rose-100 shadow-sm space-y-2">
                    <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold">04</div>
                    <h3 class="font-bold text-slate-900">Tombol Darurat IGD</h3>
                    <p class="text-sm text-slate-600">Akses cepat kontak darurat IGD, ambulans 119, dan panduan tanda bahaya.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
