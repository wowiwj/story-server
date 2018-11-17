<?php

namespace App\Core\Renders;

use Symfony\Component\HttpFoundation\Response as HttpCode;

class CommonRender extends RenderAble
{
    public function getCode()
    {
        $code = $this->exception->getCode();
        if (0 == $code) {
            return HttpCode::HTTP_BAD_REQUEST;
        }

        return $code;
    }

    public function getMessage()
    {
        if (HttpCode::HTTP_BAD_REQUEST != $this->exception->getCode()) {
            return '系统异常';
        }

        return $this->exception->getMessage();
    }
}
