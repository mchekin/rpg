<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateItemRequest;
use App\Modules\Equipment\Application\Services\ItemService;
use App\Modules\Equipment\UI\Http\CommandMappers\CreateItemCommandMapper;
use Illuminate\Http\Response;

class ItemCreateController extends Controller
{
    /**
     * @var ItemService
     */
    private $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->middleware('auth');
        $this->middleware('has.character');
        $this->middleware('is.admin');

        $this->itemService = $itemService;
    }

    public function store(
        CreateItemRequest $request,
        CreateItemCommandMapper $commandMapper
    ): Response {

        $createItemCommand = $commandMapper->map($request);

        $this->itemService->create($createItemCommand);

        return redirect()->back();
    }
}
