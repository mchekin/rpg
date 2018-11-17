<?php

namespace App\Http\Controllers;

use App\Contracts\Models\LocationInterface;
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
     * @param LocationInterface $location
     * @return \Illuminate\Http\Response
     */
    public function show(LocationInterface $location)
    {
        return view('location.show', compact('location'));
    }
}
