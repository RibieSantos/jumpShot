<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function edit(){
        $admin = Auth::user();
        return view('admin.profile.edit', compact('admin'));
    }
}
