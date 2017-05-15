<?php

namespace App\Http\Requests;

use App\Character;
use App\Location;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MoveCharacterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var Character $character */
        $character = $this->route('character');

        /** @var Location $location */
        $location = $this->route('location');

        /** @var Location $loggedInCharacterLocation */
        $characterLocation = $character->location;

        // if this character does not belong to the logged in user
        if (Auth::user()->id !== $character->user->id || !$characterLocation->adjacentLocations()->where('id', $location->id)->first()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
