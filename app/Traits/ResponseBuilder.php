<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

trait ResponseBuilder
{
    public static function buildResponse($data)
    {
        # Set default
        $httpCode = Response::HTTP_OK;
        $content = $data;

        if ($data instanceof \Error) {
            Log::emergency($data);
            $content = 'System error occurs, please contact IT support.';
            $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if ($data instanceof \Exception) {
            Log::error($data);
        }

        return ['content' => $content, 'httpCode' => $httpCode];
    }
}
