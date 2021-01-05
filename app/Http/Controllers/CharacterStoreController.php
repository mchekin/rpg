<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CharacterStoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('has.character');
    }

    public function index(Request $request, string $characterId): View
    {
        /** @var Character $buyer */
        $buyer = $request->user()->character;

        /** @var Character $seller */
        $seller = Character::query()->findOrFail($characterId);

        return view('trade.store.index', compact('buyer', 'seller'));
    }
}
