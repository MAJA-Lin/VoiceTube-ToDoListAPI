<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException as SymfonyHttpException;

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
            ['content' => $content, 'httpCode' => $httpCode] = static::processException($data);
        }

        return ['content' => $content, 'httpCode' => $httpCode];
    }

    public static function processException(\Exception $e)
    {
        # TODO: Refactor with factory mode
        if ($e instanceof SymfonyHttpException) {
            $content = $e->getMessage();
            $httpCode = $e->getStatusCode();
        } elseif ($e instanceof \InvalidArgumentException) {
            $content = $e->getMessage();

            if (strpos($e->getFile(), "Carbon") !== false) {
                $content = "Wrong format for date.";
            }

            $httpCode = Response::HTTP_UNPROCESSABLE_ENTITY;
        } elseif ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            $httpCode = Response::HTTP_NOT_FOUND;
            $content = "Data not found";
        } else {
            Log::error($e);
            $content = 'System error occurs, please contact IT support.';
            $httpCode = Response::HTTP_BAD_REQUEST;
        }

        return ['content' => $content, 'httpCode' => $httpCode];
    }
}
