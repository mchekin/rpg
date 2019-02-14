<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     *
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     * @param $request
     * @param Exception $exception
     *
     * @return RedirectResponse|Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof PostTooLargeException) {

            return back()
                ->withErrors([
                    'message' => "The file may not be greater than {$this->getMaxSizeInKiloBytes()} kilobytes",
                ]);
        }

        return parent::render($request, $exception);
    }

    private function getMaxSizeInKiloBytes(): float
    {
        return bytes_to_kilobytes(config('filesystems.max_size_in_bytes'));
    }
}
