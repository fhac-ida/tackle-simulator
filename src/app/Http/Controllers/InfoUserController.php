<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InfoUserController extends Controller
{
    public function create()
    {
        return view('laravel-examples/user-profile');
    }

    /**
     * Store or return the users profile Information
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        // Validate the incoming request data, ensuring that the fields meet the required criteria
        $attributes = request()->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
            'phone' => ['max:50'],
            'location' => ['max:70'],
            'about_me' => ['max:150'],
        ]);
        // If the email in the request is different from the current user's email
        if ($request->get('email') != Auth::user()->email) {
            // Check if the environment is a demo version and if the user is the demo user (id == 1)
            if (env('IS_DEMO') && Auth::user()->id == 1) {
                // If in demo mode, prevent changing the email and return an error message
                return redirect()->back()->withErrors(['msg2' => 'You are in a demo version, you can\'t change the email address.']);
            }
        } else {
            // If the email hasn't changed, revalidate the email to ensure it meets the criteria.
            $attribute = request()->validate([
                'email' => ['required', 'email', 'max:50', Rule::unique('users')->ignore(Auth::user()->id)],
            ]);
        }

        // Update the user's profile information in the database
        User::where('id', Auth::user()->id)
            ->update([
                'name' => $attributes['name'],
                'email' => $attribute['email'],
                'phone' => $attributes['phone'],
                'location' => $attributes['location'],
                'about_me' => $attributes['about_me'],
            ]);

        // Redirect to the user profile page with a success message
        return redirect('/user-profile')->with('success', 'Profile updated successfully');
    }
}
