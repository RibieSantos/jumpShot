<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\HistoryEvents;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function show(Request $request)
    {
        $query = Events::query();
        //search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%")
                ->orWhere('event_date', 'like', "%$search%")
                ->orWhere('location', 'like', "%$search%");
        }

        $sortField = $request->input('sort', 'id');
        $sortOrder = $request->input('direction', 'asc');
        $events = $query->orderBy($sortField, $sortOrder)->paginate(10);
        return view('admin.events', compact('sortField', 'sortOrder', 'events'));
    }

    public function create()
    {
        return view('admin.event.add-events');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        // Initialize image name as null
        $imageName = null;

        if ($request->hasFile('event_image')) {
            $image = $request->file('event_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('events'), $imageName);
        }

        Events::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'event_image' => $imageName // Will be null if no image uploaded
        ]);

        return redirect()->route('events.show')->with('success', 'Event successfully added!');
    }

    public function edit(Events $event)
    {
        return view('admin.event.update-events', compact('event'));
    }

    public function update(Request $request, Events $event)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Check if a new image is uploaded
        if ($request->hasFile('event_image')) {
            // Delete old image if it exists
            if ($event->event_image && file_exists(public_path('events/' . $event->event_image))) {
                unlink(public_path('events/' . $event->event_image));
            }

            // Save the new image
            $image = $request->file('event_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('events'), $imageName);

            // Update with new image
            $event->update([
                'title' => $request->title,
                'description' => $request->description,
                'event_date' => $request->event_date,
                'location' => $request->location,
                'event_image' => $imageName
            ]);
        } else {
            // Update without changing image
            $event->update([
                'title' => $request->title,
                'description' => $request->description,
                'event_date' => $request->event_date,
                'location' => $request->location
            ]);
        }

        return redirect()->route('events.show')->with('success', 'Event successfully updated!');
    }

    public function done(Request $request, Events $event)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'required|string',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        HistoryEvents::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'location' => $request->location,
        ]);
        // Delete old image if it exists
        if ($event->event_image && file_exists(public_path('events/' . $event->event_image))) {
            unlink(public_path('events/' . $event->event_image));
        }
        $event->delete();
        return redirect()->route('events.show')->with('success', 'this event session is done!');
    }

    public function destroy(Events $event)
    {
        // Delete old image if it exists
        if ($event->event_image && file_exists(public_path('events/' . $event->event_image))) {
            unlink(public_path('events/' . $event->event_image));
        }
        $event->delete();

        return redirect()->route('events.show')->with('success', 'Event successfully deleted!');
    }

    //Member Page
    public function index()
    {
        $events = Events::orderBy('event_date', 'asc')->get();
        return view('users.member.event', compact('events'));
    }

    public function addToGoogleCalendar($id)
    {
        $event = Events::findOrFail($id);

        $start = \Carbon\Carbon::parse($event->event_date)->format('Ymd\THis');

        $query = http_build_query([
            'action'   => 'TEMPLATE',
            'text'     => $event->title,
            'dates'    => "{$start}",
            'details'  => $event->description,
            'location' => $event->location,
            'sf'       => 'true',
            'output'   => 'xml',
        ]);

        return redirect()->away("https://calendar.google.com/calendar/render?$query");
    }

    
}
