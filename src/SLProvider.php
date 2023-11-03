<?php

namespace Ymigval\LaravelSLResponse;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Ymigval\LaravelSLResponse\Exceptions\Handler;

/**
 * @method getData(true $true)
 */
class SLProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            ExceptionHandler::class,
            Handler::class
        );

        $this->app->bind('SL', function () {
            return new SL();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->slMessage();
        $this->slError();
    }

    protected function slMessage(): void
    {
        JsonResponse::macro('withMessage', function (string $message) {
            $stub = $this->getData(true);
            $stub['messages'][] = $message;
            return Response::json($stub);
        });
    }

    protected function slError(): void
    {
        JsonResponse::macro('error', function (string|array $error, string $codeError = null) {

            if (!is_null($codeError) && !is_array($error)) {
                $errorWithCode = [
                    'code' => $codeError,
                    'message' => $error
                ];
            }

            $stub = $this->getData(true);

            if (is_array($error)) {
                $stub['errors'] = array_merge($stub['errors'], $error);
            } else {
                $stub['errors'][] = $errorWithCode ?? $error;
            }

            return Response::json($stub, 422);
        });
    }
}