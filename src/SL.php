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

        if (is_object($data) && method_exists($data, 'toArray')) {
            $data = $data->toArray();
        }

        $stub = SLArrayStub::success($data);

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
            $error = [
                'code' => $codeError,
                'message' => $error
            ];
        }

        $stub = SLArrayStub::failure($error);

        return Response::json($stub, 422);
    }
}