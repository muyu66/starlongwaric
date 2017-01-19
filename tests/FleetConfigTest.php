<?php

class FleetConfigTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->testPostCommanderStyle();
    }

    public function testIndex()
    {
        $this->get_with_login('fleet_configs');
        $this->seeJsonContains(["fleet_id" => 2]);
    }

    public function testShow()
    {
        $this->get_with_login('fleet_configs/commander_style');
        $this->seeJsonContains(['commander_style' => 1]);
    }

    public function testPostCommanderStyle()
    {
        $this->post_with_login('fleet_configs/commander_style', ['style' => 1]);
        $this->seeJsonContains(['commander_style' => 1]);
        $this->seeInDatabase('fleet_configs', ['fleet_id' => parent::UNIT_ID]);
    }
}