<?php

namespace App\Http\Controllers;

use App\Models\Location;

class LocationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['show']]);
        $this->middleware('has.character', ['only' => ['show']]);
        $this->middleware('character.location', ['only' => ['show']]);
    }

    public function show(string $locationId)
    {
        $location = Location::query()->findOrFail($locationId);

        return view('location.show', compact('location'));
    }
}
