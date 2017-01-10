<?php

use App\Http\Components\Event as EventFunc;
use App\Models\Event;
use App\Http\Controllers\EventController;

class EventFuncTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->testGenerate();
    }

    public function testGenerate()
    {
        $ctl = new EventController();
        $ctl->generate(self::UNIT_FLEET_ID, 1);
        $ctl->generate(self::UNIT_FLEET_ID, 2);
    }

    public function testEvent1()
    {
        $event_id = 1;
        $choose = 1;

        $model = Event::belong(self::UNIT_FLEET_ID)
            ->where('status', 0)
            ->where('commander', 0)
            ->with('standard')
            ->findOrFail($event_id);

        $params['fleet_id'] = self::UNIT_FLEET_ID;

        $ctl = new EventFunc($model, $choose, $params);
        $ctl->event1();

        $this->seeInDatabase('fight_logs', ['id' => $event_id, 'my_id' => self::UNIT_FLEET_ID]);
    }

    public function testEvent2()
    {
        $event_id = 2;
        $choose = 1;

        $model = Event::belong(self::UNIT_FLEET_ID)
            ->where('status', 0)
            ->where('commander', 0)
            ->with('standard')
            ->findOrFail($event_id);

        $params['fleet_id'] = self::UNIT_FLEET_ID;

        $ctl = new EventFunc($model, $choose, $params);
        $ctl->event2();

        $this->seeInDatabase('staff', ['id' => $event_id]);
    }
}
