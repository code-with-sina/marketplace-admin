<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use PHPUnit\Runner\InvalidOrderException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (InvalidOrderException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->view('errors.invalid-order', [], 500);
            }
        });
        $this->renderable(function (InvalidOrderException $e, Request $request) {
            return response()->view('errors.invalid-order', [], 500);
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
                return response()->json([
                    'message' => 'Record not found.'
                ], 404);
        });


        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Record not found.'
                ], 404);
            }
        });

        // $this->renderable(function (ForbiddenHttpException $e, Request $request) {
        //         return response()->json([
        //             'message' => 'Record not found.'
        //         ], 404);
        // });
    }
}
