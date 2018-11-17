<?php

namespace App\Core\Renders;

use Symfony\Component\HttpFoundation\Response as HttpCode;

class AuthorizationRender extends RenderAble
{
    public function getCode()
    {
        return HttpCode::HTTP_FORBIDDEN;
    }

    public function getMessage()
    {
        return $this->exception->getMessage();
    }
}
