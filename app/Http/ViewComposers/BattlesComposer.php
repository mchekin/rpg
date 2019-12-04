<?php

namespace App\Http\ViewComposers;

use App\Battle;
use App\Character;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class BattlesComposer
{
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

        /** @var Collection $battles */
        $battles = Battle::query()->where(function (Builder $query) use ($character) {
            $query->where([
                'attacker_id' => $character->id,
            ]);
        })->orWhere(function (Builder $query) use ($character) {
            $query->where([
                'defender_id' => $character->id,
            ]);
        })->orderByDesc('created_at')->paginate(10);

        $unseenBattles = $character->defends()->unseenByDefender()->whereIn('id', $battles->pluck('id'));

        $unseenBattles->markAsSeenByDefender();

        $view->with(compact('character', 'battles'));
    }
}
