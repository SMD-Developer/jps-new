<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     */
    public function render($request, Throwable $e)
    {
        $message = $e->getMessage() ?? 'Server error';
        $code = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
        switch(class_basename($e)) {
            case 'TokenMismatchException':
                if ($request->ajax()) {
                    return response()->json(['message' => $message, 'errors' => ['email' => ['Your session has expired. Please refresh the page and login again.']]], 422);
                }
                return redirect(route('admin_login'))->with('modal.title', 'Session Expired!')->with('msg', 'Your session has expired. Please login again.');
            case 'AuthorizationException':
                if ($request->ajax()) {
                    return response()->json(['message' =>'Action is unauthorized'], $code);
                }
                return response()->view('errors.unauthorized', compact('code'), $code);
            default:
                if ($request->ajax()) {
                    return response()->json(['message' => $message], $code);
                }
                return response()->view('errors.default', compact('code'), $code);
        }
    }
}