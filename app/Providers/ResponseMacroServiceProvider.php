<?php

namespace App\Providers;

# Packages
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseBuilder;

class ResponseMacroServiceProvider extends ServiceProvider
{
    use ResponseBuilder;

    /**
     * Register the application's response macros.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('custom', function ($data) {
            [
                'content' => $content,
                'httpCode' => $httpCode
            ] = ResponseBuilder::buildResponse($data);

            $jsonResponse = new JsonResponse($content, $httpCode);

            return $jsonResponse;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
