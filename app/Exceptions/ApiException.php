<?php

namespace App\Exceptions;

use Exception;

/**
 * 已知异常类，统一返回200错误，附带 Status Code
 *
 * @package App\Exceptions
 */
class ApiException extends Exception
{
    public function __construct($code)
    {
        parent::__construct($this->getMsg($code), $code);
    }

    protected function getMsg($code)
    {
        switch ($code) {
            case  40101:
                return '认证错误';
            case  40102:
                return '验证码错误';
            default:
                return '未定义错误';
        }
    }
}