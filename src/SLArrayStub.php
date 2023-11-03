<?php

namespace Ymigval\LaravelSLResponse;

class SLArrayStub
{
    /**
     * @param $data
     * @return array
     */
    public static function success($data): array
    {
        if (!is_null(config('slresponse.wrapping')) && !empty(config('slresponse.wrapping'))) {
            $wrapping = [config('slresponse.wrapping') => $data];
        }

        return array_merge(
            $wrapping ?? $data,
            [
                'success' => true,
            ]
        );
    }

    /**
     * @param $error
     * @return array
     */
    public static function failure($error): array
    {
        return [
            'errors' => is_array($error) ? $error : [$error],
            'success' => false,
        ];
    }
}