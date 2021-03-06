<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

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
     * @param \Throwable $exception
     *
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        /*
         * 05142018: HTTP status 404 if user access to POST route.
         */
        if ($exception instanceof MethodNotAllowedHttpException) {
            abort(404);
        }

        return parent::render($request, $exception);
    }

    /**
     * redirect user to login page, if he is not authenticated
     * this allows me to use the intended method on redirects.
     *
     * @param Illuminate\Http\Request                 $request
     * @param Illuminate\Auth\AuthenticationException $exception
     *
     * @return mixed
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
            ? response()->json(['message' => $exception->getMessage()], 401)
            : redirect()->guest(route('auth.login'))->withErrors([
                'title'    => 'Authentication requested',
                'content'  => 'Please log in to view this page.',
                'class'    => 'info',
            ]);
    }
}
