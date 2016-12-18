<?php

class FleetTest extends TestCase
{
    public function testIndex()
    {
        $this->testStore();
        $this->get('fleet');
        $this->see(['name', 'id']);
        $this->assertResponseOk();
    }

    public function testShow()
    {
        $this->testStore();
        $this->login();
        $this->get('fleet/1');
        $this->seeJson(['id' => 1]);
        $this->assertResponseOk();
    }

    public function testStore()
    {
        $this->login();
        $this->post('fleet', ['name' => 'Cindy']);
        $this->seeJson(['status' => '1']);
        $this->assertResponseOk();
    }
}