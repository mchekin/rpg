<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OwnStoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('has.character');
    }

    public function index(Request $request): View
    {
        /** @var Character $character */
        $character = $request->user()->character;

        return view('trade.own_store.index', compact('character'));
    }
}
