<?php

namespace App\Http\ViewComposers;

use App\Models\Character;
use App\Models\Message;
use Illuminate\Database\Query\Builder;
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

        $builder = Message::query()->whereIn('auto_id', function (Builder $query) use ($currentCharacter)       {
            $query
                ->select(DB::raw('max(`auto_id`)'))
                ->from('messages')
                ->where(function (Builder $query) use ($currentCharacter) {
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
                END'));
        })->orderByDesc('auto_id');

        $messages = $builder->paginate(5);

        $view->with(compact('messages', 'currentCharacter'));
    }
}