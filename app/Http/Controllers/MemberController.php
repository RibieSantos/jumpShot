<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function show(Request $request)
    {
        $query = Member::query()
            ->join('users', 'users.id', '=', 'members.user_id')
            ->selectRaw("CONCAT(users.lname, ', ', users.fname, IF(users.mname IS NOT NULL AND users.mname != '', CONCAT(' ', users.mname), '')) as member_name, members.*");


        // Search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereRaw("CONCAT(users.lname, ', ', users.fname, ' ', users.mname) LIKE ?", ["%$search%"])
                ->orWhere('members.birthdate', 'like', "%$search%")
                ->orWhere('members.age', 'like', "%$search%")
                ->orWhere('members.address', 'like', "%$search%")
                ->orWhere('members.contact_number', 'like', "%$search%");
        }

        $sortField = $request->input('sort', 'members.id');
        $sortOrder = $request->input('direction', 'asc');

        // Sorting
        if ($sortField === 'member_name') {
            // Sort using CONCAT in MySQL
            $member = $query->orderByRaw('CONCAT(users.lname, ", ", users.fname, " ", users.mname) ' . $sortOrder)->paginate(10);
        } else {
            $member = $query->orderBy($sortField, $sortOrder)->paginate(10);
        }

        $user = User::all();

        return view('admin.member', compact('member', 'user', 'sortField', 'sortOrder'));
    }


    public function create()
    {
        $existingUser = Member::pluck('user_id')->toArray();
        $users = User::whereNotIn('id', $existingUser)->get();
        return view('admin.member.add-member', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        Member::create([
            'user_id' => $request->user_id
        ]);
        // Update role of selected user
        $user = User::findOrFail($request->user_id);
        $user->update([
            'role' => 'member'
        ]);
        return redirect()->route('members.show')->with('success', 'Member is successfully added!');
    }

    public function edit(Member $member)
    {
        return view('admin.member.update-member', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birthdate' => 'required',
            'age' => 'required|integer',
            'contact_number' => 'required|string|max:11',
            'address' => 'required|string|max:100'
        ]);

        // Handle Image Upload
        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($member->image && file_exists(public_path('member/' . $member->profile_picture))) {
                unlink(public_path('member/' . $member->profile_picture));
            }

            // Save new image
            $image = $request->file('profile_picture');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('member'), $imageName);

            // Update member including new image
            $member->update([
                'profile_picture' => $imageName,
                'birthdate' => $request->birthdate,
                'age' => $request->age,
                'contact_number' => $request->contact_number,
                'address' => $request->address
            ]);
        } else {
            // Update without image
            $member->update([
                'birthdate' => $request->birthdate,
                'age' => $request->age,
                'contact_number' => $request->contact_number,
                'address' => $request->address
            ]);
        }

        return redirect()->route('members.show', $member)->with('success', 'Member successfully updated!');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        $user = User::findOrFail($member->user_id);
        $user->update([
            'role' => null
        ]);
        return redirect()->route('members.show')->with('success', 'Member successfully deleted!');
    }
}
