<?php

namespace App\Core\Renders;

use Symfony\Component\HttpFoundation\Response as HttpCode;

class InternalErrorRender extends RenderAble
{
    public function getCode()
    {
        return HttpCode::HTTP_INTERNAL_SERVER_ERROR;
    }

    public function getMessage()
    {
        if ('production' != app()->environment()) {
            return [];
        }

        return '系统异常';
    }
}
