<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\EducationContent;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $profile = $user->pregnancyProfile;
        $checklists = $user->checklists()->get();
        $completedCount = $checklists->where('is_completed', true)->count();
        $totalCount = $checklists->count();
        $readiness = $totalCount > 0 ? (int) round(($completedCount / $totalCount) * 100) : 0;

        $upcomingSchedules = $user->schedules()
            ->where('status', 'upcoming')
            ->orderBy('event_date')
            ->take(3)
            ->get();

        $dangerEdu = EducationContent::where('category', 'tanda_bahaya')->first();

        return view('patient.dashboard', compact(
            'user',
            'profile',
            'checklists',
            'completedCount',
            'totalCount',
            'readiness',
            'upcomingSchedules',
            'dangerEdu'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        $profile = $user->pregnancyProfile;

        return view('patient.profile', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'hpht' => ['required', 'date'],
            'blood_type' => ['required', 'string', 'max:10'],
            'referral_hospital' => ['required', 'string', 'max:255'],
            'gravida_para' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
        ]);

        $hpht = Carbon::parse($validated['hpht']);
        $dueDate = (clone $hpht)->addDays(280);

        $user->pregnancyProfile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'hpht' => $hpht->toDateString(),
                'due_date' => $dueDate->toDateString(),
                'blood_type' => $validated['blood_type'],
                'referral_hospital' => $validated['referral_hospital'],
                'gravida_para' => $validated['gravida_para'] ?? 'G1P0A0',
            ]
        );

        return back()->with('success', 'Profil & Hari Perkiraan Lahir (HPL) berhasil diperbarui.');
    }

    public function education(Request $request)
    {
        $category = $request->query('category', 'all');
        $articles = EducationContent::where('is_published', true)
            ->where('category', '!=', 'video')
            ->when($category !== 'all' && $category !== 'video', fn ($q) => $q->where('category', $category))
            ->get();

        $videos = EducationContent::where('is_published', true)
            ->where('category', 'video')
            ->get();

        return view('patient.education', compact('articles', 'videos', 'category'));
    }

    public function checklist()
    {
        $user = Auth::user();
        $checklists = $user->checklists()->get();
        $completedCount = $checklists->where('is_completed', true)->count();
        $totalCount = $checklists->count();
        $readiness = $totalCount > 0 ? (int) round(($completedCount / $totalCount) * 100) : 0;

        return view('patient.checklist', compact('checklists', 'completedCount', 'totalCount', 'readiness'));
    }

    public function updateChecklist(Request $request, Checklist $checklist)
    {
        if ($checklist->user_id !== Auth::id()) {
            abort(403);
        }

        $checklist->update([
            'is_completed' => $request->has('is_completed') ? (bool) $request->input('is_completed') : ! $checklist->is_completed,
            'details' => $request->input('details', $checklist->details),
        ]);

        return back()->with('success', "Item '{$checklist->title}' berhasil diperbarui.");
    }

    public function reminders()
    {
        $user = Auth::user();
        $schedules = $user->schedules()->orderBy('event_date')->get();

        return view('patient.reminders', compact('schedules'));
    }

    public function storeReminder(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:anc,persiapan,tanda_bahaya'],
        ]);

        Auth::user()->schedules()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'event_date' => $validated['event_date'],
            'location' => $validated['location'] ?? 'Rumah / Faskes',
            'type' => $validated['type'],
            'status' => 'upcoming',
        ]);

        return back()->with('success', 'Agenda pengingat baru berhasil ditambahkan.');
    }

    public function toggleReminder(Schedule $schedule)
    {
        if ($schedule->user_id !== Auth::id()) {
            abort(403);
        }

        $schedule->update([
            'status' => $schedule->status === 'upcoming' ? 'completed' : 'upcoming',
        ]);

        return back()->with('success', 'Status agenda diperbarui.');
    }

    public function emergency()
    {
        $user = Auth::user();
        $profile = $user->pregnancyProfile;
        $dangerEdu = EducationContent::where('category', 'tanda_bahaya')->first();

        return view('patient.emergency', compact('user', 'profile', 'dangerEdu'));
    }
}
