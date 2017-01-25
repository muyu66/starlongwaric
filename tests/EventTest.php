<?php

use App\Http\Logics\FleetEventLogic;

class EventTest extends TestCase
{
    private $id;

    public function setUp()
    {
        parent::setUp();
        $this->id = $this->testGenerate()->id;
    }

    public function testGenerate()
    {
        $loc = new FleetEventLogic();
        $model = $loc->generate(self::UNIT_FLEET_ID);
        $this->seeInDatabase('events', ['id' => $model->id]);
        return $model;
    }

    public function testGetUnFinish()
    {
        $this->get_with_login('event/un-finish');
        $this->assertResponseOk();
    }

    public function testGetFinish()
    {
        $this->get_with_login('event/finish');
        $this->assertResponseOk();
    }

    public function testPostResolve()
    {
        $this->post_with_login('event/resolve', ['id' => $this->id, 'choose' => 1]);
        $this->seeInDatabase('events', ['id' => $this->id, 'status' => '1']);
    }
}
