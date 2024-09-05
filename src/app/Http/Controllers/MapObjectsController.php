<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Models\MapObject;
use App\Models\Mapobjects\MoInterface;
use App\Models\Mapobjects\PlcMapObject;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Random;

class MapObjectsController extends Controller
{
    /**
     * Display the index page for map objects
     */
    public function index()
    {
        return view('mapobjects/index');
    }

    /**
     * Show the modal form for adding a new map object
     */
    public function addModal($id)
    {
        return view('mapobjects.add', ['id' => $id]);
    }

    /**
     * Show the form for editing a specific map object
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        return view('mapobjects.edit', compact('mapobject', 'isPlc', 'plc'));
    }

    /**
     * Update the specified map object
     *
     * @param Request $request
     * @param $mapObject_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(Request $request, $mapObject_id)
    {

        $request->validate([
            'data' => 'required',
        ]);

        // Store the graph data as a JSON file in the user's storage directory
        Storage::disk('local')->put('graphs/'.auth()->id().'/map'.$mapObject_id.'.json', json_encode($request->input('data')));

        return response()->json(['message' => 'Graph successfully saved!', 'data' => $request->input('data')]);

        $request->validate([
            'name' => 'required',
        ]);

        return Redirect::back()->with('success', 'MapObject updated!');
    }

    /**
     * Update the positions of map objects on the canvas
     *
     * @param Request $request
     * @param $map_id
     * @return string[]
     */
    public function updatePositions(Request $request, $map_id)
    {

        try {
            // Decode the JSON data for map object positions
            $json = json_decode($request->get('mapobjectpositions'));

            // Get the canvas dimensions
            $canvasWidth = floatval($request->get('canvaswidth'));
            $canvasHeight = floatval($request->get('canvasheight'));

            // Update the position of each map object relative to the canvas dimensions
            foreach ($json as $id => $dataset) {
                $leftRelative = round(floatval($dataset->left) / $canvasWidth, 4);
                $topRelative = round(floatval($dataset->top) / $canvasHeight, 4);
            }
        } catch (Exception $e) { // Error handling
            return ['error' => 'Got an error: '.$e];
        }

        return ['success' => 'Positions maybe saved'];
    }
}
