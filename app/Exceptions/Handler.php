<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Throwable;

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
    public function render($request, Throwable $exception)
    {
        // Display custom error message for specific exceptions
        // if ($exception instanceof \ErrorException) {
        //     return response()->view('errors.500', ['exception' => $exception], 500);
        // }
        
        if ($exception instanceof TokenMismatchException) {
            return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
        }
        return parent::render($request, $exception);
    }
    
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
