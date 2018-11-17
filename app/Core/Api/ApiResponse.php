<?php

namespace App\Core\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Response;
use Symfony\Component\HttpFoundation\Response as HttpCode;

class ApiResponse
{
    /**
     * @var int
     */
    protected $statusCode = HttpCode::HTTP_OK;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param       $data
     * @param array $header
     *
     * @return mixed
     */
    public function respond($data, $header = [])
    {
        if ($this->debugEnabled()) {
            $data = array_merge($data, $this->getDebug());
        }

        return Response::json($data, $this->statusCode, $header);
    }

    protected function debugEnabled()
    {
        return app()->has('debugbar') && app('debugbar')->isEnabled();
    }

    protected function getDebug()
    {
        return ['_debugbar' => app('debugbar')->getData()];
    }

    /**
     * @param array $data
     * @param null  $code
     *
     * @return mixed
     */
    public function status(array $data, $code = null)
    {
        if ($code) {
            $this->setStatusCode($code);
        }
        $status = [
            'code' => $this->statusCode,
        ];
        $data = array_merge($data, $status);

        return $this->respond($data);
    }

    /**
     * @param        $message
     * @param int    $code
     * @param string $status
     *
     * @return mixed
     */
    public function failed($message, $code = HttpCode::HTTP_BAD_REQUEST)
    {
        return $this->setStatusCode($code)->message($message);
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    public function message($message, $code = null)
    {
        return $this->status([
            'message' => $message,
        ], $code);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function internalError($message = 'Internal Error!')
    {
        return $this->failed($message, HttpCode::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function created($message = 'created')
    {
        return $this->setStatusCode(HttpCode::HTTP_CREATED)
            ->message($message);
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    public function success($data)
    {
        return $this->status(compact('data'));
    }

    public function noContent($code = HttpCode::HTTP_NO_CONTENT)
    {
        return $this->setStatusCode($code)->status([]);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function notFond($message = 'Not Fond!')
    {
        return $this->failed($message, HttpCode::HTTP_NOT_FOUND);
    }

    public function resource(JsonResource $resource)
    {
        $additional = [
            'code' => $this->statusCode,
        ];

        if ($this->debugEnabled()) {
            $additional += $this->getDebug();
        }
        $resource->additional($additional);

        return $resource;
    }

    public function resourceAdditional(JsonResource $resource, $more = [])
    {
        if ($resource->resource instanceof LengthAwarePaginator) {
            $total = $resource->resource->total();
            $resource->resource = collect($resource->resource->items());
            $more['total'] = $total;
        }

        $additional = [
            'code' => $this->statusCode,
        ];
        $additional += $more;

        if ($this->debugEnabled()) {
            $additional += $this->getDebug();
        }

        $resource->additional($additional);

        return $resource;
    }
}
