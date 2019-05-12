<?php

namespace App\Http\Controllers;

use App\Character;
use App\Location;
use App\Modules\Character\Domain\Services\CharacterService;
use App\Modules\Character\Presentation\Http\RequestMappers\AttackCharacterRequestMapper;
use App\Modules\Character\Presentation\Http\RequestMappers\CreateCharacterRequestMapper;
use App\Http\Requests\CreateCharacterRequest;
use App\Http\Requests\UpdateCharacterAttributeRequest;
use App\Modules\Character\Presentation\Http\RequestMappers\IncreaseAttributeRequestMapper;
use App\Modules\Character\Presentation\Http\RequestMappers\MoveCharacterRequestMapper;
use App\Race;
use App\User;
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

    public function create(): View
    {
        $races = Race::all();
        $user = Auth::user();

        return view('character.create', compact('races', 'user'));
    }

    public function store(
        CreateCharacterRequest $request,
        CreateCharacterRequestMapper $requestMapper
    ): Response {
        $createRequest = $requestMapper->map($request);

        $character = $this->characterService->create($createRequest);

        return redirect()->route('character.show', ['character' => $character->getModel()]);
    }

    public function show(Character $character): View
    {
        $character = $this->characterService->getOne($character->getId());

        return view('character.show', ['character' => $character->getModel()]);
    }

    public function update(
        UpdateCharacterAttributeRequest $request,
        IncreaseAttributeRequestMapper $requestMapper,
        Character $character
    ): Response {

        $increaseAttributeRequest = $requestMapper->map($character->getId(), $request);

        $this->characterService->increaseAttribute($increaseAttributeRequest);

        return back()->with('status', ucfirst($increaseAttributeRequest->getAttribute()) . ' + 1');
    }

    public function getMove(
        MoveCharacterRequestMapper $requestMapper,
        Character $character,
        Location $location
    ): Response {
        $moveCharacterRequest = $requestMapper->map($character->getId(), $location->getId());

        $this->characterService->move($moveCharacterRequest);

        return redirect()->route('location.show', compact('location'));
    }

    public function getAttack(
        Character $defender,
        Request $request,
        AttackCharacterRequestMapper $requestMapper
    ): Response {
        /** @var User $authenticatedUser */
        $authenticatedUser = $request->user();
        $character = $authenticatedUser->getCharacter();

        $attackCharacterRequest = $requestMapper->map($character->getId(), $defender->getId());

        $battle = $this->characterService->attack($attackCharacterRequest);

        return redirect()->route('battle.show', ['battle' => $battle->getModel()]);
    }
}
