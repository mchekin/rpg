<?php

namespace App\Http\Requests;

use App\Rules\MaxFileSizeInMegabytes;
use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    const MAX_SIZE_IN_MEGABYTES = 8;

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
            'file' => ['required', 'image', new MaxFileSizeInMegabytes(self::MAX_SIZE_IN_MEGABYTES)],
        ];
    }
}
