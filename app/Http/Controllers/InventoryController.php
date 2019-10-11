<?php

namespace App\Http\Controllers;

use App\Modules\Character\Domain\Services\CharacterService;
use App\Modules\Equipment\Domain\Services\ItemService;
use App\Modules\Equipment\Presentation\Http\CommandMappers\EquipItemCommandMapper;
use App\Modules\Level\Domain\Services\LevelService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\User as UserModel;

class InventoryController extends Controller
{
    /**
     * @var ItemService
     */
    private $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->middleware('auth');

        $this->itemService = $itemService;
    }

    public function index(Request $request, CharacterService $characterService, LevelService $levelService): View
    {
        /** @var UserModel $userModel */
        $characterId = $request->user()->character->getId();

        $character = $characterService->getOne($characterId);
        $level = $levelService->getLevel($character->getLevelNumber());

        return view('character.inventory.index', ['character' => $character->getModel(), 'level' => $level]);
    }

    public function equipItem(Request $request, EquipItemCommandMapper $commandMapper): RedirectResponse
    {
        $equipItemCommand = $commandMapper->map($request);

        $this->itemService->equip($equipItemCommand);

        return redirect()->back();
    }
}
