<?php

namespace App\Http\Controllers;

use App\Models\MilitaryRank;

class MilitaryRankController extends Controller
{
    public function index()
    {
        return MilitaryRank::get();
    }
}
