@extends('layouts.app')

@section('title', 'Masuk ke Portal Medis - RSIA SiagaBunda')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-lg border border-slate-200/80 p-8 space-y-6" x-data="{ email: '{{ old('email') }}', password: '' }">
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-teal-600 via-teal-700 to-cyan-800 text-white font-black text-2xl flex items-center justify-center mx-auto shadow-md shadow-teal-500/20 border border-teal-400/30">
                ✚
            </div>
            <div>
                <h1 class="text-xl font-black text-slate-900 tracking-tight">Portal Medis RSIA SiagaBunda</h1>
                <p class="text-xs text-slate-500">Sistem Pelayanan Maternal & P4K Digital</p>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-2xl text-xs font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Alamat Email</label>
                <input type="email" name="email" x-model="email" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none text-xs" placeholder="nama@email.com">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1 uppercase tracking-wider">Kata Sandi</label>
                <input type="password" name="password" x-model="password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none text-xs" placeholder="••••••••">
            </div>
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    Ingat sesi saya
                </label>
                <a href="{{ route('register') }}" class="font-bold text-teal-700 hover:underline">Registrasi Pasien Baru</a>
            </div>
            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-teal-700 to-teal-800 text-white font-extrabold text-xs hover:from-teal-800 hover:to-teal-900 shadow-md shadow-teal-600/20 transition">
                Masuk ke Sistem
            </button>
        </form>

        <div class="pt-4 border-t border-slate-100 space-y-2">
            <p class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider text-center">Isi Cepat Akun Demo (1-Klik)</p>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" @click="email='ibu.sari@siagabunda.id'; password='password'" class="px-3 py-2 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold hover:bg-rose-100 transition">
                    🤰 Pasien Ibu Hamil
                </button>
                <button type="button" @click="email='bidan@siagabunda.id'; password='password'" class="px-3 py-2 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 text-xs font-bold hover:bg-teal-100 transition">
                    🩺 Tenaga Medis (Bidan)
                </button>
            </div>
        </div>
    </div>
</div>
@endsection