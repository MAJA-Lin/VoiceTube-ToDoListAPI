<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;

trait ResponseBuilder
{
    public static function buildResponse($data)
    {
        # Set default
        $httpCode = Response::HTTP_OK;
        $content = $data;

        if ($data instanceof \Error) {
            $content = 'System error occurs, please contact IT support.';
            $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        if ($data instanceof \Exception) {
            // For customize exception
        }

        return ['content' => $content, 'httpCode' => $httpCode];
    }
}
