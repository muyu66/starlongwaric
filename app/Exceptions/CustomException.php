<?php

namespace App\Exceptions;

use Exception;

class  CustomException extends Exception
{
    public function __construct($code, $msg = '')
    {
        parent::__construct($this->dispatch($code, $msg), $code);
    }

    public function dispatch($code, $msg)
    {
        switch ($code) {
            case  401:
                $message = '认证错误';
                break;
            default:
                $message = '未知定义错误';
        }
        return $msg ? : $message;
    }
}