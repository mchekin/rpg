<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Modules\Equipment\Application\Services\InventoryService;
use App\Modules\Equipment\UI\Http\CommandMappers\EquipItemCommandMapper;
use App\Modules\Level\Application\Services\LevelService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * @var InventoryService
     */
    private $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->middleware('auth');

        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request, LevelService $levelService): View
    {
        /** @var Character $character */
        $character = $request->user()->character;

        $level = $levelService->getLevel($character->getLevelNumber());

        return view('character.inventory.index', ['character' => $character, 'level' => $level]);
    }

    public function equipItem(Request $request, EquipItemCommandMapper $commandMapper): RedirectResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->inventoryService->equipItem($command);
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
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->inventoryService->unEquipItem($command);
            });

        } catch (Exception $exception) {

            return redirect()->back()->withErrors([
                'message' => 'Error un-equipping item'
            ]);
        }

        return redirect()->back()->with('status', 'Item un-equipped');
    }
}
