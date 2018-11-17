<?php

namespace App\Core\Renders;

use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as HttpCode;

class ValidationRender extends RenderAble
{
    public function getCode()
    {
        return HttpCode::HTTP_BAD_REQUEST;
    }

    public function getMessage()
    {
        return $this->makeMessage($this->exception);
    }

    private function makeMessage(ValidationException $exception)
    {
        $errors = $exception->errors();
        $message = collect($errors)->pop();

        return collect($message)->pop();
    }
}
