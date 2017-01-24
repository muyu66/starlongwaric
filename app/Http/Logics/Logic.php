<?php

namespace App\Http\Logics;

use App\Exceptions\ApiException;
use Illuminate\Validation\Validator;

abstract class Logic
{
    public function validCore(Validator $validator)
    {
        if ($validator->fails()) {
            throw new ApiException(422, $validator->messages()->first());
        }
    }
}
