<?php

namespace App\Http\Controllers;

use App\Character;
use App\Modules\Trade\Application\Services\StoreService;
use App\Modules\Trade\UI\Http\CommandMappers\MoveItemToContainerCommandMapper;
use App\Modules\Trade\UI\Http\CommandMappers\MoveMoneyToContainerCommandMapper;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    /**
     * @var StoreService
     */
    private $service;

    public function __construct(StoreService $service)
    {
        $this->middleware('auth');

        $this->service = $service;
    }

    public function index(Request $request): View
    {
        /** @var Character $character */
        $character = $request->user()->character;

        return view('trade.store.index', compact('character'));
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

    public function moveMoneyToStore(Request $request, MoveMoneyToContainerCommandMapper $commandMapper): RedirectResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->service->moveMoneyToStore($command);
            });

        } catch (Exception $exception) {

            return redirect()->back()->withErrors([
                'message' => 'Error moving money to store: ' . $exception->getMessage()
            ]);
        }

        return redirect()->back()->with('status', 'Money move to store');
    }

    public function moveMoneyToInventory(Request $request, MoveMoneyToContainerCommandMapper $commandMapper): RedirectResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->service->moveMoneyToInventory($command);
            });

        } catch (Exception $exception) {

            return redirect()->back()->withErrors([
                'message' => 'Error moving money to inventory: ' . $exception->getMessage()
            ]);
        }

        return redirect()->back()->with('status', 'Money moved to inventory');
    }
}
