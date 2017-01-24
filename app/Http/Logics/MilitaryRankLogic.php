<?php

namespace App\Http\Logics;

use App\Models\MilitaryRank;

class MilitaryRankLogic extends Logic
{
    /**
     * 根据功勋换算出军衔
     *
     * @param $contribution
     * @return mixed
     * @author Zhou Yu
     */
    public function getRank($contribution)
    {
        $models = MilitaryRank::get();
        foreach ($models as $model) {
            if ($contribution > $model->need_contribution) {
                continue;
            }
            return $model->name;
        }
        return end($models->toArray())['name'];
    }
}
