<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use Illuminate\Http\Request;

class FleetController extends Controller
{
    public function getInfo()
    {
        $fleets = Fleet::get();
        return $fleets->merge($this->getPower());
    }

    private function getPower()
    {
        return ['power' => 1111];
    }
}