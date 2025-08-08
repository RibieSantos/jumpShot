<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $member = $user->member;
        $coach = $user->coach;

        return view('profile.edit', [
            'user' => $user,
            'member' => $member,
            'coach' => $coach,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->update([
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($user->member) {
            $member = $user->member;

            $imageName = $member->profile_picture; // Keep existing if no new one is uploaded

            if ($request->hasFile('profile_picture')) {
                // Delete old image if exists
                if ($member->profile_picture && file_exists(public_path('member/' . $member->profile_picture))) {
                    unlink(public_path('member/' . $member->profile_picture));
                }

                // Save new image
                $image = $request->file('profile_picture');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('member'), $imageName);
            }

            $member->update([
                'birthdate' => $request->input('birthdate'),
                'age' => $request->input('age'),
                'address' => $request->input('address'),
                'contact_number' => $request->input('contact_number'),
                'profile_picture' => $imageName
            ]);
        }

        if ($user->coach) {
            $coach = $user->coach;

            $imageName = $coach->profile_picture; // Keep existing if no new one is uploaded

            if ($request->hasFile('profile_picture')) {
                // Delete old image if exists
                if ($coach->profile_picture && file_exists(public_path('coach/' . $coach->profile_picture))) {
                    unlink(public_path('coach/' . $coach->profile_picture));
                }

                // Save new image
                $image = $request->file('profile_picture');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('coach'), $imageName);
            }

            $coach->update([
                'experience_level' => $request->input('experience_level'),
                'bio' => $request->input('bio'),
                'specialty' => $request->input('specialty'),
                'profile_picture' => $imageName
            ]);
        }


        return Redirect::route('profile.edit')->with('status', 'Profile updated successfully!');
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // Admin Profile
    
}
