<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     */
    public function create()
    {
        return view('auth.login');   // your login blade
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Try to login
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'These credentials do not match our records.',
                ]);
        }

        // SUCCESS: user logged in
        $request->session()->regenerate();

        // ❌ IMPORTANT: yahan koi "Invalid role for this user" check NAHI hoga
        // SuperAdmin, Admin, Member – sab login kar sakte hain.
        // Access control hum routes ke middleware se karenge.

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session (logout).
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
