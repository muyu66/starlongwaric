<?php

namespace App\Http\Logics;

use Validator;

class FleetConfigLogic extends Logic
{
    public function check(Array $array)
    {
        $validator = Validator::make($array, [
            'style' => 'required|in:1,2',
        ]);

        $this->validCore($validator);
    }
}
