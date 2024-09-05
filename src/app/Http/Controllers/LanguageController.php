<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Handle the request to switch the application's language
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function languageSwitch(Request $request)
    {
        // Retrieve the 'language' input from the request
        $language = $request->input('language');

        // Check if the language is not null and if it is not one of the allowed values ('en' or 'de')
        if ($language != null and ! in_array($language, ['en', 'de'])) {
            abort(400);
        }

        // Store the selected language in the session under the key 'language'
        session(['language' => $language]);

        // Redirect the user back to the previous page with a success message indicating the language has been switched
        return redirect()->back()->with(['language_switched' => $language]);
    }
    //
}
