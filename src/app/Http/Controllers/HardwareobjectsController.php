<?php

namespace App\Http\Controllers;

use App\Models\Preview\HardwareObject;

class HardwareobjectsController extends Controller
{
    /**
     * Display a listing of all HardwareObjects along with their associated Interfaces
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Retrieve all HardwareObject instances from the database, including their related Interfaces
        $hardwareobjects = HardwareObject::with('Interfaces')->get();

        // Return the collection of HardwareObject instances as a JSON response
        return response()->json($hardwareobjects);
    }

    /**
     * Display a specific HardwareObject along with its associated Interfaces
     *
     * @param int $id The ID of the HardwareObject to retrieve.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the specified hardware object with its interfaces.
     */
    public function InterfacesFromHardwareObject($id)
    {
        // Find a specific HardwareObject by its ID, including its related Interfaces
        $hardwareobjectWithInterface = HardwareObject::with('interfaces')->find($id);

        // Return the HardwareObject instance as a JSON response
        return response()->json($hardwareobjectWithInterface);
    }
}
