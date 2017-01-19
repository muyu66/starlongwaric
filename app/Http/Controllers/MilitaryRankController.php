<?php

namespace App\Http\Controllers;

use App\Models\MilitaryRank;

class MilitaryRankController extends Controller
{
    public function index()
    {
        return MilitaryRank::get();
    }

    public function getRank($power)
    {
        $models = $this->index();
        foreach ($models as $model) {
            if ($model === end($models)) {
                return $model->name;
            }
            if ($power > $model->need_contribution) {
                continue;
            }
            return $model->name;
        }
    }
}
