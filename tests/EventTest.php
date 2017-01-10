<?php

use App\Http\Controllers\EventController;

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
        $ctl = new EventController();
        $model = $ctl->generate(self::UNIT_FLEET_ID);
        $this->seeInDatabase('events', ['id' => $model->id]);
        return $model;
    }

    public function testGetIndex()
    {
        $this->get_with_login('event');
        $this->assertResponseOk();
    }

    public function testPostResolve()
    {
        $this->post_with_login('event/resolve', ['id' => $this->id, 'choose' => 1]);
        $this->seeInDatabase('events', ['id' => $this->id, 'status' => '1']);
    }
}
