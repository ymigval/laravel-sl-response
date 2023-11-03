<?php

namespace Ymigval\LaravelSLResponse;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
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

        $this->mergeConfigFrom(
            __DIR__ . '/../config/slresponse.php', 'slresponse'
        );
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
        $this->slWithoutWrapping();
        $this->publisheConfig();

        JsonResource::withoutWrapping();
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


    protected function slWithoutWrapping()
    {
        JsonResponse::macro('withoutWrapping', function () {

            $stub = $this->getData(true);

            if (!is_null(config('slresponse.wrapping')) && !empty(config('slresponse.wrapping'))) {
                $stub = array_merge($stub[config('slresponse.wrapping')], $stub);
                unset($stub[config('slresponse.wrapping')]);
            }

            return Response::json($stub);
        });
    }

    protected function publisheConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../config/slresponse.php' => config_path('slresponse.php'),
        ], 'slresponse');
    }
}