<?php

namespace App\Http\Controllers;

use App\Modules\Character\Domain\Services\CharacterService;
use App\Modules\Equipment\Domain\Services\ItemService;
use App\Modules\Equipment\Presentation\Http\CommandMappers\EquipItemCommandMapper;
use App\Modules\Level\Domain\Services\LevelService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\User as UserModel;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * @var ItemService
     */
    private $itemService;
    /**
     * @var CharacterService
     */
    private $characterService;

    public function __construct(ItemService $itemService, CharacterService $characterService)
    {
        $this->middleware('auth');

        $this->itemService = $itemService;
        $this->characterService = $characterService;
    }

    public function index(Request $request, CharacterService $characterService, LevelService $levelService): View
    {
        /** @var UserModel $userModel */
        $characterId = $request->user()->character->getId();

        $character = $characterService->getOne($characterId);
        $level = $levelService->getLevel($character->getLevelNumber());

        return view('character.inventory.index', ['character' => $character, 'level' => $level]);
    }

    public function equipItem(Request $request, EquipItemCommandMapper $commandMapper): RedirectResponse
    {
        $equipItemCommand = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($equipItemCommand) {
                $this->characterService->equipItem($equipItemCommand);
            });

        } catch (Exception $exception) {

            return redirect()->back()->withErrors([
                'message' => 'Error equipping item'
            ]);
        }

        return redirect()->back()->with('status', 'Item equipped');
    }

    public function unEquipItem(Request $request, EquipItemCommandMapper $commandMapper): RedirectResponse
    {
        $equipItemCommand = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($equipItemCommand) {
                $this->characterService->unEquipItem($equipItemCommand);
            });

        } catch (Exception $exception) {

            return redirect()->back()->withErrors([
                'message' => 'Error un-equipping item'
            ]);
        }

        return redirect()->back()->with('status', 'Item un-equipped');
    }
}
