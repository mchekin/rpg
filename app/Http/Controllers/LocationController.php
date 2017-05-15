<?php

namespace App\Http\Controllers;

use App\Location;

class LocationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['show']]);
        $this->middleware('has.character', ['only' => ['show']]);
        $this->middleware('character.location', ['only' => ['show']]);
    }

    /**
     * Display the specified resource.
     *
     * @param Location $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return view('location.show', compact('location'));
    }
}
