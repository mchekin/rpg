<?php

namespace App\Http\Controllers;

use App\Modules\Character\Domain\Services\CharacterService;
use App\Modules\Character\Presentation\Http\CommandMappers\AttackCharacterCommandMapper;
use App\Modules\Character\Presentation\Http\CommandMappers\CreateCharacterCommandMapper;
use App\Http\Requests\CreateCharacterRequest;
use App\Http\Requests\UpdateCharacterAttributeRequest;
use App\Modules\Character\Presentation\Http\CommandMappers\IncreaseAttributeCommandMapper;
use App\Modules\Character\Presentation\Http\CommandMappers\MoveCharacterCommandMapper;
use App\Modules\Level\Domain\Services\LevelService;
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
        $this->middleware('can.move.to.location', ['only' => ['move']]);
        $this->middleware('can.attack', ['only' => ['attack']]);

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

        return redirect()->route('character.show', ['character' => $character->getId()]);
    }

    public function show(string $characterId, LevelService $levelService): View
    {
        $character = $this->characterService->getOne($characterId);
        $level = $levelService->getLevel($character->getLevelNumber());

        return view('character.show', ['character' => $character->getModel(), 'level' => $level]);
    }

    public function update(
        UpdateCharacterAttributeRequest $request,
        IncreaseAttributeCommandMapper $commandMapper,
        string $characterId
    ): Response {

        $increaseAttributeCommand = $commandMapper->map($characterId, $request);

        $this->characterService->increaseAttribute($increaseAttributeCommand);

        return back()->with('status', ucfirst($increaseAttributeCommand->getAttribute()) . ' + 1');
    }

    public function move(
        MoveCharacterCommandMapper $commandMapper,
        string $characterId,
        string $locationId
    ): Response {
        $moveCharacterCommand = $commandMapper->map($characterId, $locationId);

        $this->characterService->move($moveCharacterCommand);

        return redirect()->route('location.show', $locationId);
    }

    public function attack(
        string $defenderId,
        Request $request,
        AttackCharacterCommandMapper $commandMapper
    ): Response {

        $attackCharacterCommand = $commandMapper->map($request, $defenderId);

        $battle = $this->characterService->attack($attackCharacterCommand);

        return redirect()->route('battle.show', $battle->getId());
    }
}
