<?php

namespace App\Http\Controllers;

use App\Models\Character;
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
        /** @var Character $customer */
        $customer = $request->user()->character;

        /** @var Character $trader */
        $trader = Character::query()->findOrFail($characterId);

        return view('trade.store.index', compact('customer', 'trader'));
    }
}
