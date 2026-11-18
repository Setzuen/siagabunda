@extends('layouts.app')

@section('title', 'Pusat Tanggap Darurat Maternal IGD 24 Jam - RSIA SiagaBunda')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold uppercase tracking-wider mb-1 border border-red-200">
                <span class="w-2 h-2 rounded-full bg-red-600 animate-ping"></span>
                Pelayanan Maternal PONEK 24 Jam
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Pusat Bantuan & Kontak Darurat IGD</h1>
            <p class="text-xs sm:text-sm text-slate-500">Akses cepat evakuasi medis, ambulans 119, IGD kebidanan, dan koordinasi donor darah siaga.</p>
        </div>
        <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-700 hover:underline">
            ← Kembali ke Dashboard Pasien
        </a>
    </div>

    <!-- Emergency Hotline Banners -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- 119 Ambulans Nasional -->
        <div class="bg-gradient-to-br from-red-600 via-red-700 to-rose-700 text-white rounded-3xl p-6 shadow-lg shadow-red-200 flex flex-col justify-between space-y-4 border border-red-500">
            <div class="space-y-1.5">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-white font-bold text-2xl shadow-inner">
                    🚑
                </div>
                <h3 class="text-lg font-black">Ambulans Siaga Nasional</h3>
                <p class="text-xs text-red-100 leading-relaxed font-medium">Layanan evakuasi gawat darurat medis bebas pulsa 24 jam seluruh Indonesia.</p>
            </div>
            <a href="tel:119" class="w-full text-center py-3 rounded-2xl bg-white text-red-700 font-black text-sm hover:bg-red-50 shadow-md transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <span>Panggil Hotline 119</span>
            </a>
        </div>

        <!-- Rumah Sakit Rujukan -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition">
            <div class="space-y-1.5">
                <div class="w-12 h-12 rounded-2xl bg-teal-100 flex items-center justify-center text-teal-700 font-bold text-2xl border border-teal-200">
                    🏥
                </div>
                <h3 class="text-lg font-black text-slate-900">IGD RSIA / RS Rujukan</h3>
                <p class="text-xs text-teal-800 font-bold truncate">{{ $profile->referral_hospital ?? 'RSIA SiagaBunda' }}</p>
                <p class="text-[11px] text-slate-400 leading-relaxed">Instalasi Gawat Darurat Kebidanan (PONEK) siaga 24 jam menerima rujukan komplikasi.</p>
            </div>
            <a href="tel:081122334455" class="w-full text-center py-3 rounded-2xl bg-teal-800 text-white font-black text-sm hover:bg-teal-900 shadow-sm transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <span>Hubungi IGD Rumah Sakit</span>
            </a>
        </div>

        <!-- Donor Darah & Bidan -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between space-y-4 hover:shadow-md transition">
            <div class="space-y-1.5">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-600 font-bold text-2xl border border-rose-200">
                    🩸
                </div>
                <h3 class="text-lg font-black text-slate-900">Donor Darah Siaga</h3>
                <p class="text-xs text-slate-600">Golongan Darah Ibu: <strong class="text-rose-600 font-black text-sm">{{ $profile->blood_type ?? '-' }}</strong></p>
                <p class="text-[11px] text-slate-400 leading-relaxed">Koordinasi cepat calon pendonor keluarga dengan golongan darah yang sama.</p>
            </div>
            <a href="https://wa.me/?text=Halo,%20kami%20memerlukan%20bantuan%20donor%20darah%20siaga%20untuk%20persalinan%20ibu%20{{ urlencode($user->name) }}%20(Golongan%20{{ $profile->blood_type ?? '-' }})." target="_blank" class="w-full text-center py-3 rounded-2xl bg-emerald-600 text-white font-black text-sm hover:bg-emerald-700 shadow-sm transition flex items-center justify-center gap-2">
                <span>💬</span> Kirim Pesan Siaga WA
            </a>
        </div>
    </div>

    <!-- Tanda Bahaya Yang Mengharuskan Segera ke IGD -->
    <div class="bg-gradient-to-br from-red-50/90 to-rose-50/90 rounded-3xl p-6 sm:p-8 border border-red-200 shadow-sm space-y-4">
        <div class="flex items-center gap-2.5">
            <span class="w-3 h-3 rounded-full bg-red-600 animate-ping"></span>
            <h2 class="text-lg font-black text-red-950">Protokol Klinis: Kapan Harus Segera ke IGD?</h2>
        </div>
        <p class="text-xs text-red-900 leading-relaxed font-medium">
            Jika Ibu mengalami salah satu dari kondisi darurat maternal berikut, <strong>JANGAN MENUNDA</strong> jadwal kontrol rutin. Segera tuju IGD Rumah Sakit rujukan:
        </p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 text-xs text-slate-800">
            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1 shadow-xs">
                <p class="font-black text-red-700 flex items-center gap-1.5">
                    <span>🩸</span> Perdarahan Jalan Lahir
                </p>
                <p class="text-slate-500 text-[11px] leading-relaxed">Darah merah segar mengalir atau bergumpal seperti menstruasi berat.</p>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1 shadow-xs">
                <p class="font-black text-red-700 flex items-center gap-1.5">
                    <span>💧</span> Ketuban Pecah Dini
                </p>
                <p class="text-slate-500 text-[11px] leading-relaxed">Cairan merembes atau menyembur keluar tak tertahankan sebelum ada kontraksi kuat.</p>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1 shadow-xs">
                <p class="font-black text-red-700 flex items-center gap-1.5">
                    <span>👶</span> Janin Kurang Bergerak
                </p>
                <p class="text-slate-500 text-[11px] leading-relaxed">Gerakan janin terasa kurang dari 10 kali dalam 12 jam atau tidak bergerak sama sekali.</p>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1 shadow-xs">
                <p class="font-black text-red-700 flex items-center gap-1.5">
                    <span>👁️</span> Sakit Kepala & Mata Kabur
                </p>
                <p class="text-slate-500 text-[11px] leading-relaxed">Pusing hebat yang tidak hilang, pandangan kabur berbayang (waspada Preeklamsia).</p>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1 shadow-xs">
                <p class="font-black text-red-700 flex items-center gap-1.5">
                    <span>⚡</span> Kejang atau Pingsan
                </p>
                <p class="text-slate-500 text-[11px] leading-relaxed">Tanda bahaya eklamsia berat yang mengancam keselamatan ibu dan bayi.</p>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1 shadow-xs">
                <p class="font-black text-red-700 flex items-center gap-1.5">
                    <span>🌡️</span> Demam Tinggi Menggigil
                </p>
                <p class="text-slate-500 text-[11px] leading-relaxed">Suhu tubuh > 38°C yang menandakan adanya infeksi ketuban atau infeksi jalan lahir.</p>
            </div>
        </div>
    </div>

    <!-- Protokol Siaga yang Wajib Dibawa Saat ke IGD -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-4">
        <h3 class="font-black text-slate-900 text-sm flex items-center gap-2">
            <span>👜</span> Dokumen & Perlengkapan Siaga yang Wajib Langsung Dibawa ke IGD
        </h3>
        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs">
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 font-bold text-slate-800 flex items-center gap-2">
                <span>📄</span> Buku KIA (Kesehatan Ibu & Anak)
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 font-bold text-slate-800 flex items-center gap-2">
                <span>💳</span> Kartu BPJS / JKN & KTP Asli
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 font-bold text-slate-800 flex items-center gap-2">
                <span>👜</span> Tas Perlengkapan Bayi & Ibu
            </div>
            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 font-bold text-slate-800 flex items-center gap-2">
                <span>🚗</span> Kunci & Kendaraan Siaga
            </div>
        </div>
    </div>
</div>
@endsection