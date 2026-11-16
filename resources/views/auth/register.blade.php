@extends('layouts.app')

@section('title', 'Daftar Ibu Hamil - SiagaBunda')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-lg bg-white rounded-2xl shadow-sm border border-rose-100 p-8 space-y-6">
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-bold text-slate-900">Pendaftaran Ibu Hamil</h1>
            <p class="text-sm text-slate-500">Buat akun untuk memantau kesiapan persalinan P4K Anda</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
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
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-rose-500 outline-none" placeholder="Contoh: Ibu Ani">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">No. HP / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-rose-500 outline-none" placeholder="0812xxxxxxxx">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-rose-500 outline-none" placeholder="ibu@email.com">
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">HPHT (Opsional)</label>
                    <input type="date" name="hpht" value="{{ old('hpht') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-rose-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Golongan Darah</label>
                    <select name="blood_type" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-rose-500 outline-none">
                        <option value="O+">O+</option>
                        <option value="A+">A+</option>
                        <option value="B+">B+</option>
                        <option value="AB+">AB+</option>
                        <option value="Belum diketahui">Belum diketahui</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Faskes / RS Rujukan</label>
                <input type="text" name="referral_hospital" value="{{ old('referral_hospital', 'RSIA Kasih Bunda') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-rose-500 outline-none">
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-rose-500 outline-none" placeholder="Min. 6 karakter">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-rose-500 outline-none">
                </div>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-rose-600 text-white font-bold text-sm hover:bg-rose-700 shadow-sm transition">
                Daftar & Mulai Persiapan P4K
            </button>
        </form>

        <p class="text-center text-xs text-slate-500">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-rose-600 hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
@endsection
