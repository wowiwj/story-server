<?php

namespace App\Core\Renders;

use App\Exceptions\FrontEndException;
use ErrorException;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Render
{
    protected $request;
    protected $exception;

    protected $renders = [
        ValidationException::class           => ValidationRender::class,
        AuthenticationException::class       => AuthenticationRender::class,
        AuthorizationException::class        => AuthorizationRender::class,
        // 以下三个是 404 错误
        NotFoundHttpException::class         => PageNotFoundRender::class,
        MethodNotAllowedHttpException::class => PageNotFoundRender::class,
        ModelNotFoundException::class        => PageNotFoundRender::class,
        // 默认前端错误
        FrontEndException::class             => FrontEndDefaultRender::class,
        // 系统错误
        ErrorException::class                => InternalErrorRender::class,
    ];

    public function __construct(Request $request, Exception $exception)
    {
        $this->request = $request;
        $this->exception = $exception;
    }

    public static function make(Exception $exception)
    {
        return new static(request(), $exception);
    }

    public function shouldReturn()
    {
        if (! ($this->request->wantsJson() || $this->request->ajax())) {
            return false;
        }

        if (! $this->exception) {
            return false;
        }

        if ('production' != app()->environment()
            && $this->exception instanceof ErrorException
        ) {
            return false;
        }

        return true;
    }

    public function report()
    {
        foreach (array_keys($this->renders) as $render) {
            if ($this->exception instanceof $render) {
                $renderClass = $this->renders[$render];
                $render = $renderClass::make($this->exception);

                return $this->response($render);
            }
        }
        $render = CommonRender::make($this->exception);

        return $this->response($render);
    }

    protected function response(RenderAble $render)
    {
        return api()->failed(
            $render->getMessage(),
            $render->getCode()
        );
    }
}
