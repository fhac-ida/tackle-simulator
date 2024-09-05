<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    /**
     * Show the login form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('session.login-session');
    }

    /**
     * Handle the login request and authenticate the user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        // Validate the incoming request data
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt($attributes)) {
            // Regenerate the session ID to prevent session fixation attacks
            session()->regenerate();

            // Redirect to the maps index page with a success message
            return redirect(route('maps.index'))->with(['success' => 'You are logged in.']);
        } else {
            // If authentication fails, redirect back to the login form with an error message
            return back()->withErrors(['email' => 'Email or password invalid.']);
        }
    }

    /**
     * Log the user out and invalidate the session
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        // Log the user out, invalidating their session
        Auth::logout();

        // Redirect to the login page with a success message
        return redirect('/login')->with(['success' => 'You\'ve been logged out.']);
    }
}
