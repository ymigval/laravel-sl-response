<?php

namespace Ymigval\LaravelSLResponse\Facades;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Facade;

/**
 * @method static JsonResponse ok(mixed $data)
 * @method static JsonResponse error(string|array $error, string $codeError = null)
 *
 * @see \Ymigval\LaravelSLResponse\SL
 */
class SLResponse extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'SL';
    }
}