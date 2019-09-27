<?php

namespace App\Http\Controllers;

use App\Modules\Character\Domain\Services\CharacterService;
use App\Modules\Level\Domain\Services\LevelService;
use Illuminate\Contracts\View\View;

class CharacterInventoryController extends Controller
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
        $this->middleware('owns.character');

        $this->characterService = $characterService;
    }

    public function index(string $characterId, LevelService $levelService): View
    {
        $character = $this->characterService->getOne($characterId);
        $level = $levelService->getLevel($character->getLevelNumber());

        return view('character.inventory.index', ['character' => $character->getModel(), 'level' => $level]);
    }
}
