<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Modules\Equipment\Domain\Services\ItemService;
use App\Modules\Equipment\Presentation\Http\CommandMappers\CreateItemCommandMapper;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    /**
     * @var ItemService
     */
    private $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->middleware('auth');
        $this->middleware('has.character');

        $this->itemService = $itemService;
    }

    public function store(
        CreateItemRequest $request,
        CreateItemCommandMapper $commandMapper
    ): Response {

        $createCommand = $commandMapper->map($request);

        $item = $this->itemService->create($createCommand);

        return redirect()->route('character.show', ['character' => $createCommand->getCreatorCharacterId()]);
    }
}
