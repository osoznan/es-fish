<?php

namespace App\Exceptions;

use App\Facades\Telegram;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            Telegram::send(env('APP_URL', 'FISHWAY') . ' - ERROR - ' . $e->getMessage().": " . $e->getFile(). " line " . $e->getLine());
        });
    }
}
