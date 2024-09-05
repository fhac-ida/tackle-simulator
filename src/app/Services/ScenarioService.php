<?php

namespace App\Services;

use App\Models\Preview\Hackerattackstep;
use App\Models\Preview\Scenario;

class ScenarioService
{
    /*
        The ScenarioService provides a service to calculate paths from start phases to endphases, named Scenarios.
    */
    public function getAllPaths(Scenario $scenario)
    {
        $scenarioId = $scenario->id;

        // Retrieve all starting steps within the scenario that belong to a start phase
        $startSteps = Hackerattackstep::whereHas('phase', function ($query) {
            $query->where('is_start_phase', true);
        })->whereHas('scenarios', function ($query) use ($scenarioId) {
            $query->where('scenariohackerstep.scenario_id', $scenarioId);
        })->get();

        // Retrieve all ending steps within the scenario that belong to an end phase
        $endSteps = Hackerattackstep::whereHas('phase', function ($query) {
            $query->where('is_end_phase', true);
        })->whereHas('scenarios', function ($query) use ($scenarioId) {
            $query->where('scenariohackerstep.scenario_id', $scenarioId);
        })->get();

        // Get all hacker attack steps associated with the scenario
        $allSteps = $scenario->hackerattackSteps;

        $paths = []; // Initialize an array to store all found paths

        // For each start step, attempt to find paths to each end step
        foreach ($startSteps as $startStep) {
            foreach ($endSteps as $endStep) {
                $this->findPaths($startStep, $endStep, [], $paths, $allSteps);
            }
        }

        return $paths; // Return the array of paths found
    }

    /**
     * Recursive method to find all paths from a current step to an end step
     *
     * @param Hackerattackstep $currentStep
     * @param Hackerattackstep $endStep
     * @param $path
     * @param $paths
     * @param $allSteps
     * @return void
     */
    private function findPaths(Hackerattackstep $currentStep, Hackerattackstep $endStep, $path, &$paths, $allSteps)
    {
        $path[] = $currentStep; // Add the current step to the path

        // If the current step is the end step, add the path to the list of paths and return
        if ($currentStep->id == $endStep->id) {
            $paths[] = $path;

            return;
        }

        $currentPhase = $currentStep->phase->step; // Get the current phase step number
        $nextPhase = $currentPhase + 1; // Define the next phase step number

        // Filter the steps to find those in the next phase
        $nextSteps = $allSteps->filter(function ($step) use ($nextPhase) {
            return $step->phase->step == $nextPhase;
        });

        // For each step in the next phase, recursively find paths, avoiding loops
        foreach ($nextSteps as $nextStep) {
            if (! in_array($nextStep, $path)) {
                // prevent redundant calculations
                $this->findPaths($nextStep, $endStep, $path, $paths, $allSteps);
            }
        }
    }
}
