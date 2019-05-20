<?php

namespace App\Http\Controllers;

use App\Character;
use App\Location;
use App\Modules\Character\Domain\Services\CharacterService;
use App\Modules\Character\Presentation\Http\CommandMappers\AttackCharacterCommandMapper;
use App\Modules\Character\Presentation\Http\CommandMappers\CreateCharacterCommandMapper;
use App\Http\Requests\CreateCharacterRequest;
use App\Http\Requests\UpdateCharacterAttributeRequest;
use App\Modules\Character\Presentation\Http\CommandMappers\IncreaseAttributeCommandMapper;
use App\Modules\Character\Presentation\Http\CommandMappers\MoveCharacterCommandMapper;
use App\Race;
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
        CreateCharacterCommandMapper $commandMapper
    ): Response {

        $createCharacterCommand = $commandMapper->map($request);

        $character = $this->characterService->create($createCharacterCommand);

        return redirect()->route('character.show', ['character' => $character->getModel()]);
    }

    public function show(Character $character): View
    {
        $character = $this->characterService->getOne($character->getId());

        return view('character.show', ['character' => $character->getModel()]);
    }

    public function update(
        UpdateCharacterAttributeRequest $request,
        IncreaseAttributeCommandMapper $commandMapper,
        Character $character
    ): Response {

        $increaseAttributeCommand = $commandMapper->map($character->getId(), $request);

        $this->characterService->increaseAttribute($increaseAttributeCommand);

        return back()->with('status', ucfirst($increaseAttributeCommand->getAttribute()) . ' + 1');
    }

    public function getMove(
        MoveCharacterCommandMapper $commandMapper,
        Character $character,
        Location $location
    ): Response {
        $moveCharacterCommand = $commandMapper->map($character->getId(), $location->getId());

        $this->characterService->move($moveCharacterCommand);

        return redirect()->route('location.show', compact('location'));
    }

    public function getAttack(
        Character $defender,
        Request $request,
        AttackCharacterCommandMapper $commandMapper
    ): Response {

        $attackCharacterCommand = $commandMapper->map($request, $defender->getId());

        $battle = $this->characterService->attack($attackCharacterCommand);

        return redirect()->route('battle.show', ['battle' => $battle->getModel()]);
    }
}
