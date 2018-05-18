<?php

namespace App\Http\Controllers;

use App\Battle;
use App\Character;
use App\Http\Requests\CreateCharacterRequest;
use App\Http\Requests\MoveCharacterRequest;
use App\Http\Requests\UpdateCharacterAttributeRequest;
use App\Location;
use App\Race;
use App\RuleSets\CharacterRuleSet;
use App\User;
use Illuminate\Http\RedirectResponse;
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
        $this->middleware('auth', ['only' => ['create', 'store', 'getMove', 'update']]);
        $this->middleware('has.character', ['only' => ['getMove', 'update']]);
        $this->middleware('owns.character', ['only' => ['update']]);
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
     * @param CharacterRuleSet $characterRuleSet
     *
     * @return Response
     */
    public function store(CreateCharacterRequest $request, CharacterRuleSet $characterRuleSet)
    {
        $character = $characterRuleSet->createCharacter($request);

        return redirect()->route("home");
    }

    /**
     * Display the specified resource.
     *
     * @param Character $character
     * @return Response
     */
    public function show(Character $character)
    {
        return view('character.show', compact('character'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCharacterAttributeRequest $request
     * @param Character $character
     *
     * @return Response
     */
    public function update(UpdateCharacterAttributeRequest $request, Character $character)
    {
        $attribute = $request->input('attribute');

        if ($character->available_attribute_points) {
            $character->available_attribute_points--;
            $character->$attribute++;
            $character->save();
        }

        return redirect()->route('character.show', compact('character'));
    }

    /**
     * @param Character $character
     * @param Location $location
     * @param MoveCharacterRequest $request
     *
     * @return RedirectResponse
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
     * @param CharacterRuleSet $characterRuleSet
     *
     * @return RedirectResponse
     */
    public function getAttack(Character $defender, Request $request, CharacterRuleSet $characterRuleSet)
    {
        $authenticatedUser = $request->user(); /** @var User $authenticatedUser */
        $attacker = $authenticatedUser->character;

        /** @var Battle $battle */
        $battle = $characterRuleSet->attack($attacker, $defender);

        return redirect()->route('battle.show', compact('battle'));
    }
}
