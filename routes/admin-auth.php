<?php

use App\Http\Controllers\admin\auth\AuthenticatedSessionController;
use App\Http\Controllers\admin\auth\RegisteredUserController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HistoryEventsController;
use App\Http\Controllers\HistoryTrainingsController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TeamPlayerController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\TrainingsController;
use App\Http\Controllers\UserController;
use App\Models\Coach;
use App\Models\Member;
use App\Models\Trainings;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('admin.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    //dashboard
    Route::get('/dashboard', function () {
        $coach = Coach::count();
        $member = Member::count();
        $users = User::all();
        $training = Trainings::count();
        // Get recent users
        $user = User::latest()->take(5)->get();

        // User registrations per month
        $userGrowth = User::selectRaw('COUNT(*) as count, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        // Prepare data for chart
        $months = $userGrowth->pluck('month')->map(function ($month) {
            return Carbon::createFromFormat('Y-m', $month)->format('F Y');
        });;
        $counts = $userGrowth->pluck('count');
        return view('admin.dashboard', compact('member', 'users', 'coach', 'training', 'user', 'months', 'counts'));
    })->name('admin.dashboard');

    //Coach side
    Route::get('/coach', [CoachController::class, 'show'])->name('coach.show');
    Route::get('/coach/AddCoach', [CoachController::class, 'create'])->name('coach.create');
    Route::post('/coach/store', [CoachController::class, 'store'])->name('coach.store');
    Route::delete('/coach/{id}', [CoachController::class, 'destroy'])->name('coach.destroy');
    Route::get('coach/edit/{coach}', [CoachController::class, 'edit'])->name('coach.edit');
    Route::put('coach/update/{coach}', [CoachController::class, 'update'])->name('coach.update');

    //Members
    Route::get('/members', [MemberController::class, 'show'])->name('members.show');
    Route::get('/members/AddMember', [MemberController::class, 'create'])->name('member.create');
    Route::post('/members/store', [MemberController::class, 'store'])->name('member.store');
    Route::get('/members/edit/{member}', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/members/update/{member}', [MemberController::class, 'update'])->name('member.update');
    Route::delete('/members/destroy/{member}', [MemberController::class, 'destroy'])->name('member.destroy');

    //Trainings
    Route::get('/trainings', [TrainingsController::class, 'show'])->name('trainings.show');
    Route::get('/trainings/addTraining', [TrainingsController::class, 'create'])->name('trainings.create');
    Route::post('/trainings/addTraining/store', [TrainingsController::class, 'store'])->name('trainings.store');
    Route::get('/trainings/edit/{trainings}', [TrainingsController::class, 'edit'])->name('trainings.edit');
    Route::put('/trainings/update/{trainings}', [TrainingsController::class, 'update'])->name('trainings.update');
    Route::delete('/trainings/destroy/{training}', [TrainingsController::class, 'destroy'])->name('trainings.destroy');
    Route::post('/trainings/done/{trainings}', [TrainingsController::class, 'done'])->name('trainings.done');

    //Histories
    Route::get('/trainingHistory', [HistoryTrainingsController::class, 'show'])->name('trainingHistory.show');
    Route::get('/eventsHistory', [HistoryEventsController::class, 'show'])->name('eventsHistory.show');

    // users
    Route::get('/users', [UserController::class, 'show'])->name('user.show');
    Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/update/{user}', [UserController::class, 'update'])->name('user.update');

    //Teams
    Route::get('/teams', [TeamsController::class, 'show'])->name('teams.show');
    Route::get('/teams/AddTeam', [TeamsController::class, 'create'])->name('teams.create');
    Route::post('/teams/store', [TeamsController::class, 'store'])->name('teams.store');
    Route::get('/teams/edit/{teams}', [TeamsController::class, 'edit'])->name('teams.edit');
    Route::put('/teams/update/{teams}', [TeamsController::class, 'update'])->name('teams.update');
    Route::delete('/teams/destroy/{teams}', [TeamsController::class, 'destroy'])->name('teams.destroy');

    //Events
    Route::get('/events', [EventsController::class, 'show'])->name('events.show');
    Route::get('/events/addEvents', [EventsController::class, 'create'])->name('events.create');
    Route::post('/events/addEvents/store', [EventsController::class, 'store'])->name('events.store');
    Route::get('/events/editEvents/{event}', [EventsController::class, 'edit'])->name('events.edit');
    Route::put('/events/updateEvents/{event}', [EventsController::class, 'update'])->name('events.update');
    Route::post('/events/doneEvents/{event}', [EventsController::class, 'done'])->name('events.done');
    Route::delete('/events/destroy/{event}', [EventsController::class, 'destroy'])->name('events.destroy');

    // Team Players
    Route::get('/TeamPlayers', [TeamPlayerController::class, 'show'])->name('players.show');
    Route::get('/TeamPlayers/viewPlayers/{team_id}', [TeamPlayerController::class, 'view'])->name('players.view');
    Route::delete('/TeamPlayers/viewPlayers/{team_id}/{players}', [TeamPlayerController::class, 'destroy'])->name('players.destroy');
    Route::get('/TeamPlayers/createPlayers/{team_id}/create', [TeamPlayerController::class, 'create'])->name('players.create');
    Route::post('/TeamPlayers/createPlayers/{team_id}/store', [TeamPlayerController::class, 'store'])->name('players.store');
    Route::get('/TeamPlayers/addPlayers', [TeamPlayerController::class, 'show'])->name('players.show');

    //Gallery
    Route::get('/gallery',[GalleryController::class,'show'])->name('gallery.show');
    Route::get('/gallery/addImage',[GalleryController::class,'create'])->name('gallery.create');
    Route::post('/gallery/addImage/store',[GalleryController::class,'store'])->name('gallery.store');
    Route::delete('/gallery/deleteImage/destroy/{gallery}',[GalleryController::class,'destroy'])->name('gallery.destroy');

    Route::get('/profile',[AdminProfileController::class,'edit'])->name('admin.edit');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('admin.logout');
});
