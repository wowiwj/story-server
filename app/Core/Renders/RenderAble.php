<?php

namespace App\Core\Renders;

use Exception;


abstract class RenderAble
{

    protected $exception;

    private function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    public static function make(Exception $exception)
    {
        return new static($exception);
    }

    abstract public function getCode();

    abstract public function getMessage();
}
