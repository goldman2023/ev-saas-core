<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;

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

    /* Reporting to sentry: https://sentry.io/onboarding/eim-solutions/get-started/  */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof WeAPIException) {
            return response()->json(['status' => 'failed', 'error' => [
                'message' => empty($exception->message) ? $exception->getMessage() : $exception->message,
                'type' => $exception->type,
                'code' => $exception->code,
            ]], $exception?->code ?? 500);
        }

        return parent::render($request, $exception);
    }
}
