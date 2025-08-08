<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HistoryEventsController;
use App\Http\Controllers\HistoryTrainingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TrainingsController;
use App\Models\Coach;
use App\Models\Events;
use App\Models\Gallery;
use App\Models\HistoryEvents;
use App\Models\HistoryTrainings;
use App\Models\Member;
use App\Models\TeamPlayers;
use App\Models\Teams;
use App\Models\Trainings;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $coach = Coach::all();
    $gallery = Gallery::all();
    $events = Events::latest()->take(5)->get();
    return view('welcome',compact('coach','gallery','events'));
})->name('welcome');

Route::get('/dashboard', function () {
    $user = Auth::user();

    // If the user is a member
    if ($user->role === 'member') {
        $member = $user->member;
        $team = $member->team()->with(['coach.user', 'member.user'])->first();

        $trainingH = HistoryTrainings::all();
        $eventsH = HistoryEvents::all();
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
        $events = Events::orderBy('event_date', 'asc')->first();
        $isExpiringSoon = $member?->isExpiringSoon() ?? false;

        return view('dashboard', compact('team', 'trainingH', 'events', 'trainings', 'eventsH', 'isExpiringSoon'));
    }

    // If the user is a coach
    if ($user->role === 'coach') {
        $coach = $user->coach;
        $team = Teams::where('coach_id', $coach->id)->with('member.user')->first();
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
        $trainingH = HistoryTrainings::all();
        $eventsH = HistoryEvents::all();
        $events = Events::orderBy('event_date', 'asc')->first();

        return view('users.coach.dashboard', compact('team', 'trainingH', 'events', 'eventsH'));
    }

    abort(403, 'Access denied');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/myTraining', [TrainingsController::class, 'index'])->name('training.index');
    Route::get('/myEvents', [EventsController::class, 'index'])->name('event.index');
    Route::get('/myTeam', [TeamsController::class, 'index'])->name('team.index');
    Route::get('/galleries', [GalleryController::class, 'index'])->name('gallery.index');

    Route::get('/events/{id}/calendar', [EventsController::class, 'addToGoogleCalendar'])->name('events.downloadCalendar');
    Route::get('/eventHistory',[HistoryEventsController::class,'eventhistory'])->name('viewall.eventHistory');
    Route::get('/trainingHistory',[HistoryTrainingsController::class,'traininhistory'])->name('viewall.traininhistory');

});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin-auth.php';
