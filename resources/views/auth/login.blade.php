@extends('layouts.app')

@section('title', 'Masuk - SiagaBunda')

@section('content')
<div class="min-h-[85vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-rose-100 p-8 space-y-6" x-data="{ email: '{{ old('email') }}', password: '' }">
        <div class="text-center space-y-1">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 text-white font-bold text-lg flex items-center justify-center mx-auto shadow-sm">
                SB
            </div>
            <h1 class="text-2xl font-bold text-slate-900 pt-2">Masuk ke SiagaBunda</h1>
            <p class="text-sm text-slate-500">Sistem Edukasi & Monitoring Persiapan Persalinan</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" x-model="email" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none text-sm" placeholder="nama@email.com">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi</label>
                <input type="password" name="password" x-model="password" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 outline-none text-sm" placeholder="••••••••">
            </div>
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                    Ingat saya
                </label>
                <a href="{{ route('register') }}" class="font-semibold text-rose-600 hover:underline">Daftar Ibu Hamil</a>
            </div>
            <button type="submit" class="w-full py-3 rounded-xl bg-rose-600 text-white font-bold text-sm hover:bg-rose-700 shadow-sm transition">
                Masuk
            </button>
        </form>

        <div class="pt-4 border-t border-slate-100 space-y-2">
            <p class="text-xs font-semibold text-slate-400 uppercase text-center">Isi Cepat Akun Demo</p>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" @click="email='ibu.sari@siagabunda.id'; password='password'" class="px-3 py-2 rounded-xl bg-rose-50 text-rose-700 text-xs font-semibold hover:bg-rose-100 transition">
                    Demo Ibu Hamil
                </button>
                <button type="button" @click="email='bidan@siagabunda.id'; password='password'" class="px-3 py-2 rounded-xl bg-teal-50 text-teal-700 text-xs font-semibold hover:bg-teal-100 transition">
                    Demo Bidan / RS
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
