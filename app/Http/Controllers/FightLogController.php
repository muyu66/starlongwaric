<?php

namespace App\Http\Controllers;

use App\Models\FightLog;
use Illuminate\Http\Request;

class FightLogController extends Controller
{
    public function getLog($fleet_id)
    {
        return FightLog::where('fleet_id', $fleet_id)->get();
    }
}
