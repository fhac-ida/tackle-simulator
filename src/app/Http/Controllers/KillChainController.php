<?php

namespace App\Http\Controllers;

use App\Models\Preview\Hackerattackstep;
use App\Models\Preview\Phase;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class KillChainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Application|Factory|View
    {
        $phases = Phase::all(); // Retrieve all phases from the database
        $steps = Hackerattackstep::whereBelongsTo($phases)->get(); // Retrieve all hacker attack steps that belong to the retrieved phases
        error_log($steps/*implode(',', $steps)*/);

        return view('pages/killchain/steplist', ['hackersteps' => $steps]); // Return a view with the retrieved hacker steps passed to it
    }

    /**
     * Retrieve and return all phases in JSON format
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetAllPhases()
    {
        $phases = Phase::all(); //Retreives all phases from the database

        return response()->json($phases); // Return the phases as a JSON response
    }

    /**
     * Retrieve and return all hacker attack steps in JSON format
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function GetAllHackersteps()
    {
        $hackerSteps = Hackerattackstep::all(); // Retrieve all hacker attack steps from the database

        return response()->json($hackerSteps); // Return the hacker steps as a JSON response
    }

    /**
     * Generate and display all possible scenarios from the start phase to the end phase
     *
     * @return Application|Factory|View
     */
    public function scenarios()
    {
        $start_phase = Phase::where('is_start_phase', true)->first();
        $end_phase = Phase::where('is_end_phase', true)->first();
        $start_steps = Hackerattackstep::where('phase_id', $start_phase->phase_id)->get(); // Retrieve all hacker attack steps that belong to the start phase

        //Get all sequences of Hackerattacks from startphase to end phase
        $allHackerStepSequences = [];
        // For each start step, generate sequences from the start phase to the end phase
        foreach ($start_steps as $step) {
            // Generate sequences for the current step towards the end phase
            $sequences = $step->generateSequences($end_phase);

            // Merge the generated sequences into the collection of all sequences
            $allHackerStepSequences = array_merge($allHackerStepSequences, $sequences);
        }

        // Return the 'scenarios' view with the sequences data
        return view('pages/killchain/scenarios', [compact($allHackerStepSequences)]);
    }
}
