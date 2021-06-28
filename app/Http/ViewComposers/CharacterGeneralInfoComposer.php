<?php

namespace App\Http\ViewComposers;

use App\Models\Character;
use App\Modules\Level\Application\Services\LevelService;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class CharacterGeneralInfoComposer
{
    /**
     * @var LevelService
     */
    private $levelService;

    public function __construct(LevelService $levelService)
    {
        $this->levelService = $levelService;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $data = $view->getData();

        /** @var Character $character */
        $character = Arr::get($data, 'character');

        $level = $this->levelService->getLevel($character->getLevelNumber());

        $view->with(compact('character', 'level'));
    }
}
