<?php

namespace App\Http\Logics;

use App\Models\User;
use App\Orms\UserLog;
use App\Http\Commons\Redis;
use Muyu\Controllers\Captcha;
use Validator;

class AuthLogic extends Logic
{
    public function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function check(Array $array)
    {
        $validator = Validator::make($array, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        $this->validCore($validator);
    }

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
