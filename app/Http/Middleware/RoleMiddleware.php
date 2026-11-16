<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        if ($request->user()->role !== $role) {
            if ($request->user()->isHospitalStaff()) {
                return redirect()->route('hospital.dashboard')
                    ->with('error', 'Anda dialihkan ke Dashboard Rumah Sakit.');
            }

            return redirect()->route('patient.dashboard')
                ->with('error', 'Akses ditolak. Halaman ini khusus untuk Tenaga Kesehatan.');
        }

        return $next($request);
    }
}
