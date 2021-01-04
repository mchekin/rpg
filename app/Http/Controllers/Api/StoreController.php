<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Trade\Application\Services\ManageStoreService;
use App\Modules\Trade\UI\Http\CommandMappers\ChangeItemPriceCommandMapper;
use App\Modules\Trade\UI\Http\CommandMappers\MoveItemToContainerCommandMapper;
use App\Modules\Trade\UI\Http\CommandMappers\MoveMoneyToContainerCommandMapper;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    /**
     * @var ManageStoreService
     */
    private $service;

    public function __construct(ManageStoreService $service)
    {
        $this->service = $service;
    }

    public function changeItemPrice(Request $request, ChangeItemPriceCommandMapper $commandMapper): JsonResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->service->changeItemPrice($command);
            });

        } catch (Exception $exception) {

            return response()->json([
                'message' => 'Error changing item price: ' . $exception->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Item price changed']);
    }

    public function moveItemToStore(Request $request, MoveItemToContainerCommandMapper $commandMapper): JsonResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->service->moveItemToStore($command);
            });

        } catch (Exception $exception) {

            return response()->json([
                'message' => 'Error moving item to store: ' . $exception->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Item moved to store']);
    }

    public function moveItemToInventory(Request $request, MoveItemToContainerCommandMapper $commandMapper): JsonResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->service->moveItemToInventory($command);
            });

        } catch (Exception $exception) {

            return response()->json([
                'message' => 'Error moving item to inventory: ' . $exception->getMessage()
            ], 500);
        }

        return  response()->json(['message' => 'Item moved to inventory']);
    }

    public function moveMoneyToStore(Request $request, MoveMoneyToContainerCommandMapper $commandMapper): JsonResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->service->moveMoneyToStore($command);
            });

        } catch (Exception $exception) {

            return response()->json([
                'message' => 'Error moving money to store: ' . $exception->getMessage()
            ]);
        }

        return response()->json(['message' => 'Money moved to store']);
    }

    public function moveMoneyToInventory(Request $request, MoveMoneyToContainerCommandMapper $commandMapper): JsonResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->service->moveMoneyToInventory($command);
            });

        } catch (Exception $exception) {

            return response()->json([
                'message' => 'Error moving money to inventory: ' . $exception->getMessage()
            ]);
        }

        return response()->json(['status' => 'Money moved to inventory']);
    }
}
