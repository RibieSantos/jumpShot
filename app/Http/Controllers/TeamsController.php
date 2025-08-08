<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Teams;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class TeamsController extends Controller
{
    public function show(Request $request)
    {
        $query = Teams::query()
            ->join('coaches', 'coaches.id', '=', 'teams.coach_id')
            ->join('users', 'users.id', '=', 'coaches.user_id')
            ->selectRaw("teams.id as team_id, teams.name, teams.coach_id, CONCAT(users.lname, ', ', users.fname, IF(users.mname IS NOT NULL AND users.mname != '', CONCAT(' ', users.mname), '')) as coach_name");


        // Search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereRaw("CONCAT(users.lname, ', ', users.fname, ' ', users.mname) LIKE ?", ["%$search%"])
                ->orWhere('teams.name', 'like', "%$search%");
        }

        $sortField = $request->input('sort', 'teams.id');
        $sortOrder = $request->input('direction', 'asc');

        // For sorting the combined field, only works if coach_name is selected in the front-end
        // $teams = $query->orderBy($sortField, $sortOrder)->paginate(10);
        // Sorting
        if ($sortField === 'coach_name') {
            // Sort using CONCAT in MySQL
            $teams = $query->orderByRaw('CONCAT(users.lname, ", ", users.fname, " ", users.mname) ' . $sortOrder)->paginate(10);
        } else {
            $teams = $query->orderBy($sortField, $sortOrder)->paginate(10);
        }

        return view('admin.teams', compact('sortField', 'sortOrder', 'teams'));
    }

    public function create()
    {
        $existingUser = Teams::pluck('coach_id')->toArray();
        $coach = Coach::join('users', 'users.id', '=', 'coaches.user_id')
            ->whereNotIn('coaches.id', $existingUser)
            ->select('coaches.id', 'users.fname', 'users.mname', 'users.lname')
            ->get();
        return view('admin.teams.add-teams', compact('coach'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'coach_id' => 'required',
            'name' => 'required'
        ]);

        Teams::create([
            'coach_id' => $request->coach_id,
            'name' => $request->name
        ]);
        return redirect()->route('teams.show')->with('success', 'Teams is successfully added!');
    }
    public function edit(Teams $teams)
    {
        $coach = Coach::join('users', 'users.id', '=', 'coaches.user_id')
            ->select('coaches.id as coach_id', 'users.fname', 'users.mname', 'users.lname')
            ->get();
        return view('admin.teams.update-teams', compact('teams', 'coach'));
    }
    public function update(Request $request, Teams $teams)
    {
        $request->validate([
            'coach_id' => 'required',
            'name' => 'required'
        ]);
        $teams->update([
            'coach_id' => $request->coach_id,
            'name' => $request->name
        ]);
        return redirect()->route('teams.show')->with('success', 'Team updated successfully!');
    }
    public function destroy(Teams $teams)
    {
        $teams->delete();
        return redirect()->route('teams.show')->with('success', 'Teams successfully deleted!');
    }

    public function index()
    {
        $user = FacadesAuth::user();
        if ($user->role === 'member') {
            $member = $user->member;
            $team = $member->team()->with(['coach.user', 'member.user'])->first();
        } else {
            $coach = $user->coach;
            $team = $coach->team()->with(['coach.user', 'member.user'])->first();
        }

        return view('users.member.team', compact('team'));
    }
}
