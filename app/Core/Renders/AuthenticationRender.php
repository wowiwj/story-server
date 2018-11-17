<?php

namespace App\Core\Renders;

use Symfony\Component\HttpFoundation\Response as HttpCode;


class AuthenticationRender extends RenderAble
{
    public function getCode()
    {
        return HttpCode::HTTP_UNAUTHORIZED;
    }

    public function getMessage()
    {
        return $this->exception->getMessage();
    }


}
