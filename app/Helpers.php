<?php

use App\Core\Api\ApiResponse;
use App\Exceptions\FrontEndException;
use Symfony\Component\HttpFoundation\Response as HttpCode;

if (! function_exists('api')) {
    /**
     * User: wangju
     * Date: 2018/11/17 10:37 PM.
     *
     * @return ApiResponse
     */
    function api()
    {
        return app(ApiResponse::class);
    }
}

if (! function_exists('fe_abort')) {
    /**
     * User: wangju
     * Date: 2018/11/17 10:23 PM.
     *
     * @param $message
     * @param int $code
     *
     * @throws FrontEndException
     */
    function fe_abort($message, $code = HttpCode::HTTP_BAD_REQUEST)
    {
        throw new FrontEndException($message, $code);
    }
}
