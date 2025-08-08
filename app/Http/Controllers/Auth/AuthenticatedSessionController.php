<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check status after authentication
    $user = Auth::user();

    if ($user->status === 'inactive') {
        Auth::logout(); // 🔴 log the user out
        $request->session()->invalidate(); // optional but safer
        $request->session()->regenerateToken(); // prevent CSRF issues
        return redirect()->route('welcome')->with('warning','You are not yet active. Please contact my Email!');
    }

    return redirect()->intended(route('dashboard', absolute: false))->with('success','Welcome back!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
