<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Log;
use Sentry\Laravel\Integration;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            Integration::captureUnhandledException($e);
        });
    }
    /**
     * tbox: custom error json page
     * Exception should be replaced with Throwable in current Laravel framework.
     */
    // public function render($request, Exception $exception)
    // {
    //     Log::debug("exception page");
    //     if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
    //         return response()->json(['success' => false, 'message' => 'Not Found!'], 404);
    //     }
    //     if ($exception instanceof NotFoundHttpException) {
    //         return response()->json(['success' => false, 'message' => 'The specified URL cannot be found'], 404);
    //     }
    //     if ($this->isHttpException($e)) {
    //         return response()->json(['success' => false, 'message' => 'The specified URL cannot be found'], 404);
    //     }
    //     return parent::render($request, $exception);
    // }
}
