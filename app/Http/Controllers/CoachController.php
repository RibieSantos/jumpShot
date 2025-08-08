<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\User;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function show(Request $request)
    {
        $query = Coach::query()
            ->join('users', 'users.id', '=', 'coaches.user_id')
            ->selectRaw("CONCAT(users.lname, ', ', users.fname, IF(users.mname IS NOT NULL AND users.mname != '', CONCAT(' ', users.mname), '')) as coach_name, coaches.*");

        //search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereRaw("CONCAT(users.lname, ', ', users.fname, ' ', users.mname) LIKE ?", ["%$search%"])
                ->orWhere('coaches.experience_level', 'like', "%$search%")
                ->orWhere('coaches.profile_picture', 'like', "%$search%")
                ->orWhere('coaches.bio', 'like', "%$search%");
        }

        $sortField = $request->input('sort', 'coaches.id');
        $sortOrder = $request->input('direction', 'asc');
        // Sorting
        if ($sortField === 'coach_name') {
            // Sort using CONCAT in MySQL
            $coach = $query->orderByRaw('CONCAT(users.lname, ", ", users.fname, " ", users.mname) ' . $sortOrder)->paginate(10);
        } else {
            $coach = $query->orderBy($sortField, $sortOrder)->paginate(10);
        }
        // $coach = $query->orderBy($sortField, $sortOrder)->paginate(10);
        return view('admin.coach', compact('sortField', 'sortOrder', 'coach'));
    }

    public function create()
    {
        $existingUser = Coach::pluck('user_id')->toArray();
        $users = User::whereNotIn('id', $existingUser)->get();
        return view('admin.coach.add-coach', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'experience_level' => 'required'
        ]);

        Coach::create([
            'user_id' => $request->user_id,
            'experience_level' => $request->experience_level
        ]);
        // Update role of selected user
        $user = User::findOrFail($request->user_id);
        $user->update([
            'role' => 'coach'
        ]);
        return redirect()->route('coach.show')->with('success', 'Coach is successfully added!');
    }

    public function edit(Coach $coach)
    {
        return view('admin.coach.update-coach', compact('coach'));
    }

    public function update(Request $request, Coach $coach)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'required',
            'birthdate' => 'required',
            'experience_level' => 'required'
        ]);


        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($coach->profile_picture && file_exists(public_path('coach/' . $coach->profile_picture))) {
                unlink(public_path('coach/' . $coach->profile_picture));
            }

            // Save new image
            $image = $request->file('profile_picture');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('coach'), $imageName);

            $coach->update([
                'profile_picture' => $imageName,
                'bio' => $request->bio,
                'birthdate' => $request->birthdate,
                'experience_level' => $request->experience_level
            ]);
        } else {
            $coach->update([
                'bio' => $request->bio,
                'birthdate' => $request->birthdate,
                'experience_level' => $request->experience_level
            ]);
        }



        return redirect()->route('coach.show', $coach)->with('success', 'Coach successfully updated!');
    }

    public function destroy(Coach $id)
    {
        $id->delete();
     
        $user = User::findOrFail($id->user_id);
        $user->update([
            'role' => null
        ]);
    
        return redirect()->route('coach.show')->with('success', 'Coach is successfully Deleted!');
    }
}
