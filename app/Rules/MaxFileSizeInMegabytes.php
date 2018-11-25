<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MaxFileSizeInMegabytes implements Rule
{
    /**
     * @var float
     */
    private $maxSizeInMegabytes;

    public function __construct(float $maxSizeInMegabytes)
    {
        $this->maxSizeInMegabytes = $maxSizeInMegabytes;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value instanceof UploadedFile && ! $value->isValid()) {
            return false;
        }

        $megabytes = $value->getSize() / 1024 / 1024;

        return $megabytes <= $this->maxSizeInMegabytes;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute may not be greater than $this->maxSizeInMegabytes megabytes.";
    }
}
