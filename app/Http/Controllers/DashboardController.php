<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers     = User::count();
        $totalSchedules = Schedule::where('user_id', Auth::id())->count();

        // Schedules per day of the week for the logged-in user
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        $schedulesByDay = Schedule::where('user_id', Auth::id())
            ->select('day', DB::raw('count(*) as count'))
            ->groupBy('day')
            ->pluck('count', 'day')
            ->toArray();

        $dayLabels  = $days;
        $dayCounts  = array_map(fn($d) => $schedulesByDay[$d] ?? 0, $days);

        // Subjects distribution (top subjects across all users)
        $subjectDist = Schedule::where('user_id', Auth::id())
            ->select('subject_name', DB::raw('count(*) as count'))
            ->groupBy('subject_name')
            ->orderByDesc('count')
            ->limit(6)
            ->get();

        // Recent schedules
        $recentSchedules = Schedule::where('user_id', Auth::id())
            ->latest()
            ->limit(5)
            ->get();

        // New users in the last 7 days
        $newUsersThisWeek = User::where('created_at', '>=', now()->subDays(7))->count();

        // Schedules by semester
        $bySemester = Schedule::where('user_id', Auth::id())
            ->select('semester', DB::raw('count(*) as count'))
            ->groupBy('semester')
            ->pluck('count', 'semester')
            ->toArray();

        return view('dashboard.index', compact(
            'totalUsers',
            'totalSchedules',
            'dayLabels',
            'dayCounts',
            'subjectDist',
            'recentSchedules',
            'newUsersThisWeek',
            'bySemester'
        ));
    }
}
