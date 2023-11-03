<?php

namespace Ymigval\LaravelSLResponse;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Response;

class SL
{
    /**
     * @param mixed $data
     * @return JsonResponse
     */
    public function ok(mixed $data): JsonResponse
    {
        if ($data instanceof JsonResource) {
            $data = $data->response()->getData(true);
        }

        $stub = SLArrayStub::success();
        $stub['result'] = $data;

        return Response::json($stub);
    }


    /**
     * @param string|array $error
     * @param string|null $codeError
     * @return JsonResponse
     */
    public function error(string|array $error, string $codeError = null): JsonResponse
    {
        if (!is_null($codeError) && !is_array($error)) {
            $errorWithCode = [
                'code' => $codeError,
                'message' => $error
            ];
        }

        $stub = SLArrayStub::failure();

        if (is_array($error)) {
            $stub['errors'] = array_merge($stub['errors'], $error);
        } else {
            $stub['errors'][] = $errorWithCode ?? $error;
        }

        return Response::json($stub, 422);
    }
}