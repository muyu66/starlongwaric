<?php

namespace App\Http\Controllers;

class FleetPowerController extends Controller
{
    public function power()
    {
        return $this->loc()->power($this->getFleetId());
    }
}
