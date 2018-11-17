<?php

namespace App\Core\Renders;

use Symfony\Component\HttpFoundation\Response as HttpCode;

class FrontEndDefaultRender extends RenderAble
{
    public function getCode()
    {
        $code = $this->exception->getCode();
        if ($code) {
            return $code;
        }
        return HttpCode::HTTP_BAD_REQUEST;
    }


    public function getMessage()
    {
        return $this->exception->getMessage();
    }
}
