<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ChangePasswordController extends Controller
{
    /**
     * function for changing a users password
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changePassword(Request $request)
    {
        // Validate the request input to ensure required fields are present and correctly formatted
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Attempt to reset the user's password using the provided email, password, password confirmation, and token
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) { // Callback function that handles the password reset process
                // Update the user's password to the newly provided one after hashing it
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60)); // Generate a new "remember me" token for the user

                // Save the updated user information to the database
                $user->save();

                // Trigger the PasswordReset event to perform any additional actions
                event(new PasswordReset($user));
            }
        );

        // Check if the password reset was successful
        return $status === Password::PASSWORD_RESET
                    ? redirect('/login')->with('success', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
