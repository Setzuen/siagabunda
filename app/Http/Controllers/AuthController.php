<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\PregnancyProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectByRole(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi tidak sesuai.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:30'],
            'hpht' => ['nullable', 'date'],
            'blood_type' => ['nullable', 'string', 'max:10'],
            'referral_hospital' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => 'patient',
            'password' => Hash::make($validated['password']),
        ]);

        $hpht = ! empty($validated['hpht']) ? Carbon::parse($validated['hpht']) : Carbon::now()->subWeeks(28);
        $dueDate = (clone $hpht)->addDays(280);

        PregnancyProfile::create([
            'user_id' => $user->id,
            'hpht' => $hpht->toDateString(),
            'due_date' => $dueDate->toDateString(),
            'blood_type' => $validated['blood_type'] ?? 'Belum diketahui',
            'referral_hospital' => $validated['referral_hospital'] ?? 'RSIA Kasih Bunda',
            'gravida_para' => 'G1P0A0',
            'risk_level' => 'rendah',
        ]);

        foreach (User::defaultChecklistItems() as $item) {
            Checklist::create([
                'user_id' => $user->id,
                'category' => $item['category'],
                'title' => $item['title'],
                'description' => $item['description'],
                'is_completed' => false,
            ]);
        }

        Auth::login($user);

        return redirect()->route('patient.dashboard')
            ->with('success', 'Selamat datang di SiagaBunda! Akun & Checklist P4K Anda telah dibuat.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar dari sistem.');
    }

    private function redirectByRole(User $user)
    {
        if ($user->isHospitalStaff()) {
            return redirect()->route('hospital.dashboard');
        }

        return redirect()->route('patient.dashboard');
    }
}
