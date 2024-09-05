<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /**
     * Show the register form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('session.register');
    }

    /**
     * Handle the registration process and store the new user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        // Validate the incoming request data
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            'password' => ['required', 'min:5', 'max:20'],
            'agreement' => ['accepted'],
        ]);

        // Hash the password before storing it in the database
        $attributes['password'] = bcrypt($attributes['password']);

        // Flash a success message to the session
        session()->flash('success', 'Your account has been created.');

        // Create a new user with the validated attributes
        $user = User::create($attributes);

        // Log the user in
        Auth::login($user);

        // Redirect the user to the dashboard
        return redirect('/dashboard');
    }
}
