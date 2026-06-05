<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    private array $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    private array $semesters = ['1st Semester', '2nd Semester', 'Summer'];

    private array $colors = [
        '#2d6a4f', '#40916c', '#52b788', '#74c69d',
        '#1e6091', '#1a759f', '#168aad', '#34a0a4',
        '#7b2d8b', '#9c4bc3', '#e9c46a', '#f4a261',
    ];

    public function index(Request $request)
    {
        $search = $request->query('search');
        $filterDay = $request->query('day');

        $schedules = Schedule::where('user_id', Auth::id())
            ->when($search, fn($q) => $q->where('subject_name', 'like', "%$search%")
                ->orWhere('subject_code', 'like', "%$search%")
                ->orWhere('instructor', 'like', "%$search%"))
            ->when($filterDay, fn($q) => $q->where('day', $filterDay))
            ->orderByRaw("FIELD(day, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->orderBy('start_time')
            ->paginate(10)
            ->withQueryString();

        return view('schedules.index', [
            'schedules' => $schedules,
            'search'    => $search,
            'filterDay' => $filterDay,
            'days'      => $this->days,
        ]);
    }

    public function create()
    {
        return view('schedules.create', [
            'days'      => $this->days,
            'semesters' => $this->semesters,
            'colors'    => $this->colors,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_name' => ['required', 'string', 'max:255'],
            'subject_code' => ['required', 'string', 'max:50'],
            'instructor'   => ['required', 'string', 'max:255'],
            'room'         => ['required', 'string', 'max:100'],
            'day'          => ['required', 'in:' . implode(',', $this->days)],
            'start_time'   => ['required', 'date_format:H:i'],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'semester'     => ['required', 'in:' . implode(',', $this->semesters)],
            'school_year'  => ['required', 'string', 'max:20'],
            'color'        => ['nullable', 'string', 'max:20'],
        ]);

        $data['user_id'] = Auth::id();
        $data['color']   = $data['color'] ?? $this->colors[array_rand($this->colors)];

        Schedule::create($data);

        return redirect()->route('schedules.index')
            ->with('toast_success', 'Schedule for "' . $data['subject_name'] . '" added successfully!');
    }

    public function edit(Schedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        return view('schedules.edit', [
            'schedule'  => $schedule,
            'days'      => $this->days,
            'semesters' => $this->semesters,
            'colors'    => $this->colors,
        ]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $this->authorizeSchedule($schedule);

        $data = $request->validate([
            'subject_name' => ['required', 'string', 'max:255'],
            'subject_code' => ['required', 'string', 'max:50'],
            'instructor'   => ['required', 'string', 'max:255'],
            'room'         => ['required', 'string', 'max:100'],
            'day'          => ['required', 'in:' . implode(',', $this->days)],
            'start_time'   => ['required', 'date_format:H:i'],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'semester'     => ['required', 'in:' . implode(',', $this->semesters)],
            'school_year'  => ['required', 'string', 'max:20'],
            'color'        => ['nullable', 'string', 'max:20'],
        ]);

        $schedule->update($data);

        return redirect()->route('schedules.index')
            ->with('toast_success', 'Schedule for "' . $schedule->subject_name . '" updated successfully!');
    }

    public function destroy(Schedule $schedule)
    {
        $this->authorizeSchedule($schedule);
        $name = $schedule->subject_name;
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('toast_success', '"' . $name . '" schedule has been deleted.');
    }

    private function authorizeSchedule(Schedule $schedule): void
    {
        if ($schedule->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
