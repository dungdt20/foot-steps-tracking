<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class StatusController
 * @package App\Http\Controllers\Web
 */
class CheckStatusController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $statusCode = Response::HTTP_OK;

        $resp = new \stdClass();
        $resp->status = 'ok';
        $resp->message = '';
        $resp->version = trim(@file_get_contents(base_path('version')));

        return response()->json($resp, $statusCode);
    }
}
