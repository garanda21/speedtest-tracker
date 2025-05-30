<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
use OpenApi\Attributes as OA;

#[OA\Info(title: 'Speedtest Tracker API', version: '1.0.0')]
abstract class ApiController
{
    /**
     * Send a response.
     *
     * @param  mixed  $data
     * @param  array  $filters
     * @param  string  $message
     * @param  int  $code
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sendResponse($data, $filters = [], $message = 'ok', $code = 200)
    {
        $response = array_filter([
            'data' => $data,
            'filters' => $filters,
            'message' => $message,
        ]);

        if (! empty($message)) {
            $response['message'] = $message;
        }

        return response()->json(
            data: $response,
            status: $code,
        );
    }

    /**
     * Throw an exception.
     *
     * @param  \Exception  $e
     * @param  int  $code
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public static function throw($e, $code = 500)
    {
        Log::info($e);

        $response = [
            'message' => $e->getMessage(),
        ];

        throw new HttpResponseException(
            response: response()->json(
                data: $response,
                status: $code,
            ),
        );
    }
}
