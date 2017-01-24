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
     * @author Zhou Yu
     */
    public function getRank($contribution)
    {
        return $this->loc()->getRank($this->index(), $contribution);
    }
}
