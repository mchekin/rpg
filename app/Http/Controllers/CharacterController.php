<?php

namespace App\Http\Controllers;

use App\Character;
use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\UserInterface;
use App\Contracts\Repositories\CharacterRepositoryInterface;
use App\Contracts\Models\LocationInterface;
use App\Contracts\Repositories\RaceRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Http\Requests\CreateCharacterRequest;
use App\Http\Requests\UpdateCharacterAttributeRequest;
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
        $this->middleware('auth');
        $this->middleware('has.character', ['except' => ['create', 'store', 'update']]);
        $this->middleware('owns.character', ['only' => ['update']]);
        $this->middleware('no.character', ['only' => ['create', 'store']]);
        $this->middleware('can.move.to.location', ['only' => ['getMove']]);
        $this->middleware('can.attack', ['only' => ['getAttack']]);
    }

    public function create(RaceRepositoryInterface $raceRepository): View
    {
        $races = $raceRepository->all();
        $user = Auth::user();

        return view('character.create', compact('races', 'user'));
    }

    public function store(
        CreateCharacterRequest $request,
        UserRepositoryInterface $userRepository,
        RaceRepositoryInterface $raceRepository
    ): Response {

        /** @var UserInterface $authenticatedUser */
        $authenticatedUser = $request->user();

        $race = $raceRepository->findOrFail($request->input('race_id'));

        $character = Character::createCharacter($request, $race);

        $character = $userRepository->addCharacter($authenticatedUser, $character);

        return redirect()->route('character.show', compact('character'));
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

        return back()->with('status', ucfirst($attribute) . ' + 1');
    }

    public function getMove(Character $character, LocationInterface $location): Response
    {
        // update character's location
        $character->location()->associate($location)->save();

        return redirect()->route('location.show', compact('location'));
    }

    public function getAttack(CharacterInterface $defender, Request $request): Response
    {
        /** @var UserInterface $authenticatedUser */
        $authenticatedUser = $request->user();

        $character = $authenticatedUser->getCharacter();

        $battle = $character->attack($defender);

        return redirect()->route('battle.show', compact('battle'));
    }
}
