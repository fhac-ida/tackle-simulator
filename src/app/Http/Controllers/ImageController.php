<?php

namespace App\Http\Controllers;

class ImageController extends Controller
{
    /**
     * Retrieve and return an image file based on the provided ID
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getImage($id)
    {
        try {
            // Match the provided ID to the corresponding image filename
            // If the ID doesn't match any case, 'unknown.png' is used as the default image
            $imageName = match ($id) {
                'PLC' => 'plc.png',
                'Switch' => 'switch.png',
                'Router' => 'router.png',
                'Gateway' => 'router.png',
                'Firewall' => 'firewall.jpg',
                'HMI' => 'sps.jpg',
                default => 'unknown.png',
            };

            // Return the image file as a response
            // The file is located in the 'public/img/' directory within the base path of the application
            return response()->file(base_path().'/public/img/'.$imageName);
        } catch (\Exception $exception) { // Error handling
            return response()->withException($exception);
        }
    }
}
