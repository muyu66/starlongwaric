<?php

class FleetBodyTest extends TestCase
{
    public function testIndex()
    {
        $this->login();
        $this->get('fleet_body', ['fleet_id' => '1']);
        $this->see('health');
        $this->seeJson();
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->login();
        $this->get('fleet_body/1', ['fleet_id' => '1']);
        $this->see('health');
        $this->seeJson();
        $this->assertResponseOk();
    }

    public function testStore()
    {
        $this->login();
        $this->post('fleet_body', ['id' => '1', 'fleet_id' => '1']);
        $this->see('fix');
        $this->seeJson();
        $this->assertResponseOk();

        $this->post('fleet_body', ['id' => '1', 'fleet_id' => '32']);
        $this->assertResponseStatus(404);
    }

    public function testPostStoreAll()
    {
        $this->login();
        $this->post('fleet_body/all', ['fleet_id' => '1']);
        $this->see('fix');
        $this->seeJson();
        $this->assertResponseOk();
    }
}