<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request){
        $query = User::query();

        //search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('fname','like',"%$search%")
            ->orWhere('mname','like',"%$search%")
            ->orWhere('lname','like',"%$search%")
            ->orWhere('role','like',"%$search%")
            ->orWhere('status','like',"%$search%")
            ->orWhere('email','like',"%$search%");
        }

        $sortField = $request->input('sort','id');
        $sortOrder = $request->input('direction','asc');
        $users = $query->orderBy($sortField,$sortOrder)->paginate(10);

        return view('admin.users',compact('users', 'sortField', 'sortOrder'));
    }
    public function edit(User $user){

        return view('admin.user.update-user', compact('user'));
    }

    public function update(Request $request,User $user){
        $request->validate([
            // 'fname'=> 'required',
            // 'mname'=> 'required',
            // 'lname'=> 'required',
            // 'email'=> 'required',
            'status'=> 'required',
            // 'image',
            
        ]);

        $user->update([
            // 'fname' => $request->fname,
            // 'mname' => $request->mname,
            // 'lname' => $request->lname,
            // 'email' => $request->email,
            'status' => $request->status,
            // 'image' => $request->image,
        ]);
        return redirect()->route('user.show',compact('user'))->with('success','User successfully updated!');
    }
}
