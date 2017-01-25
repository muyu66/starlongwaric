<?php

use App\Http\Components\Events\Event1;
use App\Http\Components\Events\Event2;
use App\Models\Event;
use App\Http\Logics\FleetEventLogic;

class EventFuncTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->testGenerate();
    }

    public function testGenerate()
    {
        $loc = new FleetEventLogic();
        $loc->generate(self::UNIT_FLEET_ID, 1);
        $loc->generate(self::UNIT_FLEET_ID, 2);
    }

    public function testEvent1()
    {
        $event_id = 1;
        $choose = 1;

        $model = Event::belong(self::UNIT_FLEET_ID)
            ->where('status', 0)
            ->with('standard')
            ->findOrFail($event_id);

        $params['fleet_id'] = self::UNIT_FLEET_ID;

        $ctl = new Event1($model, $choose, $params);
        $ctl->handle();

        $this->seeInDatabase('fight_logs', ['id' => $event_id, 'my_id' => self::UNIT_FLEET_ID]);
    }

    public function testEvent2()
    {
        $event_id = 2;
        $choose = 1;

        $model = Event::belong(self::UNIT_FLEET_ID)
            ->where('status', 0)
            ->with('standard')
            ->findOrFail($event_id);

        $params['fleet_id'] = self::UNIT_FLEET_ID;

        $ctl = new Event2($model, $choose, $params);
        $ctl->handle();

        $this->seeInDatabase('staff', ['id' => $event_id]);
    }
}
