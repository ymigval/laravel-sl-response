<?php

namespace Ymigval\LaravelSLResponse;

class SLArrayStub
{
    /**
     * @return array
     */
    public static function success(): array
    {
        return [
            'result' => [],
            'messages' => [],
            'success' => true,
        ];
    }

    /**
     * @return array
     */
    public static function failure(): array
    {
        return [
            'errors' => [],
            'messages' => [],
            'success' => false,
        ];
    }
}