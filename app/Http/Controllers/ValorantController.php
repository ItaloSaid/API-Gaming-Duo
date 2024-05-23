<?php

// app/Http/Controllers/ValorantController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ValorantController extends Controller
{
    public function getValorantStats($username)
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.tracker.gg/api/v2/valorant/standard/profile/riot/' . $username, [
            'headers' => [
                'TRN-Api-Key' => env('TRN_API_KEY'),
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        return response()->json($data);
    }
}
