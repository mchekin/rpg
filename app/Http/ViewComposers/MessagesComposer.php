<?php

namespace App\Http\ViewComposers;

use App\Character;
use App\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MessagesComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        /** @var Character $currentCharacter */
        $currentCharacter = Auth::user()->character;

        /** @var Builder $builder */
        $builder = Message::query()->where(function (Builder $query) use ($currentCharacter) {
            $query->where([
                'to_id' => $currentCharacter->id,
            ]);
        })->orWhere(function (Builder $query) use ($currentCharacter) {
            $query->where([
                'from_id' => $currentCharacter->id,
            ]);
        })->groupBy(DB::raw('
                CASE WHEN from_id = "' . $currentCharacter->id . '"
                  THEN to_id
                  ELSE from_id
                END'))
            ->orderByDesc('created_at');

        $messages = $builder->paginate(5);

        $view->with(compact('messages', 'currentCharacter'));
    }
}