<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
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
            'file' => [
                'required',
                'image',
                'mimes:jpeg,png,gif',
                'max:' . bytes_to_kilobytes(config('filesystems.max_size_in_bytes'))
            ],
        ];
    }
}
