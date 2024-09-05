<?php

namespace App\Http\Controllers;

use App\Models\Preview\InterfaceCategory;

class InterfacesController extends Controller
{
    /**
     * Retrieve all InterfaceCategory records from the database
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_all()
    {
        $interfaces = InterfaceCategory::all();

        return response()->json($interfaces);
    }

    /**
     * Retrieve a specific InterfaceCategory record by its ID
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        $interface = InterfaceCategory::find($id);

        return response()->json($interface);
    }
}
