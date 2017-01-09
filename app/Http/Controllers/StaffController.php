<?php

namespace App\Http\Controllers;

use App\Models\Staff;

class StaffController extends Controller
{
    public function getMy()
    {
        return Staff::where('boss_id', $this->getFleetId())->get();
    }

    public function getMarket()
    {
        return Staff::where('boss_id', 0)->get();
    }
}