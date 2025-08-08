<?php

namespace App\Http\Controllers;

use App\Models\HistoryEvents;
use Illuminate\Http\Request;

class HistoryEventsController extends Controller
{
    public function show(Request $request){
        $query = HistoryEvents::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('event_date', 'like', "%$search%")
                ->orWhere('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('location', 'like', "%$search%");
        }

        $sortField = $request->input('sort', 'id');
        $sortOrder = $request->input('direction', 'asc');
        $event = $query->orderBy($sortField, $sortOrder)->paginate(10);
        return view('admin.event.event-history',compact('event','sortField','sortOrder'));
    }

    public function eventhistory(){
        $eventH = HistoryEvents::all();
        return view('users.member.eventHistory',compact('eventH'));
    }
}
