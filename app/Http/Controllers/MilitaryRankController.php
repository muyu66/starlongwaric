<?php

namespace App\Http\Controllers;

use App\Models\MilitaryRank;

class MilitaryRankController extends Controller
{
    public function index()
    {
        return MilitaryRank::get();
    }

    /**
     * 根据战斗贡献换算出军衔
     *
     * @param $contribution
     * @return mixed
     */
    public function getRank($contribution)
    {
        $models = $this->index();
        foreach ($models as $model) {
            if ($contribution > $model->need_contribution) {
                continue;
            }
            return $model->name;
        }
        return end($models->toArray())['name'];
    }
}
