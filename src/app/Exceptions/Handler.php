<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
        if ($this->shouldReport($e)) {
            //            if ( \App::environment() == 'production' && ! $e instanceof TokenMismatchException) {
//                // notify to slack
//                $slackService = \App::make('\App\Services\SlackServiceInterface');
//                $slackService->exception($e);
//            }
        }

        if (app()->bound('sentry') && $this->shouldReport($e)) {
            app('sentry')->captureException($e);
        }

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        // Return JSON if request is AJAX
        if ($request->wantsJson()) {
            if(method_exists($e, 'getStatusCode')){
                $code = $e->getStatusCode();
            } else {
                $code = $e->getCode();
            }

            if ($code == 0) {
                $code = 500;
            }

            if($e instanceof ValidationException) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'error' => $e->getResponse()->getData(),
                ], $e->getResponse()->getStatusCode());
            }

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ], $code);
        }

        if($e instanceof TokenMismatchException){
            return redirect()->route('doctor.signIn')->withErrors([\Lang::get('sign_in_failed_title'),\Lang::get('session_expired')]);
        }

        if($e instanceof QueryException){
            flash($e->getMessage(), 'warning');
            return redirect()->back();
        }

        return parent::render($request, $e);
    }
}
