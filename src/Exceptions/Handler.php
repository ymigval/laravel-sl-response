<?php

namespace Ymigval\LaravelSLResponse\Exceptions;

use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;
use Ymigval\LaravelSLResponse\SLArrayStub;

/**
 * @method renderable(Closure $param)
 */
class Handler extends \App\Exceptions\Handler
{
    /**
     * @var bool
     */
    private bool $captureAllExceptions = false;


    function __construct(Container $container)
    {
        parent::__construct($container);

        if (config('slresponse.capture_all_exceptions') === true) {
            $this->captureAllExceptions = true;
        }
    }

    /**
     * @return void
     */
    public function register(): void
    {
        parent::register();

        $this->renderResponse();

    }


    /**
     * @return void
     */
    private function renderResponse(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                if (!is_null($statusCode = $this->getStatusCodeException($e))) {
                    $stub = SLArrayStub::failure($this->getMessageFromException($e));
                    return Response::json($stub, $statusCode);
                }
            }

            return null;
        });
    }


    /**
     * @param Throwable $e
     * @return array|string
     */
    private function getMessageFromException(Throwable $e): array|string
    {
        if ($e instanceof ValidationException) {
            return $e->errors();
        }

        return is_array($e->getMessage()) ? $e->getMessage() : [$e->getMessage()];
    }

    /**
     * @param Throwable $e
     * @return int|null
     */
    private function getStatusCodeException(Throwable $e): ?int
    {
        if (method_exists($e, 'getStatusCode')) {
            return $e->getStatusCode();
        }

        if ($e instanceof ValidationException) {
            return $e->status;
        }

        if (Str::of($e::class)->contains('authentication', true)) {
            return 401;
        }

        if (method_exists($e, 'status')) {
            return $e->status();
        }

        if ($this->captureAllExceptions) {
            return 500;
        }

        return null;
    }
}
