<?php

namespace App\Http\Controllers;

use App\Models\EducationContent;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HospitalController extends Controller
{
    public function dashboard(Request $request)
    {
        $search = $request->query('search');
        $riskFilter = $request->query('risk');

        $patients = User::where('role', 'patient')
            ->with(['pregnancyProfile', 'checklists', 'schedules'])
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($riskFilter, function ($q) use ($riskFilter) {
                $q->whereHas('pregnancyProfile', fn ($pq) => $pq->where('risk_level', $riskFilter));
            })
            ->get();

        $totalPatients = $patients->count();
        $avgReadiness = $totalPatients > 0
            ? (int) round($patients->avg(fn ($p) => $p->readinessPercentage()))
            : 0;
        $highRiskCount = $patients->filter(fn ($p) => optional($p->pregnancyProfile)->risk_level === 'tinggi')->count();
        $upcomingAncCount = Schedule::where('status', 'upcoming')->where('type', 'anc')->count();

        return view('hospital.dashboard', compact(
            'patients',
            'totalPatients',
            'avgReadiness',
            'highRiskCount',
            'upcomingAncCount',
            'search',
            'riskFilter'
        ));
    }

    public function showPatient(User $patient)
    {
        if (! $patient->isPatient()) {
            abort(404);
        }

        $patient->load(['pregnancyProfile', 'checklists', 'schedules']);
        $readiness = $patient->readinessPercentage();

        return view('hospital.patient_detail', compact('patient', 'readiness'));
    }

    public function updatePatientRisk(Request $request, User $patient)
    {
        $validated = $request->validate([
            'risk_level' => ['required', 'in:rendah,sedang,tinggi'],
            'notes' => ['nullable', 'string'],
        ]);

        $patient->pregnancyProfile()->updateOrCreate(
            ['user_id' => $patient->id],
            [
                'risk_level' => $validated['risk_level'],
                'notes' => $validated['notes'],
            ]
        );

        return back()->with('success', "Status risiko & catatan medis {$patient->name} berhasil diperbarui.");
    }

    public function storePatientSchedule(Request $request, User $patient)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:anc,persiapan,tanda_bahaya'],
        ]);

        $patient->schedules()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'event_date' => $validated['event_date'],
            'location' => $validated['location'] ?? optional($patient->pregnancyProfile)->referral_hospital ?? 'Poli KIA',
            'type' => $validated['type'],
            'status' => 'upcoming',
        ]);

        return back()->with('success', "Jadwal baru berhasil dikirim ke akun {$patient->name}.");
    }

    public function exportCsv()
    {
        $patients = User::where('role', 'patient')
            ->with(['pregnancyProfile', 'checklists'])
            ->get();

        $filename = 'rekap_responden_siagabunda_'.now()->format('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($patients) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM so Microsoft Excel opens Indonesian characters properly
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'ID Responden',
                'Nama Ibu Hamil',
                'Email',
                'No HP / WhatsApp',
                'Gravida/Para',
                'Usia Kehamilan (Minggu)',
                'HPL',
                'Golongan Darah',
                'Faskes Rujukan',
                'Tingkat Risiko',
                'Skor Kesiapan P4K (%)',
                'Checklist Selesai',
                'Catatan Nakes',
            ]);

            foreach ($patients as $p) {
                $prof = $p->pregnancyProfile;
                $done = $p->checklists->where('is_completed', true)->count();
                $total = $p->checklists->count();

                fputcsv($handle, [
                    $p->id,
                    $p->name,
                    $p->email,
                    $p->phone ?? '-',
                    $prof->gravida_para ?? '-',
                    $prof?->gestationalWeeks() ?? '-',
                    $prof?->due_date?->format('Y-m-d') ?? '-',
                    $prof->blood_type ?? '-',
                    $prof->referral_hospital ?? '-',
                    strtoupper($prof->risk_level ?? 'rendah'),
                    $p->readinessPercentage().'%',
                    "{$done}/{$total}",
                    $prof->notes ?? '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function education()
    {
        $contents = EducationContent::latest()->get();

        return view('hospital.education', compact('contents'));
    }

    public function storeEducation(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'summary' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'video_url' => ['nullable', 'url'],
        ]);

        EducationContent::create([
            'slug' => Str::slug($validated['title']).'-'.Str::random(4),
            'title' => $validated['title'],
            'category' => $validated['category'],
            'summary' => $validated['summary'],
            'content' => $validated['content'],
            'video_url' => $validated['video_url'] ?? null,
            'is_published' => true,
        ]);

        return back()->with('success', 'Materi edukasi baru berhasil dipublikasikan ke halaman Ibu Hamil.');
    }

    public function destroyEducation(EducationContent $education)
    {
        $education->delete();

        return back()->with('success', 'Materi edukasi berhasil dihapus.');
    }
}
