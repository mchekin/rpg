<?php

namespace App\Http\Controllers;

use App\Battle;
use App\Character;
use App\Http\Requests\CreateCharacterRequest;
use App\Http\Requests\MoveCharacterRequest;
use App\Location;
use App\Race;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{

    /**
     * CharacterController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store', 'getMove']]);
        $this->middleware('has.character', ['only' => ['getMove']]);
        $this->middleware('no.character', ['only' => ['create', 'store']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $races = Race::all();
        $user = Auth::user();
        return view('character.create', compact('races', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCharacterRequest $request
     * @return Response
     */
    public function store(CreateCharacterRequest $request)
    {
        $authenticatedUser = $request->user(); /** @var User $authenticatedUser */
        $race = Race::query()->findOrFail($request->input('race_id')); /** @var Race $race */

        $character = $authenticatedUser->character()->create([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),

            'xp' => 0,
            'level' => 1,
            'money' => 0,
            'reputation' => 0,

            'strength' => $race->strength,
            'agility' => $race->agility,
            'constitution' => $race->constitution,
            'intelligence' => $race->intelligence,
            'charisma' => $race->charisma,

            'race_id' => $race->id,
            'location_id' => $race->starting_location_id,
        ]);

        return redirect()->route("home");
    }

    /**
     * @param Character $character
     * @param Location $location
     * @param MoveCharacterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getMove(Character $character, Location $location, MoveCharacterRequest $request)
    {
        // update character's location
        $character->location()->associate($location)->save();

        return redirect()->route('location.show', compact('location'));
    }

    /**
     * @param Character $defender
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getAttack(Character $defender, Request $request)
    {
        $authenticatedUser = $request->user(); /** @var User $authenticatedUser */
        $attacker = $authenticatedUser->character;

        /** @var Battle $battle */
        $battle = Battle::query()->create([
            'attacker_id' => $attacker->id,
            'defender_id' => $defender->id,
            'location_id' => $defender->location->id,
        ]);

        return redirect()->route('battle.show', compact('battle'));
    }
}
