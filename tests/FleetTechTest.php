<?php

class FleetTechTest extends TestCase
{
    public function testIndex()
    {
        $this->login();
        $this->get('fleet_tech/1', ['fleet_id' => '1']);
        $this->see('level');
        $this->seeJson();
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->login();
        $this->get('fleet_tech', ['fleet_id' => '1']);
        $this->see('level');
        $this->seeJson();
        $this->assertResponseOk();
    }

    public function testStore()
    {
        $this->login();
        $this->post('fleet_tech', ['id' => '1', 'fleet_id' => '1']);
        $this->see('update');
        $this->seeJson();
        $this->assertResponseOk();

        $this->post('fleet_tech', ['id' => '1', 'fleet_id' => '32']);
        $this->assertResponseStatus(404);
    }

    public function testPostStoreAll()
    {
        $this->login();
        $this->post('fleet_tech/all', ['fleet_id' => '1']);
        $this->see('update');
        $this->seeJson();
        $this->assertResponseOk();
    }
}