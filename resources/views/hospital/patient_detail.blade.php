@extends('layouts.app')

@section('title', 'Evaluasi Klinis Responden: ' . $patient->name . ' - RSIA SiagaBunda')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('hospital.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-700 hover:underline mb-1">
                ← Kembali ke Monitoring Responden
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $patient->name }}</h1>
            <p class="text-xs sm:text-sm text-slate-500">{{ $patient->email }} • No. WhatsApp: {{ $patient->phone ?: '-' }}</p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider {{ ($patient->pregnancyProfile->risk_level ?? 'rendah') === 'tinggi' ? 'bg-red-100 text-red-800 border border-red-200' : 'bg-emerald-100 text-emerald-800 border border-emerald-200' }}">
                Status Klinis: Risiko {{ ucfirst($patient->pregnancyProfile->risk_level ?? 'Rendah') }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-teal-50 border border-teal-200 text-teal-900 text-xs font-bold flex items-center gap-2">
            <svg class="w-5 h-5 text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Col 1: Kehamilan & Penapisan Risiko Nakes -->
        <div class="space-y-6">
            <!-- Info Kehamilan -->
            @php $prof = $patient->pregnancyProfile; @endphp
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-3">
                <h3 class="font-extrabold text-slate-900 text-sm border-b border-slate-100 pb-2 flex items-center gap-2">
                    <span>🩺</span> Informasi Medis & Kehamilan
                </h3>
                <div class="space-y-2 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Gravida / Para:</span>
                        <strong class="text-slate-900">{{ $prof->gravida_para ?? 'G1P0A0' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">HPHT:</span>
                        <strong class="text-slate-900">{{ $prof?->hpht ? $prof->hpht->translatedFormat('d M Y') : '-' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">HPL (Taksiran Lahir):</span>
                        <strong class="text-teal-700 font-bold">{{ $prof?->due_date ? $prof->due_date->translatedFormat('d M Y') : '-' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Usia Gestasi:</span>
                        <strong class="text-slate-900 font-bold">{{ $prof?->gestationalWeeks() ?? '-' }} Minggu</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Golongan Darah:</span>
                        <strong class="text-rose-600 font-black">{{ $prof->blood_type ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Faskes Rujukan:</span>
                        <strong class="text-slate-900">{{ $prof->referral_hospital ?? 'RSIA SiagaBunda' }}</strong>
                    </div>
                </div>
            </div>

            <!-- Form Update Penapisan Risiko oleh Nakes -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <h3 class="font-extrabold text-slate-900 text-sm border-b border-slate-100 pb-2 flex items-center gap-2">
                    <span>📋</span> Penapisan Risiko Klinis (Bidan/Dokter)
                </h3>
                <form method="POST" action="{{ route('hospital.patients.risk', $patient) }}" class="space-y-3 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tingkat Risiko</label>
                        <select name="risk_level" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                            <option value="rendah" {{ ($prof->risk_level ?? 'rendah') === 'rendah' ? 'selected' : '' }}>Risiko Rendah (Normal Maternal)</option>
                            <option value="sedang" {{ ($prof->risk_level ?? 'rendah') === 'sedang' ? 'selected' : '' }}>Risiko Sedang</option>
                            <option value="tinggi" {{ ($prof->risk_level ?? 'rendah') === 'tinggi' ? 'selected' : '' }}>Risiko Tinggi (Waspada Komplikasi)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Catatan Evaluasi / Rekomendasi Nakes</label>
                        <textarea name="notes" rows="3" class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none" placeholder="Misal: Riwayat preeklamsia, pantau tensi setiap 3 hari...">{{ old('notes', $prof->notes ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-teal-800 text-white font-extrabold hover:bg-teal-900 shadow-sm transition">
                        Simpan Penapisan Risiko
                    </button>
                </form>
            </div>
        </div>

        <!-- Col 2 & 3: 7 Checklist P4K & Jadwal Terhubung -->
        <div class="lg:col-span-2 space-y-6">
            <!-- 7 Checklist Kesiapan Responden -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-sm">Status 7 Pilar Kesiapan P4K</h3>
                        <p class="text-xs text-slate-500">Skor Kesiapan: <strong class="text-teal-700">{{ $readiness }}%</strong></p>
                    </div>
                    <div class="w-32 bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-teal-600 h-2.5 rounded-full" style="width: {{ $readiness }}%"></div>
                    </div>
                </div>

                <div class="space-y-3 pt-2">
                    @foreach($patient->checklists as $chk)
                        <div class="p-3.5 rounded-2xl border {{ $chk->is_completed ? 'border-teal-200 bg-teal-50/20' : 'border-slate-200 bg-slate-50/50' }} flex items-start justify-between gap-3 text-xs">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full flex items-center justify-center font-bold text-[10px] {{ $chk->is_completed ? 'bg-teal-600 text-white' : 'bg-slate-300 text-slate-700' }}">
                                        {{ $chk->is_completed ? '✓' : '!' }}
                                    </span>
                                    <h4 class="font-bold text-slate-900">{{ $chk->title }}</h4>
                                </div>
                                <p class="text-slate-500 pl-6">{{ $chk->description }}</p>
                                @if($chk->details)
                                    <div class="ml-6 mt-1 p-2 rounded-lg bg-white border border-slate-200 text-slate-700 italic">
                                        <strong>Rincian Pasien:</strong> {{ $chk->details }}
                                    </div>
                                @endif
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase flex-shrink-0 {{ $chk->is_completed ? 'bg-teal-100 text-teal-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $chk->is_completed ? 'Siap' : 'Belum' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Kirim Jadwal ANC Baru oleh Nakes -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <h3 class="font-extrabold text-slate-900 text-sm border-b border-slate-100 pb-2 flex items-center gap-2">
                    <span>🗓️</span> Jadwalkan Kontrol ANC Pasien (Poli Kebidanan)
                </h3>
                <form method="POST" action="{{ route('hospital.patients.schedules', $patient) }}" class="space-y-3 text-xs">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Judul Pemeriksaan</label>
                            <input type="text" name="title" required placeholder="Contoh: USG Trimester 3 & Evaluasi P4K" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Jenis Agenda</label>
                            <select name="type" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                                <option value="anc">Jadwal Antenatal Care (ANC)</option>
                                <option value="persiapan">Pengingat Persiapan Persalinan</option>
                                <option value="tanda_bahaya">Pengingat Tanda Bahaya</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Tanggal & Waktu</label>
                            <input type="datetime-local" name="event_date" required class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Lokasi Pemeriksaan</label>
                            <input type="text" name="location" value="{{ $prof->referral_hospital ?? 'Poli Kebidanan RSIA SiagaBunda' }}" class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Instruksi Dokter / Bidan</label>
                        <input type="text" name="description" placeholder="Misal: Bawa buku KIA dan hasil tes hemoglobin darah terakhir." class="w-full px-3 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                    </div>

                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-teal-800 text-white font-extrabold hover:bg-teal-900 shadow-sm transition">
                        Kirim Jadwal ke Akun Pasien
                    </button>
                </form>

                <!-- Daftar Jadwal Pasien Saat Ini -->
                <div class="pt-4 border-t border-slate-100 space-y-2">
                    <p class="font-bold text-slate-700 text-xs">Jadwal Terdaftar Pasien Ini:</p>
                    @forelse($patient->schedules as $sc)
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs flex justify-between items-center">
                            <div>
                                <span class="font-bold text-slate-900">{{ $sc->title }}</span>
                                <span class="text-slate-500">({{ $sc->event_date->translatedFormat('d M Y - H:i') }} WIB @ {{ $sc->location }})</span>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $sc->status === 'completed' ? 'bg-slate-200 text-slate-700' : 'bg-teal-100 text-teal-800' }}">
                                {{ $sc->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-slate-400 text-xs">Belum ada agenda kontrol.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection