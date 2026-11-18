@extends('layouts.app')

@section('title', 'Portal Medis RSIA SiagaBunda - Pelayanan Persalinan P4K Terpadu')

@section('content')
<div class="relative overflow-hidden bg-gradient-to-b from-teal-50/50 via-white to-slate-50/80 min-h-[90vh] flex flex-col justify-center py-12 lg:py-20">
    <!-- Decorative Hospital Pattern Elements -->
    <div class="absolute top-0 right-0 -mt-12 -mr-12 w-96 h-96 bg-teal-100/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 -mb-12 -ml-12 w-96 h-96 bg-rose-100/30 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10 space-y-16">
        <!-- Hero Section -->
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 space-y-6">
                <!-- Accreditation Tag -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-100/80 border border-teal-200 text-teal-800 text-xs font-bold uppercase tracking-wider shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-teal-600 animate-ping"></span>
                    <span>Portal Pelayanan Maternal RSIA SiagaBunda</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black text-slate-900 leading-tight tracking-tight">
                    Persiapan Persalinan Lebih <span class="text-teal-600">Aman, Terencana</span> & Nyaman
                </h1>

                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl">
                    Sistem pemantauan kesiapan persalinan digital berbasis standar <strong>P4K Kemenkes RI</strong>. Menghubungkan ibu hamil dan keluarga secara langsung dengan pantauan bidan, dokter obgyn, serta kesiapsiagaan <strong>IGD Maternal PONEK 24 Jam</strong>.
                </p>

                <!-- Action CTA Buttons -->
                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ route('login') }}" class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-teal-600 to-teal-700 text-white font-extrabold text-sm hover:from-teal-700 hover:to-teal-800 shadow-lg shadow-teal-500/25 transition flex items-center gap-2">
                        <span>Masuk ke Portal Medis</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                    <a href="{{ route('register') }}" class="px-6 py-3.5 rounded-2xl bg-white text-teal-800 border border-slate-200 font-bold text-sm hover:bg-slate-50 hover:border-teal-300 shadow-sm transition">
                        Registrasi Ibu Hamil Baru
                    </a>
                    <a href="tel:119" class="px-4 py-3.5 rounded-2xl bg-red-50 text-red-700 border border-red-200 font-bold text-xs hover:bg-red-100 transition flex items-center gap-1.5">
                        <span>🚨</span> Hotline IGD 119
                    </a>
                </div>

                <!-- Hospital Quick Demo Account Credentials -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm space-y-3 max-w-xl">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                            <span class="text-teal-600">●</span> Akses Cepat Pengujian (Akun Demo)
                        </span>
                        <span class="text-[10px] text-teal-700 font-semibold bg-teal-50 px-2 py-0.5 rounded-full">Siap Uji</span>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-3 text-xs">
                        <div class="p-3.5 rounded-2xl bg-rose-50/60 border border-rose-100/80 space-y-1">
                            <div class="flex items-center gap-1.5 font-bold text-rose-800">
                                <span>🤰</span> Ruang Ibu Hamil (Pasien)
                            </div>
                            <div class="text-[11px] text-slate-600 space-y-0.5">
                                <p>Email: <code class="font-bold text-slate-900 bg-white px-1.5 py-0.5 rounded border border-rose-200">ibu.sari@siagabunda.id</code></p>
                                <p>Password: <code class="font-bold text-slate-900 bg-white px-1.5 py-0.5 rounded border border-rose-200">password</code></p>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-2xl bg-teal-50/60 border border-teal-100/80 space-y-1">
                            <div class="flex items-center gap-1.5 font-bold text-teal-800">
                                <span>🩺</span> Ruang Nakes (Bidan/RS)
                            </div>
                            <div class="text-[11px] text-slate-600 space-y-0.5">
                                <p>Email: <code class="font-bold text-slate-900 bg-white px-1.5 py-0.5 rounded border border-teal-200">bidan@siagabunda.id</code></p>
                                <p>Password: <code class="font-bold text-slate-900 bg-white px-1.5 py-0.5 rounded border border-teal-200">password</code></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clinical Service Highlights Right Column -->
            <div class="lg:col-span-5 grid sm:grid-cols-2 lg:grid-cols-1 gap-4">
                <!-- Card 1: 7 Pilar P4K -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition space-y-2 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold text-xl flex-shrink-0">
                        📋
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm">7 Pilar Kesiapan Persalinan</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Verifikasi kesiapan tempat persalinan, tenaga penolong, transportasi siaga, pembiayaan/BPJS, perlengkapan tas bersalin, pendamping, dan kontak darurat.
                        </p>
                    </div>
                </div>

                <!-- Card 2: Monitoring Bidan -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition space-y-2 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-100 text-cyan-700 flex items-center justify-center font-bold text-xl flex-shrink-0">
                        🩺
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm">Pemantauan Klinis & Risiko</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Bidan rumah sakit memantau rekam kesiapan ibu hamil, menapis tingkat risiko kehamilan (rendah/tinggi), dan menjadwalkan pemeriksaan antenatal care.
                        </p>
                    </div>
                </div>

                <!-- Card 3: Edukasi & Pernapasan 4-4-6 -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition space-y-2 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-xl flex-shrink-0">
                        🧘‍♀️
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm">Edukasi & Relaksasi Kontraksi</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">
                            Panduan komprehensif tanda bahaya kehamilan, video persiapan persalinan, dan simulasi interaktif ritme pernapasan relaksasi 4-4-6.
                        </p>
                    </div>
                </div>

                <!-- Card 4: IGD 24 Jam PONEK -->
                <div class="bg-gradient-to-r from-red-50 to-rose-50 p-6 rounded-3xl border border-red-200 shadow-sm space-y-2 flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-red-600 text-white flex items-center justify-center font-bold text-xl flex-shrink-0 shadow-sm">
                        🚑
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-red-950 text-sm">Respon Darurat IGD 119</h3>
                            <span class="px-2 py-0.5 rounded-full bg-red-600 text-white text-[9px] font-black uppercase">24 Jam</span>
                        </div>
                        <p class="text-xs text-red-800 leading-relaxed">
                            Panggilan darurat ambulans nasional dan jalur komunikasi cepat ke IGD Rumah Sakit rujukan jika muncul tanda-tanda komplikasi persalinan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Feature Pillars Summary Banner -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-slate-200/80">
            <div class="p-5 rounded-3xl bg-white border border-slate-200 shadow-xs text-center space-y-1">
                <div class="text-2xl font-black text-teal-600">100%</div>
                <p class="text-xs font-bold text-slate-800">Standar P4K Digital</p>
                <p class="text-[10px] text-slate-500">Kemenkes RI terakreditasi</p>
            </div>

            <div class="p-5 rounded-3xl bg-white border border-slate-200 shadow-xs text-center space-y-1">
                <div class="text-2xl font-black text-teal-600">7 Pilar</div>
                <p class="text-xs font-bold text-slate-800">Checklist Kesiapan</p>
                <p class="text-[10px] text-slate-500">Tempat, Nakes s/d Donor</p>
            </div>

            <div class="p-5 rounded-3xl bg-white border border-slate-200 shadow-xs text-center space-y-1">
                <div class="text-2xl font-black text-rose-600">4-4-6</div>
                <p class="text-xs font-bold text-slate-800">Metode Relaksasi</p>
                <p class="text-[10px] text-slate-500">Meredakan nyeri kontraksi</p>
            </div>

            <div class="p-5 rounded-3xl bg-white border border-slate-200 shadow-xs text-center space-y-1">
                <div class="text-2xl font-black text-red-600">24/7</div>
                <p class="text-xs font-bold text-slate-800">Siaga IGD PONEK</p>
                <p class="text-[10px] text-slate-500">Penanganan komplikasi</p>
            </div>
        </div>
    </div>
</div>
@endsection