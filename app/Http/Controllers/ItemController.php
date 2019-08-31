<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Modules\Character\Domain\Services\CharacterService;
use App\Modules\Equipment\Domain\Services\ItemService;
use App\Modules\Equipment\Presentation\Http\CommandMappers\CreateItemCommandMapper;
use Illuminate\Http\Response;

class ItemController extends Controller
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
        $this->middleware('has.character');
        $this->middleware('is.admin', ['only' => ['create', 'store']]);

        $this->itemService = $itemService;
        $this->characterService = $characterService;
    }

    public function store(
        CreateItemRequest $request,
        CreateItemCommandMapper $commandMapper
    ): Response {

        $createItemCommand = $commandMapper->map($request);

        $this->characterService->createItem($createItemCommand);

        return redirect()->back();
    }
}
