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
    public function __construct($code, $custom_msg = '')
    {
        parent::__construct($this->getMsg($code, $custom_msg), $code);
    }

    protected function getMsg($code, $custom_msg)
    {
        switch ($code) {
            case  40101:
                $msg = '认证错误';
                break;
            case  40102:
                $msg = '验证码错误';
                break;
            case  40401:
                $msg = '需要创建新的舰队';
                break;
            case  40501:
                $msg = '已存在有效的舰队，不能再新建';
                break;
            default:
                $msg = '未定义错误';
        }
        return $custom_msg ? : $msg;
    }
}