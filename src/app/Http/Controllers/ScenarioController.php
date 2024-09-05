<?php

namespace App\Http\Controllers;

use App\Models\Preview\Hackerattackstep;
use App\Models\Preview\Phase;
use App\Models\Preview\Scenario;
use Exception;
use Illuminate\Http\Request;

class ScenarioController extends Controller
{
    /**
     * Display a listing of the scenarios
     */
    public function index()
    {
        // Retrieve all scenarios with their related hacker attack steps and phases
        $scenarios = Scenario::with('hackerattackSteps.phase')->get();

        // Retrieve all phases
        $phases = Phase::all();

        // Retrieve all hacker attack steps that belong to any of the phases
        $hackersteps = Hackerattackstep::whereBelongsTo($phases)->get();

        error_log($hackersteps/*implode(',', $steps)*/);

        // Return the view 'scenarios.index' with the retrieved scenarios, phases, and hacker steps
        return view('scenarios.index', compact('scenarios', 'phases', 'hackersteps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validated = $request->validate([
                'scenario_name' => 'required|alpha_num|max:32',
            ]);

            // Extract the validated scenario name
            $name = $validated['scenario_name'];

            // Create a new scenario with the provided name
            $newScenario = Scenario::create([
                'name' => $name,
            ]);

            // Determine the number of hacker attack steps related to all phases
            $finalStep = Hackerattackstep::whereBelongsTo(Phase::all())->count();
            for ($step = 1; $step < $finalStep; $step++) {
                if ($request['hackerstep-'.$step] == 'true') {
                    $newScenario->hackerattackSteps()->attach($step);
                }
            }

            // Redirect to the scenarios list with a success message
            return \redirect()->route('scenarios')->with(['success' => __('Scenario ').$name.__(' has been added.')]);
        } catch (Exception $exception) { // Error handling
            return \redirect()->route('scenarios')->with(['error' => __('Object has not been added!')]);
        }
    }
}
