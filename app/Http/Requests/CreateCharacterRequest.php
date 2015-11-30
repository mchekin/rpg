<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateCharacterRequest extends Request
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
            'name' => 'required|unique:characters,name|min:2',
            'gender' => 'required|in:male,female',
            'race_id' => 'required|integer',
        ];
    }
}
