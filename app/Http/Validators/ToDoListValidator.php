<?php

namespace App\Http\Validators;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ToDoListValidator
{
    public static function validateToDoList(array $requestBody): array
    {
        $validator = Validator::make($requestBody, [
            'title' => 'required|max:2',
            'content' => 'required',
            'done_at' => 'nullable|date',
            // 'done_at' => 'nullable|date_format:yyyy-MM-dd HH:mm:ss',
            'attachment' => 'nullable',
        ]);

        if ($validator->fails()) {
            throw new HttpException(
                SymfonyResponse::HTTP_UNPROCESSABLE_ENTITY,
                $validator->messages()->toJson()
            );
        }

        return $validator->validated();
    }
}
