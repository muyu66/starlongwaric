<?php

namespace App\Http\Logics;

use App\Models\MilitaryRank;

class MilitaryRankLogic extends Logic
{
    /**
     * 根据战斗贡献换算出军衔
     *
     * @param $models
     * @param $contribution
     * @return mixed
     * @author Zhou Yu
     */
    public function getRank(MilitaryRank $models, $contribution)
    {
        foreach ($models as $model) {
            if ($contribution > $model->need_contribution) {
                continue;
            }
            return $model->name;
        }
        return end($models->toArray())['name'];
    }
}
