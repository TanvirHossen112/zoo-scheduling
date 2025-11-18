<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiAble
{
    /**
     * Return success response
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(
        mixed   $data = [],
        ?string $message = 'Success',
        int     $code = Response::HTTP_OK
    ): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ], $code);
    }

    /**
     * Return error response
     *
     * @param mixed $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse(
        mixed   $data = null,
        ?string $message = 'Error',
        int     $code = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data,
            'code' => $code
        ], $code);
    }
}
