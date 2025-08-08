<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\TeamPlayers;
use App\Models\Teams;
use App\Models\User;
use Illuminate\Http\Request;

class TeamPlayerController extends Controller
{
    public function show(Teams $team_id)
    {

        $teams = Teams::query()
            ->join('coaches', 'coaches.id', '=', 'teams.coach_id')
            ->join('users', 'users.id', '=', 'coaches.user_id')
            ->selectRaw("CONCAT(users.lname, ', ', users.fname, IF(users.mname IS NOT NULL AND users.mname != '', CONCAT(' ', users.mname), '')) AS coach_name,teams.*,coaches.profile_picture")
            ->get();

        return view('admin.team-player', compact('teams'));
    }

    public function view(Request $request, $id)
    {
        $team_id = $id;

        // Get coach/team info separately
        $teamInfo = Teams::join('coaches', 'coaches.id', '=', 'teams.coach_id')
            ->join('users', 'users.id', '=', 'coaches.user_id')
            ->selectRaw("
            teams.id,
            teams.name as team_name,
            CONCAT(users.lname, ', ', users.fname, IF(users.mname IS NOT NULL AND users.mname != '', CONCAT(' ', users.mname), '')) AS coach_name,
            coaches.profile_picture as coach_profile
        ")
            ->where('teams.id', $team_id)
            ->first();

        // Get players
        $query = Teams::join('team_players', 'team_players.team_id', '=', 'teams.id')
            ->join('members', 'members.id', '=', 'team_players.member_id')
            ->join('users', 'users.id', '=', 'members.user_id')
            ->join('coaches', 'coaches.id', '=', 'teams.coach_id')
            ->join('users as coach_users', 'coach_users.id', '=', 'coaches.user_id')
            ->selectRaw("
            teams.name,
            coaches.profile_picture as coach_profile,
            members.profile_picture as member_profile,
            CONCAT(coach_users.lname, ', ', coach_users.fname, IF(coach_users.mname IS NOT NULL AND coach_users.mname != '', CONCAT(' ', coach_users.mname), '')) AS coach_name,
            CONCAT(users.lname, ', ', users.fname, IF(users.mname IS NOT NULL AND users.mname != '', CONCAT(' ', users.mname), '')) AS player_name,
            team_players.id as teamplayer_id,
            teams.id as team_id
        ")
            ->where('teams.id', $team_id);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereRaw("CONCAT(users.lname, ', ', users.fname, ' ', IFNULL(users.mname, '')) LIKE ?", ["%$search%"]);
        }

        $sortField = $request->input('sort', 'team_players.id');
        $sortOrder = $request->input('direction', 'asc');

        if ($sortField === 'player_name') {
            $query->orderByRaw("CONCAT(users.lname, ', ', users.fname, ' ', IFNULL(users.mname, '')) $sortOrder");
        } else {
            $query->orderBy($sortField, $sortOrder);
        }

        $players = $query->paginate(10)->withQueryString();

        return view('admin.teamPlayer.view-teamplayer', compact('players', 'sortField', 'sortOrder', 'team_id', 'teamInfo'));
    }

    public function destroy($team_id, TeamPlayers $players)
    {
        $players->delete();

        return redirect()->route('players.view', ['team_id' => $team_id])
            ->with('success', 'Player deleted successfully!');
    }

    public function create($team_id)
{
    // Get all member IDs already assigned to any team
    $existingMemberIds = TeamPlayers::pluck('member_id')->toArray();

    // Get only members NOT yet assigned to a team
    $members = Member::whereNotIn('id', $existingMemberIds)
        ->with('user')        // eager load related user
        ->whereHas('user')    // make sure member has a user
        ->get();

    return view('admin.teamPlayer.add-teamplayer', compact('members', 'team_id'));
}


    public function store(Request $request, $team_id)
{
    $validated = $request->validate([
        'member_id' => 'required|exists:members,id'
    ]);

    // Check if the player is already in the team
    $exists = TeamPlayers::where('team_id', $team_id)
        ->where('member_id', $validated['member_id'])
        ->exists();

    if ($exists) {
        return redirect()->back()->withInput()->with('error', 'Member is already part of the team.');
    }

    TeamPlayers::create([
        'team_id' => $team_id,
        'member_id' => $validated['member_id'],
    ]);

    return redirect()->route('players.view', $team_id)->with('success', 'Player successfully added.');
}

}
