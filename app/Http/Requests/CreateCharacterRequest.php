<?php

namespace App\Http\Requests;

use App\Modules\Character\Domain\Entities\Character;
use Illuminate\Foundation\Http\FormRequest;

class CreateCharacterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name' => 'required|unique:' . Character::class . ',name|min:2',
            'gender' => 'required|in:male,female',
            'race_id' => 'required|integer',
        ];
    }
}
