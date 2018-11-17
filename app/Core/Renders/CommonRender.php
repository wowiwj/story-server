<?php

namespace App\Core\Renders;

use Exception;
use Symfony\Component\HttpFoundation\Response as HttpCode;

class CommonRender extends RenderAble
{

    public function getCode()
    {
        $code = $this->exception->getCode();
        if ($code == 0) {
            return HttpCode::HTTP_BAD_REQUEST;
        }
        return $code;
    }

    public function getMessage()
    {
        if ($this->exception->getCode() != HttpCode::HTTP_BAD_REQUEST) {
            return "系统异常";
        }

        return $this->exception->getMessage();
    }

}
