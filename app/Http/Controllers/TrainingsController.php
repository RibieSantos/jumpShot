<?php

namespace App\Http\Controllers;

use App\Models\HistoryTrainings;
use App\Models\TeamPlayers;
use App\Models\Teams;
use App\Models\TrainingHistory;
use App\Models\Trainings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingsController extends Controller
{
    public function show(Request $request)
    {
        $query = Trainings::query()
            ->join('teams', 'teams.id', '=', 'trainings.team_id')
            ->select('teams.name', 'trainings.*');

        //search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('trainings.training_date', 'like', "%$search%")
                ->orWhere('trainings.title', 'like', "%$search%")
                ->orWhere('teams.name', 'like', "%$search%")
                ->orWhere('trainings.focus', 'like', "%$search%")
                ->orWhere('trainings.location', 'like', "%$search%");
        }

        $sortField = $request->input('sort', 'id');
        $sortOrder = $request->input('direction', 'asc');
        $training = $query->orderBy($sortField, $sortOrder)->paginate(10);
        return view('admin.training', compact('sortField', 'sortOrder', 'training'));
    }

    public function create()
    {
        $teams = Teams::all();
        return view('admin.training.add-training', compact('teams'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required',
            'title' => 'required',
            'training_date' => 'required',
            'location' => 'required',
            'focus' => 'required'
        ]);

        Trainings::create([
            'team_id' => $request->team_id,
            'title' => $request->title,
            'training_date' => \Carbon\Carbon::parse($request->training_date),
            'location' => $request->location,
            'focus' => $request->focus
        ]);
        return redirect()->route('trainings.show')->with('success', 'Training seassion successfully created!');
    }
    public function edit(Trainings $trainings)
    {
        $teams = Trainings::join('teams', 'teams.id', '=', 'trainings.team_id')
            ->select('trainings.team_id', 'teams.name', 'trainings.training_date', 'trainings.location', 'trainings.focus')
            ->get();
        return view('admin.training.update-training', compact('trainings', 'teams'));
    }
    public function update(Request $request, Trainings $trainings)
    {
        $request->validate([
            'team_id' => 'required',
            'title' => 'required',
            'training_date' => 'required',
            'location' => 'required',
            'focus' => 'required'
        ]);

        $trainings->update([
            'team_id' => $request->team_id,
            'title' => $request->title,
            'training_date' => \Carbon\Carbon::parse($request->training_date),
            'location' => $request->location,
            'focus' => $request->focus
        ]);
        return redirect()->route('trainings.show')->with('success', 'Training seassion successfully updated!');
    }
    public function done(Request $request, Trainings $trainings)
    {
        $request->validate([
            'training_date' => 'required',
            'title' => 'required',
            'location' => 'required',
            'focus' => 'required'
        ]);
        HistoryTrainings::create([
            'training_date' => \Carbon\Carbon::parse($request->training_date),
            'location' => $request->location,
            'title' => $request->title,
            'focus' => $request->focus
        ]);
        $trainings->delete();
        return redirect()->route('trainings.show')->with('success', 'This training session is done!');
    }
    public function destroy(Trainings $training)
    {
        $training->delete();
        return redirect()->route('trainings.show')->with('success', 'Training successfully deleted!');
    }

    //Member Page
    public function index()
    {
        $user = Auth::user();
        $trainings = collect(); // default empty collection

        if ($user->role === 'member' && $user->member) {
            $member = $user->member;
            $teamId = TeamPlayers::where('member_id', $member->id)->pluck('team_id');
            $trainings = Trainings::whereIn('team_id', $teamId)->get();
        }

        if ($user->role === 'coach' && $user->coach) {
            $teamIds = $user->coach->team ? $user->coach->team->pluck('id') : collect();
            $trainings = Trainings::whereIn('team_id', $teamIds)->get();
        }
        return view('users.member.training', compact('trainings'));
    }
}
