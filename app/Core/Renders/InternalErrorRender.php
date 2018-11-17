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
        if (app()->environment() != 'production') {
            return [];
        }

        return '系统异常';
    }
}
