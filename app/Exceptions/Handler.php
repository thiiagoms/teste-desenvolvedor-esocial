<?php

namespace App\Exceptions;

use App\Messages\System\SystemMessage;
use DomainException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

        $this->renderable(fn (Throwable $e): JsonResponse => match (true) {
            $e instanceof AuthenticationException => response()
                ->json(['message' => $e->getMessage()], Response::HTTP_UNAUTHORIZED),
            $e instanceof AuthorizationException => response()
                ->json(['message' => $e->getMessage()], Response::HTTP_FORBIDDEN),
            $e instanceof DomainException => response()
                ->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR),
            $e instanceof LogicalException => response()
                ->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR),
            $e instanceof NotFoundHttpException => response()
                ->json(['message' => SystemMessage::RESOURCE_NOT_FOUND], Response::HTTP_NOT_FOUND),
            default => response()->json(['error' => $e->getMessage()])
        });
    }
}
