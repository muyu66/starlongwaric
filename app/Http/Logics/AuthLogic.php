<?php

namespace App\Http\Logics;

use App\Orms\UserLog;
use App\Http\Commons\Redis;
use Muyu\Controllers\Captcha;

class AuthLogic extends Logic
{
    public function getCaptcha()
    {
        $redis = new Redis(config('database.redis.default'));
        $captcha = new Captcha();
        $captcha->useRedis($redis->getConnection());
        return $captcha;
    }

    public function getCodeQuery()
    {
        return $this->getCaptcha()->query();
    }

    public function logLogin($user_id, $ip)
    {
        $model = new UserLog;
        $model->user_id = $user_id;
        $model->ip = $ip;
        $model->save();
    }
}
