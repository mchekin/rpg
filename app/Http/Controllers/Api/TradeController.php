<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Trade\Application\Services\TradeService;
use App\Modules\Trade\UI\Http\CommandMappers\BuyItemCommandMapper;
use App\Modules\Trade\UI\Http\CommandMappers\SellItemCommandMapper;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TradeController extends Controller
{
    /**
     * @var TradeService
     */
    private $service;

    public function __construct(TradeService $service)
    {
        $this->service = $service;
    }

    public function buyItem(Request $request, BuyItemCommandMapper $commandMapper): JsonResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->service->buyItem($command);
            });

        } catch (Exception $exception) {

            return response()->json([
                'message' => 'Error buying item: ' . $exception->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Item bought']);
    }

    public function sellItem(Request $request, SellItemCommandMapper $commandMapper): JsonResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->service->sellItem($command);
            });

        } catch (Exception $exception) {

            return response()->json([
                'message' => 'Error selling item: ' . $exception->getMessage()
            ], 500);
        }

        return response()->json(['message' => 'Item bought']);
    }
}
