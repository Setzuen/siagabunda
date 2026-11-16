@extends('layouts.app')

@section('title', 'Bantuan dan Kontak Darurat - SiagaBunda')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold uppercase tracking-wider mb-1">
                <span class="w-2 h-2 rounded-full bg-red-600 animate-ping"></span>
                Akses Cepat 24 Jam
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Bantuan & Kontak Darurat IGD</h1>
            <p class="text-xs sm:text-sm text-slate-500">Gunakan kontak darurat ini bila mengalami tanda bahaya kehamilan atau kondisi darurat menjelang persalinan.</p>
        </div>
        <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 hover:underline">
            ← Kembali ke Halaman Awal
        </a>
    </div>

    <!-- Emergency Hotline Banners -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- 119 Ambulans Nasional -->
        <div class="bg-red-600 text-white rounded-3xl p-6 shadow-md shadow-red-200 flex flex-col justify-between space-y-4">
            <div class="space-y-1">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-white font-bold">
                    🚑
                </div>
                <h3 class="text-lg font-bold">Ambulans Siaga Nasional</h3>
                <p class="text-xs text-red-100">Layanan panggilan gawat darurat medis bebas pulsa 24 jam seluruh Indonesia.</p>
            </div>
            <a href="tel:119" class="w-full text-center py-3 rounded-2xl bg-white text-red-700 font-extrabold text-sm hover:bg-red-50 shadow transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Panggil Hotline 119
            </a>
        </div>

        <!-- Rumah Sakit Rujukan -->
        <div class="bg-white rounded-3xl p-6 border border-red-200 shadow-sm flex flex-col justify-between space-y-4">
            <div class="space-y-1">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-600 font-bold">
                    🏥
                </div>
                <h3 class="text-lg font-bold text-slate-900">IGD Faskes Rujukan</h3>
                <p class="text-xs text-slate-500 font-semibold">{{ $profile->referral_hospital ?? 'RS Rujukan Belum Dipilih' }}</p>
                <p class="text-[11px] text-slate-400">Instalasi Gawat Darurat Kebidanan (PONEK) siap sedia menerima rujukan.</p>
            </div>
            <a href="tel:081122334455" class="w-full text-center py-3 rounded-2xl bg-rose-600 text-white font-extrabold text-sm hover:bg-rose-700 shadow transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Hubungi IGD Rumah Sakit
            </a>
        </div>

        <!-- Donor Darah & Bidan -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col justify-between space-y-4">
            <div class="space-y-1">
                <div class="w-12 h-12 rounded-2xl bg-teal-100 flex items-center justify-center text-teal-600 font-bold">
                    🩸
                </div>
                <h3 class="text-lg font-bold text-slate-900">Donor Darah Siaga</h3>
                <p class="text-xs text-slate-500">Golongan Darah Ibu: <strong class="text-teal-700">{{ $profile->blood_type ?? '-' }}</strong></p>
                <p class="text-[11px] text-slate-400">Pastikan 2 calon pendonor keluarga dengan golongan darah yang sama aktif dan dapat dihubungi.</p>
            </div>
            <a href="https://wa.me/?text=Halo,%20kami%20memerlukan%20bantuan%20donor%20darah%20siaga%20untuk%20persalinan." target="_blank" class="w-full text-center py-3 rounded-2xl bg-teal-600 text-white font-extrabold text-sm hover:bg-teal-700 shadow transition flex items-center justify-center gap-2">
                💬 Kirim Pesan Siaga WA
            </a>
        </div>
    </div>

    <!-- Tanda Bahaya Yang Mengharuskan Segera ke IGD -->
    <div class="bg-red-50/80 rounded-3xl p-6 sm:p-8 border border-red-200 shadow-sm space-y-4">
        <div class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-red-600"></span>
            <h2 class="text-lg font-extrabold text-red-950">Tanda Bahaya: Kapan Ibu Harus Langsung ke IGD?</h2>
        </div>
        <p class="text-xs text-red-800 leading-relaxed">
            Jika Ibu mengalami salah satu dari kondisi darurat di bawah ini, <strong>JANGAN MENUNGGU</strong> jadwal kontrol rutin. Segera bawa ke IGD Rumah Sakit rujukan:
        </p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 text-xs text-slate-800">
            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1">
                <p class="font-bold text-red-700 flex items-center gap-1.5">
                    <span>🩸</span> Perdarahan Jalan Lahir
                </p>
                <p class="text-slate-500">Darah mengalir merah segar atau bergumpal banyak seperti menstruasi berat.</p>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1">
                <p class="font-bold text-red-700 flex items-center gap-1.5">
                    <span>💧</span> Air Ketuban Pecah Dini
                </p>
                <p class="text-slate-500">Cairan merembes atau menyembur keluar tak tertahankan sebelum ada kontraksi kuat.</p>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1">
                <p class="font-bold text-red-700 flex items-center gap-1.5">
                    <span>👶</span> Janin Kurang Bergerak
                </p>
                <p class="text-slate-500">Gerakan janin terasa kurang dari 10 kali dalam 12 jam atau tidak bergerak sama sekali.</p>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1">
                <p class="font-bold text-red-700 flex items-center gap-1.5">
                    <span>👁️</span> Sakit Kepala & Mata Kabur
                </p>
                <p class="text-slate-500">Pusing hebat yang tidak hilang, pandangan kabur berbayang, disertai nyeri ulu hati.</p>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1">
                <p class="font-bold text-red-700 flex items-center gap-1.5">
                    <span>⚡</span> Kejang atau Tidak Sadar
                </p>
                <p class="text-slate-500">Tanda bahaya preeklamsia berat / eklamsia yang mengancam nyawa ibu dan janin.</p>
            </div>

            <div class="p-4 rounded-2xl bg-white border border-red-100 space-y-1">
                <p class="font-bold text-red-700 flex items-center gap-1.5">
                    <span>🌡️</span> Demam Tinggi Menggigil
                </p>
                <p class="text-slate-500">Suhu tubuh > 38°C yang bisa menandakan adanya infeksi jalan lahir atau ketuban.</p>
            </div>
        </div>
    </div>

    <!-- Protokol Siaga yang Wajib Dibawa Saat ke IGD -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-sm space-y-4">
        <h3 class="font-bold text-slate-900 text-base">Barang & Dokumen Siaga yang Harus Langsung Dibawa ke IGD</h3>
        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs">
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-700">
                📄 Buku KIA (Kesehatan Ibu & Anak)
            </div>
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-700">
                💳 Kartu BPJS / JKN & KTP Asli
            </div>
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-700">
                👜 Tas Perlengkapan Siaga (Pakaian)
            </div>
            <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 font-semibold text-slate-700">
                🚗 Kunci & Kendaraan Siaga
            </div>
        </div>
    </div>
</div>
@endsection
