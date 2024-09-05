<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMapRequest;
use App\Models\Map;
use App\Models\Preview\HardwareObject;
use App\Models\Preview\Scenario;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Application|Factory|View
    {
        return view('pages/maps/maplist', ['maps' => auth()->user()->maps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //Currently, this method does not perform any actions
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
                'map_name' => 'required|alpha_num|max:32',
                'template' => 'required',
            ]);
            // Extract validated data
            $name = $validated['map_name'];
            $template = $validated['template'];

            // Create a new map with the provided data
            $newMap = Map::create([
                'name' => $name,
                'boolVar' => false,
                'enumVar' => 1,
                'user_id' => $request->user()->id,
                'stringVar' => 'Map created by user',
                'floatVar' => 1.0,
                'timestampVar' => $request->date('timestampVar'),
            ]);

            // Copy the selected template to the user's graph directory
            $templatePath = 'graph_templates/'.$template.'.json';
            if (Storage::exists($templatePath)) {
                Storage::copy($templatePath, 'graphs/'.$request->user()->id.'/map'.$newMap->id.'.json');
            }
            // Create a directory for reports associated with the new map
            Storage::makeDirectory('reports/'.$newMap->id);

            // Redirect back to the maps list with a success message
            return \redirect()->route('maps.index')->with(['success' => __('Map ').$name.__(' has been added.')]);
        } catch (Exception $exception) { //Error handling
            return \redirect()->route('maps.index')->with(['error' => __('Object has not been added!')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function show($map_id)
    {
        // Currently, this method does not perform any actions
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($map_id): View|Factory|Application
    {
        $map = Map::findOrFail($map_id); // Find the map by ID, aborting if it does not exist

        $userId = Auth::id();

        // Check if the graph file for this map exists in the user's directory
        if (Storage::exists('graphs/'.$userId.'/map'.$map->id.'.json')) {
            $graph = Storage::get('graphs/'.$userId.'/map'.$map->id.'.json');
        } else {
            abort(404); // Abort with a 404 error if the graph file does not exist
        }

        // Retrieve related data for the map edit view
        $devices = HardwareObject::with('interfaces')->get();
        $scenarios = Scenario::with('hackerattackSteps.phase')->get();

        // Predefined device types
        $types = ['PLC', 'Switch', 'Router', 'Firewall', 'HMI', 'Buskoppler'];

        // Ensure the reports directory exists for this map, creating it if necessary
        if (! Storage::has('reports/'.$map_id)) {
            Storage::makeDirectory('reports/'.$map_id);
        }

        // Retrieve all files in the reports directory
        $report_direcotry = storage_path('app/reports/'.$map_id);
        $reports = File::files($report_direcotry);
        $reportFileNames = [];
        foreach ($reports as $report) {
            $reportFileNames[] = $report->getFilename(); // or any other property you need
        }

        // Return the view with all the necessary data for editing the map
        return view('pages.maps.map', [
            'map' => $map,
            'graph' => $graph,
            'types' => $types,
            'devices' => $devices,
            'reports' => $reportFileNames,
            'scenarios' => $scenarios,
        ]);
    }

    /**
     * Show the edit-modal for the map properties
     */
    public function editModal($map): View|Factory|Application
    {
        $mapData = Map::find($map);

        return view('pages.maps.edit', ['map' => $mapData]);
    }

    /**
     * Show the add-modal for a map
     *
     * @return Application|Factory|View
     */
    public function addModal()
    {
        return view('pages.maps.add');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateMapRequest  $request
     */
    public function update(Request $request, Map $map): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Find the map by ID
            $mapVar = Map::find($map)->first();
            if (! isset($mapVar)) { // Error handling
                return Redirect::back()->with('error', 'Map not found!');
            }

            // Update the map's properties with the data from the request
            $mapVar->name = $request->get('name');
            $mapVar->enumVar = $request->get('enumVar');
            $mapVar->boolVar = $request->boolean('boolVar');
            $mapVar->timestampVar = $request->get('timestampVar');
            $mapVar->stringVar = $request->get('stringVar');
            $mapVar->floatVar = $request->get('floatVar');
            $mapVar->updated_at = now();
            $mapVar->update();

            DB::commit();

            return Redirect::back()->with('success', 'Map updated!');
        } catch (Exception $exception) { // Error handling
            DB::rollBack();

            return Redirect::back()->with('error', 'Error: Map not updated!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Map  $map
     */
    public function destroy($id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|Application
    {
        $map = Map::find($id);
        $map->delete();

        return redirect('/maps')->with('success', 'Map removed.');
    }
}
