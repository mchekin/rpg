<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;

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
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof PostTooLargeException) {

            return back()
                ->withErrors([
                    'message' => "Uploaded files may not be greater than  {$this->getPostMaxSizeInMegaBytes()} megabytes",
                ]);
        }

        return parent::render($request, $exception);
    }



    /**
     * Determine the server 'post_max_size' as megabytes.
     *
     * @return int
     */
    protected function getPostMaxSizeInMegaBytes()
    {
        if (is_numeric($postMaxSize = ini_get('post_max_size'))) {
            return (int) $postMaxSize;
        }

        $metric = strtoupper(substr($postMaxSize, -1));
        $postMaxSize = (int) $postMaxSize;

        switch ($metric) {
            case 'B':
                return $postMaxSize / 1048576;
            case 'K':
                return $postMaxSize / 1024;
            case 'G':
                return $postMaxSize * 1024;
            default:
                return $postMaxSize;
        }
    }
}
