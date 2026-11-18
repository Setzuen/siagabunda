@extends('layouts.app')

@section('title', 'Pendaftaran Pasien Maternal - RSIA SiagaBunda')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-lg bg-white rounded-3xl shadow-lg border border-slate-200/80 p-8 space-y-6">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-teal-600 via-teal-700 to-cyan-800 text-white font-black text-2xl flex items-center justify-center mx-auto shadow-md shadow-teal-500/20 border border-teal-400/30">
                ✚
            </div>
            <div>
                <h1 class="text-xl font-black text-slate-900 tracking-tight">Pendaftaran Pasien Maternal Baru</h1>
                <p class="text-xs text-slate-500">Registrasi akun untuk pemantauan klinis & kesiapan P4K digital</p>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-2xl text-xs font-semibold">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
            @csrf
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Nama Lengkap Ibu</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 outline-none" placeholder="Contoh: Ny. Sari Dewi">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">No. WhatsApp / HP</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 outline-none" placeholder="0812xxxxxxxx">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 outline-none" placeholder="ibu@email.com">
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">HPHT (Hari Pertama Haid Terakhir)</label>
                    <input type="date" name="hpht" value="{{ old('hpht') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Golongan Darah</label>
                    <select name="blood_type" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="O+">O+</option>
                        <option value="A+">A+</option>
                        <option value="B+">B+</option>
                        <option value="AB+">AB+</option>
                        <option value="Belum diketahui">Belum diketahui</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Faskes / Rumah Sakit Rujukan</label>
                <input type="text" name="referral_hospital" value="{{ old('referral_hospital', 'RSIA SiagaBunda') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 outline-none">
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 outline-none" placeholder="Minimal 8 karakter">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-teal-500 outline-none" placeholder="Ulangi kata sandi">
                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-teal-700 to-teal-800 text-white font-extrabold text-xs hover:from-teal-800 hover:to-teal-900 shadow-md shadow-teal-600/20 transition">
                    Daftar Sebagai Pasien Baru
                </button>
            </div>
        </form>

        <div class="text-center pt-2 border-t border-slate-100">
            <p class="text-xs text-slate-500">
                Sudah memiliki akun rekam medis?
                <a href="{{ route('login') }}" class="font-bold text-teal-700 hover:underline">Masuk ke Portal Medis</a>
            </p>
        </div>
    </div>
</div>
@endsection