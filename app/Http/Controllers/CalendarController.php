<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function getEvents(Request $request)
    {
        $period = $request->input('period', 1);
        $startDate = now();
        $endDate = now()->addMonths($period);
        $events = DB::table('calendar')
            ->join('event_date', 'calendar.id', '=', 'event_date.event_id')
            ->join('event_location', 'calendar.id', '=', 'event_location.event_id')
            ->join('name', 'calendar.id', '=', 'name.event_id')
            ->select(
                'calendar.id',
                'calendar.team_code',
                'calendar.name AS event_name',
                'calendar.event_date',
                'calendar.participants_number',
                'event_date.start_date',
                'event_date.end_date',
                'event_location.country',
                'event_location.city',
                'event_location.sport_base',
                'event_location.centre',
                'name.discipline',
                'name.program',
                'name.gender',
                'name.age_group'
            )
            ->whereBetween('calendar.event_date', [$startDate, $endDate])
            ->get();

        return view('calendar.index', compact('events', 'startDate', 'endDate'));
    }

    public function getEventsByDate($date)
    {
        $events = DB::table('calendar')
            ->join('event_date', 'calendar.id', '=', 'event_date.event_id')
            ->join('event_location', 'calendar.id', '=', 'event_location.event_id')
            ->join('name', 'calendar.id', '=', 'name.event_id')
            ->select(
                'calendar.id',
                'calendar.team_code',
                'calendar.name AS event_name',
                'calendar.event_date',
                'calendar.participants_number',
                'event_date.start_date',
                'event_date.end_date',
                'event_location.country',
                'event_location.city',
                'event_location.sport_base',
                'event_location.centre',
                'name.discipline',
                'name.program',
                'name.gender',
                'name.age_group'
            )
            ->whereDate('calendar.event_date', $date)
            ->get();

        return view('calendar.modal', compact('events', 'date'));
    }

    public function addUserEvent(Request $request)
    {
        $userId = auth()->id();
        $eventId = $request->input('event_id');
        DB::table('userevents')->insert([
            'user_id' => $userId,
            'event_id' => $eventId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Мероприятие добавлено!');
    }

    public function updateEvent(Request $request, $id)
    {
        if (auth()->user()->role != 1) {
            return redirect()->route('calendar.index')->withErrors('У вас нет прав для изменения события.');
        }

        $validated = $request->validate([
            'team_code' => 'required|string|max:50',
            'participants_number' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'sport_base' => 'required|string|max:100',
            'centre' => 'required|string|max:100',
            'discipline' => 'required|string|max:100',
            'program' => 'required|string|max:100',
            'gender' => 'required|string|max:10',
            'age_group' => 'required|string|max:50',
        ]);
        DB::table('calendar')->where('id', $id)->update([
            'team_code' => $request->team_code,
            'participants_number' => $request->participants_number,
            'updated_at' => now(),
        ]);

        DB::table('event_date')->where('event_id', $id)->update([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'updated_at' => now(),
        ]);

        DB::table('event_location')->where('event_id', $id)->update([
            'country' => $request->country,
            'city' => $request->city,
            'sport_base' => $request->sport_base,
            'centre' => $request->centre,
            'updated_at' => now(),
        ]);

        DB::table('name')->where('event_id', $id)->update([
            'discipline' => $request->discipline,
            'program' => $request->program,
            'gender' => $request->gender,
            'age_group' => $request->age_group,
            'updated_at' => now(),
        ]);

        return redirect()->route('calendar.index')->with('message', 'Событие успешно обновлено.');
    }
    public function getUserProfile()
    {
        $userId = auth()->id();
        $userEvents = DB::table('userevents')
            ->join('calendar', 'userevents.event_id', '=', 'calendar.id')
            ->join('event_date', 'calendar.id', '=', 'event_date.event_id')
            ->join('event_location', 'calendar.id', '=', 'event_location.event_id')
            ->select(
                'calendar.name AS event_name',
                'event_date.start_date',
                'event_location.city',
                'event_location.country'
            )
            ->where('userevents.user_id', $userId)
            ->get();

        return view('user.profile', compact('userEvents'));
    }
}
