<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Profil;
use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('company.settings');
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
        $this->validate($request, [
            'name' => 'required|alpha_num|max:32',
        ]);
        $profil = Profil::create([
            'user_id' => $request->user()->id,
            'profile_name' => request('name'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/settings/'.request('name'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $answer = [];

        // Finde das Profil mit dem angegebenen Profilnamen
        $profile = Profil::where('profile_name', $id)->first();

        if ($profile['user_id'] != $request->user()->id) {
            return redirect()->back()->with(['error' => __('Access Denied!')]);
        }

        $answers_pivots = $profile->answeredQuestions;
        foreach ($answers_pivots as $pivot) {
            if ($pivot->pivot->profile_id == $profile->profile_id) {
                $answer[$pivot->pivot->question_id] = $pivot->pivot->answer_id;
            }
        }

        return view('company.settings', [
            'categories' => Category::all(),
            'questions' => [],
            'answers' => [],
            'company_answers' => $answer,
            'company_profiles' => $request->user()->profiles,
            'isExpert' => $request->isExpert,
            'profile' => $profile,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyAnswer  $companyAnswer
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyProfile $companyProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyProfile $companyProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyAnswer  $companyAnswer
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyProfile $companyProfile)
    {
        //
    }
}
