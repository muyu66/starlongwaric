<?php

class FleetConfigTest extends TestCase
{
    public function testIndex()
    {
        $this->testPostUpdatePlayTime();
        $this->login();
        $this->get('fleet_config', ['fleet_id' => '1']);
        $this->see('play_time');
        $this->seeJson();
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->testPostUpdatePlayTime();
        $this->login();
        $this->get('fleet_config/play_time', ['fleet_id' => '1']);
        $this->see('14');
        $this->seeJson();
        $this->assertResponseOk();
    }

    public function testPostUpdatePlayTime()
    {
        $this->login();
        $this->post('fleet_config/play_time', ['minute' => '14', 'fleet_id' => '1']);
        $this->see('status');
        $this->seeJson();
        $this->assertResponseOk();
    }

    public function testPostUpdatePlayTimeFail()
    {
        $this->post('fleet_config/play_time', ['minute' => '14', 'fleet_id' => '32']);
        $this->assertResponseStatus(400);
    }
}