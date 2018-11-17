<?php

namespace App\Core\Renders;

use Symfony\Component\HttpFoundation\Response as HttpCode;

class PageNotFoundRender extends RenderAble
{
    public function getMessage()
    {
        return 'api not found!';
    }

    public function getCode()
    {
        return HttpCode::HTTP_NOT_FOUND;
    }
}
