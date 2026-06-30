<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Sanctum SPA stateful middleware for cookie-based auth
        $middleware->statefulApi();

        $middleware->alias([
            'role' => \App\Http\Middleware\Role::class,
        ]);

        // JSON response for unauthenticated API requests (instead of redirect to /login)
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                abort(401, 'Unauthenticated.');
            }
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => ['code' => 'UNAUTHENTICATED', 'message' => 'Unauthenticated.'],
                ], 401);
            }
        });

        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => [
                        'code'    => 'VALIDATION_ERROR',
                        'message' => 'The given data was invalid.',
                        'details' => $e->errors(),
                    ],
                ], 422);
            }
        });

        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => ['code' => 'NOT_FOUND', 'message' => 'Resource not found.'],
                ], 404);
            }
        });
    })->create();
