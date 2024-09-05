<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Profil;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $answer = []; // Initialize an empty array to hold the answers.

        // Retrieve the first profile that matches the given profile_id from the request.
        $profile = Profil::all()->where('profile_id', $request->get('profile_id'))->first();

        // Get the pivot table data for answered questions associated with the profile.
        $answers_pivots = $profile->answeredQuestions;

        // Loop through the answered questions and store the question_id and answer_id in the $answer array.
        foreach ($answers_pivots as $pivot) {
            $answer[$pivot->pivot->question_id] = $pivot->pivot->answer_id;
        }

        // Return the 'company.settings' view with the following data:
        return view('company.settings', [
            'categories' => Category::all(), // Retrieve all categories
            'questions' => Question::all(), // Retrieve all questions
            'answers' => Answer::all(), // Retrieve all possible answers
            'company_answers' => $answer, // Pass the compiled answers specific to the company profile
            'company_profiles' => Profil::all(), // Retrieve all profiles
            'isExpert' => $request->isExpert, // Pass the 'isExpert' status from the request
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyQuestion $companyQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyQuestion $companyQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // make a new entry or update an existing one in the pivot table with the question_id and answer_id
        DB::table('company_question')->upsert(['profile_id' => $request->profile_id, 'question_id' => $request->question_id, 'answer_id' => $request->answer_id], ['profile_id', 'question_id'], ['answer_id']);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyQuestion $companyQuestion)
    {
        //
    }
}
