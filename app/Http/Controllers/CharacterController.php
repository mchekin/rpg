<?php

namespace App\Http\Controllers;

use App\Character;
use App\Contracts\Models\CharacterInterface;
use App\Contracts\Repositories\CharacterRepositoryInterface;
use App\Contracts\Models\LocationInterface;
use App\Http\Requests\CreateCharacterRequest;
use App\Http\Requests\MoveCharacterRequest;
use App\Http\Requests\UpdateCharacterAttributeRequest;
use App\Location;
use App\Race;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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

    public function store(
        CreateCharacterRequest $request,
        CharacterRepositoryInterface $characterRepository
    ): Response {
        Character::createCharacter($request);

        return redirect()->route("home");
    }

    public function show(CharacterInterface $character): View
    {
        return view('character.show', compact('character'));
    }

    public function update(
        UpdateCharacterAttributeRequest $request,
        CharacterInterface $character,
        CharacterRepositoryInterface $characterRepository
    ): Response {
        $attribute = $request->input('attribute');

        $character->applyAttributeIncrease($attribute);

        $characterRepository->save($character);

        return redirect()->route('character.show', compact('character'));
    }

    public function getMove(Character $character, LocationInterface $location, MoveCharacterRequest $request): Response
    {
        // update character's location
        $character->location()->associate($location)->save();

        return redirect()->route('location.show', compact('location'));
    }

    public function getAttack(Character $defender, Request $request): Response
    {
        /** @var User $authenticatedUser */
        $authenticatedUser = $request->user();

        $character = $authenticatedUser->character;

        $battle = $character->attack($defender);

        return redirect()->route('battle.show', compact('battle'));
    }
}
