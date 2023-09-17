<?php

namespace Infrastructure\Util;

use Illuminate\Http\JsonResponse;

/**
 * Trait ResponseHelper
 */
trait ResponseHelper
{
    /**
     * @param string $message
     * @param array $data
     * @param array $options
     * @return JsonResponse
     */
    public function sendSuccess(
        string $message,
        array $data = [],
        array $options = []
    ): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => $message
        ];

        $response['data'] = $data;

        if ($options) {
            $response = array_merge($response, $options);
        }

        return response()->json($response);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function returnSuccessWithData(array $data = []): JsonResponse
    {
        return response()->json($data);
    }

    /**
     * @param string $message
     * @param int $httpCode
     * @param array $errors
     * @param array $options
     * @return JsonResponse
     */
    public function sendError(
        string $message,
        int $httpCode = 500,
        array $errors = [],
        array $options = []
    ): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        if (!empty($options)) {
            $response = array_merge($response, $options);
        }

        if (empty($httpCode) || $httpCode > 500) {
            $httpCode = 500;
        }

        $response['errorCode'] = $httpCode;

        if ($httpCode === 500) {
            $response['message'] ='Internal Server Error';
        }

        return response()->json($response, $httpCode);
    }

    /**
     * @param $message
     * @param $developMessage
     * @param int $httpCode
     * @return JsonResponse
     */
    public function sendServerError($message, $developMessage, int $httpCode = 500): JsonResponse
    {
        $response = [
            'errorMessage' => $message,
        ];

        if (env('APP_ENV') !== 'prod') {
            $response = array_merge($response, [
                'developerMessage' => $developMessage,
            ]);
        }

        return response()->json($response, $httpCode);
    }
}
