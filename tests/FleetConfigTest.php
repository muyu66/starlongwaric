<?php

class FleetConfigTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->testPostPlayTime();
    }

    public function testIndex()
    {
        $this->get_with_login('fleet_configs');
        $this->seeJsonContains(["fleet_id" => 2]);
    }

    public function testShow()
    {
        $this->get_with_login('fleet_configs/play_time');
        $this->seeJsonContains(['play_time' => 14]);
    }

    public function testPostPlayTime()
    {
        $this->post_with_login('fleet_configs/play_time', ['minute' => 14]);
        $this->seeJsonContains(["play_time" => 14]);
        $this->seeInDatabase('fleet_configs', ['fleet_id' => parent::UNIT_ID]);
    }
}