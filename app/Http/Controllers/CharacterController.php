<?php

namespace App\Http\Controllers;

use App\Character;
use App\Contracts\Models\CharacterInterface;
use App\Contracts\Models\UserInterface;
use App\Contracts\Models\LocationInterface;
use App\Contracts\Repositories\RaceRepositoryInterface;
use App\Modules\Character\Domain\Services\CharacterService;
use App\Modules\Character\Presentation\Http\RequestMappers\CreateCharacterRequestMapper;
use App\Http\Requests\CreateCharacterRequest;
use App\Http\Requests\UpdateCharacterAttributeRequest;
use App\Modules\Character\Presentation\Http\RequestMappers\IncreaseAttributeRequestMapper;
use App\Modules\Character\Presentation\Http\RequestMappers\MoveCharacterRequestMapper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    /**
     * @var CharacterService
     */
    private $characterService;

    /**
     * CharacterController constructor.
     *
     * @param CharacterService $characterService
     */
    public function __construct(CharacterService $characterService)
    {
        $this->middleware('auth');
        $this->middleware('has.character', ['except' => ['create', 'store', 'update']]);
        $this->middleware('owns.character', ['only' => ['update']]);
        $this->middleware('no.character', ['only' => ['create', 'store']]);
        $this->middleware('can.move.to.location', ['only' => ['getMove']]);
        $this->middleware('can.attack', ['only' => ['getAttack']]);

        $this->characterService = $characterService;
    }

    public function create(RaceRepositoryInterface $raceRepository): View
    {
        $races = $raceRepository->all();
        $user = Auth::user();

        return view('character.create', compact('races', 'user'));
    }

    public function store(
        CreateCharacterRequest $request,
        CreateCharacterRequestMapper $requestMapper
    ): Response {
        $createRequest = $requestMapper->map($request);

        $character = $this->characterService->create($createRequest);

        return redirect()->route('character.show', ['character' => $character->getCharacterModel()]);
    }

    public function show(CharacterInterface $character): View
    {
        $character = $this->characterService->getOne($character->getId());

        return view('character.show', ['character' => $character->getCharacterModel()]);
    }

    public function update(
        UpdateCharacterAttributeRequest $request,
        IncreaseAttributeRequestMapper $requestMapper,
        CharacterInterface $character
    ): Response {

        $increaseAttributeRequest = $requestMapper->map($character->getId(), $request);

        $this->characterService->increaseAttribute($increaseAttributeRequest);

        return back()->with('status', ucfirst($increaseAttributeRequest->getAttribute()) . ' + 1');
    }

    public function getMove(
        MoveCharacterRequestMapper $requestMapper,
        Character $character,
        LocationInterface $location
    ): Response {
        $moveCharacterRequest = $requestMapper->map($character->getId(), $location->getId());

        $this->characterService->move($moveCharacterRequest);

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
