<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Equipment\Application\Services\InventoryService;
use App\Modules\Equipment\UI\Http\CommandMappers\EquipItemCommandMapper;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageInventoryController extends Controller
{
    /**
     * @var InventoryService
     */
    private $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function equipItem(Request $request, EquipItemCommandMapper $commandMapper): JsonResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->inventoryService->equipItem($command);
            });

        } catch (Exception $exception) {

            return response()->json([
                'message' => 'Error equipping item: ' . $exception->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Item equipped']);
    }

    public function unEquipItem(Request $request, EquipItemCommandMapper $commandMapper): JsonResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->inventoryService->unEquipItem($command);
            });

        } catch (Exception $exception) {

            return response()->json([
                'message' => 'Error un-equipping item: ' . $exception->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Item un-equipped']);
    }
}
