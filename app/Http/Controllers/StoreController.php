<?php

namespace App\Http\Controllers;

use App\Character;
use App\Modules\Trade\Application\Services\StoreService;
use App\Modules\Trade\UI\Http\CommandMappers\MoveItemToStoreCommandMapper;
use Exception;
use Illuminate\Contracts\View\View;
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

    public function moveItemToStore(Request $request, MoveItemToStoreCommandMapper $commandMapper): RedirectResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->service->moveItemToStore($command);
            });

        } catch (Exception $exception) {

            return redirect()->back()->withErrors([
                'message' => 'Error moving item to store: ' . $exception->getMessage()
            ]);
        }

        return redirect()->back()->with('status', 'Item moved to store');
    }

    public function moveItemToInventory(Request $request, MoveItemToStoreCommandMapper $commandMapper): RedirectResponse
    {
        $command = $commandMapper->map($request);

        try {

            DB::transaction(function () use ($command) {
                $this->service->moveItemToInventory($command);
            });

        } catch (Exception $exception) {

            return redirect()->back()->withErrors([
                'message' => 'Error moving item to store: ' . $exception->getMessage()
            ]);
        }

        return redirect()->back()->with('status', 'Item moved to inventory');
    }
}
