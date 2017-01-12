<?php

use App\Http\Controllers\FleetPowerController;

class FleetPowerTest extends TestCase
{
    public function testPower()
    {
        $this->login();
        $ctl = new FleetPowerController();
        $this->assertTrue(is_numeric($ctl->power()));
    }
}