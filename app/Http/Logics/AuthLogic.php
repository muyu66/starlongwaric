<?php

namespace App\Http\Logics;

use App\Orms\UserLog;

class AuthLogic extends Logic
{
    public function logLogin($user_id, $ip)
    {
        $model = new UserLog;
        $model->user_id = $user_id;
        $model->ip = $ip;
        $model->save();
    }
}
