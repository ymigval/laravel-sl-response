<?php

namespace Ymigval\LaravelSLResponse\Exceptions;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Throwable;
use Ymigval\LaravelSLResponse\SLArrayStub;

/**
 * @method renderable(Closure $param)
 */
class Handler extends \App\Exceptions\Handler
{
    public function register(): void
    {
        parent::register();

        $this->renderResponse();

    }


    private function renderResponse(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                if (!is_null($statusCode = static::getStatusCodeException($e))) {
                    $stub = SLArrayStub::failure(static::getMessageFromException($e));
                    return Response::json($stub, $statusCode);
                }
            }

            return null;
        });
    }


    private static function getMessageFromException(Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return $e->errors();
        }

        return is_array($e->getMessage()) ? $e->getMessage() : [$e->getMessage()];
    }

    private static function getStatusCodeException(Throwable $e)
    {
        if (method_exists($e, 'getStatusCode')) {
            return $e->getStatusCode();
        }

        if ($e instanceof ValidationException) {
            return $e->status;
        }

        if (method_exists($e, 'status')) {
            return $e->status();
        }

        return null;
    }
}
