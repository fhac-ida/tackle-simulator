<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetController extends Controller
{
    /**
     * Show the form for requesting a password reset link
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('session/reset-password/sendEmail');
    }

    /**
     * Handle sending a password reset link to the user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmail(Request $request)
    {
        // Check if the application is in demo mode
        if (env('IS_DEMO')) {
            // If in demo mode, prevent sending the password reset email and show an error message
            return redirect()->back()->withErrors(['msg2' => 'You are in a demo version, you can\'t recover your password.']);
        } else {
            // Validate the incoming request to ensure an email is provided and is in a valid format
            $request->validate(['email' => 'required|email']);

            // Attempt to send the password reset link to the provided email
            $status = Password::sendResetLink(
                $request->only('email')
            );

            // Check the status of the password reset link request
            return $status === Password::RESET_LINK_SENT
                        ? back()->with(['success' => __($status)]) // If successful, redirect back with a success message
                        : back()->withErrors(['email' => __($status)]); // If unsuccessful, redirect back with an error message
        }
    }

    /**
     * Show the form for resetting the password
     *
     * @param $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function resetPass($token)
    {
        return view('session/reset-password/resetPassword', ['token' => $token]);
    }
}
